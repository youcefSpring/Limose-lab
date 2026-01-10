<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Microscopes',
                'description' => 'Optical and electron microscopes for detailed observation',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Centrifuges',
                'description' => 'Equipment for separating substances by density',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Spectrometers',
                'description' => 'Instruments for spectral analysis and measurements',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Incubators',
                'description' => 'Temperature-controlled chambers for cell culture',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Chromatography Equipment',
                'description' => 'Systems for chemical separation and analysis',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'PCR Machines',
                'description' => 'Thermocyclers for DNA amplification',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Balances & Scales',
                'description' => 'Precision weighing equipment',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'pH Meters',
                'description' => 'Instruments for measuring acidity and alkalinity',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Safety Equipment',
                'description' => 'Personal protective equipment and safety devices',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'General Lab Equipment',
                'description' => 'Miscellaneous laboratory tools and apparatus',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('material_categories')->insert($categories);

        $this->command->info('Material categories seeded successfully!');
    }
}
