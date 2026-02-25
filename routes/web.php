<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\InventryController;
use App\Http\Controllers\MyaccountController;
use App\Http\Controllers\UserInventryController;

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

Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware(['auth','is_admin'])->group(function () {
        Route::get('/user_logout', [MyaccountController::class, 'user_logout'])->name('user_logout');
        Route::get('/inventry-details',[InventryController::class,'index'])->name('inventry_details');
        Route::get('/inventry-upload',[InventryController::class,'inventry_upload'])->name('inventry_upload');
        Route::post('/upload-inventry',[InventryController::class,'upload_inventry'])->name('upload_inventry');
    });

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
    });
});



