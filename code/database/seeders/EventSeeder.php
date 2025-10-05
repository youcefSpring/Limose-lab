<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organizers = User::whereIn('role', ['admin', 'lab_manager', 'researcher'])->get();

        $events = [
            [
                'title' => 'Annual SGLR Research Symposium 2024',
                'description' => 'Join us for our flagship annual symposium featuring cutting-edge research presentations, poster sessions, and networking opportunities. This year\'s theme focuses on "Innovation in Life Sciences Research".',
                'type' => 'conference',
                'start_date' => '2024-11-15 09:00:00',
                'end_date' => '2024-11-17 17:00:00',
                'location' => 'SGLR Main Auditorium',
                'is_virtual' => false,
                'status' => 'registration_open',
                'max_participants' => 250,
                'registration_deadline' => '2024-11-01',
                'agenda' => json_encode([
                    [
                        'time' => '09:00-10:00',
                        'title' => 'Registration and Welcome Coffee',
                        'speaker' => 'N/A'
                    ],
                    [
                        'time' => '10:00-11:00',
                        'title' => 'Keynote: Future of Precision Medicine',
                        'speaker' => 'Dr. Sarah Johnson'
                    ],
                    [
                        'time' => '11:15-12:30',
                        'title' => 'Session 1: Molecular Biology Advances',
                        'speaker' => 'Various'
                    ]
                ]),
                'requirements' => 'Valid ID required for entry. Lunch will be provided.',
                'contact_info' => 'events@sglr.com',
                'registration_fee' => 150.00,
                'materials_url' => 'https://sglr.com/symposium2024/materials',
            ],
            [
                'title' => 'CRISPR-Cas9 Workshop: Advanced Gene Editing Techniques',
                'description' => 'Hands-on workshop covering advanced CRISPR-Cas9 techniques including multiplexing, base editing, and prime editing. Suitable for researchers with basic CRISPR experience.',
                'type' => 'workshop',
                'start_date' => '2024-10-22 10:00:00',
                'end_date' => '2024-10-24 16:00:00',
                'location' => 'Lab Complex Building A',
                'is_virtual' => false,
                'status' => 'registration_open',
                'max_participants' => 20,
                'registration_deadline' => '2024-10-15',
                'agenda' => json_encode([
                    [
                        'time' => 'Day 1',
                        'title' => 'Theory and Design Principles',
                        'speaker' => 'Dr. Emily Rodriguez'
                    ],
                    [
                        'time' => 'Day 2',
                        'title' => 'Hands-on Lab Session',
                        'speaker' => 'Dr. David Kim'
                    ],
                    [
                        'time' => 'Day 3',
                        'title' => 'Advanced Applications',
                        'speaker' => 'Dr. Lisa Thompson'
                    ]
                ]),
                'requirements' => 'Basic molecular biology experience required. Lab coat and safety glasses provided.',
                'contact_info' => 'workshops@sglr.com',
                'registration_fee' => 450.00,
                'materials_url' => 'https://sglr.com/crispr-workshop/protocols',
            ],
            [
                'title' => 'Bioinformatics Seminar: Machine Learning in Drug Discovery',
                'description' => 'Expert seminar on the application of machine learning algorithms in pharmaceutical research and drug discovery pipelines.',
                'type' => 'seminar',
                'start_date' => '2024-10-08 14:00:00',
                'end_date' => '2024-10-08 16:00:00',
                'location' => 'Virtual Event',
                'is_virtual' => true,
                'status' => 'registration_open',
                'max_participants' => 100,
                'registration_deadline' => '2024-10-07',
                'agenda' => json_encode([
                    [
                        'time' => '14:00-14:30',
                        'title' => 'Introduction to ML in Drug Discovery',
                        'speaker' => 'Dr. Ahmed Hassan'
                    ],
                    [
                        'time' => '14:30-15:15',
                        'title' => 'Case Studies and Applications',
                        'speaker' => 'Dr. Sophie Martin'
                    ],
                    [
                        'time' => '15:15-16:00',
                        'title' => 'Q&A and Discussion',
                        'speaker' => 'All speakers'
                    ]
                ]),
                'requirements' => 'Zoom link will be provided after registration.',
                'contact_info' => 'seminars@sglr.com',
                'registration_fee' => 0.00,
                'meeting_url' => 'https://zoom.us/j/123456789',
            ],
            [
                'title' => 'Laboratory Safety Training - Level 1',
                'description' => 'Mandatory safety training for all new laboratory personnel. Covers chemical safety, biological hazards, equipment operation, and emergency procedures.',
                'type' => 'training',
                'start_date' => '2024-10-14 09:00:00',
                'end_date' => '2024-10-14 17:00:00',
                'location' => 'Training Room 102',
                'is_virtual' => false,
                'status' => 'registration_open',
                'max_participants' => 25,
                'registration_deadline' => '2024-10-12',
                'agenda' => json_encode([
                    [
                        'time' => '09:00-10:30',
                        'title' => 'Chemical Safety Protocols',
                        'speaker' => 'Safety Officer'
                    ],
                    [
                        'time' => '11:00-12:30',
                        'title' => 'Biological Safety Guidelines',
                        'speaker' => 'Safety Officer'
                    ],
                    [
                        'time' => '13:30-15:00',
                        'title' => 'Equipment Safety',
                        'speaker' => 'Technical Staff'
                    ],
                    [
                        'time' => '15:30-17:00',
                        'title' => 'Emergency Procedures and Assessment',
                        'speaker' => 'Safety Officer'
                    ]
                ]),
                'requirements' => 'Mandatory for all lab personnel. Certificate provided upon completion.',
                'contact_info' => 'safety@sglr.com',
                'registration_fee' => 0.00,
                'certification' => true,
            ],
            [
                'title' => 'International Collaboration Meeting - EU Partners',
                'description' => 'Quarterly meeting with European research partners to discuss ongoing collaborations, share progress updates, and plan future joint initiatives.',
                'type' => 'meeting',
                'start_date' => '2024-10-30 15:00:00',
                'end_date' => '2024-10-30 17:00:00',
                'location' => 'Conference Room A / Virtual Hybrid',
                'is_virtual' => true,
                'status' => 'registration_closed',
                'max_participants' => 50,
                'registration_deadline' => '2024-10-25',
                'agenda' => json_encode([
                    [
                        'time' => '15:00-15:30',
                        'title' => 'Welcome and Updates',
                        'speaker' => 'Dr. Michael Chen'
                    ],
                    [
                        'time' => '15:30-16:15',
                        'title' => 'Project Progress Reports',
                        'speaker' => 'Various PIs'
                    ],
                    [
                        'time' => '16:15-17:00',
                        'title' => 'Future Planning and Next Steps',
                        'speaker' => 'All participants'
                    ]
                ]),
                'requirements' => 'Invitation only. Translation services available.',
                'contact_info' => 'international@sglr.com',
                'registration_fee' => 0.00,
                'meeting_url' => 'https://teams.microsoft.com/l/meetup-join/...',
            ],
            [
                'title' => 'Protein Crystallography Workshop',
                'description' => 'Intensive workshop on protein crystallization techniques, X-ray data collection, and structure determination methods.',
                'type' => 'workshop',
                'start_date' => '2024-11-05 09:00:00',
                'end_date' => '2024-11-07 17:00:00',
                'location' => 'Structural Biology Lab',
                'is_virtual' => false,
                'status' => 'registration_open',
                'max_participants' => 15,
                'registration_deadline' => '2024-10-28',
                'agenda' => json_encode([
                    [
                        'time' => 'Day 1',
                        'title' => 'Crystallization Methods',
                        'speaker' => 'Dr. James Wilson'
                    ],
                    [
                        'time' => 'Day 2',
                        'title' => 'Data Collection Techniques',
                        'speaker' => 'Dr. Maria Garcia'
                    ],
                    [
                        'time' => 'Day 3',
                        'title' => 'Structure Determination',
                        'speaker' => 'Dr. Robert Brown'
                    ]
                ]),
                'requirements' => 'Prior protein purification experience preferred. All materials provided.',
                'contact_info' => 'structbio@sglr.com',
                'registration_fee' => 350.00,
                'materials_url' => 'https://sglr.com/crystallography/materials',
            ],
            [
                'title' => 'Young Researchers Forum 2024',
                'description' => 'Annual forum for graduate students and postdocs to present their research, network with peers, and receive mentorship from senior researchers.',
                'type' => 'conference',
                'start_date' => '2024-12-03 13:00:00',
                'end_date' => '2024-12-04 18:00:00',
                'location' => 'Student Center Auditorium',
                'is_virtual' => false,
                'status' => 'published',
                'max_participants' => 120,
                'registration_deadline' => '2024-11-20',
                'agenda' => json_encode([
                    [
                        'time' => 'Day 1 Afternoon',
                        'title' => 'Poster Session and Networking',
                        'speaker' => 'Young Researchers'
                    ],
                    [
                        'time' => 'Day 2 Morning',
                        'title' => 'Oral Presentations',
                        'speaker' => 'Selected Presenters'
                    ],
                    [
                        'time' => 'Day 2 Afternoon',
                        'title' => 'Career Development Panel',
                        'speaker' => 'Industry and Academic Leaders'
                    ]
                ]),
                'requirements' => 'Open to graduate students and postdocs. Abstract submission required.',
                'contact_info' => 'youngresearchers@sglr.com',
                'registration_fee' => 75.00,
            ],
            [
                'title' => 'Ethics in Research Seminar',
                'description' => 'Important seminar on research ethics, data integrity, authorship guidelines, and responsible conduct of research.',
                'type' => 'seminar',
                'start_date' => '2024-10-18 10:00:00',
                'end_date' => '2024-10-18 12:00:00',
                'location' => 'Ethics Training Room',
                'is_virtual' => false,
                'status' => 'registration_open',
                'max_participants' => 40,
                'registration_deadline' => '2024-10-16',
                'agenda' => json_encode([
                    [
                        'time' => '10:00-10:45',
                        'title' => 'Research Integrity Fundamentals',
                        'speaker' => 'Ethics Committee Chair'
                    ],
                    [
                        'time' => '11:00-11:45',
                        'title' => 'Case Studies and Best Practices',
                        'speaker' => 'Dr. Jennifer Lee'
                    ],
                    [
                        'time' => '11:45-12:00',
                        'title' => 'Q&A and Resources',
                        'speaker' => 'All speakers'
                    ]
                ]),
                'requirements' => 'Recommended for all research staff. Certificate of attendance provided.',
                'contact_info' => 'ethics@sglr.com',
                'registration_fee' => 0.00,
                'certification' => true,
            ],
            [
                'title' => 'Advanced Microscopy Techniques Training',
                'description' => 'Comprehensive training on advanced microscopy techniques including confocal, super-resolution, and electron microscopy.',
                'type' => 'training',
                'start_date' => '2024-11-12 09:00:00',
                'end_date' => '2024-11-14 17:00:00',
                'location' => 'Imaging Core Facility',
                'is_virtual' => false,
                'status' => 'registration_open',
                'max_participants' => 12,
                'registration_deadline' => '2024-11-05',
                'agenda' => json_encode([
                    [
                        'time' => 'Day 1',
                        'title' => 'Confocal Microscopy Basics',
                        'speaker' => 'Imaging Facility Staff'
                    ],
                    [
                        'time' => 'Day 2',
                        'title' => 'Super-resolution Techniques',
                        'speaker' => 'Dr. Carlos Silva'
                    ],
                    [
                        'time' => 'Day 3',
                        'title' => 'Electron Microscopy Applications',
                        'speaker' => 'EM Facility Manager'
                    ]
                ]),
                'requirements' => 'Basic microscopy knowledge required. Hands-on training included.',
                'contact_info' => 'imaging@sglr.com',
                'registration_fee' => 275.00,
                'certification' => true,
            ],
            [
                'title' => 'Quarterly Lab Managers Meeting',
                'description' => 'Regular meeting for laboratory managers to discuss operational issues, safety updates, and administrative matters.',
                'type' => 'meeting',
                'start_date' => '2024-10-25 14:00:00',
                'end_date' => '2024-10-25 16:00:00',
                'location' => 'Administration Conference Room',
                'is_virtual' => false,
                'status' => 'registration_closed',
                'max_participants' => 20,
                'registration_deadline' => '2024-10-23',
                'agenda' => json_encode([
                    [
                        'time' => '14:00-14:30',
                        'title' => 'Operational Updates',
                        'speaker' => 'Administration'
                    ],
                    [
                        'time' => '14:30-15:15',
                        'title' => 'Safety Review and Updates',
                        'speaker' => 'Safety Committee'
                    ],
                    [
                        'time' => '15:15-16:00',
                        'title' => 'Budget and Resource Planning',
                        'speaker' => 'Finance Department'
                    ]
                ]),
                'requirements' => 'Lab managers only. Agenda materials distributed in advance.',
                'contact_info' => 'labmanagers@sglr.com',
                'registration_fee' => 0.00,
            ],
        ];

        foreach ($events as $index => $eventData) {
            $organizer = $organizers->random();

            Event::create([
                'title' => $eventData['title'],
                'description' => $eventData['description'],
                'type' => $eventData['type'],
                'start_date' => $eventData['start_date'],
                'end_date' => $eventData['end_date'],
                'location' => $eventData['location'],
                'is_virtual' => $eventData['is_virtual'],
                'status' => $eventData['status'],
                'max_participants' => $eventData['max_participants'],
                'registration_deadline' => $eventData['registration_deadline'],
                'organizer_id' => $organizer->id,
                'agenda' => $eventData['agenda'],
                'requirements' => $eventData['requirements'],
                'contact_info' => $eventData['contact_info'],
                'registration_fee' => $eventData['registration_fee'],
                'meeting_url' => $eventData['meeting_url'] ?? null,
                'materials_url' => $eventData['materials_url'] ?? null,
                'certification' => $eventData['certification'] ?? false,
                'registration_count' => $this->getRegistrationCount($eventData['status'], $eventData['max_participants']),
                'tags' => json_encode($this->generateTags($eventData['type'], $eventData['title'])),
                'is_public' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function getRegistrationCount(string $status, int $maxParticipants): int
    {
        return match ($status) {
            'registration_open' => rand(5, intval($maxParticipants * 0.7)),
            'registration_closed' => rand(intval($maxParticipants * 0.8), $maxParticipants),
            'completed' => rand(intval($maxParticipants * 0.6), intval($maxParticipants * 0.9)),
            'cancelled' => rand(0, intval($maxParticipants * 0.3)),
            default => rand(0, intval($maxParticipants * 0.5)),
        };
    }

    private function generateTags(string $type, string $title): array
    {
        $baseTags = [
            'conference' => ['research', 'networking', 'presentations'],
            'workshop' => ['hands-on', 'training', 'practical'],
            'seminar' => ['education', 'discussion', 'expert'],
            'training' => ['skills', 'certification', 'learning'],
            'meeting' => ['collaboration', 'planning', 'updates'],
        ];

        $tags = $baseTags[$type] ?? ['event'];

        // Add specific tags based on title content
        if (str_contains(strtolower($title), 'crispr')) $tags[] = 'gene-editing';
        if (str_contains(strtolower($title), 'safety')) $tags[] = 'safety';
        if (str_contains(strtolower($title), 'international')) $tags[] = 'international';
        if (str_contains(strtolower($title), 'young')) $tags[] = 'students';
        if (str_contains(strtolower($title), 'microscopy')) $tags[] = 'imaging';

        return array_unique($tags);
    }
}