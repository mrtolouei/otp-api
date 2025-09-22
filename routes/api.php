<?php

use App\Http\Controllers\Panel\AuthController;
use App\Http\Controllers\Panel\PlanController;
use App\Http\Controllers\Panel\ProfileController;
use App\Http\Controllers\Services\OtpSmsController;
use App\Http\Controllers\Services\OtpVerifyController;
use App\Http\Middleware\ClientTokenMiddleware;
use App\Http\Middleware\SmsQuotaMiddleware;
use Illuminate\Support\Facades\Route;

Route::prefix('services/v1')->middleware([ClientTokenMiddleware::class])->group(function () {
    Route::post('otp-sms', OtpSmsController::class)->middleware([SmsQuotaMiddleware::class]);
    Route::post('otp-verify', OtpVerifyController::class);
});

Route::prefix('panel')->group(function () {
    Route::middleware(['guest'])->group(function () {
        Route::post('request-otp', [AuthController::class, 'requestOtp']);
        Route::post('verify-otp', [AuthController::class, 'verifyOtp']);
    });
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::apiResource('profile', ProfileController::class)->only(['index', 'store']);
        Route::get('active-plans', [PlanController::class, 'actives']);

        //------- Admins Routes -------
        Route::apiResource('plans', PlanController::class);
    });
});
