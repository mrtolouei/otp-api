<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::query()->where('mobile', '09120001122')->first();
        $plan = Plan::query()->first();
        Subscription::query()->create([
            'user_id' => $user->getAttribute('id'),
            'plan_id' => $plan->getAttribute('id'),
            'start_at' => now(),
            'end_at' => now()->addMonth(),
            'status' => 'active',
            'sms_remaining' => $plan->getAttribute('sms_quota'),
        ]);
    }
}
