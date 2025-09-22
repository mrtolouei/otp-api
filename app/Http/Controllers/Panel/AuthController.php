<?php

namespace App\Http\Controllers\Panel;

use App\Enums\OtpChannelsEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Services\OtpSmsRequest;
use App\Http\Requests\Services\OtpVerifyRequest;
use App\Http\Resources\UserResource;
use App\Models\ClientToken;
use App\Models\User;
use App\Services\Otp\OtpService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function __construct(protected OtpService $otpService)
    {
        //
    }

    public function requestOtp(OtpSmsRequest $request): JsonResponse
    {
        $clientToken = ClientToken::query()->first(['id']);
        $user = User::query()->firstOrCreate(['mobile' => $request->input('mobile')]);
        $otp = $this->otpService->generate(
            clientTokenId: $clientToken->getAttribute('id'),
            mobile: $user->getAttribute('mobile'),
            channel: OtpChannelsEnum::SMS,
        );
        return response()->json([
            'uuid' => $otp->getUuid(),
            'expires_at' => $otp->getExpiresAt(),
        ]);
    }

    public function verifyOtp(OtpVerifyRequest $request): JsonResponse
    {
        $otp = $this->otpService->verify(
            uuid: $request->input('uuid'),
            code: $request->input('code'),
        );
        if ($otp->isOk()) {
            $user = User::query()->where('mobile', $otp->getMobile())->firstOrFail();
            $token = $user->createToken($user->getAttribute('mobile'))->plainTextToken;
            return response()->json([
                'user' => UserResource::make($user),
                'token' => $token,
            ]);
        }
        return response()->json([
            'message' => __('OTP code is expired or invalid.'),
        ], 403);
    }

    public function logout(Request $request): Response
    {
        $request->user()->currentAccessToken()->delete();
        return response()->noContent();
    }
}
