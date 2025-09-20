<?php

namespace App\Services\Otp\Channels;

use App\Jobs\SendSmsJob;
use App\Models\Company;
use Illuminate\Support\Facades\Blade;

class SmsOtpChannel implements OtpChannelInterface
{
    public function handle(string $clientUuid, string $mobile, int $code): void
    {
        $company = Company::query()->where('uuid', $clientUuid)->first();
        $message = Blade::render(
            'کد تایید شما جهت ادامه فرآیند:' . "\n" . '{{$code}}' . "\n" . '{{$sender_name}}',
            ['code' => $code, 'sender_name' => $company->getAttribute('sender_name')]
        );
        SendSmsJob::dispatch($mobile, $message, $clientUuid);
    }
}
