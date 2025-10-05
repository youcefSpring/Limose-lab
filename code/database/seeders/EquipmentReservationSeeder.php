<?php

namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipmentReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $equipment = Equipment::where('status', 'operational')->get();
        $users = User::whereIn('role', ['researcher', 'lab_manager'])->get();

        foreach ($equipment as $item) {
            // Each equipment gets 0-5 reservations
            $numReservations = rand(0, 5);

            for ($i = 0; $i < $numReservations; $i++) {
                $user = $users->random();
                $startDate = $this->generateRandomDate();
                $endDate = $this->calculateEndDate($startDate);

                DB::table('equipment_reservations')->insert([
                    'equipment_id' => $item->id,
                    'user_id' => $user->id,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'purpose' => $this->generatePurpose($item->category),
                    'status' => $this->getReservationStatus($startDate, $endDate),
                    'notes' => $this->generateNotes(),
                    'approved_by' => $this->getApprover($users),
                    'approved_at' => now()->subDays(rand(1, 30)),
                    'setup_requirements' => $this->generateSetupRequirements($item->category),
                    'created_at' => now()->subDays(rand(1, 60)),
                    'updated_at' => now()->subDays(rand(0, 30)),
                ]);
            }
        }
    }

    private function generateRandomDate(): string
    {
        // Generate dates from 30 days ago to 60 days in the future
        $start = now()->subDays(30);
        $end = now()->addDays(60);

        $randomTimestamp = rand($start->timestamp, $end->timestamp);
        $randomDate = (new \DateTime())->setTimestamp($randomTimestamp);

        // Round to the nearest hour
        $randomDate->setTime($randomDate->format('H'), 0, 0);

        return $randomDate->format('Y-m-d H:i:s');
    }

    private function calculateEndDate(string $startDate): string
    {
        $start = new \DateTime($startDate);

        // Random duration between 1 hour and 3 days
        $hours = rand(1, 72);
        $start->add(new \DateInterval("PT{$hours}H"));

        return $start->format('Y-m-d H:i:s');
    }

    private function getReservationStatus(string $startDate, string $endDate): string
    {
        $now = now();
        $start = new \DateTime($startDate);
        $end = new \DateTime($endDate);

        if ($end < $now) {
            return rand(0, 1) ? 'completed' : 'cancelled';
        } elseif ($start <= $now && $end >= $now) {
            return 'in_progress';
        } else {
            return rand(0, 9) ? 'confirmed' : 'pending';
        }
    }

    private function generatePurpose(string $category): string
    {
        $purposes = [
            'microscopy' => [
                'Cell imaging for research project',
                'Fluorescence microscopy analysis',
                'Live cell imaging experiment',
                'Immunofluorescence staining analysis',
                'Confocal microscopy imaging'
            ],
            'analytical' => [
                'Protein concentration analysis',
                'Sample purity verification',
                'Quantitative analysis',
                'Quality control testing',
                'Molecular weight determination'
            ],
            'spectroscopy' => [
                'UV-Vis spectroscopy analysis',
                'Chemical composition analysis',
                'Absorption spectrum measurement',
                'Kinetic studies',
                'Concentration determination'
            ],
            'chromatography' => [
                'Protein purification',
                'Compound separation',
                'HPLC analysis',
                'Sample purification',
                'Analytical separation'
            ],
            'safety' => [
                'Sterile cell culture work',
                'Biological sample preparation',
                'Contamination-free procedures',
                'Aseptic technique training',
                'Microbiological work'
            ],
            'general' => [
                'Sample preparation',
                'Routine laboratory work',
                'Research experiment',
                'Training session',
                'Method development'
            ]
        ];

        $categoryPurposes = $purposes[$category] ?? $purposes['general'];
        return $categoryPurposes[array_rand($categoryPurposes)];
    }

    private function generateNotes(): ?string
    {
        $notes = [
            'Standard protocol required',
            'Special safety precautions needed',
            'Extended usage time requested',
            'Training completed',
            'Maintenance check performed',
            null, // Some reservations have no notes
            null,
            null
        ];

        return $notes[array_rand($notes)];
    }

    private function getApprover($users): ?int
    {
        $labManagers = $users->where('role', 'lab_manager');
        return $labManagers->isNotEmpty() ? $labManagers->random()->id : null;
    }

    private function generateSetupRequirements(string $category): ?string
    {
        $requirements = [
            'microscopy' => 'Objective lenses cleaned, camera calibrated, fluorescence filters checked',
            'analytical' => 'Calibration verified, reference standards prepared, baseline established',
            'spectroscopy' => 'Wavelength calibration, blank measurement, detector sensitivity check',
            'chromatography' => 'Column equilibration, mobile phase preparation, system pressure check',
            'safety' => 'UV sterilization, airflow verification, work surface decontamination',
            'general' => 'Basic equipment check, safety verification, user training confirmed'
        ];

        return $requirements[$category] ?? null;
    }
}