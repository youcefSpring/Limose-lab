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
                'research_domain' => 'Intelligence Artificielle',
                'department' => 'Laboratoire LIMOSE',
                'position' => 'Professeur - Équipe IA',
                'specialization' => 'Apprentissage Automatique et Réseaux de Neurones',
                'orcid_id' => '0000-0001-2345-6789',
                'education' => 'Doctorat en Intelligence Artificielle, USTHB Alger',
                'experience_years' => 15,
                'current_projects_count' => 4,
                'publications_count' => 52,
            ],
            [
                'research_domain' => 'Génie Logiciel',
                'department' => 'Laboratoire LIMOSE',
                'position' => 'Maître de Conférences - Génie Logiciel',
                'specialization' => 'Applications Distribuées et Architecture Logicielle',
                'orcid_id' => '0000-0002-3456-7890',
                'education' => 'Doctorat en Génie Logiciel, Université de Boumerdes',
                'experience_years' => 12,
                'current_projects_count' => 3,
                'publications_count' => 38,
            ],
            [
                'research_domain' => 'Sécurité Informatique',
                'department' => 'Laboratoire LIMOSE',
                'position' => 'Maître de Conférences - Sécurité Informatique',
                'specialization' => 'Cryptographie et Sécurité des Systèmes',
                'orcid_id' => '0000-0003-4567-8901',
                'education' => 'Doctorat en Sécurité Informatique, École Nationale Supérieure d\'Informatique',
                'experience_years' => 10,
                'current_projects_count' => 3,
                'publications_count' => 29,
            ],
            [
                'research_domain' => 'Réseaux et Télécommunications',
                'department' => 'Laboratoire LIMOSE',
                'position' => 'Maître de Conférences - Réseaux',
                'specialization' => 'Réseaux de Capteurs Sans Fil et IoT',
                'orcid_id' => '0000-0004-5678-9012',
                'education' => 'Doctorat en Réseaux et Télécommunications, Université de Boumerdes',
                'experience_years' => 9,
                'current_projects_count' => 2,
                'publications_count' => 25,
            ],
            [
                'research_domain' => 'Big Data et Systèmes Distribués',
                'department' => 'Laboratoire LIMOSE',
                'position' => 'Maître Assistant - Big Data',
                'specialization' => 'Analyse de Données Massives et Cloud Computing',
                'orcid_id' => '0000-0005-6789-0123',
                'education' => 'Doctorat en Informatique, Université de Boumerdes',
                'experience_years' => 7,
                'current_projects_count' => 2,
                'publications_count' => 18,
            ],
            [
                'research_domain' => 'Vision par Ordinateur',
                'department' => 'Laboratoire LIMOSE',
                'position' => 'Maître Assistant - Vision par Ordinateur',
                'specialization' => 'Traitement d\'Images et Intelligence Artificielle',
                'orcid_id' => '0000-0006-7890-1234',
                'education' => 'Doctorat en Vision par Ordinateur, USTHB Alger',
                'experience_years' => 6,
                'current_projects_count' => 2,
                'publications_count' => 15,
            ],
            [
                'research_domain' => 'Cloud Computing',
                'department' => 'Laboratoire LIMOSE',
                'position' => 'Maître Assistant - Cloud Computing',
                'specialization' => 'Virtualisation et Informatique en Nuage',
                'orcid_id' => '0000-0007-8901-2345',
                'education' => 'Doctorat en Systèmes Distribués, Université de Constantine',
                'experience_years' => 8,
                'current_projects_count' => 3,
                'publications_count' => 22,
            ],
            [
                'research_domain' => 'Traitement Automatique du Langage Naturel',
                'department' => 'Laboratoire LIMOSE',
                'position' => 'Doctorante - NLP',
                'specialization' => 'Linguistique Computationnelle et IA',
                'orcid_id' => '0000-0008-9012-3456',
                'education' => 'Master en Informatique, Université de Boumerdes (En cours de Doctorat)',
                'experience_years' => 3,
                'current_projects_count' => 1,
                'publications_count' => 8,
            ],
            [
                'research_domain' => 'Blockchain et Cryptomonnaies',
                'department' => 'Laboratoire LIMOSE',
                'position' => 'Doctorant - Blockchain',
                'specialization' => 'Technologies Blockchain et Finance Numérique',
                'orcid_id' => '0000-0009-0123-4567',
                'education' => 'Master en Systèmes d\'Information, Université de Boumerdes (En cours de Doctorat)',
                'experience_years' => 4,
                'current_projects_count' => 2,
                'publications_count' => 12,
            ],
            [
                'research_domain' => 'Interaction Homme-Machine',
                'department' => 'Laboratoire LIMOSE',
                'position' => 'Maître Assistant - HCI',
                'specialization' => 'Interface Utilisateur et Expérience Utilisateur',
                'orcid_id' => '0000-0010-1234-5678',
                'education' => 'Doctorat en IHM, École Nationale Supérieure d\'Informatique',
                'experience_years' => 5,
                'current_projects_count' => 2,
                'publications_count' => 14,
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
                    'bio' => 'Chercheur expérimenté spécialisé en ' . $researcherData[$index]['specialization'] . '. Engagé dans l\'avancement des connaissances scientifiques à travers la recherche innovante au sein du Laboratoire LIMOSE.',
                    'website' => 'https://limose.univ-boumerdes.dz/researchers/' . strtolower(str_replace([' ', '.'], ['-', ''], $user->name)),
                    'is_active' => true,
                ]);
            }
        }
    }
}