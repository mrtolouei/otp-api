<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'title' => 'شروع',
                'description' => 'بسته شروع برای تست',
                'price' => 0,
                'token_quota' => 1,
                'sms_quota' => 10,
                'duration_months' => 1,
                'is_active' => true,
            ]
        ];

        foreach ($plans as $plan) {
            Plan::query()->updateOrCreate(['title' => $plan['title']], $plan);
        }
    }
}
