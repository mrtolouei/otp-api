<?php

namespace App\Jobs;

use App\Models\Company;
use App\Services\Sms\SmsService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendSmsJob implements ShouldQueue
{
    use Queueable;

    public function __construct(protected string $mobile, protected string $message, protected string $clientUuid)
    {
        //
    }

    public function handle(SmsService $smsService): bool
    {
        $result = $smsService->send($this->mobile, $this->message);
        if ($result->isOk()) {
            $company = Company::with(['user.activeSubscription'])->where('uuid', $this->clientUuid)->first();
            $company->getAttribute('user')->activeSubscription->decrement('sms_remaining');
            return true;
        }
        return false;
    }
}
