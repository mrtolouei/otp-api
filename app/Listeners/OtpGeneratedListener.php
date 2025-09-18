<?php

namespace App\Listeners;

use App\Events\OtpGeneratedEvent;

class OtpGeneratedListener
{
    public function __construct()
    {
        //
    }

    public function handle(OtpGeneratedEvent $event): void
    {
        //
    }
}
