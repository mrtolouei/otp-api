<?php

namespace App\Http\Controllers\Otp;

use App\Http\Controllers\Controller;
use App\Http\Requests\VerifyOtpRequest;
use App\Services\OtpService;
use Illuminate\Http\JsonResponse;

class VerifyOtpController extends Controller
{
    public function __construct(protected OtpService $otpService)
    {
        //
    }

    public function __invoke(VerifyOtpRequest $request): JsonResponse
    {
        $auth = $this->otpService->verify($request->input('uuid'), $request->input('code'));
        if ($auth->isOk()) {
            return response()->json([
                'message' => __('OTP verified successfully.'),
                'data' => [
                    'mobile' => $auth->getMobile(),
                ]
            ]);
        }
        return response()->json([
            'message' => __('The provided OTP code is invalid or has expired.')
        ], 401);
    }
}
