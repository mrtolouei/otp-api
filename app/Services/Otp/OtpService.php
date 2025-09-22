<?php

namespace App\Services\Otp;

use App\Dto\OtpGenerateResult;
use App\Dto\OtpVerifyResult;
use App\Enums\OtpChannelsEnum;
use App\Events\CreateOtpEvent;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class OtpService
{
    public function generate(int $clientTokenId, string $mobile, OtpChannelsEnum $channel, int $ttl = 120): OtpGenerateResult
    {
        $key = md5("OTP:$clientTokenId:$mobile");
        if (!Cache::has($key)) {
            $uuid = Str::uuid()->toString();
            $code = rand(11111, 99999);
            Cache::add($uuid, $key, $ttl);
            Cache::add($key, [
                'uuid' => $uuid,
                'code' => $code,
                'mobile' => $mobile,
                'client_token_id' => $clientTokenId,
                'channel' => $channel->name,
                'expires_at' => now()->addSeconds($ttl)->timestamp,
            ], $ttl);
            CreateOtpEvent::dispatch($key);
        }
        $data = Cache::get($key);
        return new OtpGenerateResult(
            uuid: $data['uuid'],
            expiresAt: $data['expires_at'],
        );
    }

    public function verify(string $uuid, int $code): OtpVerifyResult
    {
        if (Cache::has($uuid)) {
            $key = Cache::get($uuid);
            if (Cache::has($key)) {
                $data = Cache::get($key);
                if ($data['code'] === $code) {
                    Cache::forget($uuid);
                    Cache::forget($key);
                    return (new OtpVerifyResult(true))->setMobile($data['mobile']);
                }
            }
        }
        return new OtpVerifyResult(false);
    }
}
