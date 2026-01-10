<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // General Settings
            ['key' => 'site_name', 'value' => 'RLMS', 'type' => 'text', 'group' => 'general'],
            ['key' => 'site_tagline', 'value' => 'Research Laboratory Management System', 'type' => 'text', 'group' => 'general'],
            ['key' => 'contact_email', 'value' => 'info@rlms.edu', 'type' => 'text', 'group' => 'general'],
            ['key' => 'contact_phone', 'value' => '+1 (555) 123-4567', 'type' => 'text', 'group' => 'general'],

            // Frontend - Hero Section
            ['key' => 'hero_title', 'value' => 'Research Laboratory Management System', 'type' => 'text', 'group' => 'frontend_hero'],
            ['key' => 'hero_subtitle', 'value' => 'Streamline your research operations with our comprehensive lab management platform', 'type' => 'text', 'group' => 'frontend_hero'],

            // Frontend - About Section
            ['key' => 'about_description', 'value' => 'Our research laboratory is dedicated to advancing scientific knowledge through innovative research and collaboration. With state-of-the-art equipment and a team of dedicated researchers, we strive to make significant contributions to our field while fostering the next generation of scientists.', 'type' => 'textarea', 'group' => 'frontend_about'],
            ['key' => 'stat_equipment', 'value' => '500+', 'type' => 'text', 'group' => 'frontend_about'],
            ['key' => 'stat_projects', 'value' => '50+', 'type' => 'text', 'group' => 'frontend_about'],
            ['key' => 'stat_researchers', 'value' => '100+', 'type' => 'text', 'group' => 'frontend_about'],
            ['key' => 'stat_publications', 'value' => '200+', 'type' => 'text', 'group' => 'frontend_about'],

            // Frontend - Contact Info
            ['key' => 'location_address', 'value' => 'Research Building, University Campus, City, Country', 'type' => 'textarea', 'group' => 'frontend_contact'],
            ['key' => 'contact_email_2', 'value' => 'lab@research.edu', 'type' => 'text', 'group' => 'frontend_contact'],
            ['key' => 'contact_hours', 'value' => 'Mon-Fri, 9AM-5PM', 'type' => 'text', 'group' => 'frontend_contact'],

            // Appearance
            ['key' => 'logo', 'value' => null, 'type' => 'image', 'group' => 'appearance'],
            ['key' => 'favicon', 'value' => null, 'type' => 'image', 'group' => 'appearance'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
