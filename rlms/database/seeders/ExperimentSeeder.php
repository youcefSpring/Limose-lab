<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ExperimentSeeder extends Seeder
{
    public function run(): void
    {
        $experiments = [
            [
                'project_id' => 1,
                'user_id' => 3,
                'title' => 'Protein Crystallization Experiment 1',
                'description' => 'Initial crystallization trials for protein complex. Hypothesis: Protein will crystallize under specific pH conditions. Procedure: Prepare protein samples, set up crystallization trays, monitor crystal growth. Results: Crystals formed after 48 hours.',
                'experiment_type' => 'report',
                'experiment_date' => Carbon::parse('2024-01-10'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'project_id' => 2,
                'user_id' => 8,
                'title' => 'RNA Extraction and Quality Control',
                'description' => 'Extract RNA from stress-treated samples. Hypothesis: RNA quality will meet sequencing requirements. Procedure: Tissue lysis, RNA extraction, quality assessment.',
                'experiment_type' => 'data',
                'experiment_date' => Carbon::now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('experiments')->insert($experiments);
        $this->command->info('Experiments seeded successfully!');
    }
}
