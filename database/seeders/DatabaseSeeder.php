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
            UserSeeder::class,
            ResearcherSeeder::class,
            ProjectSeeder::class,
            PublicationSeeder::class,
            EquipmentSeeder::class,
            EventSeeder::class,
            CollaborationSeeder::class,
            FundingSeeder::class,
            // Relationship seeders (must run after main entities)
            ProjectResearcherSeeder::class,
            PublicationAuthorSeeder::class,
            EquipmentReservationSeeder::class,
            EventRegistrationSeeder::class,
            CollaborationProjectSeeder::class,
            FundingExpenseSeeder::class,
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
        DB::table('project_researcher')->truncate();
        DB::table('publication_authors')->truncate();
        DB::table('collaboration_projects')->truncate();

        // Clear dependent tables
        DB::table('equipment_reservations')->truncate();
        DB::table('event_registrations')->truncate();
        DB::table('funding_expenses')->truncate();
        DB::table('equipment_maintenance')->truncate();

        // Clear main tables
        DB::table('equipment')->truncate();
        DB::table('events')->truncate();
        DB::table('collaborations')->truncate();
        DB::table('funding')->truncate();
        DB::table('publications')->truncate();
        DB::table('projects')->truncate();
        DB::table('researchers')->truncate();
        DB::table('users')->truncate();
    }
}
