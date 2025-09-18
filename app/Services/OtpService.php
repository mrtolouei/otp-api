<?php

namespace App\Services;

use App\Dto\OtpGenerateResult;
use App\Dto\OtpVerifyResult;
use App\Events\OtpGeneratedEvent;
use Illuminate\Support\Facades\Cache;

class OtpService
{
    public function generate(string $mobile, string $key, int $ttl = 120): OtpGenerateResult
    {
        $uuid = md5("OTP_$key:$mobile");
        if (!Cache::has($uuid)) {
            $code = rand(11111, 99999);
            Cache::add($uuid, [
                'code' => $code,
                'mobile' => $mobile,
                'company_uuid' => $key,
                'expires_at' => now()->addSeconds($ttl)->timestamp,
            ], $ttl);
            OtpGeneratedEvent::dispatch($uuid);
        }
        $data = Cache::get($uuid);
        return new OtpGenerateResult(
            uuid: $uuid,
            expiresAt: $data['expires_at'],
        );
    }

    public function verify(string $uuid, int $code): OtpVerifyResult
    {
        if (Cache::has($uuid)) {
            $data = Cache::get($uuid);
            if ($data['code'] === $code) {
                $mobile = $data['mobile'];
                Cache::forget($uuid);
                return new OtpVerifyResult(
                    ok: true,
                    mobile: $mobile
                );
            }
        }
        return new OtpVerifyResult(
            ok: false
        );
    }
}
