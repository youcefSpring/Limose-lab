<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        $reservations = [
            [
                'user_id' => 3,
                'material_id' => 1,
                'start_date' => Carbon::parse('2024-01-15'),
                'end_date' => Carbon::parse('2024-01-20'),
                'quantity' => 1,
                'purpose' => 'Microscopy analysis for protein structure research',
                'status' => 'approved',
                'validated_by' => 2,
                'validated_at' => Carbon::parse('2024-01-10'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4,
                'material_id' => 7,
                'start_date' => Carbon::now()->addDays(2),
                'end_date' => Carbon::now()->addDays(5),
                'quantity' => 2,
                'purpose' => 'PCR amplification for gene expression study',
                'status' => 'pending',
                'validated_by' => null,
                'validated_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 8,
                'material_id' => 3,
                'start_date' => Carbon::parse('2024-01-05'),
                'end_date' => Carbon::parse('2024-01-08'),
                'quantity' => 1,
                'purpose' => 'Sample centrifugation',
                'status' => 'completed',
                'validated_by' => 2,
                'validated_at' => Carbon::parse('2024-01-04'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('reservations')->insert($reservations);
        $this->command->info('Reservations seeded successfully!');
    }
}
