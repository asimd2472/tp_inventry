<?php

use App\Http\Controllers\Api\CvrController;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\OrderTrackingController;
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
    Route::post('/inventory/download-excel', [UserInventryController::class, 'download_excel']);


    Route::post('/track-order', [OrderTrackingController::class, 'trackOrder']);
    Route::post('/logout', [OrderTrackingController::class, 'logout']);


});

Route::post('/cvr-save', [CvrController::class, 'cvr_save']);
Route::post('/send-brochures', [GalleryController::class, 'send_brochures']);
Route::post('/send-dealers', [GalleryController::class, 'send_dealers']);
Route::get('/get-brochures', [GalleryController::class, 'get_brochures']);
Route::get('/post-installation-images', [GalleryController::class, 'post_installation_images']);


