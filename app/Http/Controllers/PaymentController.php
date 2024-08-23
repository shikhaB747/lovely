<?php

namespace App\Http\Controllers;

use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\{MembershipPlan, PurchasedPlan, User};
use Carbon\Carbon;
use Error;
use Stripe;

class PaymentController extends Controller
{
    public $stripe;
    public $API_KEY;

    function __construct()
    {
        $key            =   env('STRIPE_SECRET');
        $this->API_KEY  =   $key;
        $this->stripe   =   new \Stripe\StripeClient($key);
    }

    /**===== Payment for Plan ===== */

    public function payment(Request $request)
    {
        // ======== Validate the request data =======
        $validator = Validator::make($request->all(), [
            'user_id'   =>  'required|exists:users,id',
            'plan_id'   =>  'required|exists:membership_plans,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()], 422);
        }

        // Set session data
        $plan_id  =  $request->plan_id;
        $user_id  =  $request->user_id;

        session()->put('plan_id', $plan_id);
        session()->put('user_id', $user_id);

        $price   =  MembershipPlan::find($plan_id);

        $amount  =  $price->price;

        return view('payment/payment', compact('amount'));
    }

    public function purchasePlan()
    {

        Stripe\Stripe::setApiKey($this->API_KEY);

        header('Content-Type: application/json');

        // Get data
        $plan_id  =  session()->get('plan_id');
        $user_id  =  session()->get('user_id');

        try {
            // retrieve JSON from POST body
            $jsonStr = file_get_contents('php://input');
            $jsonObj = json_decode($jsonStr);

            // Create a PaymentIntent with amount and currency
            $paymentIntent     = \Stripe\PaymentIntent::create([
                'amount'       => $jsonObj->items[0]->amount * 100,
                'currency'     => 'gbp', // gbp, ngn
                'automatic_payment_methods' => [
                    'enabled'  => true,
                ],
                'metadata' => [
                    'plan_id'  => $plan_id,
                    'user_id'  => $user_id
                ]
            ]);

            $output = [
                'clientSecret' => $paymentIntent->client_secret,
            ];
            echo json_encode($output);
        } catch (Error $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function fail_payment()
    {
        return view('payment/payment_fail');
    }

    public function success_payment(Request $request)
    {
        // Set your Stripe API key
        Stripe\Stripe::setApiKey($this->API_KEY);

        // Retrieve the PaymentIntent ID from the query parameters or session
        $paymentIntent = $this->stripe->paymentIntents->retrieve(
            $request->input('payment_intent'),
            []
        );

        $plan_id  =  $paymentIntent->metadata->plan_id ?? session()->get('plan_id');
        $user_id  =  $paymentIntent->metadata->user_id ?? session()->get('user_id');

        $plan     =  MembershipPlan::where('id', $plan_id)->first();
        
        $validity =  $days   =  $plan->validity;

        $planExpiry          =  Carbon::now()->addDays($days);

        $data     = [
            'user_id'        => $user_id,
            'membership_id'  => $plan_id,
            'purchase_date'  => Carbon::now(),
            'start_date'     => Carbon::now(),
            'end_date'       => $planExpiry,
            'price'          => $plan->price,
            'validity'       => $validity,
            'payment_method' => 'STRIPE',
            'txn_id'         => $paymentIntent->id
        ];

        $planPurchaseStatus = PurchasedPlan::create($data);

        if ($planPurchaseStatus) {

            $user = User::find($user_id);
            
            // ============ make user premium =============================

            $userData['available_spotlight']   = $user->available_spotlight + $plan->spot_light_count ;

            $userData['available_super_likes'] = $user->available_super_likes + $plan->super_likes_count ; 

            $userData['is_premium']            = ($plan->category == 'Premium') ? 1 : 0;

            $userData['premium_expiry_date']   = $planExpiry;
 
            User::where(['id' => $user_id])->update($userData);

            // ============ Send Notification to User of plan purchased ===

            $type           =  $plan->category;
            $title          =  "Plan purchased!";
            $message        =  "Enjoy services!";
            $details        =  ['message' => $message, 'type' => $type, 'respected_id' => "$user_id"];

            NotificationHelper::sendNotification($user->device_token, $title, $details);
            NotificationHelper::saveNotification($user_id, $type, $title, $message, 0);

            // ==============================================================

            return view('payment/payment_success');
        } else {

            return view('payment/payment_fail');
        }
    }
}
