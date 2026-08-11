<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\InventryController;
use App\Http\Controllers\CvrController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\MyaccountController;
use App\Http\Controllers\UserCVRController;
use App\Http\Controllers\UserInventryController;
use App\Http\Controllers\Admin\AdminCvrController;
use App\Http\Controllers\SuperAdmin\RoleController;
use App\Http\Controllers\SuperAdmin\SiteVisitController;
use App\Http\Controllers\SuperAdmin\UserController;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/clearcache', function () {
    Artisan::call('optimize:clear');
});

Route::get('/migrate', function () {
    Artisan::call('migrate');
});

Route::get('/storagelink', function () {
    Artisan::call('storage:link');
});


Route::get('/',[HomeController::class,'index'])->name('login');
Route::post('login_check',[MyaccountController::class,'login_check'])->name('login_check');

// new endpoints for OTP-based authentication
Route::post('send-otp',[MyaccountController::class,'sendOtp'])->name('send_otp');
Route::post('verify-otp',[MyaccountController::class,'verifyOtp'])->name('verify_otp');

// Route::prefix('admin')->name('admin.')->group(function () {

//     Route::middleware(['auth','is_admin'])->group(function () {
//         Route::get('/user_logout', [MyaccountController::class, 'user_logout'])->name('user_logout');
//         Route::get('/inventry-details',[InventryController::class,'index'])->name('inventry_details');
//         Route::get('/inventry-upload',[InventryController::class,'inventry_upload'])->name('inventry_upload');
//         Route::post('/upload-inventry',[InventryController::class,'upload_inventry'])->name('upload_inventry');

//         Route::get('/users', [MyaccountController::class, 'users'])->name('users');
//         Route::post('/users/store-or-update', [MyaccountController::class, 'storeOrUpdateUser'])->name('users.storeOrUpdate');
//         Route::get('/cvr-details', [CvrController::class, 'cvrDetails'])->name('cvrDetails');
//         Route::get('/cvr-export', [CvrController::class, 'export'])->name('export');
//         Route::get('/gallery', [GalleryController::class, 'gallery'])->name('gallery');

//         Route::post('/brochure_upload',[GalleryController::class,'brochure_upload'])->name('brochure_upload');
//         Route::post('/dealers_upload',[GalleryController::class,'dealers_upload'])->name('dealers_upload');
//         Route::post('/product_installation_images',[GalleryController::class,'product_installation_images'])->name('product_installation_images');
//         Route::delete('/admin/brochure/{id}', [GalleryController::class, 'delete_brochure'])->name('brochure_delete');
//         Route::delete('/admin/dealers/{id}', [GalleryController::class, 'dealers_delete'])->name('dealers_delete');
//         Route::delete('/admin/installation_images_delete/{id}', [GalleryController::class, 'installation_images_delete'])->name('installation_images_delete');
//         Route::get('/login-history', [MyaccountController::class, 'login_history'])->name('login_history');
//         Route::get('/login-history-user/{id}', [MyaccountController::class,'user_login_history'])->name('admin.user_login_history');

//         Route::get('/cvr', [AdminCvrController::class, 'cvr']);
//         Route::post('/upload-cvr', [AdminCvrController::class, 'uploadCvr']);
//         Route::get('/cvr/repository', [AdminCvrController::class, 'repository'])->name('repository');
//         Route::get('/cvr/repository-data', [AdminCvrController::class, 'repositoryData'])->name('repository.data');
//         Route::get('/cvr/view/{id}', [AdminCvrController::class, 'viewCvrDetails'])->name('cvr.details');
//         Route::post('/cvr/{id}/summary', [AdminCvrController::class, 'updateSummary'])->name('cvr.updateSummary');
//         Route::post('/cvr/{id}/action-points', [AdminCvrController::class, 'addActionPoint'])->name('cvr.addActionPoint');
//         Route::post('/cvr/{id}/complaints', [AdminCvrController::class, 'addComplaint'])->name('cvr.addComplaint');
//         Route::delete('/cvr/action-point/{id}', [AdminCvrController::class, 'deleteActionPoint'])->name('cvr.deleteActionPoint');
//         Route::delete('/cvr/complaint/{id}', [AdminCvrController::class, 'deleteComplaint'])->name('cvr.deleteComplaint');
//         Route::put('/cvr/action-point/{id}/status', [AdminCvrController::class, 'updateActionPointStatus'])->name('cvr.updateActionPointStatus');
        
//     });

// });

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function(){
// Route::middleware(['auth'])->prefix('admin')->group(function(){



Route::resource(
'users',
UserController::class
);



Route::resource(
'roles',
RoleController::class
);

// Route::resource('site-visit',SiteVisitController::class);
Route::get('site-visit', [SiteVisitController::class, 'index'])->name('site_visit.index');
Route::post('site-visit-store', [SiteVisitController::class, 'store'])->name('site-visit.store');
Route::get('site-visit-record', [SiteVisitController::class, 'site_visit_record'])->name('site_visit_record');
Route::get('site-visit-record/data', [SiteVisitController::class, 'siteVisitRecordData'])->name('site_visit_record.data');
Route::get('site-visit-record/export', [SiteVisitController::class, 'export'])->name('site_visit_record.export');
Route::get('site-visit-record/{id}', [SiteVisitController::class, 'show'])->name('site_visit_record.show');

Route::get('/inventry-details',[InventryController::class,'index'])->name('inventry_details');
Route::get('/inventry-upload',[InventryController::class,'inventry_upload'])->name('inventry_upload');


Route::get('/cvr', [AdminCvrController::class, 'cvr']);
Route::post('/upload-cvr', [AdminCvrController::class, 'uploadCvr']);
Route::get('/cvr/repository', [AdminCvrController::class, 'repository'])->name('repository');
Route::get('/cvr/repository-data', [AdminCvrController::class, 'repositoryData'])->name('repository.data');
Route::get('/cvr/view/{id}', [AdminCvrController::class, 'viewCvrDetails'])->name('cvr.details');
Route::post('/cvr/{id}/summary', [AdminCvrController::class, 'updateSummary'])->name('cvr.updateSummary');
Route::post('/cvr/{id}/action-points', [AdminCvrController::class, 'addActionPoint'])->name('cvr.addActionPoint');
Route::post('/cvr/{id}/complaints', [AdminCvrController::class, 'addComplaint'])->name('cvr.addComplaint');
Route::delete('/cvr/action-point/{id}', [AdminCvrController::class, 'deleteActionPoint'])->name('cvr.deleteActionPoint');
Route::delete('/cvr/complaint/{id}', [AdminCvrController::class, 'deleteComplaint'])->name('cvr.deleteComplaint');
Route::put('/cvr/action-point/{id}/status', [AdminCvrController::class, 'updateActionPointStatus'])->name('cvr.updateActionPointStatus');

Route::get('/cvr-export', [CvrController::class, 'export'])->name('export');

Route::get('/gallery', [GalleryController::class, 'gallery'])->name('gallery');

Route::post('/brochure_upload',[GalleryController::class,'brochure_upload'])->name('brochure_upload');
Route::post('/dealers_upload',[GalleryController::class,'dealers_upload'])->name('dealers_upload');
Route::post('/product_installation_images',[GalleryController::class,'product_installation_images'])->name('product_installation_images');
Route::delete('/admin/brochure/{id}', [GalleryController::class, 'delete_brochure'])->name('brochure_delete');
Route::delete('/admin/dealers/{id}', [GalleryController::class, 'dealers_delete'])->name('dealers_delete');
Route::delete('/admin/installation_images_delete/{id}', [GalleryController::class, 'installation_images_delete'])->name('installation_images_delete');
Route::get('/login-history', [MyaccountController::class, 'login_history'])->name('login_history');
Route::get('/login-history-user/{id}', [MyaccountController::class,'user_login_history'])->name('admin.user_login_history');


Route::get('/user_logout', [MyaccountController::class, 'user_logout'])->name('user_logout');


Route::get('/download-deales', [MyaccountController::class, 'download_deales'])->name('download_deales');
Route::post('/send_dealers', [MyaccountController::class, 'send_dealers'])->name('send_dealers');
Route::match(['get', 'post'], '/post-installation-images', [MyaccountController::class, 'post_installation_images'])->name('post_installation_images');




});

Route::prefix('user')->name('user.')->group(function () {
    Route::middleware(['auth','is_user'])->group(function () {
        Route::get('/user_logout', [MyaccountController::class, 'user_logout'])->name('user_logout');
        Route::get('/inventry-check',[UserInventryController::class,'index'])->name('inventry_check');
        
        Route::post('/inventory/user-types', [UserInventryController::class, 'getUserTypes']);
        Route::post('/inventory/models', [UserInventryController::class, 'getModels']);
        Route::post('/inventory/finishes', [UserInventryController::class, 'getFinishes']);
        Route::post('/inventory/designs', [UserInventryController::class, 'getDesigns']);
        Route::post('/inventory/shades', [UserInventryController::class, 'getShades']);
        Route::post('/inventory/sizes', [UserInventryController::class, 'getSizes']);
        Route::post('/inventory/stock', [UserInventryController::class, 'getStock']);

        Route::post('/inventory/dimention', [UserInventryController::class, 'getDimention']);
        Route::post('/inventory/colour', [UserInventryController::class, 'getColour']);
        Route::post('/inventory/orientation', [UserInventryController::class, 'getOrientation']);
        Route::post('/inventory/special_feature', [UserInventryController::class, 'getSpecialFeature']);

        Route::post('/inventory-send', [UserInventryController::class, 'inventorySend']);

        Route::post('/inventory-item-check', [UserInventryController::class, 'inventoryItemCheck']);

        
    });
});



