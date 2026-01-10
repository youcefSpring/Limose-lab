<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create projects
        $projects = [
            [
                'title' => 'Protein Structure Analysis',
                'description' => 'Research project focused on analyzing protein structures using advanced spectroscopy techniques. Objectives: Identify novel protein structures and their functional implications. Methodology: X-ray crystallography and NMR spectroscopy.',
                'start_date' => Carbon::parse('2024-01-01'),
                'end_date' => Carbon::parse('2024-12-31'),
                'status' => 'active',
                'created_by' => 3, // Dr. Sarah Johnson (Researcher)
                'project_type' => 'research',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Gene Expression Studies',
                'description' => 'Investigating gene expression patterns in response to environmental stress. Objectives: Understand molecular mechanisms of stress response. Methodology: RNA-seq and qPCR analysis.',
                'start_date' => Carbon::parse('2024-03-01'),
                'end_date' => Carbon::parse('2025-02-28'),
                'status' => 'active',
                'created_by' => 8, // Researcher 1
                'project_type' => 'research',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Nanomaterials for Drug Delivery',
                'description' => 'Development of novel nanomaterials for targeted drug delivery systems. Objectives: Create biocompatible nanoparticles for cancer therapy. Methodology: Synthesis and characterization of nanoparticles.',
                'start_date' => Carbon::parse('2023-09-01'),
                'end_date' => Carbon::parse('2024-08-31'),
                'status' => 'active',
                'created_by' => 9, // Researcher 2
                'project_type' => 'development',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($projects as $project) {
            $projectId = DB::table('projects')->insertGetId($project);

            // Add project members
            $members = [
                ['project_id' => $projectId, 'user_id' => $project['created_by'], 'role' => 'owner', 'joined_at' => now()],
                ['project_id' => $projectId, 'user_id' => 4, 'role' => 'member', 'joined_at' => now()], // PhD student
                ['project_id' => $projectId, 'user_id' => 14, 'role' => 'member', 'joined_at' => now()], // PhD Student 1
            ];

            DB::table('project_user')->insert($members);
        }

        $this->command->info('Projects seeded successfully!');
    }
}
