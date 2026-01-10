<?php

namespace Database\Seeders;

use App\Models\Publication;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PublicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get researchers and PhD students
        $researcher1 = User::role('researcher')->first();
        $researcher2 = User::role('researcher')->skip(1)->first();
        $phdStudent = User::role('phd_student')->first();

        if (!$researcher1) {
            $this->command->error('No researcher found. Please run UserSeeder first.');
            return;
        }

        if (!$phdStudent) {
            $this->command->error('No PhD student found. Please run UserSeeder first.');
            return;
        }

        // If we don't have a second researcher, use the first one
        if (!$researcher2) {
            $researcher2 = $researcher1;
        }

        $publications = [
            // Researcher 1 - Dr. Sarah Johnson (Molecular Biology)
            [
                'user_id' => $researcher1->id,
                'title' => 'Advanced Molecular Techniques in Cellular Biology',
                'title_fr' => 'Techniques moléculaires avancées en biologie cellulaire',
                'title_ar' => 'التقنيات الجزيئية المتقدمة في علم الأحياء الخلوية',
                'abstract' => 'This study explores novel molecular techniques for understanding cellular mechanisms and their applications in modern biology.',
                'abstract_fr' => 'Cette étude explore de nouvelles techniques moléculaires pour comprendre les mécanismes cellulaires et leurs applications en biologie moderne.',
                'abstract_ar' => 'تستكشف هذه الدراسة تقنيات جزيئية جديدة لفهم الآليات الخلوية وتطبيقاتها في علم الأحياء الحديث.',
                'authors' => 'Sarah Johnson, John Smith, Maria Garcia',
                'journal' => 'Journal of Molecular Biology',
                'year' => 2025,
                'volume' => '45',
                'issue' => '3',
                'pages' => '234-256',
                'doi' => '10.1234/jmb.2025.123',
                'type' => 'journal',
                'status' => 'published',
                'publication_date' => '2025-03-15',
                'keywords' => 'molecular biology, cellular mechanisms, genetics',
                'research_areas' => 'Molecular Biology, Genetics',
                'is_featured' => true,
                'is_open_access' => true,
                'citations_count' => 15,
                'visibility' => 'public',
            ],
            [
                'user_id' => $researcher1->id,
                'title' => 'CRISPR Applications in Gene Therapy',
                'title_fr' => 'Applications CRISPR en thérapie génique',
                'title_ar' => 'تطبيقات كريسبر في العلاج الجيني',
                'abstract' => 'A comprehensive review of CRISPR-Cas9 applications in modern gene therapy and their potential for treating genetic diseases.',
                'authors' => 'Sarah Johnson, Ahmed Hassan',
                'journal' => 'Nature Genetics',
                'year' => 2024,
                'volume' => '56',
                'issue' => '8',
                'pages' => '1123-1145',
                'doi' => '10.1038/ng.2024.456',
                'type' => 'journal',
                'status' => 'published',
                'publication_date' => '2024-08-20',
                'keywords' => 'CRISPR, gene therapy, genetics, molecular biology',
                'research_areas' => 'Molecular Biology, Genetics, Medical Research',
                'is_featured' => false,
                'is_open_access' => true,
                'citations_count' => 42,
                'visibility' => 'public',
            ],

            // Researcher 2 - Dr. John Researcher (Advanced Physics)
            [
                'user_id' => $researcher2->id,
                'title' => 'Quantum Entanglement in Superconducting Circuits',
                'title_fr' => 'Intrication quantique dans les circuits supraconducteurs',
                'title_ar' => 'التشابك الكمومي في الدوائر فائقة التوصيل',
                'abstract' => 'Investigation of quantum entanglement phenomena in superconducting quantum circuits and their applications in quantum computing.',
                'authors' => 'John Researcher, Marie Curie, Albert Einstein',
                'journal' => 'Physical Review Letters',
                'year' => 2025,
                'volume' => '130',
                'issue' => '12',
                'pages' => '120501-120512',
                'doi' => '10.1103/PhysRevLett.130.120501',
                'type' => 'journal',
                'status' => 'published',
                'publication_date' => '2025-01-05',
                'keywords' => 'quantum physics, entanglement, superconductivity, quantum computing',
                'research_areas' => 'Quantum Physics, Condensed Matter Physics',
                'is_featured' => true,
                'is_open_access' => false,
                'citations_count' => 8,
                'visibility' => 'public',
            ],
            [
                'user_id' => $researcher2->id,
                'title' => 'Advances in Quantum Computing Algorithms',
                'abstract' => 'Novel algorithms for quantum computers demonstrating exponential speedup over classical approaches.',
                'authors' => 'John Researcher',
                'conference' => 'International Conference on Quantum Computing',
                'year' => 2024,
                'pages' => '45-67',
                'doi' => '10.1109/ICQC.2024.789',
                'type' => 'conference',
                'status' => 'published',
                'publication_date' => '2024-11-10',
                'keywords' => 'quantum algorithms, quantum computing, computational complexity',
                'research_areas' => 'Quantum Computing, Computer Science',
                'is_featured' => false,
                'is_open_access' => true,
                'citations_count' => 23,
                'visibility' => 'public',
            ],

            // PhD Student - Ahmed Hassan (Biochemistry)
            [
                'user_id' => $phdStudent->id,
                'title' => 'Protein Structure Analysis Using Machine Learning',
                'title_fr' => 'Analyse de la structure des protéines par apprentissage automatique',
                'title_ar' => 'تحليل بنية البروتين باستخدام التعلم الآلي',
                'abstract' => 'Application of deep learning techniques for predicting protein structures and understanding protein folding mechanisms.',
                'authors' => 'Ahmed Hassan, Sarah Johnson',
                'journal' => 'Bioinformatics',
                'year' => 2024,
                'volume' => '40',
                'issue' => '15',
                'pages' => '2890-2905',
                'doi' => '10.1093/bioinformatics/btaa890',
                'type' => 'journal',
                'status' => 'published',
                'publication_date' => '2024-12-01',
                'keywords' => 'protein structure, machine learning, bioinformatics, deep learning',
                'research_areas' => 'Biochemistry, Bioinformatics, Artificial Intelligence',
                'is_featured' => true,
                'is_open_access' => true,
                'citations_count' => 12,
                'visibility' => 'public',
            ],
            [
                'user_id' => $phdStudent->id,
                'title' => 'Novel Approaches to Enzyme Catalysis',
                'abstract' => 'Investigation of enzyme mechanisms and development of novel catalytic approaches for biochemical reactions.',
                'authors' => 'Ahmed Hassan',
                'type' => 'thesis',
                'status' => 'in_press',
                'year' => 2025,
                'keywords' => 'enzymes, catalysis, biochemistry',
                'research_areas' => 'Biochemistry, Enzyme Engineering',
                'is_featured' => false,
                'is_open_access' => false,
                'citations_count' => 0,
                'visibility' => 'pending',
            ],

            // Additional publications
            [
                'user_id' => $researcher1->id,
                'title' => 'Epigenetic Modifications in Cancer Development',
                'abstract' => 'Study of epigenetic changes that contribute to cancer development and potential therapeutic targets.',
                'authors' => 'Sarah Johnson, Jane Williams, Michael Brown',
                'journal' => 'Cancer Research',
                'year' => 2024,
                'volume' => '84',
                'issue' => '6',
                'pages' => '1456-1478',
                'doi' => '10.1158/0008-5472.CAN-23-3456',
                'type' => 'journal',
                'status' => 'published',
                'publication_date' => '2024-06-15',
                'keywords' => 'epigenetics, cancer, oncology, molecular biology',
                'research_areas' => 'Molecular Biology, Cancer Research',
                'is_featured' => false,
                'is_open_access' => true,
                'citations_count' => 28,
                'visibility' => 'public',
            ],
            [
                'user_id' => $researcher2->id,
                'title' => 'Topological Quantum Materials',
                'abstract' => 'Exploration of topological properties in quantum materials and their applications in next-generation electronics.',
                'authors' => 'John Researcher, Lisa Anderson',
                'journal' => 'Nature Materials',
                'year' => 2024,
                'volume' => '23',
                'issue' => '4',
                'pages' => '567-589',
                'doi' => '10.1038/nmat.2024.234',
                'type' => 'journal',
                'status' => 'published',
                'publication_date' => '2024-04-10',
                'keywords' => 'topology, quantum materials, condensed matter physics',
                'research_areas' => 'Condensed Matter Physics, Materials Science',
                'is_featured' => false,
                'is_open_access' => false,
                'citations_count' => 35,
                'visibility' => 'public',
            ],
        ];

        foreach ($publications as $publication) {
            Publication::create($publication);
        }

        $this->command->info('Publications seeded successfully!');
        $this->command->info('Total publications: ' . count($publications));
    }
}
