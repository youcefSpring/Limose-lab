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
        \DB::table('model_has_roles')
            ->where('model_id', $researcher->id)
            ->where('role_id', \Spatie\Permission\Models\Role::where('name', 'researcher')->first()->id)
            ->update(['employment_type' => 'fulltime']);

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

        // Fulltime Researcher
        $fulltimeResearcher = User::create([
            'name' => 'Dr. John Researcher',
            'email' => 'fulltime@rlms.test',
            'password' => Hash::make('password'),
            'status' => 'active',
            'locale' => 'en',
            'email_verified_at' => now(),
            'research_group' => 'Advanced Physics',
            'bio' => 'Full-time senior researcher with 10+ years experience in quantum physics.',
            'phone' => '+1234567893',
        ]);
        $fulltimeResearcher->assignRole('researcher');
        \DB::table('model_has_roles')
            ->where('model_id', $fulltimeResearcher->id)
            ->where('role_id', \Spatie\Permission\Models\Role::where('name', 'researcher')->first()->id)
            ->update(['employment_type' => 'fulltime']);

        // Part-time Researcher
        $parttimeResearcher = User::create([
            'name' => 'Dr. Jane Williams',
            'email' => 'parttime@rlms.test',
            'password' => Hash::make('password'),
            'status' => 'active',
            'locale' => 'en',
            'email_verified_at' => now(),
            'research_group' => 'Environmental Science',
            'bio' => 'Part-time researcher focusing on climate studies.',
            'phone' => '+1234567894',
        ]);
        $parttimeResearcher->assignRole('partial_researcher');
        \DB::table('model_has_roles')
            ->where('model_id', $parttimeResearcher->id)
            ->where('role_id', \Spatie\Permission\Models\Role::where('name', 'partial_researcher')->first()->id)
            ->update(['employment_type' => 'parttime']);

        // Technician / Maintenance Worker
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
        \DB::table('model_has_roles')
            ->where('model_id', $technician->id)
            ->where('role_id', \Spatie\Permission\Models\Role::where('name', 'technician')->first()->id)
            ->update(['employment_type' => 'fulltime']);

        // Maintenance Worker (additional)
        $maintenanceWorker = User::create([
            'name' => 'Mike Maintenance',
            'email' => 'maintenance@rlms.test',
            'password' => Hash::make('password'),
            'status' => 'active',
            'locale' => 'en',
            'email_verified_at' => now(),
            'research_group' => 'Maintenance Department',
            'bio' => 'Specialized equipment maintenance and repair specialist.',
            'phone' => '+1234567895',
        ]);
        $maintenanceWorker->assignRole('technician');
        \DB::table('model_has_roles')
            ->where('model_id', $maintenanceWorker->id)
            ->where('role_id', \Spatie\Permission\Models\Role::where('name', 'technician')->first()->id)
            ->update(['employment_type' => 'fulltime', 'additional_info' => 'Certified in HVAC and laboratory equipment maintenance']);

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
