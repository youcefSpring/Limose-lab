<?php

namespace Database\Seeders;

use App\Models\Funding;
use App\Models\User;
use Illuminate\Database\Seeder;

class FundingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $principalInvestigators = User::where('role', 'researcher')->get();

        $fundingRecords = [
            [
                'title' => 'Neural Mechanisms of Learning and Memory',
                'description' => 'Comprehensive study of synaptic plasticity and memory formation using advanced electrophysiology and optogenetics techniques.',
                'funding_agency' => 'National Science Foundation',
                'type' => 'government_grant',
                'amount' => 750000.00,
                'currency' => 'USD',
                'start_date' => '2024-01-01',
                'end_date' => '2026-12-31',
                'status' => 'active',
                'application_date' => '2023-09-15',
                'award_date' => '2023-12-20',
                'grant_number' => 'NSF-BIO-2024-0123',
                'indirect_cost_rate' => 25.0,
                'budget_categories' => json_encode([
                    'personnel' => 450000,
                    'equipment' => 150000,
                    'supplies' => 100000,
                    'travel' => 25000,
                    'other' => 25000
                ]),
            ],
            [
                'title' => 'Cancer Immunotherapy Development Initiative',
                'description' => 'Development of novel CAR-T cell therapies for treatment-resistant solid tumors with focus on improving efficacy and reducing side effects.',
                'funding_agency' => 'National Cancer Institute',
                'type' => 'government_grant',
                'amount' => 1200000.00,
                'currency' => 'USD',
                'start_date' => '2023-07-01',
                'end_date' => '2026-06-30',
                'status' => 'active',
                'application_date' => '2023-02-01',
                'award_date' => '2023-05-15',
                'grant_number' => 'NCI-R01-2023-4567',
                'indirect_cost_rate' => 30.0,
                'budget_categories' => json_encode([
                    'personnel' => 720000,
                    'equipment' => 200000,
                    'supplies' => 180000,
                    'travel' => 50000,
                    'other' => 50000
                ]),
            ],
            [
                'title' => 'Sustainable Biofuel Production from Algae',
                'description' => 'Engineering microalgae for enhanced lipid production and development of cost-effective biofuel extraction methods.',
                'funding_agency' => 'Department of Energy',
                'type' => 'government_grant',
                'amount' => 850000.00,
                'currency' => 'USD',
                'start_date' => '2024-03-01',
                'end_date' => '2027-02-28',
                'status' => 'active',
                'application_date' => '2023-10-30',
                'award_date' => '2024-01-15',
                'grant_number' => 'DOE-BER-2024-0890',
                'indirect_cost_rate' => 28.0,
                'budget_categories' => json_encode([
                    'personnel' => 510000,
                    'equipment' => 170000,
                    'supplies' => 120000,
                    'travel' => 30000,
                    'other' => 20000
                ]),
            ],
            [
                'title' => 'Alzheimer\'s Disease Drug Discovery Program',
                'description' => 'High-throughput screening and validation of novel therapeutic compounds targeting amyloid and tau pathologies.',
                'funding_agency' => 'Alzheimer\'s Association',
                'type' => 'private_foundation',
                'amount' => 500000.00,
                'currency' => 'USD',
                'start_date' => '2024-02-01',
                'end_date' => '2026-01-31',
                'status' => 'active',
                'application_date' => '2023-11-01',
                'award_date' => '2023-12-15',
                'grant_number' => 'AARG-24-967890',
                'indirect_cost_rate' => 20.0,
                'budget_categories' => json_encode([
                    'personnel' => 300000,
                    'equipment' => 80000,
                    'supplies' => 90000,
                    'travel' => 20000,
                    'other' => 10000
                ]),
            ],
            [
                'title' => 'Quantum Computing for Protein Structure Prediction',
                'description' => 'Development of quantum algorithms for accurate prediction of protein folding and drug-protein interactions.',
                'funding_agency' => 'IBM Research',
                'type' => 'industry_partnership',
                'amount' => 650000.00,
                'currency' => 'USD',
                'start_date' => '2024-01-15',
                'end_date' => '2025-12-31',
                'status' => 'active',
                'application_date' => '2023-08-20',
                'award_date' => '2023-11-30',
                'grant_number' => 'IBM-QC-2024-001',
                'indirect_cost_rate' => 15.0,
                'budget_categories' => json_encode([
                    'personnel' => 390000,
                    'equipment' => 130000,
                    'supplies' => 80000,
                    'travel' => 35000,
                    'other' => 15000
                ]),
            ],
            [
                'title' => 'Marine Biodiversity Conservation Project',
                'description' => 'Comprehensive study of climate change impacts on marine ecosystems and development of conservation strategies.',
                'funding_agency' => 'World Wildlife Fund',
                'type' => 'private_foundation',
                'amount' => 400000.00,
                'currency' => 'USD',
                'start_date' => '2023-06-01',
                'end_date' => '2025-05-31',
                'status' => 'active',
                'application_date' => '2023-01-15',
                'award_date' => '2023-04-10',
                'grant_number' => 'WWF-MC-2023-445',
                'indirect_cost_rate' => 18.0,
                'budget_categories' => json_encode([
                    'personnel' => 240000,
                    'equipment' => 60000,
                    'supplies' => 70000,
                    'travel' => 25000,
                    'other' => 5000
                ]),
            ],
            [
                'title' => 'CRISPR Gene Therapy Clinical Trial',
                'description' => 'Phase I clinical trial of CRISPR-based gene therapy for inherited retinal diseases.',
                'funding_agency' => 'Foundation Fighting Blindness',
                'type' => 'private_foundation',
                'amount' => 950000.00,
                'currency' => 'USD',
                'start_date' => '2024-04-01',
                'end_date' => '2027-03-31',
                'status' => 'awarded',
                'application_date' => '2023-12-01',
                'award_date' => '2024-02-28',
                'grant_number' => 'FFB-GT-2024-112',
                'indirect_cost_rate' => 22.0,
                'budget_categories' => json_encode([
                    'personnel' => 570000,
                    'equipment' => 150000,
                    'supplies' => 150000,
                    'travel' => 40000,
                    'other' => 40000
                ]),
            ],
            [
                'title' => 'Advanced Materials for Energy Storage',
                'description' => 'Development of novel nanomaterials for next-generation battery technologies with improved capacity and safety.',
                'funding_agency' => 'University Research Fund',
                'type' => 'internal_funding',
                'amount' => 125000.00,
                'currency' => 'USD',
                'start_date' => '2024-01-01',
                'end_date' => '2024-12-31',
                'status' => 'active',
                'application_date' => '2023-11-15',
                'award_date' => '2023-12-10',
                'grant_number' => 'URF-2024-EM-78',
                'indirect_cost_rate' => 10.0,
                'budget_categories' => json_encode([
                    'personnel' => 75000,
                    'equipment' => 25000,
                    'supplies' => 20000,
                    'travel' => 3000,
                    'other' => 2000
                ]),
            ],
            [
                'title' => 'Global Health Data Analytics Platform',
                'description' => 'Development of AI-powered platform for analyzing global health data and predicting disease outbreaks.',
                'funding_agency' => 'Bill & Melinda Gates Foundation',
                'type' => 'private_foundation',
                'amount' => 1100000.00,
                'currency' => 'USD',
                'start_date' => '2023-10-01',
                'end_date' => '2026-09-30',
                'status' => 'active',
                'application_date' => '2023-05-15',
                'award_date' => '2023-08-20',
                'grant_number' => 'BMGF-GH-2023-990',
                'indirect_cost_rate' => 25.0,
                'budget_categories' => json_encode([
                    'personnel' => 660000,
                    'equipment' => 200000,
                    'supplies' => 120000,
                    'travel' => 70000,
                    'other' => 50000
                ]),
            ],
            [
                'title' => 'Personalized Medicine for Rare Diseases',
                'description' => 'Development of personalized therapeutic approaches for rare genetic diseases using genomics and proteomics.',
                'funding_agency' => 'Roche Pharmaceuticals',
                'type' => 'industry_partnership',
                'amount' => 800000.00,
                'currency' => 'USD',
                'start_date' => '2024-02-15',
                'end_date' => '2026-02-14',
                'status' => 'active',
                'application_date' => '2023-09-30',
                'award_date' => '2023-12-15',
                'grant_number' => 'ROCHE-PM-2024-567',
                'indirect_cost_rate' => 20.0,
                'budget_categories' => json_encode([
                    'personnel' => 480000,
                    'equipment' => 120000,
                    'supplies' => 140000,
                    'travel' => 40000,
                    'other' => 20000
                ]),
            ],
            [
                'title' => 'Agricultural Biotechnology Innovation',
                'description' => 'Development of drought-resistant crop varieties using advanced gene editing and breeding techniques.',
                'funding_agency' => 'European Research Council',
                'type' => 'international_grant',
                'amount' => 1500000.00,
                'currency' => 'EUR',
                'start_date' => '2024-01-01',
                'end_date' => '2028-12-31',
                'status' => 'under_review',
                'application_date' => '2023-10-01',
                'award_date' => null,
                'grant_number' => 'ERC-AdG-2024-101234',
                'indirect_cost_rate' => 25.0,
                'budget_categories' => json_encode([
                    'personnel' => 900000,
                    'equipment' => 300000,
                    'supplies' => 200000,
                    'travel' => 60000,
                    'other' => 40000
                ]),
            ],
            [
                'title' => 'Microbiome and Mental Health Study',
                'description' => 'Investigation of gut-brain axis and microbiome influences on mental health disorders.',
                'funding_agency' => 'National Institute of Mental Health',
                'type' => 'government_grant',
                'amount' => 675000.00,
                'currency' => 'USD',
                'start_date' => '2023-09-01',
                'end_date' => '2026-08-31',
                'status' => 'completed',
                'application_date' => '2023-03-01',
                'award_date' => '2023-06-15',
                'grant_number' => 'NIMH-R01-2023-789',
                'indirect_cost_rate' => 28.0,
                'budget_categories' => json_encode([
                    'personnel' => 405000,
                    'equipment' => 100000,
                    'supplies' => 120000,
                    'travel' => 30000,
                    'other' => 20000
                ]),
            ],
            [
                'title' => 'COVID-19 Variant Surveillance Network',
                'description' => 'Establishment of genomic surveillance network for early detection and characterization of SARS-CoV-2 variants.',
                'funding_agency' => 'Centers for Disease Control',
                'type' => 'government_grant',
                'amount' => 425000.00,
                'currency' => 'USD',
                'start_date' => '2023-05-01',
                'end_date' => '2024-04-30',
                'status' => 'completed',
                'application_date' => '2023-01-20',
                'award_date' => '2023-03-15',
                'grant_number' => 'CDC-CV-2023-334',
                'indirect_cost_rate' => 20.0,
                'budget_categories' => json_encode([
                    'personnel' => 255000,
                    'equipment' => 85000,
                    'supplies' => 60000,
                    'travel' => 15000,
                    'other' => 10000
                ]),
            ],
            [
                'title' => 'Regenerative Medicine Startup Fund',
                'description' => 'Seed funding for startup developing stem cell therapies for spinal cord injuries.',
                'funding_agency' => 'TechStars Bio Accelerator',
                'type' => 'crowdfunding',
                'amount' => 200000.00,
                'currency' => 'USD',
                'start_date' => '2024-03-01',
                'end_date' => '2025-02-28',
                'status' => 'applied',
                'application_date' => '2024-01-15',
                'award_date' => null,
                'grant_number' => 'TS-BIO-2024-99',
                'indirect_cost_rate' => 0.0,
                'budget_categories' => json_encode([
                    'personnel' => 120000,
                    'equipment' => 40000,
                    'supplies' => 30000,
                    'travel' => 5000,
                    'other' => 5000
                ]),
            ],
            [
                'title' => 'Artificial Intelligence in Drug Discovery',
                'description' => 'Development of machine learning models for predicting drug-target interactions and optimizing drug design.',
                'funding_agency' => 'Google Research',
                'type' => 'industry_partnership',
                'amount' => 550000.00,
                'currency' => 'USD',
                'start_date' => '2024-05-01',
                'end_date' => '2026-04-30',
                'status' => 'awarded',
                'application_date' => '2024-01-10',
                'award_date' => '2024-03-20',
                'grant_number' => 'GOOGLE-AI-2024-445',
                'indirect_cost_rate' => 15.0,
                'budget_categories' => json_encode([
                    'personnel' => 330000,
                    'equipment' => 110000,
                    'supplies' => 70000,
                    'travel' => 25000,
                    'other' => 15000
                ]),
            ],
        ];

        foreach ($fundingRecords as $index => $fundingData) {
            $pi = $principalInvestigators->random();

            Funding::create([
                'title' => $fundingData['title'],
                'description' => $fundingData['description'],
                'funding_agency' => $fundingData['funding_agency'],
                'type' => $fundingData['type'],
                'amount' => $fundingData['amount'],
                'currency' => $fundingData['currency'],
                'start_date' => $fundingData['start_date'],
                'end_date' => $fundingData['end_date'],
                'status' => $fundingData['status'],
                'application_date' => $fundingData['application_date'],
                'award_date' => $fundingData['award_date'],
                'principal_investigator_id' => $pi->id,
                'grant_number' => $fundingData['grant_number'],
                'indirect_cost_rate' => $fundingData['indirect_cost_rate'],
                'budget_categories' => $fundingData['budget_categories'],
                'budget_used' => $this->calculateBudgetUsed($fundingData['status'], $fundingData['amount']),
                'progress_percentage' => $this->calculateProgress($fundingData['status']),
                'reporting_requirements' => $this->generateReportingRequirements($fundingData['type']),
                'compliance_status' => 'compliant',
                'next_report_due' => $this->calculateNextReportDate($fundingData['start_date']),
                'keywords' => json_encode($this->generateKeywords($fundingData['title'])),
                'success_metrics' => json_encode([
                    'publications' => rand(2, 15),
                    'patents' => rand(0, 3),
                    'students_trained' => rand(1, 8),
                    'collaborations' => rand(1, 5)
                ]),
                'renewal_eligible' => in_array($fundingData['status'], ['active', 'completed']),
                'equipment_purchased' => json_encode($this->generateEquipmentList()),
                'publications_funded' => rand(0, 10),
                'is_active' => in_array($fundingData['status'], ['active', 'awarded']),
            ]);
        }
    }

    private function calculateBudgetUsed(string $status, float $totalAmount): float
    {
        return match ($status) {
            'active' => $totalAmount * (rand(20, 70) / 100),
            'completed' => $totalAmount * (rand(85, 100) / 100),
            'awarded' => 0.0,
            'under_review' => 0.0,
            'applied' => 0.0,
            'rejected' => 0.0,
            default => 0.0,
        };
    }

    private function calculateProgress(string $status): int
    {
        return match ($status) {
            'active' => rand(25, 75),
            'completed' => 100,
            'awarded' => 5,
            'under_review' => 0,
            'applied' => 0,
            'rejected' => 0,
            default => 0,
        };
    }

    private function generateReportingRequirements(string $type): string
    {
        $requirements = [
            'government_grant' => 'Annual progress reports, financial reports quarterly, final report required.',
            'private_foundation' => 'Semi-annual progress updates, annual financial summary, impact report.',
            'industry_partnership' => 'Quarterly milestone reports, intellectual property disclosures, final deliverables.',
            'internal_funding' => 'Annual progress report, final summary report.',
            'international_grant' => 'Annual reports, compliance certifications, dissemination reports.',
            'crowdfunding' => 'Monthly updates to backers, milestone achievements, final outcome report.',
        ];

        return $requirements[$type] ?? 'Standard reporting requirements apply.';
    }

    private function calculateNextReportDate(string $startDate): string
    {
        $start = new \DateTime($startDate);
        $start->add(new \DateInterval('P3M')); // Add 3 months
        return $start->format('Y-m-d');
    }

    private function generateKeywords(string $title): array
    {
        $keywords = [];
        $title = strtolower($title);

        if (str_contains($title, 'neural') || str_contains($title, 'brain')) {
            $keywords = array_merge($keywords, ['neuroscience', 'brain', 'neural']);
        }
        if (str_contains($title, 'cancer') || str_contains($title, 'tumor')) {
            $keywords = array_merge($keywords, ['cancer', 'oncology', 'tumor']);
        }
        if (str_contains($title, 'gene') || str_contains($title, 'crispr')) {
            $keywords = array_merge($keywords, ['genetics', 'gene editing', 'molecular biology']);
        }
        if (str_contains($title, 'ai') || str_contains($title, 'machine learning')) {
            $keywords = array_merge($keywords, ['artificial intelligence', 'machine learning', 'computational']);
        }
        if (str_contains($title, 'drug') || str_contains($title, 'therapy')) {
            $keywords = array_merge($keywords, ['drug discovery', 'therapeutics', 'pharmacology']);
        }

        return array_unique(array_merge($keywords, ['research', 'innovation', 'biotechnology']));
    }

    private function generateEquipmentList(): array
    {
        $equipmentOptions = [
            'Microscope system',
            'Spectrophotometer',
            'PCR machine',
            'Centrifuge',
            'Incubator',
            'Biosafety cabinet',
            'Chromatography system',
            'Mass spectrometer',
            'DNA sequencer',
            'Cell sorter'
        ];

        $count = rand(0, 4);
        $equipment = [];

        for ($i = 0; $i < $count; $i++) {
            $equipment[] = $equipmentOptions[array_rand($equipmentOptions)];
        }

        return array_unique($equipment);
    }
}