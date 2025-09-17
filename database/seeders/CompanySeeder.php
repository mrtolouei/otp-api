<?php

namespace Database\Seeders;

use App\Facades\JWT;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        $user = User::query()->where('mobile', '09120001122')->first();
        $companies = [
            [
                'uuid' => Str::uuid()->toString(),
                'user_id' => $user->getAttribute('id'),
                'name' => 'شرکت عمومی غرب گستر کشور',
                'national_id' => '4000010018',
                'sender_name' => 'شرکت عمومی',
                'phone' => '0216635252',
                'address' => 'تهران - تهران - بزرگراه لشکری - خیابان نخ زرین',
                'client_token' => JWT::encode([
                    'owner_national_id' => $user->getAttribute('national_id'),
                    'com_national_id' => '4000010018',
                    'created_at' => now()->timestamp,
                ]),
            ]
        ];

        foreach ($companies as $company) {
            Company::query()->updateOrCreate(['national_id' => $company['national_id']], $company);
        }
    }
}
