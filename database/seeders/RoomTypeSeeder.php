<?php

namespace Database\Seeders;

use App\Models\RoomType;
use Illuminate\Database\Seeder;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roomTypes = [
            [
                'name' => 'bathroom',
                'description' => 'Bathroom facilities including toilets and sinks',
            ],
            [
                'name' => 'office',
                'description' => 'Office space for administrative and research staff',
            ],
            [
                'name' => 'meeting_room',
                'description' => 'Meeting and conference room for discussions and presentations',
            ],
            [
                'name' => 'secretary',
                'description' => 'Secretary office for administrative support',
            ],
        ];

        foreach ($roomTypes as $type) {
            RoomType::create($type);
        }

        $this->command->info('Room types seeded successfully!');
    }
}
