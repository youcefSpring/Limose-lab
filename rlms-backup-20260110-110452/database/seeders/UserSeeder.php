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
        // Admin User
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@rlms.test',
            'password' => Hash::make('password'),
            'status' => 'active',
            'locale' => 'en',
            'email_verified_at' => now(),
            'research_group' => 'Administration',
            'bio' => 'System administrator with full access rights.',
        ]);
        $admin->assignRole('admin');

        // Material Manager
        $materialManager = User::create([
            'name' => 'Material Manager',
            'email' => 'manager@rlms.test',
            'password' => Hash::make('password'),
            'status' => 'active',
            'locale' => 'en',
            'email_verified_at' => now(),
            'research_group' => 'Equipment Management',
            'bio' => 'Responsible for laboratory equipment and material management.',
        ]);
        $materialManager->assignRole('material_manager');

        // Researcher
        $researcher = User::create([
            'name' => 'Dr. Sarah Johnson',
            'email' => 'researcher@rlms.test',
            'password' => Hash::make('password'),
            'status' => 'active',
            'locale' => 'en',
            'email_verified_at' => now(),
            'research_group' => 'Molecular Biology',
            'bio' => 'Senior researcher specializing in molecular biology and genetics.',
            'phone' => '+1234567890',
        ]);
        $researcher->assignRole('researcher');

        // PhD Student
        $phdStudent = User::create([
            'name' => 'Ahmed Hassan',
            'email' => 'phd@rlms.test',
            'password' => Hash::make('password'),
            'status' => 'active',
            'locale' => 'ar',
            'email_verified_at' => now(),
            'research_group' => 'Biochemistry',
            'bio' => 'PhD candidate researching protein structures.',
            'phone' => '+1234567891',
        ]);
        $phdStudent->assignRole('phd_student');

        // Partial Researcher
        $partialResearcher = User::create([
            'name' => 'Marie Dubois',
            'email' => 'partial@rlms.test',
            'password' => Hash::make('password'),
            'status' => 'active',
            'locale' => 'fr',
            'email_verified_at' => now(),
            'research_group' => 'Chemistry',
            'bio' => 'Visiting researcher from partner university.',
        ]);
        $partialResearcher->assignRole('partial_researcher');

        // Technician
        $technician = User::create([
            'name' => 'John Smith',
            'email' => 'technician@rlms.test',
            'password' => Hash::make('password'),
            'status' => 'active',
            'locale' => 'en',
            'email_verified_at' => now(),
            'research_group' => 'Technical Support',
            'bio' => 'Laboratory technician responsible for equipment maintenance.',
            'phone' => '+1234567892',
        ]);
        $technician->assignRole('technician');

        // Guest User
        $guest = User::create([
            'name' => 'Guest User',
            'email' => 'guest@rlms.test',
            'password' => Hash::make('password'),
            'status' => 'active',
            'locale' => 'en',
            'email_verified_at' => now(),
            'research_group' => 'External',
            'bio' => 'Guest user with limited read-only access.',
        ]);
        $guest->assignRole('guest');

        // Pending User (needs approval)
        User::create([
            'name' => 'Pending User',
            'email' => 'pending@rlms.test',
            'password' => Hash::make('password'),
            'status' => 'pending',
            'locale' => 'en',
            'email_verified_at' => now(),
            'research_group' => 'Pending Approval',
            'bio' => 'New user awaiting admin approval.',
        ]);

        // Additional researchers and students for testing
        for ($i = 1; $i <= 5; $i++) {
            $user = User::create([
                'name' => "Researcher $i",
                'email' => "researcher{$i}@rlms.test",
                'password' => Hash::make('password'),
                'status' => 'active',
                'locale' => ['ar', 'fr', 'en'][rand(0, 2)],
                'email_verified_at' => now(),
                'research_group' => ['Biology', 'Chemistry', 'Physics', 'Engineering'][rand(0, 3)],
                'bio' => "Test researcher account {$i}.",
            ]);
            $user->assignRole('researcher');
        }

        for ($i = 1; $i <= 5; $i++) {
            $user = User::create([
                'name' => "PhD Student $i",
                'email' => "phd{$i}@rlms.test",
                'password' => Hash::make('password'),
                'status' => 'active',
                'locale' => ['ar', 'fr', 'en'][rand(0, 2)],
                'email_verified_at' => now(),
                'research_group' => ['Biology', 'Chemistry', 'Physics', 'Engineering'][rand(0, 3)],
                'bio' => "Test PhD student account {$i}.",
            ]);
            $user->assignRole('phd_student');
        }

        $this->command->info('Users seeded successfully!');
        $this->command->info('Test credentials: email@rlms.test / password');
    }
}
