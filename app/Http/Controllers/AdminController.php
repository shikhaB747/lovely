<?php

namespace App\Http\Controllers;

use App\Models\{Interest, PurchasedPlan, User};
use Illuminate\Http\Request;

class AdminController extends Controller
{

  function index()
  {
    $users = User::with('userDetails')->latest()->get();

    return view('users', compact('users'));
  }

  public function userDetail($id)
  {
    $data = User::with('userDetails')->where('id', $id)->first();

    $credit = PurchasedPlan::with('user:id,name,image_profile','membershipPlan')->where('user_id', $id)->orderBy('id','desc')->get();
      
    return view('user-detail', compact('data', 'credit'));
  }

  /**
   * Function : status
   * Desc : plan status update
   */
  public function userStatusUpdate($id, $status)
  {

    try {
      $category = User::where('id', $id)->update(['status' => $status]);
      if ($category) {

        $getData = User::select('status')->where('id', $id)->first();

        return ['success' => true, 'message' => ($getData->status == '0') ? 'User Activated Successfully' : 'User Inactive Successfully'];
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
      $delete = User::where('id', $id)->delete();
      if ($delete) {
        return ['success' => true, 'message' => 'User deleted successfully'];
      } else {
        return ['success' => false, 'message' => 'Something went wrong !!'];
      }
    } catch (\Exception $e) {
      return ['success' => false, 'message' => $e->getMessage(), 'errors' => array('message' => $e->getMessage())];
    }
  }

  /**
   * Function : interest
   * Desc : interest data
   */
  public function interest()
  {
    $interest = Interest::orderBy('id', 'desc')->get();

    return view('interest', compact('interest'));
  }

  /**
   * Function : add interest
   * Desc : interest data
   */
  public function addInterest(Request $request)
  {

    $data['title']     = $request->title;
    $data['sub_title'] = implode(',', $request->possasive);

    Interest::create($data);

    return redirect()->back()->with('success', 'Interest added successfully');
  }

  public function editInterest($id)
  {
    $interest = Interest::where('id', $id)->first();
    return view('edit-interest', compact('interest'));
  }

  public function saveInterest(Request $request)
  {

      $id                = $request->id;

      $data['title']     = $request->title;
      $data['sub_title'] = implode(',', $request->possasive);

      Interest::where('id', $id)->update($data);

      return redirect()->back()->with('success', 'Interest updated successfully');
  }
}
