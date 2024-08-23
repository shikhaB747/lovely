<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\{Interest, ReportSupport, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function getInterestList()
    {
        $data = Interest::get();
        return response()->json(['status' => true, 'message' => 'Interest list', 'data' => $data]);
    }

    /** Block User */
    public function addBlockedId(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'new_blocked_id'  =>  'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()], 422);
        }

        $id         =  $this->loggedInUser->id;

        // Fetch the user detail record
        $userDetail = User::find($id);

        // Get the current blocked_ids value
        $blockedIds = $userDetail->blocked_ids;

        // Convert the string to an array
        $blockedIdsArray = $blockedIds ? explode(',', $blockedIds) : [];

        // Add the new ID if it's not already in the array (string)
        $newBlockedId =  $request->input('new_blocked_id');
        if (!in_array($newBlockedId, $blockedIdsArray)) {
            $blockedIdsArray[] = $newBlockedId;
        }

        // Convert the array back to a comma-separated string
        $userDetail->blocked_ids = implode(',', $blockedIdsArray);

        // Save the updated user detail record
        $userDetail->save();

        return response()->json(['status' => true, 'message' => 'Blocked ID added successfully.', 'data' => $userDetail], 200);
    }

    /** Report User */
    public function reportUser(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'reported_user_id'  =>  'required|exists:users,id',
            'reason'            =>  'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()], 422);
        }

        // Fetch the reporting user's detail record
        $reportingUserDetail = User::where('id', $this->loggedInUser->id)->firstOrFail();

        // Get the current blocked_ids value
        $blockedIds = $reportingUserDetail->blocked_ids;

        // Convert the string to an array
        $blockedIdsArray = $blockedIds ? explode(',', $blockedIds) : [];

        // Add the new ID if it's not already in the array
        $reportedUserId = (string) $request->reported_user_id;
        if (!in_array($reportedUserId, $blockedIdsArray)) {
            $blockedIdsArray[] = $reportedUserId;
        }

        // Convert the array back to a comma-separated string
        $reportingUserDetail->blocked_ids = implode(',', $blockedIdsArray);

        // Save the updated user detail record
        $reportingUserDetail->save();

        // Optionally, save the report to a UserReport model for record-keeping
        ReportSupport::create([
            'user_id'          => $this->loggedInUser->id,
            'reported_user_id' => $request->reported_user_id,
            'reason'           => $request->reason,
            'row_type'         => 'report'
        ]);

        return response()->json(['status' => true, 'message' => 'User reported and blocked successfully.'], 200);
    }

    /** Support & Delete User */
    public function supportNDeleteUser(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'reason'            => 'required|string',
            'type'              => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()], 422);
        }

        if ($request->type == 'delete') {

            User::destroy($this->loggedInUser->id);
            SELF::logout();

            return response()->json(['status' => true, 'message' => 'Account removed.'], 200);
        }

        $attachment = "";
        if ($request->hasFile('image')) {
            $attachment = fileUpload($request->file('image'), 'attachment'); // image upload ===
        }

        // Optionally, save the report to a UserReport model for record-keeping
        ReportSupport::create([
            'user_id'    => $this->loggedInUser->id,
            'row_type'   => $request->type,
            'question'   => $request->question,
            'reason'     => $request->reason,
            'attachment' => $attachment
        ]);

        return response()->json(['status' => true, 'message' => 'Support message send successfully.'], 200);
    }

    /**
     * Logout api
     *
     * @return \Illuminate\Http\Response
     */
    function logout()
    {
        $user = $this->loggedInUser;
        $user->tokens()->delete();
        return response()->json(['status' => true, 'message' => 'Logout Successfully!']);
    }

    public function checkUserStatus()
    {
        $getUserStatus  =  User::find($this->loggedInUser->id);

        return response()->json([ 'status' => true, 'message' => 'User status', 'status'=>$getUserStatus->status ], 200);
    } 

    function userList_old(Request $request)
    {

        $list_type     =  $request->list_type;  // list_type = liked, superLiked, popular

        $loggedUser    =  $loggedUserId = $this->loggedInUser->id;

        $distance      =  $request->distance;

        $getBlockedIds =  User::where('id', $loggedUser)->first('blocked_ids', 'not_for_me_ids');

        $allBlockedIds =  explode(',', $getBlockedIds->blocked_ids);

        $user          =  User::find($loggedUser);

        $like_to_date  =  $user->userDetails->like_to_date;

        $array1        =  $user->userDetails->all_interests ?? array();

        // Fetch all incognito profiles and their interactions with the logged user in one go
        $incogUsers = User::where('id', '!=', $loggedUserId)
            ->where('incognito_mode', 1)
            ->with(['interactions' => function ($query) use ($loggedUserId) {
                $query->where('user_id', $loggedUserId);
            }])
            ->get();


        $allIds = $remainingValues = [];

        foreach ($incogUsers as $cogUser) {
            if ($cogUser->interactions->isNotEmpty()) {
                $allIds[] = $cogUser->partner_id;
            }
        }

        $incogUserIds     =  $incogUsers->pluck('id')->toArray();

        $commonValues     =  array_intersect($incogUserIds, $allIds);

        // dd($commonValues);

        $remainingValues  =  array_diff($incogUserIds, $allIds, $commonValues);

        // Get Ids of those users who have set snooze time
        $snoozeUsers = User::where(function ($query) {

            $query->where('snooze_hour', '=', 1)
                ->orWhere(function ($query) {
                    $query->where('snooze_hour', '>', 1)
                        ->where('snooze_till', '>', Carbon::now());
                });
        })
            ->pluck('id')
            ->toArray();

        $allValuesAfterMerge = array_merge($remainingValues, $snoozeUsers, $allIds, $allBlockedIds);

        array_push($allValuesAfterMerge, $loggedUserId);

        // ==============================================

        $query = User::active()->select('id', 'name', 'image_profile')
            ->whereNotIn('id', $allValuesAfterMerge)
            //->orWhereIn('id', $commonValues)
            ->with('userDetails:user_id,job_role,profile_score,all_interests,about_me');


        // ================ LIST_TYPE Filter ============

        if ($list_type == 'popular') {

            /* $getPopularUser = LikesMatch::groupBy('partner_id')->pluck('partner_id')->toArray();
            $query->whereIn('id', $getPopularUser); */

            // === fetch spotlight user

            $getPlanIds       = MembershipPlan::where('category', 'Spotlight')->pluck('id')->toArray();

            $now              = Carbon::now()->format('Y-m-d');

            $getSpotLightUser = PurchasedPlan::whereIn('membership_id', $getPlanIds)->where('end_date', '>=', $now)->pluck('user_id')->toArray();

            // ======================

            $getPopularUser = User::where('total_super_likes_points', '>', '5')

                ->pluck('id')
                ->toArray();

            $allIdssss = array_merge($getSpotLightUser,  $getPopularUser);

            // Apply the IDs to the query

            $query->whereIn('id', $allIdssss);
        }

        // ==== FILTERS SECTION ============

        // Filter by "Who you want to date"
        if ($request->has('gender')) {
            $gender  =  explode(',', $request->gender);

            $query->whereIn('gender', $gender);
        } else {
            $query->where('gender', $like_to_date);
        }

        // Filter by age range ============
        if ($request->has('age_min') && $request->has('age_max')) {
            $query->whereBetween('age', [$request->age_min, $request->age_max]);
        }

        // Filter by language ============
        if ($request->has('language') && $request->language) {
            $languages = explode(',', $request->input('language')); // Use input() to get the parameter

            $query->whereHas('userDetails', function ($subQuery) use ($languages) {
                foreach ($languages as $language) {
                    $subQuery->whereRaw('JSON_CONTAINS(`language`, ?)', [json_encode($language)]);
                }
            });
        }

        // Filter by age range ============
        if ($request->has('height_min') && $request->has('height_max')) {
            $query->whereHas('userDetails', function ($subQuery) use ($request) {
                $subQuery->whereBetween('age', [$request->height_min, $request->height_max]);
            });
        }

        // Filter by relationship_status ============
        if ($request->has('relationship_status')) {
            $query->whereHas('userDetails', function ($subQuery) use ($request) {
                $subQuery->where('relationship_status', 'like', "%{$request->relationship_status}%");
            });
        }

        // Filter by do_smoke ============
        if ($request->has('do_smoke')) {
            $query->whereHas('userDetails', function ($subQuery) use ($request) {
                $subQuery->where('do_smoke', 'like', "%{$request->do_smoke}%");
            });
        }

        // Filter by do_drink ============
        if ($request->has('do_drink')) {
            $query->whereHas('userDetails', function ($subQuery) use ($request) {
                $subQuery->where('do_drink', 'like', "%{$request->do_drink}%");
            });
        }

        // Filter by religion ============
        if ($request->has('religion')) {
            $query->whereHas('userDetails', function ($subQuery) use ($request) {
                $subQuery->where('identify_religion', 'like', "%{$request->religion}%");
            });
        }

        // Filter by have_children ============
        if ($request->has('have_children')) {
            $query->whereHas('userDetails', function ($subQuery) use ($request) {
                $subQuery->where('have_children', 'like', "%{$request->have_children}%");
            });
        }

        // Filter by education ============
        if ($request->has('education')) {
            $query->whereHas('userDetails', function ($subQuery) use ($request) {
                $subQuery->where('education', 'like', "%{$request->education}%");
            });
        }

        // Filter by political ============
        if ($request->has('political')) {
            $query->whereHas('userDetails', function ($subQuery) use ($request) {
                $subQuery->where('political_leanings', 'like', "%{$request->political}%");
            });
        }

        // Filter by exercise ============
        if ($request->has('exercise')) {
            $query->whereHas('userDetails', function ($subQuery) use ($request) {
                $subQuery->where('do_work_out', 'like', "%{$request->exercise}%");
            });
        }

        // ======== FILTERS SECTION END ========

        $query->whereHas('userDetails', function ($subQuery) {
            $subQuery->whereNotNull('all_interests');
        });

        $user_data = $query->get();

        // Assuming $array1 is defined somewhere before this portion of code
        // Ensure $array1 is an array
        if (is_string($array1)) {
            $array1 = json_decode($array1, true);
        }

        foreach ($user_data as $data_user) {

            $match_percent = 0;

            // Get user interests
            $array2 = $data_user->userDetails->all_interests ?? [];

            // Decode JSON strings if necessary
            if (is_string($array2)) {
                $array2 = json_decode($array2, true);
            }

            // Ensure both arrays are indeed arrays
            if (is_array($array1) && is_array($array2)) {
                // Find the intersection of the two arrays
                $matchingValues = array_intersect($array1, $array2);

                // Count the number of matching values
                $match_percent  = count($matchingValues);
            }

            // Fetch like and dislike status
            $likeStatus    = LikesMatch::where([
                'user_id'          => $loggedUser,
                'partner_id'       => $data_user->id,
                'interaction_type' => 'like'
            ])->first();

            $dislikeStatus = LikesMatch::where([
                'user_id'          => $loggedUser,
                'partner_id'       => $data_user->id,
                'interaction_type' => 'dislike'
            ])->first();

            // Assign default values if necessary
            $data_user->job_role = $data_user->userDetails->job_role ?? 'NA';
            $data_user->about_me = $data_user->userDetails->about_me ?? 'NA';
            $data_user->name     = ($data_user->name == "") ? 'Guest00' . $data_user->id : $data_user->name;

            $mergedArray  = array_merge($array1, $array2);

            // Get the unique values from the merged array
            $uniqueValues = array_unique($mergedArray);

            // Count the number of unique values
            $count        = count($uniqueValues);

            // Assign the match percentage
            $data_user->match_percent   =  number_format(($match_percent * 100) / $count);

            $data_user->likeStatus      =  $likeStatus->user_status ?? 0;
            $data_user->dislikeStatus   =  $dislikeStatus->user_status ?? 0;
            $data_user->is_match        =  isMatched($loggedUser, $data_user->id);
            $data_user->notForMeIds     =  notForMe($loggedUser, $data_user->id);

            unset($data_user->userDetails);
        }

        return response()->json(['status' => true, 'message' => 'User list', 'data' => $user_data], 200);
    }

}
