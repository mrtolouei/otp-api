<?php

use App\Http\Controllers\Otp\SmsOtpController;
use App\Http\Controllers\Otp\VerifyOtpController;
use App\Http\Middleware\EnsureHasSmsQuota;
use App\Http\Middleware\VerifyClientToken;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {
   /** @TODO Login route - base on OTP */
   /** @TODO Signup route - base on OTP */
});
Route::middleware(['auth:sanctum'])->prefix('panel')->group(function () {
   /** @TODO Logout route */
});

Route::middleware([VerifyClientToken::class])->prefix('v1')->group(function () {
    Route::prefix('request-otp')->group(function () {
        Route::post('sms', SmsOtpController::class)->middleware(EnsureHasSmsQuota::class);
    });
    Route::post('verify-otp', VerifyOtpController::class);
});
