<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'uuid' => Str::uuid()->toString(),
                'title' => 'طرح پایه',
                'description' => 'طرح پایه شروع برای کسب و کارهای کوچک',
                'token_quota' => 1,
                'sms_quota' => 100,
                'voice_quota' => 10,
                'months_duration' => 1,
                'price' => 0,
            ],
        ];

        foreach ($plans as $plan) {
            Plan::query()->updateOrCreate(['uuid' => $plan['uuid']], $plan);
        }
    }
}
