<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Super Admin (Pakai role 'admin')
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@tixgo.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        // 2. Manager (Pakai role 'admin_maskapai')
        User::create([
            'name' => 'Manager TixGo',
            'email' => 'manager@tixgo.com',
            'password' => Hash::make('password'),
            'role' => 'admin_maskapai'
        ]);

        // 3. User Biasa (Pakai role 'user')
        User::create([
            'name' => 'User Biasa',
            'email' => 'user@tixgo.com',
            'password' => Hash::make('password'),
            'role' => 'user'
        ]);
    }
}