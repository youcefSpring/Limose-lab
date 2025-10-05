<?php

namespace Database\Seeders;

use App\Models\FundingSource;
use Illuminate\Database\Seeder;

class FundingSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fundingSources = [
            [
                'name' => 'National Science Foundation',
                'type' => 'government',
                'description' => 'US Government agency supporting research and education in science and engineering',
                'contact_email' => 'grants@nsf.gov',
                'contact_phone' => '+1-703-292-5111',
                'website' => 'https://www.nsf.gov',
                'country' => 'United States',
                'status' => 'active',
                'application_deadline' => now()->addMonths(6),
                'min_amount' => 50000,
                'max_amount' => 2000000,
                'currency' => 'USD',
                'eligibility_criteria' => 'Research institutions in the United States',
                'application_process' => 'Online application through FastLane or Research.gov',
            ],
            [
                'name' => 'European Research Council',
                'type' => 'international',
                'description' => 'European Union funding body for excellent frontier research',
                'contact_email' => 'info@erc.europa.eu',
                'contact_phone' => '+32-2-298-1111',
                'website' => 'https://erc.europa.eu',
                'country' => 'European Union',
                'status' => 'active',
                'application_deadline' => now()->addMonths(4),
                'min_amount' => 150000,
                'max_amount' => 3500000,
                'currency' => 'EUR',
                'eligibility_criteria' => 'European researchers or researchers working in Europe',
                'application_process' => 'Online application through ERC portal',
            ],
            [
                'name' => 'Gates Foundation',
                'type' => 'private',
                'description' => 'Private foundation funding global health and development research',
                'contact_email' => 'info@gatesfoundation.org',
                'contact_phone' => '+1-206-709-3100',
                'website' => 'https://www.gatesfoundation.org',
                'country' => 'United States',
                'status' => 'active',
                'application_deadline' => now()->addMonths(8),
                'min_amount' => 100000,
                'max_amount' => 5000000,
                'currency' => 'USD',
                'eligibility_criteria' => 'Global health and development projects',
                'application_process' => 'Letter of inquiry followed by full proposal',
            ],
            [
                'name' => 'Wellcome Trust',
                'type' => 'private',
                'description' => 'Global charitable foundation dedicated to health research',
                'contact_email' => 'grants@wellcome.org',
                'contact_phone' => '+44-20-7611-8888',
                'website' => 'https://wellcome.org',
                'country' => 'United Kingdom',
                'status' => 'active',
                'application_deadline' => now()->addMonths(5),
                'min_amount' => 75000,
                'max_amount' => 3000000,
                'currency' => 'GBP',
                'eligibility_criteria' => 'Biomedical research worldwide',
                'application_process' => 'Online application through Wellcome portal',
            ],
            [
                'name' => 'CNRS Research Grant',
                'type' => 'government',
                'description' => 'French National Centre for Scientific Research funding',
                'contact_email' => 'grants@cnrs.fr',
                'contact_phone' => '+33-1-44-96-40-00',
                'website' => 'https://www.cnrs.fr',
                'country' => 'France',
                'status' => 'active',
                'application_deadline' => now()->addMonths(3),
                'min_amount' => 25000,
                'max_amount' => 500000,
                'currency' => 'EUR',
                'eligibility_criteria' => 'French research institutions',
                'application_process' => 'CNRS application system',
            ],
            [
                'name' => 'Industry Research Partnership',
                'type' => 'industry',
                'description' => 'Private industry collaboration funding',
                'contact_email' => 'partnerships@techcorp.com',
                'contact_phone' => '+1-555-0123',
                'website' => 'https://techcorp.com/research',
                'country' => 'United States',
                'status' => 'active',
                'application_deadline' => now()->addMonths(2),
                'min_amount' => 30000,
                'max_amount' => 800000,
                'currency' => 'USD',
                'eligibility_criteria' => 'Applied research with commercial potential',
                'application_process' => 'Direct application to industry partner',
            ],
        ];

        foreach ($fundingSources as $source) {
            FundingSource::create($source);
        }
    }
}