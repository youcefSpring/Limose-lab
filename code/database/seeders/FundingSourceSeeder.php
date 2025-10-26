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
                'name_ar' => 'مؤسسة العلوم الوطنية',
                'name_fr' => 'Fondation Nationale des Sciences',
                'name_en' => 'National Science Foundation',
                'type' => 'government',
                'contact_info' => 'Email: grants@nsf.gov, Phone: +1-703-292-5111',
                'website' => 'https://www.nsf.gov',
            ],
            [
                'name_ar' => 'مجلس البحوث الأوروبي',
                'name_fr' => 'Conseil Européen de la Recherche',
                'name_en' => 'European Research Council',
                'type' => 'international',
                'contact_info' => 'Email: info@erc.europa.eu, Phone: +32-2-298-1111',
                'website' => 'https://erc.europa.eu',
            ],
            [
                'name_ar' => 'مؤسسة غيتس',
                'name_fr' => 'Fondation Gates',
                'name_en' => 'Gates Foundation',
                'type' => 'private',
                'contact_info' => 'Email: info@gatesfoundation.org, Phone: +1-206-709-3100',
                'website' => 'https://www.gatesfoundation.org',
            ],
            [
                'name_ar' => 'صندوق ويلكوم',
                'name_fr' => 'Wellcome Trust',
                'name_en' => 'Wellcome Trust',
                'type' => 'private',
                'contact_info' => 'Email: grants@wellcome.org, Phone: +44-20-7611-8888',
                'website' => 'https://wellcome.org',
            ],
            [
                'name_ar' => 'منحة بحوث CNRS',
                'name_fr' => 'Bourse de recherche CNRS',
                'name_en' => 'CNRS Research Grant',
                'type' => 'government',
                'contact_info' => 'Email: grants@cnrs.fr, Phone: +33-1-44-96-40-00',
                'website' => 'https://www.cnrs.fr',
            ],
            [
                'name_ar' => 'شراكة البحوث الصناعية',
                'name_fr' => 'Partenariat de Recherche Industrielle',
                'name_en' => 'Industry Research Partnership',
                'type' => 'other',
                'contact_info' => 'Email: partnerships@techcorp.com, Phone: +1-555-0123',
                'website' => 'https://techcorp.com/research',
            ],
        ];

        foreach ($fundingSources as $source) {
            FundingSource::create($source);
        }
    }
}