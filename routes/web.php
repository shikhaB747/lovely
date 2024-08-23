<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\{ForgotPasswordController, LoginController};
use App\Http\Controllers\{DashboardController, FaceRecognitionController, AdminController, PaymentController, MembershipController};

Route::get('/', function () {
  return view('login');
});

Route::get('login',                   [LoginController::class, 'showLoginForm'])->name('login');

Route::post('admin-login',            [LoginController::class, 'adminLogin'])->name('admin-login');
 
//========== forgot password ============

Route::get('/forgot-password',        [ForgotPasswordController::class, 'forgot_password'])->name('forgot-password');

Route::post('/sendResetLinkEmail',    [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('sendResetLinkEmail');

Route::get('/password/reset/{token}', [ForgotPasswordController::class, 'setPassword'])->name('/password/reset/');

Route::post('/reset-password',        [ForgotPasswordController::class, 'reset_password'])->name('reset-password');

// ========== Password Update

Route::get('/credentials', function () {
  return view('admin/settings/credentials');
});

Route::post('/password/update',      [ForgotPasswordController::class, 'changePassword'])->name('password.update');

// ==============================

Route::get('/admin/dashboard',       [DashboardController::class, 'index'])->name('dashboard');

Route::get('/admin/profile',         [DashboardController::class, 'profile'])->name('admin.profile');
 
Route::get('/users',                 [AdminController::class, 'index'])->name('users');

Route::get('/user-detail/{id}',      [AdminController::class, 'userDetail'])->name('user-detail');

Route::get('user/status/{id}/{status}',
                                     [AdminController::class, 'userStatusUpdate'])->name('user.status');

Route::get('user/delete/{id}',       [AdminController::class, 'delete'])->name('user.delete');

// =====================================

Route::get('/interest',              [AdminController::class, 'interest'])->name('interest');

Route::post('/add-interest',         [AdminController::class, 'addInterest'])->name('add-interest');

Route::get('/edit-interest/{id}',   [AdminController::class, 'editInterest'])->name('edit-interest');

Route::post('/update-interest',      [AdminController::class, 'saveInterest'])->name('update-interest');

// =====================================

Route::get('/membership-premium',    [MembershipController::class, 'index'])->name('membership-premium');

Route::post('/add-premium',          [MembershipController::class, 'addPremium'])->name('add-premium');

Route::get('/edit-premium-plan/{id}', [MembershipController::class, 'editPremiumPlan'])->name('edit-premium-plan');

Route::post('/edit-premium',         [MembershipController::class, 'editPremium'])->name('edit-premium');

// =====================================

Route::get('/super-like-plan',       [MembershipController::class, 'superLikePlan'])->name('super-like-plan');

Route::get('/edit-super-like/{id}',  [MembershipController::class, 'editSuperLike'])->name('edit-super-like');

// =====================================

Route::get('/spot-light-plan',       [MembershipController::class, 'spotLightPlan'])->name('spot-light-plan');

Route::get('/edit-spot-light/{id}',  [MembershipController::class, 'editSpotLight'])->name('edit-spot-light');

// =====================================

Route::get('premium/status/{id}/{status}',
                                     [MembershipController::class, 'premiumStatusUpdate'])->name('premium.status');

Route::get('premium/delete/{id}',    [MembershipController::class, 'delete'])->name('premium.delete');

// =====================================

Route::get('/credit-history',        [MembershipController::class, 'creditHistory'])->name('credit-history');

Route::get('logout',          [LoginController::class, 'logout'])->name('logout');

// payment related Routes
Route::get('payment',         [PaymentController::class, 'payment'])->name('payment');

Route::post('purchasePlan',   [PaymentController::class, 'purchasePlan'])->name('purchasePlan');

Route::get('success_payment', [PaymentController::class, 'success_payment'])->name('success_payment');

Route::get('fail_payment',    [PaymentController::class, 'fail_payment'])->name('fail_payment');
