<?php

namespace App\Http\Controllers\API;

use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\{MembershipPlan, PurchasedPlan, User};
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Validator};

class MembershipController extends Controller
{
    function index(Request $request)
    {

        $category = $request->category;
        $memberShipPlanList = MembershipPlan::query();

        if (!empty($category)) {
            $memberShipPlanList->where('category', 'LIKE', '%' . $category . '%');
        }

        $plansList = $memberShipPlanList->where('status', '0')->get();

        return response()->json(['status' => true, 'message' => 'Membership plans', 'data' => $plansList]);
    }

    function purchasePlan(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'plan_id'  =>  'required',
            'price'    =>  'required',
        ]);

        $plan_id  =  $request->plan_id;
        $user_id  =  $this->loggedInUser->id;

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()], 422);
        }

        $getPlanDays = MembershipPlan::findOrFail($plan_id);

        $planExpiry  = Carbon::now()->addDays($getPlanDays->validity);

        $data = ['user_id' => $this->loggedInUser->id, 'membership_id' => $plan_id, 'purchase_date' => Carbon::now(), 'start_date' => Carbon::now(), 'end_date' => $planExpiry, 'price' => $request->price];

        $planPurchaseStatus = PurchasedPlan::create($data);

        if ($planPurchaseStatus) {

            $user = User::find($user_id);
            // make user premium
            User::where(['id' => $user_id])->update(['is_premium' => 1, 'premium_expiry_date' => $planExpiry]);

            // === Send Notification to User of plan purchased

            $type           =  'premium';
            $title          =  "You became premium!";
            $message        =  "Enjoy premium services!";
            $details        =  ['message' => $message, 'type' => $type, 'respected_id' => "$user_id"];

            NotificationHelper::sendNotification($user->device_token, $title, $message, $details);
            NotificationHelper::saveNotification($user_id, $type, $title, $message, 0);

            // ============================================================

            return response()->json(['status' => true, 'message' => 'Plan purchased successfully']);
        } else {
            return response()->json(['status' => false, 'message' => 'Plan purchasing failed']);
        }
    }

    function premiumProfile()
    {
        $plans = MembershipPlan::select('category', DB::raw('MIN(price) as min_price'))
            ->groupBy('category')
            ->get();

        $categoryWithDescription = [];

        foreach ($plans as $plan) {
            $description = MembershipPlan::where('category', $plan->category)
                ->where('price', $plan->min_price)
                ->value('description');
            $categoryWithDescription[] = [
                'category'    => $plan->category,
                'description' => $description,
                'min_price'   => $plan->min_price,
            ];
        }

        if ($plans) {
            return response()->json(['status' => true, 'message' => 'Plan data list', 'data' => $categoryWithDescription]);
        } else {
            return response()->json(['status' => false, 'message' => 'Plan purchasing failed']);
        }
    }
}
