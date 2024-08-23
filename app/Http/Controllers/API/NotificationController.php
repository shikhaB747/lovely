<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\{User, Notification, NotificationPreference};
use App\Helpers\NotificationHelper;
use Illuminate\Support\Facades\{Auth, Validator as FacadesValidator};

class NotificationController extends BaseController
{

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index(Request $request)
   {
      $user = Auth::user();

      Notification::where('user_id', $user->id)->update(['read_at' => date('y-m-d h:i:s')]);

      $notification = Notification::with(['user:id,name,image_profile'])
         ->where('user_id', $user->id)
         ->orderBy('id', 'desc')->get();

      if (sizeof($notification) > 0) {
         return response()->json(['status' => true, 'message' => 'Notification list', 'data' => $notification]);
      } else {
         return response()->json(['status' => false, 'message' => 'Notification not_found']);
      }
   }

   public function sendNotification(Request $request)
   {
      // $id = $request->id;
      $token = $request->token;
      $title = $request->title;
      $name  = $request->name;
      $body  = $request->body;

      $validator = FacadesValidator::make($request->all(), [

         'title' => 'required',
         'name'  => 'required',
         'body'  => 'required'
      ]);

      if ($validator->fails()) {
         return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
      }

      if (!empty($id)) {
         $getToken = User::where('id', $id)->first();
      }

      if ($token == "") {
         $deviceToken[] = $getToken->device_token;
      } else {
         $deviceToken[] = $request->id;
      }

      $body = ['name' => $name, 'body' => $body];
      $notify = NotificationHelper::sendNotification($deviceToken, $title, $body);

      return $notify;
   }

   public function storeNotificationPreference(Request $request)
   {
      $user_id = Auth::user()->id;

      $settingNotification = NotificationPreference::firstOrNew(['user_id' => $user_id]);
      $settingNotification->new_matches      = $request->new_matches;
      $settingNotification->expiring_matches = $request->expiring_matches;
      $settingNotification->new_messages     = $request->new_messages;
      $settingNotification->tips             = $request->tips;
      $settingNotification->survey_feedback  = $request->survey_feedback;
      $settingNotification->save();

      return response()->json(['status' => true, 'message' => 'Notification settings saved successfully.']);
   }

   public function getNotificationPreference()
   {
      $user_id = Auth::user()->id;
      $notificationPreference = NotificationPreference::where('user_id',$user_id)->first();

      return response()->json(['status' => true, 'message' => 'Notification settings fetched successfully.','data'=>$notificationPreference]);
   }
}
