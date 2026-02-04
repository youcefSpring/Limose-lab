<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Insert admin notification email settings
        Setting::create([
            'key' => 'admin_notification_email',
            'value' => env('MAIL_FROM_ADDRESS', 'admin@example.com'),
            'type' => 'email',
            'group' => 'notifications',
            'category' => 'Email Notifications',
            'order' => 1,
        ]);

        Setting::create([
            'key' => 'enable_email_notifications',
            'value' => '1',
            'type' => 'boolean',
            'group' => 'notifications',
            'category' => 'Email Notifications',
            'order' => 2,
        ]);

        Setting::create([
            'key' => 'notify_admin_on_submission',
            'value' => '1',
            'type' => 'boolean',
            'group' => 'notifications',
            'category' => 'Email Notifications',
            'order' => 3,
        ]);

        Setting::create([
            'key' => 'notify_user_on_status_change',
            'value' => '1',
            'type' => 'boolean',
            'group' => 'notifications',
            'category' => 'Email Notifications',
            'order' => 4,
        ]);

        Setting::create([
            'key' => 'notify_user_on_event_rsvp',
            'value' => '1',
            'type' => 'boolean',
            'group' => 'notifications',
            'category' => 'Email Notifications',
            'order' => 5,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Setting::whereIn('key', [
            'admin_notification_email',
            'enable_email_notifications',
            'notify_admin_on_submission',
            'notify_user_on_status_change',
            'notify_user_on_event_rsvp',
        ])->delete();
    }
};
