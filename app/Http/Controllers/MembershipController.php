<?php

namespace App\Http\Controllers;

use App\Models\MembershipPlan;
use App\Models\PurchasedPlan;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function index()
    {

        $memberShipPlanList = MembershipPlan::query();

        $memberShipPlanList->where('category', 'LIKE', '%Premium%');

        $plansList = $memberShipPlanList->get();

        return view('membership', compact('plansList'));
    }

    public function editPremiumPlan($id)
    {
        $premium = MembershipPlan::where('id', $id)->first();
        return view('edit-membership', compact('premium'));
    }

    public function editSuperLike($id)
    {
        $premium = MembershipPlan::where('id', $id)->first();
        return view('edit-superlike', compact('premium'));
    }

     public function editSpotLight($id)
    {
        $premium = MembershipPlan::where('id', $id)->first();
        return view('edit-spotlight', compact('premium'));
    }

    public function superLikePlan()
    {

        $memberShipPlanList = MembershipPlan::query();

        $memberShipPlanList->where('category', 'LIKE', '%Super like%');

        $plansList = $memberShipPlanList->get();

        return view('superlike', compact('plansList'));
    }

    public function spotLightPlan()
    {

        $memberShipPlanList = MembershipPlan::query();

        $memberShipPlanList->where('category', 'LIKE', '%Spotlight%');

        $plansList = $memberShipPlanList->get();

        return view('spotlight', compact('plansList'));
    }

    public function addPremium(Request $request)
    {

        $minPrice = MembershipPlan::where('category', 'LIKE', 'Premium')->min('price');

        $plans    = MembershipPlan::select('*')
            ->where('category', 'LIKE', 'Premium')
            ->where('price', $minPrice)
            ->first();

        $request['category']    = $request->category;

        $request['title']       = $request->title ?? $plans->title;
        
        MembershipPlan::create($request->all());

        return redirect()->back()->with('success', 'Premium plan added successfully');
    }

    public function editPremium(Request $request)
    {

        $id                  = $request->id;
        
        $plans               = MembershipPlan::where('id', $id)->first();
 
        $data['title']       = $request->title ?? $plans->title;
        
        $data['description'] = $request->description ? $plans->description : null;

        $data['validity']    = $request->validity ? $plans->validity : 1;
        
        $data['spot_light_count'] = $request->spot_light_count ;
        
        $data['super_likes_count'] = $request->super_likes_count ;

        $data['price']       = $request->price ?? $plans->price;
        
        $data['discount']    = $request->discount ?? $plans->discount;

        $data['duration']    = $request->duration ? $plans->duration : null;

        MembershipPlan::where('id', $request->id)->update($data);

        return redirect()->back()->with('success', 'Plan updated successfully');
    }

     /**
     * Function : status
     * Desc : plan status update
     */
    public function premiumStatusUpdate($id, $status)
    {
        try {
            $category = MembershipPlan::where('id', $id)->update(['status'=>$status]);
            if ($category) {

                $getData = MembershipPlan::select('status')->where('id', $id)->first();

                return ['success' => true, 'message' => ($getData->status == '0') ? 'Plan Activated Successfully' : 'Plan Inactive Successfully'];
            } else {
                return ['success' => false, 'message' => 'Something went wrong !!'];
            }
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage(), 'errors' => array('message' => $e->getMessage())];
        }
    }

      /**
     * Function : deleted
     * Desc : delete category data
     */
    public function delete($id)
    {
        try {
            // $delete = MembershipPlan::where('id', $id)->delete();
            $delete = MembershipPlan::where('id', $id)->update(['status'=>3]);
            if ($delete) {
                return ['success' => true, 'message' => 'Plan deleted successfully'];
            } else {
                return ['success' => false, 'message' => 'Something went wrong !!'];
            }
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage(), 'errors' => array('message' => $e->getMessage())];
        }
    }

    /**
     * Function : deleted
     * Desc : delete category data
     */
    public function creditHistory(Request $request)
    {
        $credit = PurchasedPlan::with('user:id,name,image_profile','membershipPlan')->orderBy('id','desc')->get();
        return view('credit-history', compact('credit'));
    }

}
