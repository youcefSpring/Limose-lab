<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $materials = [
            // Microscopes
            [
                'name' => 'Olympus BX53 Microscope',
                'description' => 'Advanced upright microscope for materials science and life science applications',
                'category_id' => 1,
                'quantity' => 2,
                'status' => 'available',
                'location' => 'Lab Room 101',
                'serial_number' => 'OLY-BX53-001',
                'purchase_date' => Carbon::parse('2022-01-15'),
                'maintenance_schedule' => 'quarterly',
                'last_maintenance_date' => Carbon::parse('2024-10-01'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Zeiss Electron Microscope',
                'description' => 'High-resolution scanning electron microscope',
                'category_id' => 1,
                'quantity' => 1,
                'status' => 'available',
                'location' => 'Lab Room 105',
                'serial_number' => 'ZEI-SEM-002',
                'purchase_date' => Carbon::parse('2021-06-20'),
                'maintenance_schedule' => 'monthly',
                'last_maintenance_date' => Carbon::parse('2024-12-01'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Centrifuges
            [
                'name' => 'Eppendorf Centrifuge 5430R',
                'description' => 'Refrigerated microcentrifuge with rotor capacity up to 24 x 1.5/2.0 mL',
                'category_id' => 2,
                'quantity' => 3,
                'status' => 'available',
                'location' => 'Lab Room 102',
                'serial_number' => 'EPP-5430R-003',
                'purchase_date' => Carbon::parse('2022-03-10'),
                'maintenance_schedule' => 'quarterly',
                'last_maintenance_date' => Carbon::parse('2024-06-15'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Spectrometers
            [
                'name' => 'Thermo UV-Vis Spectrometer',
                'description' => 'High-performance UV-Visible spectrophotometer for quantitative analysis',
                'category_id' => 3,
                'quantity' => 1,
                'status' => 'maintenance',
                'location' => 'Lab Room 103',
                'serial_number' => 'THR-UV-004',
                'purchase_date' => Carbon::parse('2020-09-25'),
                'maintenance_schedule' => 'quarterly',
                'last_maintenance_date' => Carbon::parse('2024-09-01'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Incubators
            [
                'name' => 'Thermo CO2 Incubator',
                'description' => 'CO2 incubator for cell culture with temperature and humidity control',
                'category_id' => 4,
                'quantity' => 2,
                'status' => 'available',
                'location' => 'Cell Culture Room 201',
                'serial_number' => 'THR-INC-005',
                'purchase_date' => Carbon::parse('2021-11-30'),
                'maintenance_schedule' => 'quarterly',
                'last_maintenance_date' => Carbon::parse('2024-11-01'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Chromatography
            [
                'name' => 'Agilent HPLC System',
                'description' => 'High-performance liquid chromatography system for chemical analysis',
                'category_id' => 5,
                'quantity' => 1,
                'status' => 'available',
                'location' => 'Lab Room 104',
                'serial_number' => 'AGI-HPLC-006',
                'purchase_date' => Carbon::parse('2022-05-15'),
                'maintenance_schedule' => 'monthly',
                'last_maintenance_date' => Carbon::parse('2024-12-01'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // PCR Machines
            [
                'name' => 'Bio-Rad T100 Thermal Cycler',
                'description' => 'PCR thermal cycler with 96-well block for DNA amplification',
                'category_id' => 6,
                'quantity' => 4,
                'status' => 'available',
                'location' => 'Molecular Lab 202',
                'serial_number' => 'BIO-T100-007',
                'purchase_date' => Carbon::parse('2023-01-20'),
                'maintenance_schedule' => 'yearly',
                'last_maintenance_date' => Carbon::parse('2024-01-15'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Balances
            [
                'name' => 'Sartorius Analytical Balance',
                'description' => 'High-precision analytical balance with 0.0001g readability',
                'category_id' => 7,
                'quantity' => 5,
                'status' => 'available',
                'location' => 'Weighing Room',
                'serial_number' => 'SAR-BAL-008',
                'purchase_date' => Carbon::parse('2022-08-10'),
                'maintenance_schedule' => 'quarterly',
                'last_maintenance_date' => Carbon::parse('2024-07-01'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // pH Meters
            [
                'name' => 'Mettler Toledo pH Meter',
                'description' => 'Benchtop pH meter with automatic temperature compensation',
                'category_id' => 8,
                'quantity' => 3,
                'status' => 'available',
                'location' => 'Lab Room 102',
                'serial_number' => 'MET-PH-009',
                'purchase_date' => Carbon::parse('2023-03-15'),
                'maintenance_schedule' => 'quarterly',
                'last_maintenance_date' => Carbon::parse('2024-10-01'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Safety Equipment
            [
                'name' => 'Biosafety Cabinet Class II',
                'description' => 'Class II biosafety cabinet for safe handling of biological materials',
                'category_id' => 9,
                'quantity' => 2,
                'status' => 'available',
                'location' => 'BSL-2 Lab 301',
                'serial_number' => 'BSC-II-010',
                'purchase_date' => Carbon::parse('2021-07-01'),
                'maintenance_schedule' => 'yearly',
                'last_maintenance_date' => Carbon::parse('2024-07-01'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // General Equipment
            [
                'name' => 'Magnetic Stirrer Hot Plate',
                'description' => 'Combination magnetic stirrer and heating plate',
                'category_id' => 10,
                'quantity' => 10,
                'status' => 'available',
                'location' => 'Chemistry Lab 106',
                'serial_number' => null,
                'purchase_date' => Carbon::parse('2023-09-01'),
                'maintenance_schedule' => 'yearly',
                'last_maintenance_date' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Vortex Mixer',
                'description' => 'Variable speed vortex mixer for tubes and microplates',
                'category_id' => 10,
                'quantity' => 8,
                'status' => 'available',
                'location' => 'Lab Room 102',
                'serial_number' => null,
                'purchase_date' => Carbon::parse('2023-10-15'),
                'maintenance_schedule' => 'yearly',
                'last_maintenance_date' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('materials')->insert($materials);

        $this->command->info('Materials seeded successfully!');
    }
}
