<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'mobile' => '09373102743',
                'firstname' => 'علیرضا',
                'lastname' => 'طلوعی',
                'national_id' => '4651854567',
                'birthdate' => '1997-06-04',
            ],
            [
                'mobile' => '09120001122',
                'firstname' => 'کاربر',
                'lastname' => 'عمومی',
                'national_id' => '8301001011',
                'birthdate' => '1997-01-01',
            ],
        ];

        foreach ($users as $user) {
            User::query()->updateOrCreate(['mobile' => $user['mobile']], $user);
        }
    }
}
