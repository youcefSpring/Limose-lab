<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Illuminate\Database\Seeder;

class SystemSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // General Settings
            [
                'key' => 'app_name',
                'value' => 'SGLR Laboratory Management System',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Application Name',
                'description' => 'The name of the application displayed throughout the system',
                'is_public' => true,
                'sort_order' => 1,
            ],
            [
                'key' => 'app_description',
                'value' => 'Scientific and Research Laboratory Management System',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Application Description',
                'description' => 'Brief description of the application',
                'is_public' => true,
                'sort_order' => 2,
            ],
            [
                'key' => 'default_language',
                'value' => 'en',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Default Language',
                'description' => 'Default system language (en, fr, ar)',
                'is_public' => true,
                'validation_rules' => json_encode(['required', 'in:en,fr,ar']),
                'sort_order' => 3,
            ],
            [
                'key' => 'timezone',
                'value' => 'UTC',
                'type' => 'string',
                'group' => 'general',
                'label' => 'System Timezone',
                'description' => 'Default timezone for the system',
                'is_public' => false,
                'sort_order' => 4,
            ],
            [
                'key' => 'maintenance_mode',
                'value' => 'false',
                'type' => 'boolean',
                'group' => 'general',
                'label' => 'Maintenance Mode',
                'description' => 'Enable maintenance mode to prevent user access',
                'is_public' => true,
                'sort_order' => 5,
            ],

            // User Management Settings
            [
                'key' => 'allow_user_registration',
                'value' => 'false',
                'type' => 'boolean',
                'group' => 'users',
                'label' => 'Allow User Registration',
                'description' => 'Allow new users to register themselves',
                'is_public' => true,
                'sort_order' => 1,
            ],
            [
                'key' => 'require_email_verification',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'users',
                'label' => 'Require Email Verification',
                'description' => 'Require email verification for new accounts',
                'is_public' => false,
                'sort_order' => 2,
            ],
            [
                'key' => 'password_min_length',
                'value' => '8',
                'type' => 'integer',
                'group' => 'users',
                'label' => 'Minimum Password Length',
                'description' => 'Minimum required password length',
                'is_public' => false,
                'validation_rules' => json_encode(['required', 'integer', 'min:6', 'max:50']),
                'sort_order' => 3,
            ],
            [
                'key' => 'session_timeout',
                'value' => '120',
                'type' => 'integer',
                'group' => 'users',
                'label' => 'Session Timeout (minutes)',
                'description' => 'User session timeout in minutes',
                'is_public' => false,
                'validation_rules' => json_encode(['required', 'integer', 'min:15', 'max:480']),
                'sort_order' => 4,
            ],

            // Email Settings
            [
                'key' => 'mail_from_address',
                'value' => 'noreply@sglr.com',
                'type' => 'string',
                'group' => 'email',
                'label' => 'From Email Address',
                'description' => 'Default sender email address',
                'is_public' => false,
                'validation_rules' => json_encode(['required', 'email']),
                'sort_order' => 1,
            ],
            [
                'key' => 'mail_from_name',
                'value' => 'SGLR Laboratory System',
                'type' => 'string',
                'group' => 'email',
                'label' => 'From Name',
                'description' => 'Default sender name',
                'is_public' => false,
                'sort_order' => 2,
            ],
            [
                'key' => 'notification_email_enabled',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'email',
                'label' => 'Enable Email Notifications',
                'description' => 'Send email notifications to users',
                'is_public' => false,
                'sort_order' => 3,
            ],

            // Equipment Settings
            [
                'key' => 'equipment_booking_advance_days',
                'value' => '30',
                'type' => 'integer',
                'group' => 'equipment',
                'label' => 'Booking Advance Days',
                'description' => 'Maximum days in advance equipment can be booked',
                'is_public' => true,
                'validation_rules' => json_encode(['required', 'integer', 'min:1', 'max:365']),
                'sort_order' => 1,
            ],
            [
                'key' => 'equipment_max_booking_duration',
                'value' => '8',
                'type' => 'integer',
                'group' => 'equipment',
                'label' => 'Max Booking Duration (hours)',
                'description' => 'Maximum duration for equipment booking in hours',
                'is_public' => true,
                'validation_rules' => json_encode(['required', 'integer', 'min:1', 'max:24']),
                'sort_order' => 2,
            ],
            [
                'key' => 'equipment_maintenance_reminder_days',
                'value' => '7',
                'type' => 'integer',
                'group' => 'equipment',
                'label' => 'Maintenance Reminder (days)',
                'description' => 'Days before maintenance due to send reminder',
                'is_public' => false,
                'validation_rules' => json_encode(['required', 'integer', 'min:1', 'max:30']),
                'sort_order' => 3,
            ],

            // Project Settings
            [
                'key' => 'project_default_duration_months',
                'value' => '12',
                'type' => 'integer',
                'group' => 'projects',
                'label' => 'Default Project Duration (months)',
                'description' => 'Default duration for new projects in months',
                'is_public' => false,
                'validation_rules' => json_encode(['required', 'integer', 'min:1', 'max:60']),
                'sort_order' => 1,
            ],
            [
                'key' => 'project_budget_currency',
                'value' => 'USD',
                'type' => 'string',
                'group' => 'projects',
                'label' => 'Default Currency',
                'description' => 'Default currency for project budgets',
                'is_public' => true,
                'validation_rules' => json_encode(['required', 'string', 'size:3']),
                'sort_order' => 2,
            ],

            // File Upload Settings
            [
                'key' => 'max_file_upload_size',
                'value' => '10240',
                'type' => 'integer',
                'group' => 'uploads',
                'label' => 'Max File Upload Size (KB)',
                'description' => 'Maximum file upload size in kilobytes',
                'is_public' => false,
                'validation_rules' => json_encode(['required', 'integer', 'min:1024', 'max:102400']),
                'sort_order' => 1,
            ],
            [
                'key' => 'allowed_file_types',
                'value' => 'pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,gif',
                'type' => 'string',
                'group' => 'uploads',
                'label' => 'Allowed File Types',
                'description' => 'Comma-separated list of allowed file extensions',
                'is_public' => false,
                'sort_order' => 2,
            ],

            // Notification Settings
            [
                'key' => 'notifications_enabled',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'notifications',
                'label' => 'Enable Notifications',
                'description' => 'Enable system notifications',
                'is_public' => false,
                'sort_order' => 1,
            ],
            [
                'key' => 'notification_retention_days',
                'value' => '90',
                'type' => 'integer',
                'group' => 'notifications',
                'label' => 'Notification Retention (days)',
                'description' => 'Days to keep notifications before automatic cleanup',
                'is_public' => false,
                'validation_rules' => json_encode(['required', 'integer', 'min:7', 'max:365']),
                'sort_order' => 2,
            ],

            // Security Settings
            [
                'key' => 'max_login_attempts',
                'value' => '5',
                'type' => 'integer',
                'group' => 'security',
                'label' => 'Max Login Attempts',
                'description' => 'Maximum failed login attempts before lockout',
                'is_public' => false,
                'validation_rules' => json_encode(['required', 'integer', 'min:3', 'max:10']),
                'sort_order' => 1,
            ],
            [
                'key' => 'lockout_duration_minutes',
                'value' => '15',
                'type' => 'integer',
                'group' => 'security',
                'label' => 'Lockout Duration (minutes)',
                'description' => 'Account lockout duration in minutes',
                'is_public' => false,
                'validation_rules' => json_encode(['required', 'integer', 'min:5', 'max:60']),
                'sort_order' => 2,
            ],
            [
                'key' => 'force_https',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'security',
                'label' => 'Force HTTPS',
                'description' => 'Force HTTPS for all connections',
                'is_public' => false,
                'sort_order' => 3,
            ],

            // Backup Settings
            [
                'key' => 'backup_enabled',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'backup',
                'label' => 'Enable Automated Backups',
                'description' => 'Enable automated database backups',
                'is_public' => false,
                'sort_order' => 1,
            ],
            [
                'key' => 'backup_frequency_hours',
                'value' => '24',
                'type' => 'integer',
                'group' => 'backup',
                'label' => 'Backup Frequency (hours)',
                'description' => 'Backup frequency in hours',
                'is_public' => false,
                'validation_rules' => json_encode(['required', 'integer', 'min:1', 'max:168']),
                'sort_order' => 2,
            ],
            [
                'key' => 'backup_retention_days',
                'value' => '30',
                'type' => 'integer',
                'group' => 'backup',
                'label' => 'Backup Retention (days)',
                'description' => 'Days to keep backup files',
                'is_public' => false,
                'validation_rules' => json_encode(['required', 'integer', 'min:7', 'max:365']),
                'sort_order' => 3,
            ],
        ];

        foreach ($settings as $setting) {
            SystemSetting::create($setting);
        }
    }
}