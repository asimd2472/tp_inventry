<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OtpAuthController;

Route::post('/send-otp', [OtpAuthController::class, 'sendOtp']);
Route::post('/verify-otp', [OtpAuthController::class, 'verifyOtp']);