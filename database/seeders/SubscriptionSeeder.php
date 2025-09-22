<?php

namespace Database\Seeders;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    public function run(): void
    {
        $subscriptions = [
            [
                'user_id' => 1,
                'plan_id' => 1,
                'token_remaining' => 100,
                'sms_remaining' => 100,
                'voice_remaining' => 100,
                'expires_at' => null,
            ],
        ];

        foreach ($subscriptions as $subscription) {
            Subscription::query()->updateOrCreate([
                'user_id' => $subscription['user_id'],
                'plan_id' => $subscription['plan_id'],
            ], $subscription);
        }
    }
}
