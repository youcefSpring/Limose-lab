<?php

namespace Database\Seeders;

use App\Models\ProjectFunding;
use App\Models\Project;
use App\Models\FundingSource;
use Illuminate\Database\Seeder;

class ProjectFundingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = Project::all();
        $fundingSources = FundingSource::all();

        if ($projects->isEmpty() || $fundingSources->isEmpty()) {
            return;
        }

        $projectFundings = [];

        foreach ($projects->take(10) as $project) {
            // Each project gets 1-3 funding sources
            $numFundings = rand(1, 3);
            $usedSources = [];

            for ($i = 0; $i < $numFundings; $i++) {
                $fundingSource = $fundingSources->whereNotIn('id', $usedSources)->random();
                $usedSources[] = $fundingSource->id;

                $startDate = now()->subMonths(rand(1, 24));
                $duration = rand(12, 60); // 1-5 years
                $endDate = $startDate->copy()->addMonths($duration);

                $projectFundings[] = [
                    'project_id' => $project->id,
                    'funding_source_id' => $fundingSource->id,
                    'amount' => rand(50000, 2000000),
                    'currency' => $fundingSource->currency,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'status' => $this->getRandomStatus($startDate, $endDate),
                    'grant_number' => $this->generateGrantNumber($fundingSource),
                    'notes' => $this->generateNotes(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        ProjectFunding::insert($projectFundings);
    }

    /**
     * Get random status based on dates
     */
    private function getRandomStatus($startDate, $endDate): string
    {
        $now = now();

        if ($startDate->isFuture()) {
            return 'approved';
        } elseif ($endDate->isPast()) {
            return rand(1, 10) > 8 ? 'cancelled' : 'completed';
        } else {
            return 'active';
        }
    }

    /**
     * Generate grant number
     */
    private function generateGrantNumber(FundingSource $source): string
    {
        $prefix = match($source->type) {
            'government' => 'GOV',
            'private' => 'PVT',
            'industry' => 'IND',
            'international' => 'INT',
            default => 'GEN'
        };

        return $prefix . '-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
    }

    /**
     * Generate random notes
     */
    private function generateNotes(): string
    {
        $notes = [
            'Grant approved with full funding amount.',
            'Milestone payments based on deliverables.',
            'Annual reporting required.',
            'Equipment purchase allowed.',
            'Personnel costs covered at 100%.',
            'Travel restrictions apply.',
            'Publication requirements included.',
            'Final report due 30 days after completion.',
            'Extension possible with justification.',
            'Collaboration with industry partner required.',
        ];

        return $notes[array_rand($notes)];
    }
}