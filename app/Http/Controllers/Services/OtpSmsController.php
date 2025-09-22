<?php

namespace App\Http\Controllers\Services;

use App\Enums\OtpChannelsEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Services\OtpSmsRequest;
use App\Services\Otp\OtpService;
use Illuminate\Http\JsonResponse;

class OtpSmsController extends Controller
{
    public function __construct(protected OtpService $otpService)
    {
        //
    }

    public function __invoke(OtpSmsRequest $request): JsonResponse
    {
        $otp = $this->otpService->generate(
            clientTokenId: $request->input('client_token_id'),
            mobile: $request->input('mobile'),
            channel: OtpChannelsEnum::SMS,
        );
        return response()->json([
            'message' => __('OTP has been sent to your mobile number.'),
            'data' => [
                'uuid' => $otp->getUuid(),
                'expires_at' => $otp->getExpiresAt(),
            ],
        ]);
    }
}
