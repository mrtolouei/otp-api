<?php

namespace App\Services\Otp;

use App\Dto\OtpGenerateResult;
use App\Dto\OtpVerifyResult;
use App\Enums\OtpChannelEnum;
use App\Events\OtpGeneratedEvent;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class OtpService
{
    public function generate(string $clientUuid, string $mobile, OtpChannelEnum $channel, int $ttl = 120): OtpGenerateResult
    {
        $key = md5("otp:$clientUuid:$mobile");
        if (!Cache::has($key)) {
            $uuid = Str::uuid()->toString();
            $code = rand(11111, 99999);
            Cache::add($uuid, $key, $ttl);
            Cache::add($key, [
                'uuid' => $uuid,
                'client_uuid' => $clientUuid,
                'code' => $code,
                'mobile' => $mobile,
                'expires_at' => now()->addSeconds($ttl)->timestamp,
                'channel' => $channel->name,
            ], $ttl);
            OtpGeneratedEvent::dispatch($key);
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
            $data = Cache::get($key);
            if ($data['code'] === $code) {
                Cache::forget($uuid);
                Cache::forget($key);
                return new OtpVerifyResult(
                    ok: true,
                    mobile: $data['mobile'],
                );
            }
        }
        return new OtpVerifyResult(
            ok: false
        );
    }
}
