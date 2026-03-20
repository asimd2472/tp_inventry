<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OtpAuthController;

Route::post('/send-otp', [OtpAuthController::class, 'sendOtp']);
Route::post('/verify-otp', [OtpAuthController::class, 'verifyOtp']);
// Inventory APIs requiring authentication
use App\Http\Controllers\Api\UserInventryController;

Route::middleware('auth:api')->group(function () {
	Route::get('/inventory/types', [UserInventryController::class, 'getTypes']);
	Route::post('/inventory/models', [UserInventryController::class, 'getModels']);
	Route::post('/inventory/designs', [UserInventryController::class, 'getDesigns']);
	Route::post('/inventory/dimention', [UserInventryController::class, 'getDimention']);
	Route::post('/inventory/colour', [UserInventryController::class, 'getColour']);
	Route::post('/inventory/orientation', [UserInventryController::class, 'getOrientation']);
	Route::post('/inventory/special_feature', [UserInventryController::class, 'getSpecialFeature']);
	Route::post('/inventory/stock', [UserInventryController::class, 'getStock']);
    Route::post('/inventory/inventory-item-check', [UserInventryController::class, 'inventoryItemCheck']);
    Route::post('/inventory/upload-excel', [UserInventryController::class, 'upload_excel']);
});

