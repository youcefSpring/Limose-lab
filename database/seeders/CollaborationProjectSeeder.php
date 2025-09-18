<?php

namespace Database\Seeders;

use App\Models\Collaboration;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CollaborationProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $collaborations = Collaboration::where('status', 'active')->get();
        $projects = Project::where('status', 'active')->get();

        foreach ($collaborations as $collaboration) {
            // Each collaboration is linked to 1-3 projects
            $numProjects = rand(1, 3);
            $selectedProjects = $projects->random(min($numProjects, $projects->count()));

            foreach ($selectedProjects as $project) {
                // Avoid duplicate entries
                $exists = DB::table('collaboration_projects')
                    ->where('collaboration_id', $collaboration->id)
                    ->where('project_id', $project->id)
                    ->exists();

                if (!$exists) {
                    DB::table('collaboration_projects')->insert([
                        'collaboration_id' => $collaboration->id,
                        'project_id' => $project->id,
                        'role' => $this->generateCollaborationRole($collaboration->type),
                        'contribution_type' => $this->generateContributionType($collaboration->type),
                        'funding_contribution' => $this->generateFundingContribution($project->budget, $collaboration->type),
                        'start_date' => max($collaboration->start_date, $project->start_date),
                        'end_date' => min($collaboration->end_date, $project->end_date),
                        'status' => 'active',
                        'deliverables' => json_encode($this->generateDeliverables($collaboration->type, $project->title)),
                        'milestones' => json_encode($this->generateMilestones()),
                        'progress_percentage' => rand(20, 80),
                        'last_update' => now()->subDays(rand(1, 30)),
                        'notes' => $this->generateNotes($collaboration->partner_institution, $project->title),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }

    private function generateCollaborationRole(string $collaborationType): string
    {
        $roles = [
            'research_partnership' => ['co_investigator', 'data_provider', 'analysis_partner', 'methodology_contributor'],
            'student_exchange' => ['host_institution', 'sending_institution', 'co_supervisor'],
            'joint_program' => ['program_partner', 'curriculum_developer', 'accreditation_partner'],
            'equipment_sharing' => ['equipment_provider', 'facility_access', 'technical_support'],
            'knowledge_exchange' => ['expertise_provider', 'technology_transfer', 'advisory_partner'],
            'funding_partnership' => ['co_funder', 'grant_partner', 'budget_contributor'],
        ];

        $typeRoles = $roles[$collaborationType] ?? ['general_partner'];
        return $typeRoles[array_rand($typeRoles)];
    }

    private function generateContributionType(string $collaborationType): string
    {
        $contributions = [
            'research_partnership' => ['research_expertise', 'data_collection', 'analysis_tools', 'methodology'],
            'student_exchange' => ['student_hosting', 'supervision', 'training_programs', 'mentorship'],
            'joint_program' => ['curriculum_development', 'faculty_exchange', 'accreditation_support'],
            'equipment_sharing' => ['equipment_access', 'technical_training', 'maintenance_support'],
            'knowledge_exchange' => ['technology_transfer', 'intellectual_property', 'consulting'],
            'funding_partnership' => ['financial_support', 'grant_matching', 'resource_allocation'],
        ];

        $typeContributions = $contributions[$collaborationType] ?? ['general_support'];
        return $typeContributions[array_rand($typeContributions)];
    }

    private function generateFundingContribution(float $projectBudget, string $collaborationType): float
    {
        // Funding contribution varies by collaboration type
        $percentage = match ($collaborationType) {
            'funding_partnership' => rand(20, 50) / 100,
            'research_partnership' => rand(10, 30) / 100,
            'equipment_sharing' => rand(5, 15) / 100,
            'joint_program' => rand(15, 35) / 100,
            default => rand(0, 10) / 100,
        };

        return $projectBudget * $percentage;
    }

    private function generateDeliverables(string $collaborationType, string $projectTitle): array
    {
        $baseDeliverables = [
            'Joint research publication',
            'Shared datasets',
            'Collaborative methodology',
            'Progress reports',
        ];

        $typeSpecificDeliverables = [
            'research_partnership' => [
                'Co-authored papers',
                'Shared research protocols',
                'Joint conference presentations',
                'Collaborative grant applications',
            ],
            'student_exchange' => [
                'Student exchange program',
                'Joint supervision reports',
                'Cultural exchange activities',
                'Academic credit transfers',
            ],
            'joint_program' => [
                'Joint degree curriculum',
                'Accreditation documents',
                'Faculty exchange program',
                'Student mobility framework',
            ],
            'equipment_sharing' => [
                'Equipment usage reports',
                'Technical training sessions',
                'Maintenance schedules',
                'Usage optimization protocols',
            ],
            'knowledge_exchange' => [
                'Technology transfer agreements',
                'Intellectual property documentation',
                'Innovation workshops',
                'Commercialization plans',
            ],
            'funding_partnership' => [
                'Joint funding proposals',
                'Budget allocation reports',
                'Financial progress reports',
                'Cost-sharing agreements',
            ],
        ];

        $specificDeliverables = $typeSpecificDeliverables[$collaborationType] ?? [];
        $allDeliverables = array_merge($baseDeliverables, $specificDeliverables);

        // Return 2-4 random deliverables
        $numDeliverables = rand(2, 4);
        return array_slice(array_unique($allDeliverables), 0, $numDeliverables);
    }

    private function generateMilestones(): array
    {
        $milestones = [
            [
                'title' => 'Collaboration Agreement Signed',
                'description' => 'Formal collaboration agreement executed by both parties',
                'due_date' => now()->subDays(rand(30, 90))->format('Y-m-d'),
                'status' => 'completed',
            ],
            [
                'title' => 'Initial Planning Meeting',
                'description' => 'First joint planning session with all stakeholders',
                'due_date' => now()->subDays(rand(15, 60))->format('Y-m-d'),
                'status' => 'completed',
            ],
            [
                'title' => 'Resource Allocation',
                'description' => 'Allocation of resources and responsibilities',
                'due_date' => now()->addDays(rand(30, 90))->format('Y-m-d'),
                'status' => rand(0, 1) ? 'in_progress' : 'pending',
            ],
            [
                'title' => 'Mid-term Review',
                'description' => 'Progress evaluation and adjustment of goals',
                'due_date' => now()->addDays(rand(90, 180))->format('Y-m-d'),
                'status' => 'pending',
            ],
        ];

        return $milestones;
    }

    private function generateNotes(string $partnerInstitution, string $projectTitle): string
    {
        $templates = [
            "Active collaboration with {partner} on {project}. Regular communication maintained through monthly video conferences.",
            "Partnership with {partner} progressing well. Joint research activities on {project} showing promising results.",
            "Collaboration with {partner} includes resource sharing and joint supervision for {project}.",
            "Working closely with {partner} team on {project}. Exchange of researchers and students planned.",
            "Strong partnership with {partner} established for {project}. Multiple deliverables in development.",
        ];

        $template = $templates[array_rand($templates)];
        return str_replace(
            ['{partner}', '{project}'],
            [$partnerInstitution, $projectTitle],
            $template
        );
    }
}