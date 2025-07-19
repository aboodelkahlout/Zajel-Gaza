<?php

use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsHotelOwner;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HotelWonerController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ForgotPasswordController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;



Route::get('/', function () {
    return view('home');
});

Route::post('/contact/send', [UserController::class, 'send'])->name('contact.send');



Route::get('login',[UserController::class,'showloginpage'])->name("showloginpage");
Route::post('login',[UserController::class,'login'])->name("login");

Route::get('register',[UserController::class,'showregisterpage'])->name("showregisterpage");
Route::post('register',[UserController::class,'register'])->name("register");
Route::get('hotel_owner/register', [HotelWonerController::class, 'showRegisterForm'])->name('hotel_owner.register');
Route::post('hotel_owner/register', [HotelWonerController::class, 'register'])->name('registerhotelowner');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Illuminate\Http\Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'تم إرسال رابط التحقق إلى بريدك الإلكتروني.');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


Route::get('/verify-code', [UserController::class, 'showVerificationForm'])->name('verify.code.form');
Route::post('/verify-code', [UserController::class, 'verifyCode'])->name('verify.code.submit');


Route::get('index',[UserController::class,'index'])->name('index');


Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');



Route::middleware(['auth', 'is_user'])->prefix('user')->group(function () {
Route::get('/user/home/',[UserController::class, 'home'])->name('user.home');
Route::get('/user/detiles/hotel/{id}',[UserController::class, 'detileshotel'])->name('user.detiles.hotel');
Route::post('user/rating/hotel/{id}',[UserController::class, 'userrating'])->name('user.rating.hotel');
Route::post('user/comment/hote/{id}',[UserController::class, 'usercomment'])->name('user.comment.hotel');
Route::get('user/show/allhotel',[UserController::class, 'showallhotel' ])->name('user.show.allhotel');
Route::get('user/fav/hotel',[UserController::class, 'fav'])->name('user.fav.hotel');
Route::post('user/add/fav/hotel/{id}',[UserController::class, 'addfav'])->name('user.add.fav.hotel');
Route::delete('user/remove/fav/hotel/{id}',[UserController::class, 'removefav'])->name('user.remove.fav.hotel');
Route::get('user/most/hotel/rating',[UserController::class, 'mosthotelrating'])->name('user.most.hotel.rating');
Route::get('user/settings/',[UserController::class, 'settings'])->name('user.settings.page');
Route::put('user/update/settings/',[UserController::class, 'updatesettings'])->name('user.update.settings');
Route::put('user/update/email/',[UserController::class, 'updateemail'])->name('user.update.email');
Route::post('user/logout',[UserController::class, 'logout'])->name('user.logout');
});



Route::middleware(['auth', 'is_hotel_owner'])->prefix('hotel_owner')->group(function () {
Route::get('/hotel-owner/dashbord',[HotelWonerController::class, 'hotelownerdashbord'])->name('owner.dashboard');
Route::get('/hotel-owner/editinfo/{id}', [HotelWonerController::class, 'showeditinfo'])->name('show.info.hotel');
Route::put('/hotel-owner/editinfo/{id}', [HotelWonerController::class, 'editinfohotel'])->name('edit.info.hotel');
Route::post('/hotel/{hotel}/images', [HotelWonerController::class, 'uploadImages'])->name('hotel.image.upload');
Route::delete('/hotel/images/{id}', [HotelWonerController::class, 'deleteImage'])->name('hotel.image.delete');
Route::get('/hotel-owner/add/hotel/{id}',[HotelWonerController::class, 'addhotel'])->name('hotel.add.hotel');
Route::post('/hotel-owner/add/hotel/{id}',[HotelWonerController::class, 'addhotelop'])->name('hotel.add.hotel.op');
Route::get('hotel-owner/hotel/statistics/{id}',[HotelWonerController::class, 'statistics'])->name('hotel.statistics');
Route::get('hotel-owner/hotel/comments',[HotelWonerController::class, 'comments'])->name('hotel.comments');
Route::delete('hote-owner/hotel/comments/{id}',[HotelWonerController::class,'hotelownerdestroycomment'])->name('hotel.destroycomment');
Route::get('/comments/{id}/reply', [HotelWonerController::class,'replyForm'])->name('hotelwoner.commentsreplyForm');
Route::post('/comments/{id}/reply', [HotelWonerController::class,'saveReply'])->name('hotelowner.commentssaveReply');
Route::get('/hotel-owner/settings', [HotelWonerController::class,'settings'])->name('hotelowner.settings');
Route::put('/hotel-owner/updatesettings/{id}',[HotelWonerController::class, 'updatesettings'])->name('hotelowner.update.settings');
Route::put('/hotel-owner/updatepassword/{id}',[HotelWonerController::class, 'updatepassword'])->name('hotelowner.update.password');
Route::post('/hotel-owner/logout', [AdminController::class, 'logout'])->name('hotelowner.logout');
Route::get('/hotel-owner/show/edit/reply/comment/{id}/{replyid}',[HotelWonerController::class, 'showeditreply'])->name('hotelowner.show.edit.reply');
Route::put('/hotel-owner/edit/reply/comment/{replyid}',[HotelWonerController::class, 'editreply'])->name('hotelowner.edit.reply');
Route::delete('/hotel-owner/delete/reply/comment/{id}',[HotelWonerController::class,'destroyreply'])->name('hotelowner.destroy.reply');
});


Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'admindashbord'])->name('admin.dashboard');
    Route::get('/admin/hotel-requests', [AdminController::class, 'hotelRequests'])->name('admin.hotel.requests');
    Route::post('/admin/hotel-requests/{id}/approve', [AdminController::class, 'approveHotelRequest'])->name('admin.hotel.requests.approve');
    Route::post('/admin/hotel-requests/{id}/reject', [AdminController::class, 'rejectHotelRequest'])->name('admin.hotel.requests.reject');
    Route::delete('/admin/hotel-requests/{id}/del',[AdminController::class, 'deletehotel'])->name('admin.hotel.requests.delete');
    Route::get('/admin/hotel-owners', [AdminController::class, 'hotelOwners'])->name('admin.hotel_owners');
    Route::put('/admin/hotel-owners/{id}/toggle-status', [AdminController::class, 'toggleStatus'])->name('admin.hotel_owners.toggle_status');
    Route::delete('/admin/hotel-owners/{id}', [AdminController::class, 'destroy'])->name('admin.hotel_owners.delete');
    Route::get('/admin/hotel-owners/{id}/show', [AdminController::class, 'show'])->name('admin.hotel_owners.show');
    Route::get('/admin/user/',[AdminController::class, 'showalluser'])->name('showalluser');
    Route::delete('/admin/user/{id}/',[AdminController::class, 'deluser'])->name('deluser');
    Route::put('/admin/user/{id}/toggle-status',[AdminController::class, 'togglestatususer'])->name('admin.user.toggle_status');
    Route::get('/admin/user/statistics',[AdminController::class, 'statistics'])->name('admin.statistics');
    Route::get('/comments', [AdminController::class, 'showcomment'])->name('admin.ratingandcomment');
    Route::delete('/comments/{id}', [AdminController::class, 'destroycomment'])->name('admin.destroycomment');
    Route::get('/comments/{id}/reply', [AdminController::class, 'replyForm'])->name('admin.commentsreplyForm');
    Route::post('/comments/{id}/reply', [AdminController::class, 'saveReply'])->name('admin.commentssaveReply');
    Route::get('/settings', [AdminController::class, 'setting'])->name('admin.settings');
    Route::put('/settings', [AdminController::class, 'updatesetting'])->name('admin.settings.update');
    Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::delete('/hotel-owners/deleteall', [AdminController::class, 'deleteall'])->name('admin.hotel_owners.delete.all');
    Route::post('/hotel/deleteallhotel', [AdminController::class, 'deleteallhotel'])->name('admin.hotel.delete.allhotel');
    Route::get('/admin/hotel_owners/{id}/details', [HotelOwnerController::class, 'details']);
});