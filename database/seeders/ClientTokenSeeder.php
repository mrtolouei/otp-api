<?php

namespace Database\Seeders;

use App\Models\ClientToken;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ClientTokenSeeder extends Seeder
{
    public function run(): void
    {
        $tokens = [
            [
                'user_id' => 1,
                'signature' => 'شرکت اصلی',
                'token' => md5(Str::uuid()->toString()),
            ],
        ];
        foreach ($tokens as $token) {
            ClientToken::query()->updateOrCreate(['user_id' => $token['user_id']], $token);
        }
    }
}
