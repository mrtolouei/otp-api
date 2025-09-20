<?php

namespace App\Factories;

use App\Enums\OtpChannelEnum;
use App\Services\Otp\Channels\OtpChannelInterface;
use App\Services\Otp\Channels\SmsOtpChannel;
use App\Services\Otp\Channels\VoiceCallOtpChannel;
use InvalidArgumentException;

class OtpChannelFactory
{
    public function make(string $channel): OtpChannelInterface
    {
        return match ($channel) {
            OtpChannelEnum::SMS->name   => app(SmsOtpChannel::class),
            OtpChannelEnum::VOICE->name => app(VoiceCallOtpChannel::class),
            default => throw new InvalidArgumentException("Invalid OTP channel: $channel")
        };
    }
}
