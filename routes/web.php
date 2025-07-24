<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ServicePackageController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\EventController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('home');
});

Route::any('/admin', [AdminController::class, 'login'])->name('admin.login');
Route::any('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
Route::post('/admin/getstate', [AdminController::class, 'getstate']);
Route::post('/admin/getcity', [AdminController::class, 'getcity']);
Route::post('/admin/getsubType', [AdminController::class, 'getsubType']);

// Interprise bussiness user routes

Route::group([], function(){
    Route::get('/signup', [BusinessController::class, 'signup'])->name('bussiness.signup');
    Route::post('/store', [BusinessController::class, 'enerpriseStore'])->name('bussiness.store');
    Route::get('/login', [BusinessController::class, 'login'])->name('bussiness.login');
    Route::post('/login', [BusinessController::class, 'Enterpriselogin'])->name('interprise.login');
    Route::any('/logout', [BusinessController::class, 'logout'])->name('interprise.logout');
});



Route::post('/getstate', [BusinessController::class, 'getstate']);
Route::post('/getcity', [BusinessController::class, 'getcity']);
Route::post('/getsubType', [BusinessController::class, 'getsubType']);

Route::middleware(['auth'])->prefix('dashboard')->as('interprise.')->group(function () {
    Route::any('/', [BusinessController::class, 'dashboard'])->name('dashboard');
    Route::any('/create-event', [EventController::class, 'createEvent'])->name('create-event');
    Route::post('/add-event/{id?}', [EventController::class, 'addEvent'])->name('add-event');
    Route::get('/edit-event/{id?}', [EventController::class, 'editEvent'])->name('edit-event');
    Route::any('/event-list', [EventController::class, 'eventList'])->name('event-list');
    Route::get('/view-event/{id?}', [EventController::class, 'viewEvent'])->name('view-event');
    Route::post('/delete_event', [EventController::class, 'delete'])->name('delete_event');
    // Ticket routes
    Route::any('/create-ticket', [BusinessController::class, 'createTicket'])->name('create-ticket');
    Route::any('/ticket-list', [BusinessController::class, 'ticketList'])->name('ticket-list');
   // Route::any('/session-list/{id?}',[EventController::class,'SessionList'])->name('interprise.session-list');
    Route::any('/session-list/{id}', [EventController::class, 'SessionList'])->name('session-list');
    Route::any('/generateSlots/{id?}', [EventController::class, 'generateSessions'])->name('generateSessions');
    //20-07-2025
    Route::get('/edit-session/{id}', [EventController::class, 'editSession'])->name('edit-session');
    Route::post('/update-session/{id}', [EventController::class, 'updateSession'])->name('update-session');
    //21-07-2025
    Route::post('/session_status', [EventController::class, 'session_status'])->name('session_status');
    Route::get('/booking-list',[BookingController::class,'bookingList'])->name('booking-list');
    Route::get('/view-booking/{id?}', [BookingController::class, 'viewBooking'])->name('view-booking');

});

// Route::any('/dashboard', [BusinessController::class, 'dashboard'])->name('interprise.dashboard');
// Route::any('/dashboard/create-event', [BusinessController::class, 'createEvent'])->name('interprise.create-event');
// Route::any('/dashboard/create-event', [EventController::class, 'createEvent'])->name('interprise.create-event');
// Route::post('/add-event/{id?}', [EventController::class, 'addEvent'])->name('interprise.add-event');
// Route::get('/edit-event/{id?}', [EventController::class, 'editEvent'])->name('interprise.edit-event');
// Route::any('/dashboard/event-list', [EventController::class, 'eventList'])->name('interprise.event-list');
// Route::post('/delete_event', [EventController::class, 'delete'])->name('interprise.delete_event');
// Route::get('/view-event/{id?}', [EventController::class, 'viewEvent'])->name('interprise.view-event');

// Route::any('/dashboard/create-ticket', [BusinessController::class, 'createTicket'])->name('interprise.create-ticket');
// Route::any('/dashboard/ticket-list', [BusinessController::class, 'ticketList'])->name('interprise.ticket-list');

// Group all protected admin routes under middleware
Route::middleware(['auth:admin', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/userList', [UserManagementController::class, 'userList'])->name('admin.userList');
    Route::any('/admin/addUser/{id?}', [UserManagementController::class, 'addUser'])->name('admin.addUser');
    Route::get('/admin/inerprise-list', [UserManagementController::class, 'interpriseList'])->name('admin.interpriseList');
    Route::post('/admin/add-interprise', [UserManagementController::class, 'addInterprise'])->name('admin.addInerprise');
    Route::post('/admin/update_status', [UserManagementController::class, 'updateUserStatus']);
    Route::post('/admin/delete_user', [UserManagementController::class, 'deleteUser']);
    Route::get('/admin/interprise/{id?}', [UserManagementController::class, 'interpriseProfile'])->name('admin.interprisePro');
    Route::get('/admin/viewCoach/{id}', [UserManagementController::class, 'viewCoach'])->name('admin.viewCoach');
    Route::get('/admin/viewUser/{id}', [UserManagementController::class, 'viewUser'])->name('admin.viewUser');
    Route::get('/admin/view_user_enquiry/{id}', [UserManagementController::class, 'view_user_enquiry'])->name('admin.view_user_enquiry');
    Route::get('/admin/view_coach_enquiry/{id}', [UserManagementController::class, 'view_coach_enquiry'])->name('admin.view_coach_enquiry');

    Route::post('/admin/enquiry_status', [UserManagementController::class, 'enquiry_status']);
    Route::post('/admin/user/bulk-delete-user', [UserManagementController::class, 'bulkDeleteusr'])->name('admin.bulkDeleteusr');
    Route::post('/admin/coach/bulk-delete-coach', [UserManagementController::class, 'bulkDeleteCoach'])->name('admin.bulkDeleteCoach');

    Route::any('/admin/addProfessional/{id?}', [UserManagementController::class, 'addProfessional'])->name('admin.addProfessional');
    Route::post('/admin/deleteDocument', [UserManagementController::class, 'deleteDocument'])->name('admin.deleteDocument');

    Route::get('/admin/languageList', [MasterController::class, 'languageList'])->name('admin.languageList');
    Route::any('/admin/addLanguage/{id?}', [MasterController::class, 'addLanguage'])->name('admin.addLanguage');
    Route::post('/admin/update_lang_status', [MasterController::class, 'updateLanguageStatus']);
    Route::post('/admin/language/bulk-delete-language', [MasterController::class, 'bulkDeleteLanguage'])->name('admin.bulkDeleteLanguage');


    //service Route
    Route::get('/admin/servicePackageList/{id}', [ServicePackageController::class, 'servicePackageList'])->name('admin.servicePackageList');
    Route::any('/admin/coach-{id}/addServicePackage/{package_id?}', [ServicePackageController::class, 'addServicePackage'])->name('admin.addServicePackage');

    Route::get('/admin/serviceList', [MasterController::class, 'serviceList'])->name('admin.serviceList');
    Route::any('/admin/addService/{id?}', [MasterController::class, 'addService'])->name('admin.addService');
    Route::post('/admin/update_service_status', [MasterController::class, 'updateServiceStatus']);
    Route::post('/admin/service/bulk-delete', [MasterController::class, 'bulkDeleteService'])->name('admin.bulkDeleteService');

    Route::get('/admin/subscriptionList', [MasterController::class, 'subscriptionList'])->name('admin.subscriptionList');
    Route::any('/admin/addSubscription/{id?}', [MasterController::class, 'addSubscription'])->name('admin.addSubscription');
    Route::any('/admin/update_subscri_status/{id?}', [MasterController::class, 'update_subscri_status'])->name('admin.update_subscri_status');
    Route::post('/admin/plan/bulk-delete', [MasterController::class, 'bulkDeletePlan'])->name('admin.bulkDeletePlan');

    Route::any('/admin/addPolicy/{id?}', [MasterController::class, 'addPolicy'])->name('admin.addPolicy');
    Route::get('/admin/policyList', [MasterController::class, 'policyList'])->name('admin.policyList');
    Route::get('/admin/viewPolicy/{id}', [MasterController::class, 'viewPolicy'])->name('admin.viewPolicy');
    Route::post('/admin/deletePolicy', [MasterController::class, 'deletePolicy'])->name('admin.deletePolicy');
    Route::post('/admin/policy/bulk-delete', [MasterController::class, 'bulkDeletePolicy'])->name('admin.bulkDeletePolicy');



   
    Route::get('/admin/coachTypeList', [MasterController::class, 'coachTypeList'])->name('admin.coachTypeList');
    Route::post('/admin/update_type_status', [MasterController::class, 'updateTypeStatus']);
    Route::any('/admin/addCoachSubType/{id?}', [MasterController::class, 'addCoachSubType'])->name('admin.addCoachSubType');
    Route::get('/admin/coachSubTypeList/{id?}', [MasterController::class, 'coachSubTypeList'])->name('admin.coachSubTypeList');
    Route::post('/admin/update_subtype_status', [MasterController::class, 'updateSubTypeStatus']);
    Route::post('/admin/coachCat/bulk-delete', [MasterController::class, 'bulkDeleteCoachCat'])->name('admin.bulkDeleteCoachCat');
    Route::post('/admin/coachSubCat/bulk-delete', [MasterController::class, 'bulkDeleteCoachSubCat'])->name('admin.bulkDeleteCoachSubCat');



    Route::any('/admin/addCoachingCategory/{id?}', [MasterController::class, 'addCoachingCategory'])->name('admin.addCoachingCategory');
    Route::get('/admin/coachingCategoryList', [MasterController::class, 'coachingCategoryList'])->name('admin.coachingCategoryList');
    Route::post('/admin/update_category_status', [MasterController::class, 'updateCategoryStatus']);
    Route::post('/admin/category/bulk-delete', [MasterController::class, 'bulkDeletecat'])->name('admin.bulkDeletecat');

    Route::get('/admin/enquiryList', [MasterController::class, 'enquiryList'])->name('admin.enquiryList');
    Route::get('/admin/viewEnquiry', [MasterController::class, 'viewEnquiry'])->name('admin.viewEnquiry');

    Route::any('/admin/addDeliveryMode/{id?}', [MasterController::class, 'addDeliveryMode'])->name('admin.addDeliveryMode');
    Route::get('/admin/deliveryModeList', [MasterController::class, 'deliveryModeList'])->name('admin.deliveryModeList');
    Route::post('/admin/update_mode_status', [MasterController::class, 'updateModeStatus']);
    Route::post('/admin/mode/bulk-delete', [MasterController::class, 'bulkDeleteMode'])->name('admin.bulkDeleteMode');

    Route::get('/admin/blogList', [MasterController::class, 'blogList'])->name('admin.blogList');
    Route::any('/admin/addBlog/{id?}', [MasterController::class, 'addBlog'])->name('admin.addBlog');
    Route::post('/admin/update_blog_status', [MasterController::class, 'updateBlogStatus']);
    Route::post('/admin/blog/bulk-delete', [MasterController::class, 'bulkDeleteBlog'])->name('admin.bulkDeleteBlog');

    Route::any('/admin/addEmailTemplate/{id?}', [MasterController::class, 'addEmailTemplate'])->name('admin.addEmailTemplate');

    Route::get('/admin/reviewlist', [ReviewController::class, 'index'])->name('admin.reviewlist');
    Route::get('/admin/viewReview/{id}', [ReviewController::class, 'viewReview'])->name('admin.viewReview');
    Route::post('/admin/status', [ReviewController::class, 'status'])->name('admin.status');
    Route::post('/admin/enquiry_status', [UserManagementController::class, 'enquiry_status']);

    // event start //
      Route::any('/admin/addEvent/{id?}', [AdminController::class, 'addEvent'])->name('admin.addEvent');
      Route::post('/admin/createEvent/{id?}', [AdminController::class, 'createEvent'])->name('admin.createEvent');
      Route::any('/admin/event-list', [AdminController::class, 'eventList'])->name('admin.event-list');
      Route::get('/admin/edit-event/{id?}', [AdminController::class, 'editEvent'])->name('admin.edit-event');
      Route::get('/admin/view-event/{id?}', [AdminController::class, 'viewEvent'])->name('admin.view-event');
      Route::post('/admin/event_update_status', [AdminController::class, 'updateEventStatus']);

      //session start//

       Route::any('/admin/session-list/{id?}', [AdminController::class, 'sessionList'])->name('admin.session-list');

      Route::any('/admin/addSession/{id?}', [AdminController::class, 'addSession'])->name('admin.addSession');
      Route::any('/admin/generateSessions/{id?}', [AdminController::class, 'generateSessions'])->name('admin.generateSessions');
      Route::get('/admin/edit-session/{id}', [AdminController::class, 'edit'])->name('admin.session.edit');
     Route::post('/admin/updateSession/{id}', [AdminController::class, 'update'])->name('admin.updateSession');
     Route::post('/admin/session_status', [AdminController::class, 'session_status']);

    // 21/07/2025
    Route::get('/admin/booking-list',[AdminController::class,'bookingList'])->name('admin.booking-list');
    // 22-07-2025
    Route::get('/admin/view-booking/{id?}', [AdminController::class, 'viewBooking'])->name('admin.viewBookings');



});