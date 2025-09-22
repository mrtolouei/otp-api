<?php

namespace Database\Seeders;

use App\Models\User;
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
        ];

        foreach ($users as $user) {
            $user = User::query()->updateOrCreate(['mobile' => $user['mobile']], $user);
            $user->roles()->sync(1);
        }
    }
}
