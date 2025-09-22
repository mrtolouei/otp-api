<?php

namespace App\Services\Otp\Channels;

use App\Jobs\SendSmsJob;
use App\Models\ClientToken;
use Illuminate\Support\Facades\Blade;

class SmsOtpChannel implements OtpChannelInterface
{
    public function handle(int $clientTokenId, string $mobile, int $code): void
    {
        $clientToken = ClientToken::query()->findOrFail($clientTokenId);
        $userId = $clientToken->getAttribute('user_id');
        $message = Blade::render(
            string: 'کد تایید:' . PHP_EOL . '{{$code}}' . PHP_EOL . '{{$sender_name}}',
            data: [
                'code' => $code,
                'sender_name' => $clientToken->getAttribute('sender_name'),
            ]
        );
        SendSmsJob::dispatch($userId, $mobile, $message);
    }
}
