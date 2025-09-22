<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\Sms\SmsService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendSmsJob implements ShouldQueue
{
    use Queueable;

    public function __construct(protected int $userId, protected string $mobile, protected string $message)
    {
        //
    }

    public function handle(SmsService $smsService): void
    {
        $result = $smsService->send($this->mobile, $this->message);
        if ($result) {
            $user = User::with(['subscription'])->findOrFail($this->userId);
            $user->subscription->decrement('sms_remaining');
        }
    }
}
