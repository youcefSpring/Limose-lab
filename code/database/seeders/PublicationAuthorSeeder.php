<?php

namespace Database\Seeders;

use App\Models\Publication;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PublicationAuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $publications = Publication::all();
        $researchers = User::where('role', 'researcher')->get();

        foreach ($publications as $publication) {
            // Each publication gets 2-6 authors
            $numAuthors = rand(2, 6);

            // Always include the corresponding author
            $correspondingAuthor = $publication->corresponding_author_id;
            $selectedResearchers = collect([$correspondingAuthor]);

            // Add random researchers excluding the corresponding author
            $availableResearchers = $researchers->where('id', '!=', $correspondingAuthor);
            $additionalAuthors = $availableResearchers->random(min($numAuthors - 1, $availableResearchers->count()));
            $selectedResearchers = $selectedResearchers->merge($additionalAuthors->pluck('id'));

            // Shuffle to randomize order (except first author)
            $shuffledAuthors = $selectedResearchers->shuffle();

            foreach ($shuffledAuthors as $index => $userId) {
                $authorOrder = $index + 1;
                $isCorresponding = $userId == $correspondingAuthor;
                $isFirstAuthor = $authorOrder == 1;
                $isLastAuthor = $authorOrder == $shuffledAuthors->count();

                DB::table('publication_authors')->insert([
                    'publication_id' => $publication->id,
                    'user_id' => $userId,
                    'author_order' => $authorOrder,
                    'is_corresponding' => $isCorresponding,
                    'is_first_author' => $isFirstAuthor,
                    'is_last_author' => $isLastAuthor,
                    'contribution_type' => $this->getContributionType($authorOrder, $shuffledAuthors->count()),
                    'contribution_description' => $this->generateContributionDescription($authorOrder, $shuffledAuthors->count()),
                    'affiliation_at_time' => $this->generateAffiliation(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    private function getContributionType(int $order, int $total): string
    {
        if ($order == 1) {
            return 'primary_research';
        } elseif ($order == $total) {
            return 'supervision';
        } else {
            $types = ['data_analysis', 'methodology', 'writing', 'conceptualization', 'investigation'];
            return $types[array_rand($types)];
        }
    }

    private function generateContributionDescription(int $order, int $total): string
    {
        if ($order == 1) {
            return 'Designed and conducted experiments, analyzed data, wrote the manuscript.';
        } elseif ($order == $total) {
            return 'Supervised the research, provided funding, reviewed and edited the manuscript.';
        } else {
            $contributions = [
                'Contributed to experimental design and data collection.',
                'Performed statistical analysis and data interpretation.',
                'Assisted with methodology development and validation.',
                'Contributed to manuscript writing and revision.',
                'Provided technical expertise and conceptual guidance.',
            ];
            return $contributions[array_rand($contributions)];
        }
    }

    private function generateAffiliation(): string
    {
        $affiliations = [
            'Scientific Research Laboratory Management System',
            'Department of Biological Sciences, SGLR',
            'Department of Chemistry, SGLR',
            'Department of Molecular Biology, SGLR',
            'Department of Bioengineering, SGLR',
            'Center for Advanced Research, SGLR',
        ];

        return $affiliations[array_rand($affiliations)];
    }
}