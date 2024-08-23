<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Helpers\NotificationHelper;
use App\Models\{Interaction, Interaction as LikesMatch, Matches, User};
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InteractionController extends Controller
{

    /**
     * Handle user interaction and check for mutual interaction to create a match.
     *
     * @param int $userId
     * @param int $partnerId
     * @param string $interactionType
     * @return \Illuminate\Http\JsonResponse
     */
    function matchUser(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'partner_id'  =>  'required|exists:users,id',
            'user_status' =>  'required|in:like,dislike,super-like,unmatch',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()], 422);
        }

        $request['user_id']      =   $user_id = $user1_id = $this->loggedInUser->id;

        $partner_id              =   $user2_id = $request->partner_id;

        $data['its_a_match']     =   0;

        // === Check plan

        $getCount = User::find($user_id);

        if ($getCount->is_premium != 1) {

            if ($request->user_status == 'super-like') {
                if ($getCount->available_super_likes <= 0) {
                    return response()->json(['status' => false, 'message' => 'Super like plan has been expired', 'data' => ''], 200);
                }
            }
        }
        
        // handle un-match and dislike conditions
        if ($request->user_status == 'unmatch' || $request->user_status == 'dislike') {

            LikesMatch::where(['user_id' => $user_id, 'partner_id' => $partner_id])->delete();

            // ==== add id to the blocked users list so that it can't appear in list

            if ($request->user_status == 'dislike') {

                $reportingUserDetail = User::where('id', $user_id)->firstOrFail();

                // Get the current blocked_ids value
                $blockedIds          = $reportingUserDetail->blocked_ids;

                // Convert the string to an array
                $blockedIdsArray     = $blockedIds ? explode(',', $blockedIds) : [];

                // Add the new ID if it's not already in the array
                $reportedUserId      = (string) $request->partner_id;

                if (!in_array($reportedUserId, $blockedIdsArray)) {
                    $blockedIdsArray[] = $reportedUserId;
                }

                // Convert the array back to a comma-separated string
                $reportingUserDetail->blocked_ids = implode(',', $blockedIdsArray);

                // Save the updated user detail record
                $reportingUserDetail->save();
            }

            // ============= Remove from NotForMe(NFM)

            $removeIdFromNFM = User::where('id', $user_id)->firstOrFail();

            $newMatches = $removeIdFromNFM->not_for_me_ids;

            // Convert the string to an array
            $newMatchesArray = $newMatches ? explode(',', $newMatches) : [];

            // Remove the item from the array
            $itemToRemove = $partner_id; // Specify the item to remove
            if (($key = array_search($itemToRemove, $newMatchesArray)) !== false) {
                unset($newMatchesArray[$key]);
            }

            // Update the new_matches column
            $removeIdFromNFM->not_for_me_ids = implode(',', $newMatchesArray);
            $removeIdFromNFM->updated_at     = Carbon::now();

            $removeIdFromNFM->save();

            // =======================================================================

            return response()->json(['status' => true, 'message' => ucfirst($request->user_status) . ' user successful', 'data' => ''], 200);
        }

        // Check if the match already exists
        $existingMatch = Matches::where(function ($query) use ($user1_id, $user2_id) {
            $query->where('user1_id', $user1_id)
                ->where('user2_id', $user2_id);
        })->orWhere(function ($query) use ($user1_id, $user2_id) {
            $query->where('user1_id', $user2_id)
                ->where('user2_id', $user1_id);
        })->first();

        if ($existingMatch) {
            return response()->json(['status' => false, 'message' => 'This match already exists'], 409);
        }

        $matchUpdateColumn = ['user_id' => $user_id, 'partner_id' => $partner_id, 'interaction_type' => $request->user_status];

        LikesMatch::updateOrCreate($matchUpdateColumn, $matchUpdateColumn);

        // ========= User like/Super-like increment =========

        $partner        =  User::select('name', 'device_token')->find($partner_id);
        $user           =  User::select('name', 'device_token')->find($user_id);

        // ==================

        $total_likes        =  $getCount->total_likes;
        $total_super_likes  =  $getCount->total_super_likes_points;

        if ($request->user_status == 'like') {

            $total_likes    =  $getCount->total_likes + 1;

            $title          =  "Popular x Premium!";
            $message1       =  "Someone likes your profile! 😊 Explore the connection and see if it's a perfect match.";
            $message        =  "Someone likes your profile! Explore the connection and see if it's a perfect match.";
        } else if ($request->user_status == 'super-like') {

            $total_super_likes =  $getCount->total_super_likes_points + 1;

            $title             =  "Super Like Received!";
            $message1          =  "Wow! You've been Super Liked! 🌟 Check who's interested in making a special connection.!";
            $message           =  "Wow! You've been Super Liked! Check who's interested in making a special connection.!";

            // === deduct super like count===

            $userData['available_super_likes'] = $getCount->available_super_likes - 1;
            User::where(['id' => $user_id])->update($userData);

            // ==============================
        }

        // ===================== Send Notification of Like =========

        $type           =  $request->user_status;
        $details        =  ['message' => $message, 'type' => $type, 'respected_id' => "$user_id"];

        NotificationHelper::sendNotification($partner->device_token, $title, $message, $details);
        NotificationHelper::saveNotification($partner_id, $type, $title, $message1, $user_id);

        // ============================================================

        User::where(['id' => $user_id])->update([
            'total_likes' => $total_likes,
            'total_super_likes_points' => $total_super_likes
        ]);

        // Check for mutual like or super like

        $mutualLike      = Interaction::where('user_id', $partner_id)
            ->where('partner_id', $user_id)
            ->where('interaction_type', 'like')
            ->exists();

        $mutualSuperLike = Interaction::where('user_id', $partner_id)
            ->where('partner_id', $user_id)
            ->where('interaction_type', 'super-like')
            ->exists();

        if ($mutualLike || $mutualSuperLike) {

            // Ensure the smaller ID is first
            $user1_id  = min($user_id, $partner_id);
            $user2_id  = max($user_id, $partner_id);

            $expire_at = Carbon::parse(now())->addHours(24);

            // Insert match
            Matches::insert([
                'user1_id'   => $user1_id,
                'user2_id'   => $user2_id,
                'expire_at'  => $expire_at,
                'chat_room'  => max($user1_id, $user2_id) . 'Chat' . min($user1_id, $user2_id),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // === Send Notification to User

            $type           =  'match';

            $title          =  "New Match!";

            $message        =  "Congratulations! You've got a new match! Start the conversation now!";
            $message1       =  "Congratulations! You've got a new match! 🎉 Start the conversation now!";

            $details        =  ['message' => $message, 'type' => $type, 'respected_id' => "$user_id"];

            NotificationHelper::sendNotification($partner->device_token, $title, $message, $details);
            NotificationHelper::saveNotification($partner_id, $type, $title, $message1, $user_id);

            // === Send Notification to Partner ============================

            $details        =  ['message' => $message, 'type' => $type, 'respected_id' => "$partner_id"];

            NotificationHelper::sendNotification($user->device_token, $title, $message, $details);
            NotificationHelper::saveNotification($user_id, $type, $title, $message1, $partner_id);

            // =============================================================

            $data['its_a_match'] = 1;
        }

        return response()->json(['status' => true, 'message' => ucfirst($request->user_status) . ' user successful', 'data' => $data], 200);
    }

    function matchedUserList()
    {

        $loggedUser    = $this->loggedInUser->id;
        $isMatchedIds  = LikesMatch::where('user_id', $loggedUser)->pluck('partner_id')->toArray();

        $getBlockedIds = User::where('id', $loggedUser)->first('blocked_ids');

        $allIds        = explode(',', $getBlockedIds->blocked_ids);

        $user_data_query = User::active()->select('id', 'name')
            ->where('id', '!=', $loggedUser)
            ->whereNotIn('id', $allIds)
            ->with('userDetails:user_id,profile_images,job_role');

        $user_data_query->whereIn('id', $isMatchedIds);

        $user_data = $user_data_query->get();

        return response()->json(['status' => true, 'message' => 'Matched user list', 'data' => $user_data], 200);
    }

    public function extendChat(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'match_id'  =>  'required|exists:matches,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()], 422);
        }

        $match      =  Matches::findOrFail($request->match_id);

        $expire_at  =  Carbon::parse($match->expire_at)->addHours(24);

        $extend     =  Matches::where('id', $request->match_id)->update(['is_extend' => 1, 'expire_at' => $expire_at]);

        if ($extend) {

            $loginId  =  $this->loggedInUser->id;

            if ($loginId == $match->user1_id) {
                $user_id    = $match->user1_id;
                $partner_id = $match->user2_id;
            } else {
                $user_id    = $match->user2_id;
                $partner_id = $match->user1_id;
            }

            $partner = User::select('device_token')->find($partner_id);

            // === Send Notification to User

            $type           =  'extend';

            $title          =  "Rematch Opportunity!";
            $message        =  "Missed connection? You have a rematch opportunity! Give it another shot!";
            $message1       =  "Missed connection? You have a rematch opportunity! 🔁 Give it another shot!";
            $details        =  ['message' => $message, 'type' => $type, 'respected_id' => "$user_id"];

            NotificationHelper::sendNotification($partner->device_token, $title, $message, $details);
            NotificationHelper::saveNotification($user_id, $type, $title, $message1, $partner_id);

            // ============================================================

            return response()->json(['status' => true, 'message' => 'Extend successfully']);
        } else {
            return response()->json(['status' => true, 'message' => 'not extended']);
        }
    }

    public function notForMe(Request $request)
    {

        $user_id = $this->loggedInUser->id;

        $reportingUserDetail = User::where('id', $user_id)->firstOrFail();

        // Get the current blocked_ids value
        $notForMeIds          = $reportingUserDetail->blocked_ids;

        // Convert the string to an array
        $notForMeIdsArray     = $notForMeIds ? explode(',', $notForMeIds) : [];

        // Add the new ID if it's not already in the array
        $reportedUserId      = (string) $request->user_id;
        if (!in_array($reportedUserId, $notForMeIdsArray)) {
            $notForMeIdsArray[] = $reportedUserId;
        }

        // Convert the array back to a comma-separated string
        $reportingUserDetail->not_for_me_ids = implode(',', $notForMeIdsArray);

        // Save the updated user detail record not-for-me
        $reportingUserDetail->save();

        return response()->json(['status' => true, 'message' => 'Check out later! In case you change mind.']);
    }

    /**
     * Get the list of matches for a user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMatchList(Request $request)
    {
        $userId = $request->user()->id;

        $getBlockedIds = User::where('id', $userId)->first('blocked_ids');

        $allIds        = explode(',', $getBlockedIds->blocked_ids);

        $matches       = Matches::where('user1_id', $userId)
            ->orWhere('user2_id', $userId)
            ->whereNotIn('user2_id', $allIds)
            ->whereNotIn('user1_id', $allIds)
            ->with(['user1', 'user2'])
            ->get()
            ->map(function ($match) use ($userId) {

                $matchedUser   = $match->user1_id === $userId ? $match->user2 : $match->user1;

                $expiryDate    = Carbon::parse($match->expire_at);

                $now           = Carbon::now();

                $diffInHours   = $expiryDate->diffInHours($now);  // Total difference in hours

                $diffInMinutes = $expiryDate->diffInMinutes($now) % 60;  // Remaining minutes

                return [
                    'match_id' => $match->id,
                    'user_details' => [
                        'id'       => $matchedUser->id,
                        'name'     => $matchedUser->name,
                        'email'    => $matchedUser->email,
                        'job_role' => $matchedUser->userDetails->job_role,
                        'profile_images' => $matchedUser->image_profile
                        // Add other fields as needed
                    ],
                    'created_at'   => $match->created_at,
                    'is_extend'    => $match->is_extend,
                    'expire_hour'  => $diffInHours,
                    'expire_min'   => $diffInMinutes,
                    'expire_in_hour_min'  => "{$diffInHours} hours and {$diffInMinutes} minutes"
                ];
            });

        return response()->json(['status' => true, 'message' => 'Match list fetched successfully', 'data' => $matches]);
    }
}
