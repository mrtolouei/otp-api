<?php

use App\Http\Controllers\Services\OtpSmsController;
use App\Http\Controllers\Services\OtpVerifyController;
use App\Http\Middleware\ClientTokenMiddleware;
use App\Http\Middleware\SmsQuotaMiddleware;
use Illuminate\Support\Facades\Route;

Route::prefix('services/v1')->middleware([ClientTokenMiddleware::class])->group(function () {
    Route::post('otp-sms', OtpSmsController::class)->middleware([SmsQuotaMiddleware::class]);
    Route::post('otp-verify', OtpVerifyController::class);
});
