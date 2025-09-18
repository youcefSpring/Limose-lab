<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', 'researcher')->get();

        $projects = [
            [
                'title' => 'CRISPR-Cas9 Gene Editing in Neural Development',
                'description' => 'Investigation of CRISPR-Cas9 applications for studying neural development pathways in model organisms. This project aims to understand the molecular mechanisms underlying neurogenesis.',
                'status' => 'active',
                'start_date' => '2024-01-15',
                'end_date' => '2026-01-14',
                'budget' => 750000.00,
                'funding_source' => 'National Science Foundation',
                'priority' => 'high',
                'category' => 'basic_research',
            ],
            [
                'title' => 'Protein Folding Dynamics in Alzheimer\'s Disease',
                'description' => 'Comprehensive study of protein misfolding mechanisms in Alzheimer\'s disease using advanced spectroscopic techniques and computational modeling.',
                'status' => 'active',
                'start_date' => '2023-09-01',
                'end_date' => '2025-08-31',
                'budget' => 500000.00,
                'funding_source' => 'National Institutes of Health',
                'priority' => 'high',
                'category' => 'clinical_research',
            ],
            [
                'title' => 'Microbiome Analysis in Inflammatory Bowel Disease',
                'description' => 'Longitudinal study of gut microbiome changes in patients with inflammatory bowel disease to identify potential therapeutic targets.',
                'status' => 'active',
                'start_date' => '2024-03-01',
                'end_date' => '2026-02-28',
                'budget' => 400000.00,
                'funding_source' => 'Department of Health',
                'priority' => 'medium',
                'category' => 'clinical_research',
            ],
            [
                'title' => 'Machine Learning for Drug Discovery',
                'description' => 'Development of AI-powered algorithms to accelerate the identification of novel drug compounds for cancer treatment.',
                'status' => 'active',
                'start_date' => '2024-02-01',
                'end_date' => '2025-07-31',
                'budget' => 300000.00,
                'funding_source' => 'Private Foundation',
                'priority' => 'high',
                'category' => 'applied_research',
            ],
            [
                'title' => 'Climate Change Impact on Marine Ecosystems',
                'description' => 'Long-term monitoring and analysis of climate change effects on marine biodiversity and ecosystem functioning.',
                'status' => 'active',
                'start_date' => '2023-06-01',
                'end_date' => '2026-05-31',
                'budget' => 600000.00,
                'funding_source' => 'Environmental Protection Agency',
                'priority' => 'medium',
                'category' => 'environmental_research',
            ],
            [
                'title' => 'Immunotherapy for Autoimmune Disorders',
                'description' => 'Development of novel immunotherapeutic approaches for treating rheumatoid arthritis and multiple sclerosis.',
                'status' => 'planning',
                'start_date' => '2024-09-01',
                'end_date' => '2027-08-31',
                'budget' => 850000.00,
                'funding_source' => 'Pharmaceutical Company',
                'priority' => 'high',
                'category' => 'clinical_research',
            ],
            [
                'title' => 'Synthetic Biology for Biofuel Production',
                'description' => 'Engineering microorganisms for efficient production of sustainable biofuels from renewable biomass sources.',
                'status' => 'active',
                'start_date' => '2024-01-01',
                'end_date' => '2025-12-31',
                'budget' => 450000.00,
                'funding_source' => 'Department of Energy',
                'priority' => 'medium',
                'category' => 'applied_research',
            ],
            [
                'title' => 'Quantum Computing Applications in Biology',
                'description' => 'Exploring quantum computing algorithms for solving complex biological problems including protein structure prediction.',
                'status' => 'planning',
                'start_date' => '2024-10-01',
                'end_date' => '2027-09-30',
                'budget' => 1200000.00,
                'funding_source' => 'National Science Foundation',
                'priority' => 'high',
                'category' => 'basic_research',
            ],
            [
                'title' => 'Nanoparticle Drug Delivery Systems',
                'description' => 'Design and testing of targeted nanoparticle systems for precise drug delivery to cancer cells.',
                'status' => 'active',
                'start_date' => '2023-11-01',
                'end_date' => '2025-10-31',
                'budget' => 380000.00,
                'funding_source' => 'Cancer Research Institute',
                'priority' => 'high',
                'category' => 'applied_research',
            ],
            [
                'title' => 'Stem Cell Therapy for Spinal Cord Injury',
                'description' => 'Preclinical studies on the efficacy of stem cell transplantation for treating spinal cord injuries.',
                'status' => 'completed',
                'start_date' => '2022-01-01',
                'end_date' => '2023-12-31',
                'budget' => 320000.00,
                'funding_source' => 'Spinal Cord Research Foundation',
                'priority' => 'medium',
                'category' => 'clinical_research',
            ],
            [
                'title' => 'Agricultural Biotechnology for Crop Improvement',
                'description' => 'Development of genetically modified crops with enhanced resistance to pests and environmental stresses.',
                'status' => 'active',
                'start_date' => '2024-04-01',
                'end_date' => '2026-03-31',
                'budget' => 550000.00,
                'funding_source' => 'Agricultural Research Service',
                'priority' => 'medium',
                'category' => 'applied_research',
            ],
            [
                'title' => 'Epigenetic Regulation in Cancer Development',
                'description' => 'Investigation of epigenetic modifications and their role in cancer initiation and progression.',
                'status' => 'active',
                'start_date' => '2023-08-01',
                'end_date' => '2025-07-31',
                'budget' => 420000.00,
                'funding_source' => 'American Cancer Society',
                'priority' => 'high',
                'category' => 'basic_research',
            ],
        ];

        foreach ($projects as $index => $projectData) {
            $principalInvestigator = $users->random();

            Project::create([
                'title' => $projectData['title'],
                'description' => $projectData['description'],
                'status' => $projectData['status'],
                'start_date' => $projectData['start_date'],
                'end_date' => $projectData['end_date'],
                'budget' => $projectData['budget'],
                'funding_source' => $projectData['funding_source'],
                'priority' => $projectData['priority'],
                'category' => $projectData['category'],
                'principal_investigator_id' => $principalInvestigator->id,
                'progress_percentage' => $this->getProgressPercentage($projectData['status']),
                'milestones' => json_encode($this->generateMilestones($projectData['title'])),
                'objectives' => $this->generateObjectives($projectData['title']),
                'methodology' => $this->generateMethodology($projectData['category']),
                'expected_outcomes' => $this->generateExpectedOutcomes($projectData['title']),
                'risk_assessment' => 'Medium risk level with standard mitigation strategies in place.',
                'is_active' => in_array($projectData['status'], ['active', 'planning']),
            ]);
        }
    }

    private function getProgressPercentage(string $status): int
    {
        return match ($status) {
            'planning' => 5,
            'active' => rand(20, 80),
            'completed' => 100,
            'suspended' => rand(10, 60),
            'cancelled' => rand(5, 30),
            default => 0,
        };
    }

    private function generateMilestones(string $title): array
    {
        return [
            [
                'title' => 'Project Initiation',
                'description' => 'Complete project setup and team assembly',
                'due_date' => '2024-02-01',
                'status' => 'completed'
            ],
            [
                'title' => 'Literature Review',
                'description' => 'Comprehensive review of existing research',
                'due_date' => '2024-04-01',
                'status' => 'completed'
            ],
            [
                'title' => 'Methodology Development',
                'description' => 'Develop and validate research methodology',
                'due_date' => '2024-06-01',
                'status' => 'in_progress'
            ],
            [
                'title' => 'Data Collection',
                'description' => 'Execute primary data collection phase',
                'due_date' => '2024-10-01',
                'status' => 'pending'
            ]
        ];
    }

    private function generateObjectives(string $title): string
    {
        return "1. Conduct comprehensive analysis of the research problem\n" .
               "2. Develop innovative solutions using cutting-edge techniques\n" .
               "3. Validate findings through rigorous testing\n" .
               "4. Disseminate results through peer-reviewed publications\n" .
               "5. Train graduate students and postdoctoral researchers";
    }

    private function generateMethodology(string $category): string
    {
        $methodologies = [
            'basic_research' => 'Experimental design using controlled laboratory conditions with statistical analysis of results.',
            'clinical_research' => 'Randomized controlled trial with institutional review board approval and patient consent.',
            'applied_research' => 'Prototype development followed by validation testing and performance evaluation.',
            'environmental_research' => 'Field studies with longitudinal data collection and environmental monitoring.',
        ];

        return $methodologies[$category] ?? 'Standard research methodology with peer review and validation protocols.';
    }

    private function generateExpectedOutcomes(string $title): string
    {
        return "Expected outcomes include advancement of scientific knowledge in the field, " .
               "development of new techniques or technologies, publication of high-impact research papers, " .
               "and potential for practical applications benefiting society.";
    }
}