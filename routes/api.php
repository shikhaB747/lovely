<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\{AuthController, MembershipController, NotificationController, UserController, UserListController, ChatController, FaceRecognitionController, InteractionController};

// Authentication Routes ========  

Route::post('login-user',              [AuthController::class, 'verifyUser']);

Route::post('social-login',            [AuthController::class, 'socialLogin']);

// ================================

Route::middleware('auth:sanctum')->group(function () {

  Route::get('get-user-list',          [UserListController::class, 'userList']);

  Route::get('special-user-list',      [UserListController::class, 'specialUserList']);

  Route::get('addBlockedId',           [UserController::class, 'addBlockedId']);

  Route::post('report-user',           [UserController::class, 'reportUser']);

  Route::post('support-n-delete-user', [UserController::class, 'supportNDeleteUser']);

  Route::get('logout',                 [UserController::class, 'logout']);

  Route::get(
    'filterUsersNotLikedByLoggedUser',
    [UserListController::class, 'filterUsersNotLikedByLoggedUser']
  );

  // user profile related routes =============================

  Route::get('get-profile',            [AuthController::class, 'getProfile']);

  Route::post('update-profile',        [AuthController::class, 'updateProfile']);

  Route::post('update-profile-images', [AuthController::class, 'updateUserImages']);

  Route::post('image-update-by-index', [AuthController::class, 'imageUpdateByIndex']);

  // user membership related routes ===========================

  Route::post('plan-purchase',         [MembershipController::class, 'purchasePlan']);

  // user chat related routes =================================

  Route::post('store-chat',            [ChatController::class, 'storeChat']);

  Route::get('chat-list',              [ChatController::class, 'chatList']);
 
  Route::get('readChat',               [ChatController::class, 'unreadChatMsgCount']);

  // Interaction routes       =================================

  Route::get('matched-user-list1',     [InteractionController::class, 'matchedUserList']);

  Route::get('matched-user-list',      [InteractionController::class, 'getMatchList']);

  Route::post('match-user',            [InteractionController::class, 'matchUser']);

  Route::post('extend-chat',           [InteractionController::class, 'extendChat']);

  Route::get('not-for-me',             [InteractionController::class, 'notForMe']);

  // Notification routes       =================================

  Route::get('notification-list',      [NotificationController::class, 'index']);

  Route::post(
    'notification-setting-update',
    [NotificationController::class, 'storeNotificationPreference']
  );

  Route::get('notification-preference', [NotificationController::class, 'getNotificationPreference']);

  Route::post('detect-face',           [FaceRecognitionController::class, 'detectFaces']);

  Route::get('read-chat',              [ChatController::class, 'readChat']);

  Route::get('check-user-status',      [UserController::class, 'checkUserStatus']);

});

Route::get('get-interest-list',        [UserController::class, 'getInterestList']);

Route::get('membership-plan-list',     [MembershipController::class, 'index']);

Route::get('plan-profile',             [MembershipController::class, 'premiumProfile']);

Route::get('testNotification',         [ChatController::class, 'testNotification']);
