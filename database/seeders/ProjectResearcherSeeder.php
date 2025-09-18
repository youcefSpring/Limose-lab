<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectResearcherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = Project::all();
        $researchers = User::where('role', 'researcher')->get();

        foreach ($projects as $project) {
            // Each project gets 2-5 researchers (including PI)
            $numResearchers = rand(2, 5);

            // Get random researchers excluding the PI
            $availableResearchers = $researchers->where('id', '!=', $project->principal_investigator_id);
            $selectedResearchers = $availableResearchers->random(min($numResearchers - 1, $availableResearchers->count()));

            // Add PI to the project
            DB::table('project_researcher')->insert([
                'project_id' => $project->id,
                'user_id' => $project->principal_investigator_id,
                'role' => 'principal_investigator',
                'contribution_percentage' => rand(30, 50),
                'start_date' => $project->start_date,
                'end_date' => $project->end_date,
                'is_active' => true,
                'responsibilities' => 'Lead project planning, supervision, and coordination. Responsible for overall project success and deliverables.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Add other researchers
            foreach ($selectedResearchers as $index => $researcher) {
                $roles = ['co_investigator', 'research_scientist', 'postdoc', 'graduate_student'];
                $role = $roles[array_rand($roles)];

                DB::table('project_researcher')->insert([
                    'project_id' => $project->id,
                    'user_id' => $researcher->id,
                    'role' => $role,
                    'contribution_percentage' => rand(10, 30),
                    'start_date' => $project->start_date,
                    'end_date' => $project->end_date,
                    'is_active' => true,
                    'responsibilities' => $this->generateResponsibilities($role),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    private function generateResponsibilities(string $role): string
    {
        $responsibilities = [
            'co_investigator' => 'Collaborate on research design, data analysis, and manuscript preparation. Provide scientific expertise and guidance.',
            'research_scientist' => 'Conduct experiments, analyze data, and contribute to research publications. Mentor junior researchers.',
            'postdoc' => 'Execute research protocols, analyze experimental data, and assist with laboratory management.',
            'graduate_student' => 'Conduct thesis research, learn techniques, and contribute to project objectives under supervision.',
        ];

        return $responsibilities[$role] ?? 'General research activities and project support.';
    }
}