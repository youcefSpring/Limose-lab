<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'title' => 'Annual Research Symposium',
                'description' => 'Yearly symposium showcasing research achievements',
                'event_type' => 'public',
                'event_date' => Carbon::now()->addDays(30),
                'event_time' => '09:00:00',
                'location' => 'Main Auditorium',
                'capacity' => 150,
                'target_roles' => json_encode(['admin', 'researcher', 'phd_student']),
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Safety Training Workshop',
                'description' => 'Mandatory laboratory safety training',
                'event_type' => 'public',
                'event_date' => Carbon::now()->addDays(10),
                'event_time' => '14:00:00',
                'location' => 'Training Room 201',
                'capacity' => 30,
                'target_roles' => json_encode(['researcher', 'phd_student', 'technician']),
                'created_by' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($events as $event) {
            $eventId = DB::table('events')->insertGetId($event);

            // Add some attendees
            DB::table('event_attendees')->insert([
                ['event_id' => $eventId, 'user_id' => 3, 'status' => 'confirmed', 'registered_at' => now()],
                ['event_id' => $eventId, 'user_id' => 4, 'status' => 'confirmed', 'registered_at' => now()],
            ]);
        }

        $this->command->info('Events seeded successfully!');
    }
}
