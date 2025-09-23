<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Clear existing data
        $this->clearExistingData();

        // Run seeders in order
        $this->call([
            // SystemSettingsSeeder::class, // Model doesn't exist yet
            UserSeeder::class,
            // ResearcherSeeder::class, // Missing first_name field
            // ProjectSeeder::class, // Depends on researchers
            // PublicationSeeder::class, // Might have issues
            // EquipmentSeeder::class, // Might have issues
            // EventSeeder::class, // Might have issues
            // CollaborationSeeder::class, // Might have issues
            // FundingSeeder::class, // Might have issues
            FundingSourceSeeder::class,
            // Relationship seeders (must run after main entities)
            // ProjectResearcherSeeder::class, // Table doesn't exist yet
            // PublicationAuthorSeeder::class, // Table doesn't exist yet
            // ProjectFundingSeeder::class, // Depends on projects
            // EquipmentReservationSeeder::class, // Table doesn't exist yet
            // EventRegistrationSeeder::class, // Table doesn't exist yet
            // CollaborationProjectSeeder::class, // Table doesn't exist yet
            // FundingExpenseSeeder::class, // Table doesn't exist yet
            // NotificationSeeder::class, // Model might not exist
        ]);

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Clear existing data from all tables
     */
    private function clearExistingData(): void
    {
        // Clear pivot tables first (no foreign key constraints to worry about in reverse)
        // DB::table('project_members')->truncate(); // Table may not exist
        // DB::table('publication_authors')->truncate(); // Table may not exist
        // DB::table('collaboration_projects')->truncate(); // Table may not exist

        // Clear dependent tables (if they exist)
        try { DB::table('equipment_reservations')->truncate(); } catch (\Exception $e) {}
        try { DB::table('event_registrations')->truncate(); } catch (\Exception $e) {}
        try { DB::table('funding_expenses')->truncate(); } catch (\Exception $e) {}
        try { DB::table('equipment_maintenance')->truncate(); } catch (\Exception $e) {}
        try { DB::table('project_funding')->truncate(); } catch (\Exception $e) {}
        try { DB::table('notifications')->truncate(); } catch (\Exception $e) {}

        // Clear main tables (if they exist)
        try { DB::table('equipment')->truncate(); } catch (\Exception $e) {}
        try { DB::table('events')->truncate(); } catch (\Exception $e) {}
        try { DB::table('collaborations')->truncate(); } catch (\Exception $e) {}
        try { DB::table('funding')->truncate(); } catch (\Exception $e) {}
        try { DB::table('funding_sources')->truncate(); } catch (\Exception $e) {}
        try { DB::table('publications')->truncate(); } catch (\Exception $e) {}
        try { DB::table('projects')->truncate(); } catch (\Exception $e) {}
        try { DB::table('researchers')->truncate(); } catch (\Exception $e) {}
        try { DB::table('users')->truncate(); } catch (\Exception $e) {}
    }
}
