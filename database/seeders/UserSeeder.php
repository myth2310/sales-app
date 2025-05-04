<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin Els',
            'email' => 'superadmin@gmail.com',
            'role' => 'super admin',
            'password' => Hash::make('superadmin123'),
        ]);

        User::create([
            'name' => 'Admin Els',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('admin123'),
        ]);

        User::create([
            'name' => 'Sales Els',
            'email' => 'sales@gmail.com',
            'role' => 'sales',
            'password' => Hash::make('sales123'),
        ]);
    }
}
