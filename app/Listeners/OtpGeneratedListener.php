<?php

namespace App\Listeners;

use App\Events\OtpGeneratedEvent;
use App\Factories\OtpChannelFactory;
use App\Models\OtpLog;
use Illuminate\Support\Facades\Cache;

class OtpGeneratedListener
{
    public function __construct(protected OtpChannelFactory $factory)
    {
        //
    }

    public function handle(OtpGeneratedEvent $event): void
    {
        $data = Cache::get($event->key);
        $this->factory->make($data['channel'])->handle(
            clientUuid: $data['client_uuid'],
            mobile: $data['mobile'],
            code: $data['code'],
        );
        OtpLog::query()->create([
            'company_uuid' => $data['client_uuid'],
            'uuid' => $data['uuid'],
            'mobile' => $data['mobile'],
            'channel' => $data['channel'],
            'expires_at' => $data['expires_at'],
        ]);
    }
}
