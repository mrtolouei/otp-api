<?php

namespace App\Http\Controllers\Otp;

use App\Http\Controllers\Controller;
use App\Http\Requests\SmsOtpRequest;
use App\Services\OtpService;
use Illuminate\Http\JsonResponse;

class SmsOtpController extends Controller
{
    public function __construct(protected OtpService $otpService)
    {
        //
    }

    public function __invoke(SmsOtpRequest $request): JsonResponse
    {
        $otp = $this->otpService->generate(
            mobile: $request->input('to'),
            key: $request->input('company_uuid')
        );

        return response()->json([
            'message' => __('OTP sent successfully'),
            'data' => [
                'uuid' => $otp->getUuid(),
                'expires_at' => $otp->getExpiresAt(),
            ],
        ]);
    }
}

