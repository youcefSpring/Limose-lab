<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleAndPermissionSeeder::class,
            MaterialCategorySeeder::class,
            UserSeeder::class,
            MaterialSeeder::class,
            ProjectSeeder::class,
            ReservationSeeder::class,
            ExperimentSeeder::class,
            EventSeeder::class,
            MaintenanceLogSeeder::class,
        ]);
    }
}
