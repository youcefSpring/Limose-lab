<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        $notifications = [
            [
                'title' => 'Welcome to SGLR Laboratory System',
                'message' => 'Welcome to the Scientific and Research Laboratory Management System. Please take a moment to update your profile and explore the available features.',
                'type' => 'info',
                'priority' => 'normal',
                'action_url' => '/dashboard/profile',
                'action_text' => 'Update Profile',
            ],
            [
                'title' => 'Equipment Maintenance Reminder',
                'message' => 'Several pieces of equipment are due for maintenance this week. Please check the equipment management section for details.',
                'type' => 'warning',
                'priority' => 'high',
                'action_url' => '/equipment',
                'action_text' => 'View Equipment',
            ],
            [
                'title' => 'New Project Collaboration Opportunity',
                'message' => 'A new interdisciplinary research project is looking for collaborators. Review the project details and consider joining.',
                'type' => 'success',
                'priority' => 'normal',
                'action_url' => '/projects',
                'action_text' => 'Browse Projects',
            ],
            [
                'title' => 'System Maintenance Scheduled',
                'message' => 'The system will undergo scheduled maintenance this weekend from 2:00 AM to 6:00 AM. Please save your work before this time.',
                'type' => 'danger',
                'priority' => 'urgent',
                'expires_at' => now()->addDays(7),
            ],
            [
                'title' => 'Monthly Research Report Due',
                'message' => 'Your monthly research progress report is due by the end of this week. Please submit your report through the project management section.',
                'type' => 'warning',
                'priority' => 'high',
                'action_url' => '/projects/reports',
                'action_text' => 'Submit Report',
                'expires_at' => now()->addDays(14),
            ],
            [
                'title' => 'New Publication Added',
                'message' => 'A new publication has been added to the research database. Check it out to stay updated with the latest research.',
                'type' => 'info',
                'priority' => 'low',
                'action_url' => '/publications',
                'action_text' => 'View Publications',
            ],
            [
                'title' => 'Training Session Available',
                'message' => 'A new training session for advanced equipment operation is now available. Register to enhance your skills.',
                'type' => 'success',
                'priority' => 'normal',
                'action_url' => '/events',
                'action_text' => 'Register for Training',
            ],
        ];

        foreach ($users as $user) {
            // Give each user 2-4 random notifications
            $userNotifications = collect($notifications)->random(rand(2, 4));

            foreach ($userNotifications as $index => $notification) {
                Notification::create([
                    'user_id' => $user->id,
                    'title' => $notification['title'],
                    'message' => $notification['message'],
                    'type' => $notification['type'],
                    'priority' => $notification['priority'],
                    'action_url' => $notification['action_url'] ?? null,
                    'action_text' => $notification['action_text'] ?? null,
                    'expires_at' => $notification['expires_at'] ?? null,
                    'is_read' => rand(0, 1) === 1, // 50% chance of being read
                    'read_at' => rand(0, 1) === 1 ? now()->subDays(rand(1, 7)) : null,
                    'created_at' => now()->subDays(rand(0, 30)),
                ]);
            }
        }

        // Create some system-wide notifications for admins
        $admins = User::where('role', 'admin')->get();
        $systemNotifications = [
            [
                'title' => 'Database Backup Completed',
                'message' => 'The automated database backup has been completed successfully.',
                'type' => 'success',
                'priority' => 'low',
            ],
            [
                'title' => 'High CPU Usage Alert',
                'message' => 'The server is experiencing high CPU usage. Please monitor system performance.',
                'type' => 'warning',
                'priority' => 'high',
            ],
            [
                'title' => 'Security Update Available',
                'message' => 'A new security update is available for the system. Please schedule maintenance to apply updates.',
                'type' => 'danger',
                'priority' => 'urgent',
            ],
        ];

        foreach ($admins as $admin) {
            foreach ($systemNotifications as $notification) {
                Notification::create([
                    'user_id' => $admin->id,
                    'title' => $notification['title'],
                    'message' => $notification['message'],
                    'type' => $notification['type'],
                    'priority' => $notification['priority'],
                    'created_at' => now()->subHours(rand(1, 48)),
                ]);
            }
        }
    }
}