<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MaintenanceLogSeeder extends Seeder
{
    public function run(): void
    {
        $logs = [
            [
                'material_id' => 4,
                'technician_id' => 6,
                'maintenance_type' => 'corrective',
                'description' => 'Replace faulty temperature sensor',
                'scheduled_date' => Carbon::now()->subDays(5)->toDateString(),
                'completed_date' => Carbon::now()->subDays(3)->toDateString(),
                'status' => 'completed',
                'cost' => 250.00,
                'notes' => 'Replaced temperature sensor and recalibrated system',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_id' => 6,
                'technician_id' => 6,
                'maintenance_type' => 'preventive',
                'description' => 'Monthly maintenance check',
                'scheduled_date' => Carbon::now()->addDays(5)->toDateString(),
                'completed_date' => null,
                'status' => 'scheduled',
                'cost' => null,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('maintenance_logs')->insert($logs);
        $this->command->info('Maintenance logs seeded successfully!');
    }
}
