<?php

namespace App\Listeners;

use App\Events\OtpGeneratedEvent;
use App\Jobs\SendSmsJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;

class OtpGeneratedListener
{
    public function __construct()
    {
        //
    }

    public function handle(OtpGeneratedEvent $event): void
    {
        $data = Cache::get($event->uuid);
        $message = Blade::render("کدتایید شما جهت ادامه فرآیند:");
        SendSmsJob::dispatch($data['mobile']);
    }
}
