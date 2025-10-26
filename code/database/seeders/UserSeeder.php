<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user for LIMOSE Lab
        User::create([
            'name' => 'Admin LIMOSE',
            'email' => 'admin@limose.univ-boumerdes.dz',
            'email_verified_at' => now(),
            'password' => Hash::make('LimoseAdmin2024!'),
            'role' => 'admin',
            'status' => 'active',
            'phone' => '+213-24-81-70-00',
            'is_active' => true,
            'department' => 'Laboratoire LIMOSE',
            'position' => 'Administrateur Système',
            'preferred_language' => 'fr',
            'bio' => 'Administrateur système responsable de la gestion du système d\'information du laboratoire LIMOSE.',
        ]);

        // Create lab managers for LIMOSE
        $labManagers = [
            [
                'name' => 'Dr. Amina Benali',
                'email' => 'a.benali@limose.univ-boumerdes.dz',
                'department' => 'Laboratoire LIMOSE',
                'position' => 'Directrice du Laboratoire',
                'bio' => 'Directrice du laboratoire LIMOSE, spécialisée en intelligence artificielle et gestion de la recherche.',
                'preferred_language' => 'fr',
            ],
            [
                'name' => 'Dr. Karim Messoudi',
                'email' => 'k.messoudi@limose.univ-boumerdes.dz',
                'department' => 'Laboratoire LIMOSE',
                'position' => 'Responsable Technique',
                'bio' => 'Responsable technique du laboratoire, expert en infrastructure informatique et coordination des projets.',
                'preferred_language' => 'fr',
            ],
        ];

        foreach ($labManagers as $index => $manager) {
            User::create([
                'name' => $manager['name'],
                'email' => $manager['email'],
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => 'lab_manager',
                'status' => 'active',
                'phone' => '+213-24-81-70-0' . (2 + $index),
                'is_active' => true,
                'department' => $manager['department'],
                'position' => $manager['position'],
                'preferred_language' => $manager['preferred_language'] ?? 'fr',
                'bio' => $manager['bio'],
            ]);
        }

        // Create researchers for LIMOSE Lab
        $researchers = [
            [
                'name' => 'Prof. Mohamed Chaoui',
                'email' => 'm.chaoui@limose.univ-boumerdes.dz',
                'phone' => '+213-24-81-70-10',
                'department' => 'Laboratoire LIMOSE',
                'position' => 'Professeur - Équipe IA',
                'bio' => 'Professeur spécialisé en intelligence artificielle et apprentissage automatique.',
                'preferred_language' => 'fr',
            ],
            [
                'name' => 'Dr. Fatima Zohra Kerbouche',
                'email' => 'fz.kerbouche@limose.univ-boumerdes.dz',
                'phone' => '+213-24-81-70-11',
                'department' => 'Laboratoire LIMOSE',
                'position' => 'Maître de Conférences - Génie Logiciel',
                'bio' => 'Experte en génie logiciel et développement d\'applications distribuées.',
                'preferred_language' => 'fr',
            ],
            [
                'name' => 'Dr. Youcef Challal',
                'email' => 'y.challal@limose.univ-boumerdes.dz',
                'phone' => '+213-24-81-70-12',
                'department' => 'Laboratoire LIMOSE',
                'position' => 'Maître de Conférences - Sécurité Informatique',
                'bio' => 'Spécialiste en sécurité des systèmes d\'information et cryptographie.',
                'preferred_language' => 'fr',
            ],
            [
                'name' => 'Dr. Nabila Labraoui',
                'email' => 'n.labraoui@limose.univ-boumerdes.dz',
                'phone' => '+213-24-81-70-13',
                'department' => 'Laboratoire LIMOSE',
                'position' => 'Maître de Conférences - Réseaux',
                'bio' => 'Experte en réseaux de capteurs sans fil et Internet des objets.',
                'preferred_language' => 'fr',
            ],
            [
                'name' => 'Dr. Abderrazak Dahane',
                'email' => 'a.dahane@limose.univ-boumerdes.dz',
                'phone' => '+213-24-81-70-14',
                'department' => 'Laboratoire LIMOSE',
                'position' => 'Maître Assistant - Big Data',
                'bio' => 'Chercheur en analyse de données massives et systèmes distribués.',
                'preferred_language' => 'fr',
            ],
            [
                'name' => 'Dr. Sarah Haddad',
                'email' => 's.haddad@limose.univ-boumerdes.dz',
                'phone' => '+213-24-81-70-15',
                'department' => 'Laboratoire LIMOSE',
                'position' => 'Maître Assistant - Vision par Ordinateur',
                'bio' => 'Spécialisée en traitement d\'images et vision artificielle.',
                'preferred_language' => 'fr',
            ],
            [
                'name' => 'Dr. Khaled Bouabdallah',
                'email' => 'k.bouabdallah@limose.univ-boumerdes.dz',
                'phone' => '+213-24-81-70-16',
                'department' => 'Laboratoire LIMOSE',
                'position' => 'Maître Assistant - Cloud Computing',
                'bio' => 'Expert en informatique en nuage et virtualisation.',
                'preferred_language' => 'fr',
            ],
            [
                'name' => 'Dr. Aicha Mokhtari',
                'email' => 'a.mokhtari@limose.univ-boumerdes.dz',
                'phone' => '+213-24-81-70-17',
                'department' => 'Laboratoire LIMOSE',
                'position' => 'Doctorante - NLP',
                'bio' => 'Doctorante en traitement automatique du langage naturel et linguistique computationnelle.',
                'preferred_language' => 'ar',
            ],
            [
                'name' => 'Dr. Rachid Seghir',
                'email' => 'r.seghir@limose.univ-boumerdes.dz',
                'phone' => '+213-24-81-70-18',
                'department' => 'Laboratoire LIMOSE',
                'position' => 'Doctorant - Blockchain',
                'bio' => 'Doctorant spécialisé en technologies blockchain et cryptomonnaies.',
                'preferred_language' => 'fr',
            ],
            [
                'name' => 'Dr. Leila Ghomri',
                'email' => 'l.ghomri@limose.univ-boumerdes.dz',
                'phone' => '+213-24-81-70-19',
                'department' => 'Laboratoire LIMOSE',
                'position' => 'Maître Assistant - HCI',
                'bio' => 'Spécialisée en interaction homme-machine et expérience utilisateur.',
                'preferred_language' => 'fr',
            ],
        ];

        foreach ($researchers as $researcher) {
            User::create([
                'name' => $researcher['name'],
                'email' => $researcher['email'],
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => 'researcher',
                'status' => 'active',
                'phone' => $researcher['phone'],
                'is_active' => true,
                'department' => $researcher['department'],
                'position' => $researcher['position'],
                'preferred_language' => $researcher['preferred_language'] ?? 'en',
                'bio' => $researcher['bio'],
            ]);
        }

        // Create external visitors and collaborators
        $visitors = [
            [
                'name' => 'Prof. Jean-Claude Martin',
                'email' => 'jc.martin@sorbonne.fr',
                'phone' => '+33-1-44-27-70-00',
                'bio' => 'Professeur visiteur de l\'Université Sorbonne Paris Nord, expert en systèmes intelligents.',
                'preferred_language' => 'fr',
            ],
            [
                'name' => 'Dr. Hassan Al-Mahmoud',
                'email' => 'h.mahmoud@kaust.edu.sa',
                'phone' => '+966-12-808-0000',
                'bio' => 'Chercheur de l\'Université KAUST, spécialisé en apprentissage profond.',
                'preferred_language' => 'ar',
            ],
            [
                'name' => 'Prof. Maria Gonzalez',
                'email' => 'm.gonzalez@upm.es',
                'phone' => '+34-91-336-30-00',
                'bio' => 'Professeure de l\'Université Polytechnique de Madrid, experte en robotique.',
                'preferred_language' => 'fr',
            ],
            [
                'name' => 'Dr. Ahmed Ben Salem',
                'email' => 'a.bensalem@enit.utm.tn',
                'phone' => '+216-71-874-700',
                'bio' => 'Chercheur de l\'École Nationale d\'Ingénieurs de Tunis, spécialiste en cybersécurité.',
                'preferred_language' => 'fr',
            ],
            [
                'name' => 'Prof. Fatima Ouali',
                'email' => 'f.ouali@um5.ac.ma',
                'phone' => '+212-537-27-17-00',
                'bio' => 'Professeure de l\'Université Mohammed V Rabat, experte en intelligence artificielle.',
                'preferred_language' => 'ar',
            ],
        ];

        foreach ($visitors as $visitor) {
            User::create([
                'name' => $visitor['name'],
                'email' => $visitor['email'],
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => 'visitor',
                'status' => 'active',
                'phone' => $visitor['phone'],
                'is_active' => true,
                'preferred_language' => $visitor['preferred_language'] ?? 'en',
                'bio' => $visitor['bio'],
            ]);
        }
    }
}