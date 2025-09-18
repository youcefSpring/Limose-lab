<?php

namespace Database\Seeders;

use App\Models\Researcher;
use App\Models\User;
use Illuminate\Database\Seeder;

class ResearcherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get researcher users
        $researcherUsers = User::where('role', 'researcher')->get();

        $researcherData = [
            [
                'research_domain' => 'Molecular Biology',
                'department' => 'Department of Biological Sciences',
                'position' => 'Senior Research Scientist',
                'specialization' => 'Gene Expression and Regulation',
                'orcid_id' => '0000-0001-1234-5678',
                'education' => 'Ph.D. in Molecular Biology, Harvard University',
                'experience_years' => 12,
                'current_projects_count' => 3,
                'publications_count' => 45,
            ],
            [
                'research_domain' => 'Biochemistry',
                'department' => 'Department of Chemistry',
                'position' => 'Principal Investigator',
                'specialization' => 'Protein Structure and Function',
                'orcid_id' => '0000-0002-2345-6789',
                'education' => 'Ph.D. in Biochemistry, MIT',
                'experience_years' => 15,
                'current_projects_count' => 4,
                'publications_count' => 67,
            ],
            [
                'research_domain' => 'Genetics',
                'department' => 'Department of Biological Sciences',
                'position' => 'Research Scientist',
                'specialization' => 'Population Genetics',
                'orcid_id' => '0000-0003-3456-7890',
                'education' => 'Ph.D. in Genetics, Stanford University',
                'experience_years' => 8,
                'current_projects_count' => 2,
                'publications_count' => 23,
            ],
            [
                'research_domain' => 'Microbiology',
                'department' => 'Department of Microbiology',
                'position' => 'Assistant Professor',
                'specialization' => 'Bacterial Pathogenesis',
                'orcid_id' => '0000-0004-4567-8901',
                'education' => 'Ph.D. in Microbiology, University of California, Berkeley',
                'experience_years' => 6,
                'current_projects_count' => 2,
                'publications_count' => 18,
            ],
            [
                'research_domain' => 'Immunology',
                'department' => 'Department of Immunology',
                'position' => 'Senior Research Scientist',
                'specialization' => 'Adaptive Immunity',
                'orcid_id' => '0000-0005-5678-9012',
                'education' => 'Ph.D. in Immunology, Johns Hopkins University',
                'experience_years' => 10,
                'current_projects_count' => 3,
                'publications_count' => 34,
            ],
            [
                'research_domain' => 'Neuroscience',
                'department' => 'Department of Neuroscience',
                'position' => 'Research Scientist',
                'specialization' => 'Cognitive Neuroscience',
                'orcid_id' => '0000-0006-6789-0123',
                'education' => 'Ph.D. in Neuroscience, University of Cambridge',
                'experience_years' => 9,
                'current_projects_count' => 2,
                'publications_count' => 28,
            ],
            [
                'research_domain' => 'Cell Biology',
                'department' => 'Department of Cell Biology',
                'position' => 'Principal Investigator',
                'specialization' => 'Cell Signaling',
                'orcid_id' => '0000-0007-7890-1234',
                'education' => 'Ph.D. in Cell Biology, Yale University',
                'experience_years' => 14,
                'current_projects_count' => 4,
                'publications_count' => 52,
            ],
            [
                'research_domain' => 'Bioinformatics',
                'department' => 'Department of Computer Science',
                'position' => 'Computational Biologist',
                'specialization' => 'Genomics and Data Analysis',
                'orcid_id' => '0000-0008-8901-2345',
                'education' => 'Ph.D. in Bioinformatics, University of Toronto',
                'experience_years' => 7,
                'current_projects_count' => 3,
                'publications_count' => 21,
            ],
            [
                'research_domain' => 'Pharmacology',
                'department' => 'Department of Pharmacology',
                'position' => 'Research Scientist',
                'specialization' => 'Drug Development',
                'orcid_id' => '0000-0009-9012-3456',
                'education' => 'Ph.D. in Pharmacology, University of Oxford',
                'experience_years' => 11,
                'current_projects_count' => 3,
                'publications_count' => 39,
            ],
            [
                'research_domain' => 'Environmental Science',
                'department' => 'Department of Environmental Science',
                'position' => 'Associate Professor',
                'specialization' => 'Climate Change Biology',
                'orcid_id' => '0000-0010-0123-4567',
                'education' => 'Ph.D. in Environmental Science, ETH Zurich',
                'experience_years' => 13,
                'current_projects_count' => 3,
                'publications_count' => 41,
            ],
        ];

        foreach ($researcherUsers as $index => $user) {
            if (isset($researcherData[$index])) {
                Researcher::create([
                    'user_id' => $user->id,
                    'research_domain' => $researcherData[$index]['research_domain'],
                    'department' => $researcherData[$index]['department'],
                    'position' => $researcherData[$index]['position'],
                    'specialization' => $researcherData[$index]['specialization'],
                    'orcid_id' => $researcherData[$index]['orcid_id'],
                    'education' => $researcherData[$index]['education'],
                    'experience_years' => $researcherData[$index]['experience_years'],
                    'current_projects_count' => $researcherData[$index]['current_projects_count'],
                    'publications_count' => $researcherData[$index]['publications_count'],
                    'bio' => 'Experienced researcher with expertise in ' . $researcherData[$index]['specialization'] . '. Committed to advancing scientific knowledge through innovative research.',
                    'website' => 'https://research.sglr.com/' . strtolower(str_replace(' ', '-', $user->name)),
                    'is_active' => true,
                ]);
            }
        }
    }
}