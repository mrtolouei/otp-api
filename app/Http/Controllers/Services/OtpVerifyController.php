<?php

namespace App\Http\Controllers\Services;

use App\Enums\OtpChannelsEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Services\OtpVerifyRequest;
use App\Services\Otp\OtpService;
use Illuminate\Http\JsonResponse;

class OtpVerifyController extends Controller
{
    public function __construct(protected OtpService $otpService)
    {
        //
    }

    public function __invoke(OtpVerifyRequest $request): JsonResponse
    {
        $otp = $this->otpService->verify(
            uuid: $request->input('uuid'),
            code: $request->input('code'),
        );
        if ($otp->isOk()) {
            return response()->json([
                'message' => __('OTP verified successfully.'),
                'data' => [
                    'mobile' => $otp->getMobile(),
                ],
            ]);
        }
        return response()->json([
           'message' => __('Invalid or expired OTP code.'),
        ], 403);
    }
}
