<?php

namespace App\Listeners;

use App\Events\CreateOtpEvent;
use App\Factories\OtpChannelFactory;
use App\Models\ClientToken;
use App\Models\OtpLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;

class CreateOtpListener
{
    public function __construct(protected OtpChannelFactory $factory)
    {
        //
    }

    public function handle(CreateOtpEvent $event): void
    {
        $data = Cache::get($event->key);
        $this->factory->make($data['channel'])->handle(
            clientTokenId: $data['client_token_id'],
            mobile: $data['mobile'],
            code: $data['code'],
        );
        $clientToken = ClientToken::query()->findOrFail($data['client_token_id']);
        OtpLog::query()->create([
            'user_id' => $clientToken->getAttribute('user_id'),
            'client_token_id' => $clientToken->getAttribute('id'),
            'mobile' => $data['mobile'],
            'channel' => $data['channel'],
        ]);
    }
}
