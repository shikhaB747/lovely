<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\{Interaction as LikesMatch, MembershipPlan, PurchasedPlan, User};
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserListController extends Controller
{
 
    public function specialUserList(Request $request)
    {
        $list_type      =  $request->list_type;  // list_type = liked, superLiked, popular

        $loggedUser     =  $this->loggedInUser->id;

        $getBlockedIds  =  User::where('id', $loggedUser)->first('blocked_ids', 'not_for_me_ids');

        $allIds         =  explode(',', $getBlockedIds->blocked_ids);

        $user           =  User::find($loggedUser);

        $array1         =  $user->userDetails->all_interests ?? array();

        $query          =  User::active()->select('id', 'name', 'image_profile')
            ->where('id', '!=', $loggedUser)
            ->whereNotIn('id', $allIds)
            ->with('userDetails:user_id,job_role,profile_score,all_interests,about_me');

        if ($list_type == 'liked') {

            $getLikedUserList = LikesMatch::where(['partner_id' => $loggedUser, 'interaction_type' => 'like'])->pluck('user_id')->toArray();

            $query->whereIn('id', $getLikedUserList);
        }

        if ($list_type == 'superLiked') {

            $getSuperLikeUser = LikesMatch::where(['partner_id' => $loggedUser, 'interaction_type' => 'super-like'])->pluck('user_id')->toArray();

            $query->whereIn('id', $getSuperLikeUser);
        }

        if ($list_type == 'popular') {

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
                $match_percent = count($matchingValues);
            }

            // Fetch like and dislike status
            $likeStatus = LikesMatch::where([
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

            // Assign the match percentage
            $data_user->match_percent   =  $match_percent * 10;

            $data_user->likeStatus      =  $likeStatus->user_status ?? 0;
            $data_user->dislikeStatus   =  $dislikeStatus->user_status ?? 0;
            $data_user->is_match        =  isMatched($loggedUser, $data_user->id);
            $data_user->notForMeIds     =  notForMe($loggedUser, $data_user->id);

            unset($data_user->userDetails);
        }

        return response()->json(['status' => true, 'message' => 'User list', 'data' => $user_data], 200);
    }

    function userList(Request $request)
    {
        $loggedUserId = $this->loggedInUser->id;
        $list_type = $request->list_type;  // list_type = liked, superLiked, popular

        $user = User::with('userDetails')->find($loggedUserId);
        
        // Fetch blocked and not-for-me IDs
        $blockedIds    = explode(',', $user->blocked_ids);
        
        $snoozeUserIds = User::where(function ($query) {
            $query->orWhere('snooze_hour', '>', 1)
            ->where('snooze_till', '>', Carbon::now());
            $query->where('snooze_hour', '<', 0);
        })->pluck('id')->toArray();

        // Fetch incognito user IDs
        $incogUsers = User::where('id', '!=', $loggedUserId)
            ->where('incognito_mode', 1)
            ->with(['interactions' => function ($query) use ($loggedUserId) {
                $query->where('user_id', $loggedUserId);
            }])
            ->get();

        $incogUserIds = $incogUsers->pluck('id')->toArray();


  
        $allIds       = $incogUsers->filter(function ($user) {
            return $user->interactions->isNotEmpty();
        })->pluck('partner_id')->toArray();

        $commonValues    = array_intersect($incogUserIds, $allIds);
                                                                            
        $remainingValues = array_diff($incogUserIds, $allIds, $commonValues);

        $excludeIds      = array_merge($remainingValues, $snoozeUserIds, $allIds, $blockedIds, [$loggedUserId]);

        $query = User::active()
            ->select('id', 'name', 'image_profile')
            ->whereNotIn('id', $excludeIds)
            ->with('userDetails:user_id,job_role,profile_score,all_interests,about_me');

        // Apply list_type filter
        if ($list_type == 'popular') {

            $spotlightPlanIds = MembershipPlan::where('category', 'Spotlight')->pluck('id')->toArray();
            $now = Carbon::now()->format('Y-m-d');
            $spotlightUserIds = PurchasedPlan::whereIn('membership_id', $spotlightPlanIds)
                ->where('end_date', '>=', $now)
                ->pluck('user_id')->toArray();

            $popularUserIds  = User::where('total_super_likes_points', '>', 5)
            ->pluck('id')->toArray();
  
            $popularIds = array_merge($spotlightUserIds, $popularUserIds);
            $query->whereIn('id', $popularIds);
        }

        // Filter by "Who you want to date"
        if ($request->has('gender')) {
            $gender  =  explode(',', $request->gender);

            $query->whereIn('gender', $gender);
        } else {
            $query->where('gender', $user->userDetails->like_to_date);
        }

        // Apply filters
        $filters = [
            'age_min' => function ($query, $value) use ($request) {
                $query->whereBetween('age', [$value, $request->age_max]);
            },
            'language' => function ($query, $value) {
                $languages = explode(',', $value);
                $query->whereHas('userDetails', function ($subQuery) use ($languages) {
                    foreach ($languages as $language) {
                        $subQuery->whereRaw('JSON_CONTAINS(language, ?)', [json_encode($language)]);
                    }
                });
            },
            'height_min' => function ($query) use ($request) {
                $query->whereHas('userDetails', function ($subQuery) use ($request) {
                    $subQuery->whereBetween('height', [$request->height_min, $request->height_max]);
                });
            },
            'relationship_status' => function ($query, $value) {
                $query->whereHas('userDetails', function ($subQuery) use ($value) {
                    $subQuery->where('relationship_status', 'like', "%{$value}%");
                });
            },
            'do_smoke' => function ($query, $value) {
                $query->whereHas('userDetails', function ($subQuery) use ($value) {
                    $subQuery->where('do_smoke', 'like', "%{$value}%");
                });
            },
            'do_drink' => function ($query, $value) {
                $query->whereHas('userDetails', function ($subQuery) use ($value) {
                    $subQuery->where('do_drink', 'like', "%{$value}%");
                });
            },
            'religion' => function ($query, $value) {
                $query->whereHas('userDetails', function ($subQuery) use ($value) {
                    $subQuery->where('identify_religion', 'like', "%{$value}%");
                });
            },
            'have_children' => function ($query, $value) {
                $query->whereHas('userDetails', function ($subQuery) use ($value) {
                    $subQuery->where('have_children', 'like', "%{$value}%");
                });
            },
            'education' => function ($query, $value) {
                $query->whereHas('userDetails', function ($subQuery) use ($value) {
                    $subQuery->where('education', 'like', "%{$value}%");
                });
            },
            'political' => function ($query, $value) {
                $query->whereHas('userDetails', function ($subQuery) use ($value) {
                    $subQuery->where('political_leanings', 'like', "%{$value}%");
                });
            },
            'exercise' => function ($query, $value) {
                $query->whereHas('userDetails', function ($subQuery) use ($value) {
                    $subQuery->where('do_work_out', 'like', "%{$value}%");
                });
            },
        ];

        foreach ($filters as $key => $filter) {
            if ($request->has($key)) {
                $filter($query, $request->input($key));
            }
        }

        $query->whereHas('userDetails', function ($subQuery) {
            $subQuery->whereNotNull('all_interests');
        });

        $user_data = $query->get();


        $array1       = $user->userDetails->all_interests ?? [];

        if (is_string($array1)) {
            $array1 = json_decode($array1, true);
        }

        foreach ($user_data as $data_user) {
            $match_percent = 0;

            $array2 = $data_user->userDetails->all_interests ?? [];
            if (is_string($array2)) {
                $array2 = json_decode($array2, true);
            }

            if (is_array($array1) && is_array($array2)) {
                $matchingValues = array_intersect($array1, $array2);
                $match_percent = count($matchingValues);
            }

            $mergedArray = array_merge($array1, $array2);
            $uniqueValues = array_unique($mergedArray);
            $count = count($uniqueValues);

            $data_user->match_percent = number_format(($match_percent * 100) / $count);
            $data_user->likeStatus = LikesMatch::where([
                'user_id' => $loggedUserId,
                'partner_id' => $data_user->id,
                'interaction_type' => 'like'
            ])->value('interaction_type') ?? 0;

            $data_user->dislikeStatus = LikesMatch::where([
                'user_id' => $loggedUserId,
                'partner_id' => $data_user->id,
                'interaction_type' => 'dislike'
            ])->value('interaction_type') ?? 0;

            $data_user->is_match = isMatched($loggedUserId, $data_user->id);
            $data_user->notForMeIds = notForMe($loggedUserId, $data_user->id);

            $data_user->job_role = $data_user->userDetails->job_role ?? 'NA';
            $data_user->about_me = $data_user->userDetails->about_me ?? 'NA';
            $data_user->name = $data_user->name ?: 'Guest00' . $data_user->id;

            unset($data_user->userDetails);
        }

        return response()->json(['status' => true, 'message' => 'User list', 'data' => $user_data], 200);
    }
}
