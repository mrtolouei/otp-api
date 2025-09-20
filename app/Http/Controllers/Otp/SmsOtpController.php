<?php

namespace App\Http\Controllers\Otp;

use App\Enums\OtpChannelEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\SmsOtpRequest;
use App\Services\Otp\OtpService;
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
            clientUuid: $request->input('company_uuid'),
            mobile: $request->input('to'),
            channel: OtpChannelEnum::SMS,
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

