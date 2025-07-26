<?php

use App\Http\Controllers\Api\ApiEventController;
use App\Http\Controllers\Api\GuestController;
use App\Http\Controllers\Api\ServicePackages;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

// fghtfh

Route::get('/status', function () {
    return response()->json(['status' => 'API is working']);
});

Route::post('/register', [UserController::class, 'register']);
Route::get('/changeStatus', [UserController::class, 'verifyEmail']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/forget_pwd', [UserController::class, 'forget_pwd']);
Route::post('/verify_OTP', [UserController::class, 'verify_OTP']);
Route::post('/resetPassword', [UserController::class, 'resetPassword']);

Route::get('/professional_title', [UserController::class, 'professional_title']);

Route::post('/pending_request_list', [UserController::class, 'pending_request_list']);



Route::post('/coachlist', [AuthController::class, 'index']);
Route::post('/coachDetails', [AuthController::class, 'coachDetails']);

Route::post('/getCountries', [GuestController::class, 'getAllCountries']);
Route::post('/getStates/{country_id}', [GuestController::class, 'getStateOfaCountry']);
Route::post('/getCities/{state_id}', [GuestController::class, 'getCitiesOfaState']);

Route::post('/getDeliveryMode', [GuestController::class, 'deliveryAllMode']);
Route::post('/getLanguages', [GuestController::class, 'getAllLanguages']);
Route::post('/ageGroups', [GuestController::class, 'getAllAgeGroup']);

Route::post('/getCoachType', [GuestController::class, 'getAllCoachType']);
Route::post('/getSubCoachType/{coach_type_id}', [GuestController::class, 'getAllSubCoachType']);
// Route::post('/updateProfile', [AuthController::class, 'updateProfile']);
// Route::post('/getuserprofile', [AuthController::class, 'getuserprofile']);
// Route::post('/getcoachprofile', [AuthController::class, 'getcoachprofile']);

// VG route start
//Route::get('/test', [TestController::class, 'test']);
Route::get('/home_page', [UserController::class, 'event_list']);
Route::post('/EventSlotbyDate', [ApiEventController::class, 'EventSlotbyDate']);
Route::post('/BlockSlot', [ApiEventController::class, 'BlockSlot']);
Route::post('/BookingEvent', [ApiEventController::class, 'BookingEvent']);
Route::post('/UserBookedEventList', [ApiEventController::class, 'UserBookedEventList']);

// VG route end


Route::middleware('auth:api')->group(function () {
    Route::post('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/getuserprofile', [AuthController::class, 'getuserprofile']);
    Route::post('/updateProfile', [AuthController::class, 'updateProfile']);
    // Route::post('/updateProfile', [AuthController::class, 'updateProfile']);
    Route::post('/updateProfileImage', [UserController::class, 'updateProfileImage']);

    // User service package api
    Route::get('/getalluserservicepackage', [ServicePackages::class, 'getAllUserServicePackage']);
    Route::post('/getuserservicepackage/{id}', [ServicePackages::class, 'getUserServicePackage']);
    Route::post('/adduserservicepackage', [ServicePackages::class, 'addUserServicePackage']);



    // Friend request api
    Route::post('/friend_requests', [UserController::class, 'friend_requests']);
    Route::get('/suggested_user', [UserController::class, 'suggested_user']);
    Route::get('/friend-list', [UserController::class, 'friendList']);
    Route::get('pending-friend-requests',[UserController::class,'pendingFriendRequest']);

    // Blocked users
     Route::get('/blocked-users', [UserController::class, 'blockedUsers']);

});