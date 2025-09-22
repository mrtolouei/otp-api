<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'مدیر سیستم',
            ],
        ];
        $permissions = Permission::all()->pluck('id')->toArray();
        foreach ($roles as $role) {
            $role = Role::query()->updateOrCreate(['name' => $role['name']]);
            $role->permissions()->sync($permissions);
        }
    }
}
