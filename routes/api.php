<?php

use App\Http\Controllers\Otp\SmsOtpController;
use App\Http\Controllers\Otp\VerifyOtpController;
use App\Http\Middleware\VerifyClientToken;
use Illuminate\Support\Facades\Route;

Route::middleware([VerifyClientToken::class])->prefix('v1')->group(function () {
    Route::prefix('request-otp')->group(function () {
        Route::post('sms', SmsOtpController::class);
    });
    Route::post('verify-otp', VerifyOtpController::class);
});
