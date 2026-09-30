<?php
// [Magfi Adi Radza Putra] - Database Seeder

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            UserRoleSeeder::class,
        ]);
    }
}
