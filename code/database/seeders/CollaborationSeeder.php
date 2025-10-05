<?php

namespace Database\Seeders;

use App\Models\Collaboration;
use App\Models\User;
use Illuminate\Database\Seeder;

class CollaborationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coordinators = User::whereIn('role', ['admin', 'lab_manager', 'researcher'])->get();

        $collaborations = [
            [
                'partner_institution' => 'Harvard Medical School',
                'country' => 'United States',
                'type' => 'research_partnership',
                'description' => 'Joint research collaboration focusing on neurodegenerative diseases, particularly Alzheimer\'s and Parkinson\'s disease. Sharing of research data, student exchanges, and joint publication initiatives.',
                'start_date' => '2023-01-15',
                'end_date' => '2026-01-14',
                'status' => 'active',
                'contact_person' => 'Dr. Elizabeth Warren',
                'contact_email' => 'e.warren@hms.harvard.edu',
                'contact_phone' => '+1-617-432-1000',
                'website' => 'https://hms.harvard.edu/partnerships/sglr',
                'objectives' => 'Advance understanding of neurodegenerative mechanisms through collaborative research, facilitate researcher exchanges, and develop innovative therapeutic approaches.',
                'deliverables' => json_encode([
                    'Joint research publications',
                    'Shared datasets and protocols',
                    'Student exchange program',
                    'Annual collaborative symposium'
                ]),
                'funding_amount' => 1500000.00,
                'currency' => 'USD',
            ],
            [
                'partner_institution' => 'University of Oxford',
                'country' => 'United Kingdom',
                'type' => 'student_exchange',
                'description' => 'Student and researcher exchange program between our institutions, focusing on biotechnology and molecular biology research areas.',
                'start_date' => '2023-09-01',
                'end_date' => '2025-08-31',
                'status' => 'active',
                'contact_person' => 'Prof. James Thompson',
                'contact_email' => 'james.thompson@ox.ac.uk',
                'contact_phone' => '+44-1865-270000',
                'website' => 'https://www.ox.ac.uk/international/sglr-partnership',
                'objectives' => 'Facilitate cultural and academic exchange, enhance research collaboration, and provide international experience for students and staff.',
                'deliverables' => json_encode([
                    '20 student exchanges per year',
                    '5 researcher exchanges per year',
                    'Joint supervision of PhD students',
                    'Collaborative research projects'
                ]),
                'funding_amount' => 250000.00,
                'currency' => 'GBP',
            ],
            [
                'partner_institution' => 'Max Planck Institute for Molecular Biology',
                'country' => 'Germany',
                'type' => 'research_partnership',
                'description' => 'Collaborative research initiative in structural biology and protein crystallography, including access to specialized equipment and expertise.',
                'start_date' => '2024-02-01',
                'end_date' => '2027-01-31',
                'status' => 'active',
                'contact_person' => 'Dr. Klaus Mueller',
                'contact_email' => 'klaus.mueller@mpg.de',
                'contact_phone' => '+49-30-8413-0',
                'website' => 'https://www.mpg.de/collaborations/sglr',
                'objectives' => 'Advance structural biology research through shared expertise, equipment access, and joint research projects.',
                'deliverables' => json_encode([
                    'Shared access to synchrotron facilities',
                    'Joint research publications',
                    'Technology transfer initiatives',
                    'Collaborative grant applications'
                ]),
                'funding_amount' => 800000.00,
                'currency' => 'EUR',
            ],
            [
                'partner_institution' => 'University of Tokyo',
                'country' => 'Japan',
                'type' => 'joint_program',
                'description' => 'Joint degree program in biomedical engineering and collaborative research in regenerative medicine and tissue engineering.',
                'start_date' => '2023-04-01',
                'end_date' => '2028-03-31',
                'status' => 'active',
                'contact_person' => 'Prof. Hiroshi Yamamoto',
                'contact_email' => 'h.yamamoto@u-tokyo.ac.jp',
                'contact_phone' => '+81-3-5841-3000',
                'website' => 'https://www.u-tokyo.ac.jp/en/partnerships/sglr',
                'objectives' => 'Establish joint degree program, conduct collaborative research in regenerative medicine, and promote cultural exchange.',
                'deliverables' => json_encode([
                    'Joint PhD program accreditation',
                    'Shared research facilities',
                    'Annual joint conferences',
                    'Technology commercialization initiatives'
                ]),
                'funding_amount' => 1200000.00,
                'currency' => 'JPY',
            ],
            [
                'partner_institution' => 'Institut Pasteur',
                'country' => 'France',
                'type' => 'research_partnership',
                'description' => 'Collaboration in infectious disease research, vaccine development, and public health initiatives, particularly focusing on emerging pathogens.',
                'start_date' => '2024-01-01',
                'end_date' => '2026-12-31',
                'status' => 'active',
                'contact_person' => 'Dr. Marie Dubois',
                'contact_email' => 'm.dubois@pasteur.fr',
                'contact_phone' => '+33-1-45-68-80-00',
                'website' => 'https://www.pasteur.fr/collaborations/sglr',
                'objectives' => 'Advance infectious disease research, develop novel vaccines, and enhance global health security through collaborative efforts.',
                'deliverables' => json_encode([
                    'Joint vaccine development projects',
                    'Shared pathogen surveillance data',
                    'Collaborative training programs',
                    'Policy recommendations'
                ]),
                'funding_amount' => 950000.00,
                'currency' => 'EUR',
            ],
            [
                'partner_institution' => 'University of Melbourne',
                'country' => 'Australia',
                'type' => 'equipment_sharing',
                'description' => 'Equipment sharing agreement for specialized analytical instruments and collaborative research in environmental biology.',
                'start_date' => '2023-07-01',
                'end_date' => '2025-06-30',
                'status' => 'active',
                'contact_person' => 'Dr. Sarah Mitchell',
                'contact_email' => 's.mitchell@unimelb.edu.au',
                'contact_phone' => '+61-3-8344-4000',
                'website' => 'https://www.unimelb.edu.au/partnerships/sglr',
                'objectives' => 'Share expensive equipment costs, maximize instrument utilization, and facilitate collaborative environmental research.',
                'deliverables' => json_encode([
                    'Remote access to specialized equipment',
                    'Joint training programs',
                    'Collaborative research projects',
                    'Shared maintenance costs'
                ]),
                'funding_amount' => 150000.00,
                'currency' => 'AUD',
            ],
            [
                'partner_institution' => 'Karolinska Institute',
                'country' => 'Sweden',
                'type' => 'research_partnership',
                'description' => 'Collaborative research in cancer biology and immunotherapy, including clinical translation of research findings.',
                'start_date' => '2024-03-01',
                'end_date' => '2027-02-28',
                'status' => 'pending',
                'contact_person' => 'Dr. Erik Lindqvist',
                'contact_email' => 'erik.lindqvist@ki.se',
                'contact_phone' => '+46-8-524-800-00',
                'website' => 'https://ki.se/collaborations/sglr',
                'objectives' => 'Advance cancer research through collaborative projects, facilitate clinical translation, and enhance immunotherapy development.',
                'deliverables' => json_encode([
                    'Joint clinical trials',
                    'Collaborative research publications',
                    'Technology transfer initiatives',
                    'Researcher exchange program'
                ]),
                'funding_amount' => 750000.00,
                'currency' => 'SEK',
            ],
            [
                'partner_institution' => 'National University of Singapore',
                'country' => 'Singapore',
                'type' => 'knowledge_exchange',
                'description' => 'Knowledge exchange program focusing on biotechnology innovation, startup incubation, and technology commercialization.',
                'start_date' => '2023-11-01',
                'end_date' => '2025-10-31',
                'status' => 'active',
                'contact_person' => 'Dr. Li Wei',
                'contact_email' => 'li.wei@nus.edu.sg',
                'contact_phone' => '+65-6516-6666',
                'website' => 'https://www.nus.edu.sg/partnerships/sglr',
                'objectives' => 'Promote innovation in biotechnology, support startup development, and facilitate technology transfer between institutions.',
                'deliverables' => json_encode([
                    'Joint innovation workshops',
                    'Startup incubation programs',
                    'Technology licensing agreements',
                    'Entrepreneurship training'
                ]),
                'funding_amount' => 300000.00,
                'currency' => 'SGD',
            ],
            [
                'partner_institution' => 'ETH Zurich',
                'country' => 'Switzerland',
                'type' => 'funding_partnership',
                'description' => 'Joint funding applications for large-scale research projects in computational biology and systems biology.',
                'start_date' => '2024-01-15',
                'end_date' => '2026-01-14',
                'status' => 'active',
                'contact_person' => 'Prof. Andreas Weber',
                'contact_email' => 'andreas.weber@ethz.ch',
                'contact_phone' => '+41-44-632-11-11',
                'website' => 'https://ethz.ch/partnerships/sglr',
                'objectives' => 'Secure major research funding through collaborative applications and advance computational biology research.',
                'deliverables' => json_encode([
                    'Joint grant applications',
                    'Shared computational resources',
                    'Collaborative software development',
                    'Joint conference organization'
                ]),
                'funding_amount' => 2000000.00,
                'currency' => 'CHF',
            ],
            [
                'partner_institution' => 'University of São Paulo',
                'country' => 'Brazil',
                'type' => 'research_partnership',
                'description' => 'Collaborative research in tropical medicine and biodiversity conservation, with focus on Amazon ecosystem studies.',
                'start_date' => '2023-08-01',
                'end_date' => '2026-07-31',
                'status' => 'active',
                'contact_person' => 'Dr. Carlos Santos',
                'contact_email' => 'c.santos@usp.br',
                'contact_phone' => '+55-11-3091-3000',
                'website' => 'https://www.usp.br/partnerships/sglr',
                'objectives' => 'Study tropical diseases, conserve biodiversity, and develop sustainable research practices in tropical environments.',
                'deliverables' => json_encode([
                    'Field research expeditions',
                    'Species conservation programs',
                    'Disease surveillance networks',
                    'Environmental monitoring systems'
                ]),
                'funding_amount' => 600000.00,
                'currency' => 'BRL',
            ],
            [
                'partner_institution' => 'University of Cape Town',
                'country' => 'South Africa',
                'type' => 'student_exchange',
                'description' => 'Student exchange and research collaboration program focusing on public health and infectious diseases prevalent in Africa.',
                'start_date' => '2024-02-01',
                'end_date' => '2026-01-31',
                'status' => 'pending',
                'contact_person' => 'Dr. Nomsa Mbeki',
                'contact_email' => 'n.mbeki@uct.ac.za',
                'contact_phone' => '+27-21-650-9111',
                'website' => 'https://www.uct.ac.za/partnerships/sglr',
                'objectives' => 'Address African health challenges through collaborative research and provide educational opportunities for students.',
                'deliverables' => json_encode([
                    'Student exchange programs',
                    'Joint health research projects',
                    'Capacity building initiatives',
                    'Community health programs'
                ]),
                'funding_amount' => 400000.00,
                'currency' => 'ZAR',
            ],
            [
                'partner_institution' => 'Chinese Academy of Sciences',
                'country' => 'China',
                'type' => 'research_partnership',
                'description' => 'Large-scale collaboration in genomics and personalized medicine research, including access to population-scale genomic data.',
                'start_date' => '2023-06-01',
                'end_date' => '2028-05-31',
                'status' => 'active',
                'contact_person' => 'Dr. Zhang Wei',
                'contact_email' => 'zhang.wei@cas.cn',
                'contact_phone' => '+86-10-6255-9955',
                'website' => 'https://www.cas.cn/partnerships/sglr',
                'objectives' => 'Advance genomics research, develop personalized medicine approaches, and facilitate large-scale population studies.',
                'deliverables' => json_encode([
                    'Joint genomics databases',
                    'Collaborative research publications',
                    'Technology development projects',
                    'Training and education programs'
                ]),
                'funding_amount' => 3000000.00,
                'currency' => 'CNY',
            ],
        ];

        foreach ($collaborations as $index => $collabData) {
            $coordinator = $coordinators->random();

            Collaboration::create([
                'partner_institution' => $collabData['partner_institution'],
                'country' => $collabData['country'],
                'type' => $collabData['type'],
                'description' => $collabData['description'],
                'start_date' => $collabData['start_date'],
                'end_date' => $collabData['end_date'],
                'status' => $collabData['status'],
                'contact_person' => $collabData['contact_person'],
                'contact_email' => $collabData['contact_email'],
                'contact_phone' => $collabData['contact_phone'],
                'website' => $collabData['website'],
                'objectives' => $collabData['objectives'],
                'deliverables' => $collabData['deliverables'],
                'funding_amount' => $collabData['funding_amount'],
                'currency' => $collabData['currency'],
                'coordinator_id' => $coordinator->id,
                'agreement_signed' => in_array($collabData['status'], ['active', 'completed']),
                'renewal_eligible' => true,
                'priority_level' => $this->getPriorityLevel($collabData['funding_amount']),
                'success_metrics' => json_encode([
                    'publications' => rand(5, 25),
                    'student_exchanges' => rand(2, 15),
                    'joint_grants' => rand(1, 5),
                    'patent_applications' => rand(0, 3)
                ]),
                'challenges' => $this->generateChallenges($collabData['type']),
                'next_review_date' => $this->calculateNextReviewDate($collabData['start_date']),
                'documents_url' => 'https://sglr.com/collaborations/' . $index . '/documents',
                'is_active' => in_array($collabData['status'], ['active', 'pending']),
            ]);
        }
    }

    private function getPriorityLevel(float $fundingAmount): string
    {
        if ($fundingAmount >= 1000000) {
            return 'high';
        } elseif ($fundingAmount >= 500000) {
            return 'medium';
        } else {
            return 'low';
        }
    }

    private function generateChallenges(string $type): string
    {
        $challenges = [
            'research_partnership' => 'Coordination of research timelines, intellectual property agreements, data sharing protocols.',
            'student_exchange' => 'Visa processing delays, cultural adaptation support, academic credit transfers.',
            'joint_program' => 'Curriculum harmonization, accreditation requirements, administrative coordination.',
            'equipment_sharing' => 'Scheduling conflicts, maintenance responsibilities, technical support coordination.',
            'knowledge_exchange' => 'Technology transfer regulations, commercialization timelines, market differences.',
            'funding_partnership' => 'Application coordination, budget allocation, reporting requirements.',
        ];

        return $challenges[$type] ?? 'Standard collaboration challenges including communication, coordination, and administrative requirements.';
    }

    private function calculateNextReviewDate(string $startDate): string
    {
        $start = new \DateTime($startDate);
        $start->add(new \DateInterval('P1Y')); // Add 1 year
        return $start->format('Y-m-d');
    }
}