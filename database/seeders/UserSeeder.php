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
        // Create admin user
        User::create([
            'name' => 'System Administrator',
            'email' => 'admin@sglr.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
            'phone' => '+1-555-0001',
            'is_active' => true,
            'department' => 'Information Technology',
            'position' => 'System Administrator',
            'preferred_language' => 'en',
            'bio' => 'System administrator responsible for managing the laboratory information system.',
        ]);

        // Create lab managers
        $labManagers = [
            [
                'name' => 'Dr. Sarah Johnson',
                'email' => 'sarah.johnson@sglr.com',
                'department' => 'Laboratory Operations',
                'position' => 'Senior Lab Manager',
                'bio' => 'Experienced laboratory manager with expertise in equipment management and safety protocols.',
            ],
            [
                'name' => 'Dr. Michael Chen',
                'email' => 'michael.chen@sglr.com',
                'department' => 'Research Coordination',
                'position' => 'Research Lab Manager',
                'bio' => 'Research-focused lab manager specializing in project coordination and resource allocation.',
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
                'phone' => '+1-555-000' . (2 + $index),
                'is_active' => true,
                'department' => $manager['department'],
                'position' => $manager['position'],
                'preferred_language' => 'en',
                'bio' => $manager['bio'],
            ]);
        }

        // Create researchers
        $researchers = [
            [
                'name' => 'Dr. Emily Rodriguez',
                'email' => 'emily.rodriguez@sglr.com',
                'phone' => '+1-555-0010',
                'department' => 'Department of Biological Sciences',
                'position' => 'Senior Research Scientist',
                'bio' => 'Molecular biologist specializing in gene expression and regulation.',
            ],
            [
                'name' => 'Dr. David Kim',
                'email' => 'david.kim@sglr.com',
                'phone' => '+1-555-0011',
                'department' => 'Department of Chemistry',
                'position' => 'Principal Investigator',
                'bio' => 'Biochemist focused on protein structure and function studies.',
            ],
            [
                'name' => 'Dr. Lisa Thompson',
                'email' => 'lisa.thompson@sglr.com',
                'phone' => '+1-555-0012',
                'department' => 'Department of Biological Sciences',
                'position' => 'Research Scientist',
                'bio' => 'Geneticist with expertise in population genetics and genomics.',
            ],
            [
                'name' => 'Dr. James Wilson',
                'email' => 'james.wilson@sglr.com',
                'phone' => '+1-555-0013',
                'department' => 'Department of Microbiology',
                'position' => 'Assistant Professor',
                'bio' => 'Microbiologist studying bacterial pathogenesis and antimicrobial resistance.',
            ],
            [
                'name' => 'Dr. Maria Garcia',
                'email' => 'maria.garcia@sglr.com',
                'phone' => '+1-555-0014',
                'department' => 'Department of Immunology',
                'position' => 'Senior Research Scientist',
                'bio' => 'Immunologist researching adaptive immunity and vaccine development.',
            ],
            [
                'name' => 'Dr. Robert Brown',
                'email' => 'robert.brown@sglr.com',
                'phone' => '+1-555-0015',
                'department' => 'Department of Neuroscience',
                'position' => 'Research Scientist',
                'bio' => 'Neuroscientist investigating cognitive functions and neural networks.',
            ],
            [
                'name' => 'Dr. Jennifer Lee',
                'email' => 'jennifer.lee@sglr.com',
                'phone' => '+1-555-0016',
                'department' => 'Department of Cell Biology',
                'position' => 'Principal Investigator',
                'bio' => 'Cell biologist studying cell signaling and molecular mechanisms.',
            ],
            [
                'name' => 'Dr. Ahmed Hassan',
                'email' => 'ahmed.hassan@sglr.com',
                'phone' => '+1-555-0017',
                'department' => 'Department of Computer Science',
                'position' => 'Computational Biologist',
                'bio' => 'Bioinformatician specializing in genomics and data analysis.',
                'preferred_language' => 'ar',
            ],
            [
                'name' => 'Dr. Sophie Martin',
                'email' => 'sophie.martin@sglr.com',
                'phone' => '+1-555-0018',
                'department' => 'Department of Pharmacology',
                'position' => 'Research Scientist',
                'bio' => 'Pharmacologist focused on drug development and therapeutic research.',
                'preferred_language' => 'fr',
            ],
            [
                'name' => 'Dr. Carlos Silva',
                'email' => 'carlos.silva@sglr.com',
                'phone' => '+1-555-0019',
                'department' => 'Department of Environmental Science',
                'position' => 'Associate Professor',
                'bio' => 'Environmental scientist studying climate change and ecosystem dynamics.',
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

        // Create visitors
        $visitors = [
            [
                'name' => 'John Smith',
                'email' => 'john.smith@university.edu',
                'phone' => '+1-555-0020',
                'bio' => 'Visiting researcher from State University studying collaborative research opportunities.',
            ],
            [
                'name' => 'Anna Kowalski',
                'email' => 'anna.kowalski@university.pl',
                'phone' => '+48-123-456-789',
                'bio' => 'International visitor from Warsaw University of Technology.',
                'preferred_language' => 'en',
            ],
            [
                'name' => 'Hiroshi Tanaka',
                'email' => 'hiroshi.tanaka@university.jp',
                'phone' => '+81-3-1234-5678',
                'bio' => 'Researcher from Tokyo Institute of Technology exploring research partnerships.',
            ],
            [
                'name' => 'Elena Petrov',
                'email' => 'elena.petrov@university.ru',
                'phone' => '+7-495-123-4567',
                'bio' => 'Visiting scientist from Moscow State University.',
            ],
            [
                'name' => 'Pierre Dubois',
                'email' => 'pierre.dubois@university.fr',
                'phone' => '+33-1-23-45-67-89',
                'bio' => 'Exchange researcher from Sorbonne University.',
                'preferred_language' => 'fr',
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