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
            ['key' => 'site_name', 'value' => 'RLMS', 'type' => 'text', 'group' => 'general', 'order' => 1],
            ['key' => 'site_tagline', 'value' => 'Research Laboratory Management System', 'type' => 'text', 'group' => 'general', 'order' => 2],
            ['key' => 'contact_email', 'value' => 'info@rlms.edu', 'type' => 'text', 'group' => 'general', 'order' => 3],
            ['key' => 'contact_phone', 'value' => '+1 (555) 123-4567', 'type' => 'text', 'group' => 'general', 'order' => 4],

            // Laboratory Information
            ['key' => 'lab_name', 'value' => 'Research Laboratory', 'type' => 'text', 'group' => 'lab_info', 'order' => 1, 'is_multilingual' => true],
            ['key' => 'lab_full_name', 'value' => 'Advanced Research Laboratory', 'type' => 'text', 'group' => 'lab_info', 'order' => 2, 'is_multilingual' => true],
            ['key' => 'lab_description', 'value' => 'A state-of-the-art research facility dedicated to advancing scientific knowledge and innovation.', 'type' => 'textarea', 'group' => 'lab_info', 'order' => 3, 'is_multilingual' => true],
            ['key' => 'lab_mission', 'value' => 'To conduct groundbreaking research that addresses global challenges and contributes to scientific advancement.', 'type' => 'textarea', 'group' => 'lab_info', 'order' => 4, 'is_multilingual' => true],
            ['key' => 'lab_vision', 'value' => 'To be a world-leading research institution recognized for excellence in innovation and scientific discovery.', 'type' => 'textarea', 'group' => 'lab_info', 'order' => 5, 'is_multilingual' => true],
            ['key' => 'established_year', 'value' => '2020', 'type' => 'text', 'group' => 'lab_info', 'order' => 6],
            ['key' => 'director_name', 'value' => 'Dr. Laboratory Director', 'type' => 'text', 'group' => 'lab_info', 'order' => 7],

            // Laboratory Location
            ['key' => 'building_name', 'value' => 'Research Building', 'type' => 'text', 'group' => 'lab_location', 'order' => 1],
            ['key' => 'floor_number', 'value' => '3rd Floor', 'type' => 'text', 'group' => 'lab_location', 'order' => 2],
            ['key' => 'room_number', 'value' => 'Room 301-305', 'type' => 'text', 'group' => 'lab_location', 'order' => 3],
            ['key' => 'full_address', 'value' => 'Research Building, University Campus, City, Country', 'type' => 'textarea', 'group' => 'lab_location', 'order' => 4],
            ['key' => 'city', 'value' => 'City Name', 'type' => 'text', 'group' => 'lab_location', 'order' => 5],
            ['key' => 'country', 'value' => 'Country Name', 'type' => 'text', 'group' => 'lab_location', 'order' => 6],
            ['key' => 'postal_code', 'value' => '12345', 'type' => 'text', 'group' => 'lab_location', 'order' => 7],
            ['key' => 'latitude', 'value' => '0.0', 'type' => 'text', 'group' => 'lab_location', 'order' => 8],
            ['key' => 'longitude', 'value' => '0.0', 'type' => 'text', 'group' => 'lab_location', 'order' => 9],

            // Laboratory Contact
            ['key' => 'main_phone', 'value' => '+1 (555) 123-4567', 'type' => 'text', 'group' => 'lab_contact', 'order' => 1],
            ['key' => 'fax', 'value' => '+1 (555) 123-4568', 'type' => 'text', 'group' => 'lab_contact', 'order' => 2],
            ['key' => 'general_email', 'value' => 'info@lab.edu', 'type' => 'text', 'group' => 'lab_contact', 'order' => 3],
            ['key' => 'support_email', 'value' => 'support@lab.edu', 'type' => 'text', 'group' => 'lab_contact', 'order' => 4],
            ['key' => 'office_hours', 'value' => 'Monday - Friday: 9:00 AM - 5:00 PM', 'type' => 'textarea', 'group' => 'lab_contact', 'order' => 5],

            // Social Media
            ['key' => 'website_url', 'value' => 'https://lab.edu', 'type' => 'text', 'group' => 'lab_social', 'order' => 1],
            ['key' => 'facebook_url', 'value' => '', 'type' => 'text', 'group' => 'lab_social', 'order' => 2],
            ['key' => 'twitter_url', 'value' => '', 'type' => 'text', 'group' => 'lab_social', 'order' => 3],
            ['key' => 'linkedin_url', 'value' => '', 'type' => 'text', 'group' => 'lab_social', 'order' => 4],
            ['key' => 'youtube_url', 'value' => '', 'type' => 'text', 'group' => 'lab_social', 'order' => 5],
            ['key' => 'instagram_url', 'value' => '', 'type' => 'text', 'group' => 'lab_social', 'order' => 6],

            // Research Areas
            ['key' => 'research_area_1_title', 'value' => 'Molecular Biology', 'type' => 'text', 'group' => 'research_areas', 'order' => 1, 'is_multilingual' => true],
            ['key' => 'research_area_1_desc', 'value' => 'Advanced studies in molecular and cellular biology.', 'type' => 'textarea', 'group' => 'research_areas', 'order' => 2, 'is_multilingual' => true],
            ['key' => 'research_area_1_icon', 'value' => null, 'type' => 'image', 'group' => 'research_areas', 'order' => 3],

            ['key' => 'research_area_2_title', 'value' => 'Quantum Physics', 'type' => 'text', 'group' => 'research_areas', 'order' => 4, 'is_multilingual' => true],
            ['key' => 'research_area_2_desc', 'value' => 'Cutting-edge research in quantum mechanics and applications.', 'type' => 'textarea', 'group' => 'research_areas', 'order' => 5, 'is_multilingual' => true],
            ['key' => 'research_area_2_icon', 'value' => null, 'type' => 'image', 'group' => 'research_areas', 'order' => 6],

            ['key' => 'research_area_3_title', 'value' => 'Environmental Science', 'type' => 'text', 'group' => 'research_areas', 'order' => 7, 'is_multilingual' => true],
            ['key' => 'research_area_3_desc', 'value' => 'Studies on environmental sustainability and climate change.', 'type' => 'textarea', 'group' => 'research_areas', 'order' => 8, 'is_multilingual' => true],
            ['key' => 'research_area_3_icon', 'value' => null, 'type' => 'image', 'group' => 'research_areas', 'order' => 9],

            ['key' => 'research_area_4_title', 'value' => 'Artificial Intelligence', 'type' => 'text', 'group' => 'research_areas', 'order' => 10, 'is_multilingual' => true],
            ['key' => 'research_area_4_desc', 'value' => 'Machine learning and AI applications in scientific research.', 'type' => 'textarea', 'group' => 'research_areas', 'order' => 11, 'is_multilingual' => true],
            ['key' => 'research_area_4_icon', 'value' => null, 'type' => 'image', 'group' => 'research_areas', 'order' => 12],

            // Localization
            ['key' => 'default_locale', 'value' => 'en', 'type' => 'select', 'group' => 'localization', 'options' => 'en,fr,ar', 'order' => 1],
            ['key' => 'available_locales', 'value' => 'en,fr,ar', 'type' => 'text', 'group' => 'localization', 'order' => 2],
            ['key' => 'rtl_enabled', 'value' => '1', 'type' => 'boolean', 'group' => 'localization', 'order' => 3],

            // Branding
            ['key' => 'primary_logo', 'value' => null, 'type' => 'image', 'group' => 'branding', 'order' => 1],
            ['key' => 'secondary_logo', 'value' => null, 'type' => 'image', 'group' => 'branding', 'order' => 2],
            ['key' => 'logo_dark', 'value' => null, 'type' => 'image', 'group' => 'branding', 'order' => 3],
            ['key' => 'favicon', 'value' => null, 'type' => 'image', 'group' => 'branding', 'order' => 4],
            ['key' => 'hero_background', 'value' => null, 'type' => 'image', 'group' => 'branding', 'order' => 5],
            ['key' => 'about_image', 'value' => null, 'type' => 'image', 'group' => 'branding', 'order' => 6],
            ['key' => 'primary_color', 'value' => '#8C1515', 'type' => 'color', 'group' => 'branding', 'order' => 7],
            ['key' => 'secondary_color', 'value' => '#F9F6F2', 'type' => 'color', 'group' => 'branding', 'order' => 8],

            // Frontend - Hero Section
            ['key' => 'hero_title', 'value' => 'Research Laboratory Management System', 'type' => 'text', 'group' => 'frontend_hero', 'order' => 1, 'is_multilingual' => true],
            ['key' => 'hero_subtitle', 'value' => 'Streamline your research operations with our comprehensive lab management platform', 'type' => 'textarea', 'group' => 'frontend_hero', 'order' => 2, 'is_multilingual' => true],

            // Frontend - About Section
            ['key' => 'about_description', 'value' => 'Our research laboratory is dedicated to advancing scientific knowledge through innovative research and collaboration. With state-of-the-art equipment and a team of dedicated researchers, we strive to make significant contributions to our field while fostering the next generation of scientists.', 'type' => 'textarea', 'group' => 'frontend_about', 'order' => 1, 'is_multilingual' => true],
            ['key' => 'stat_equipment', 'value' => '500+', 'type' => 'text', 'group' => 'frontend_about', 'order' => 2],
            ['key' => 'stat_projects', 'value' => '50+', 'type' => 'text', 'group' => 'frontend_about', 'order' => 3],
            ['key' => 'stat_researchers', 'value' => '100+', 'type' => 'text', 'group' => 'frontend_about', 'order' => 4],
            ['key' => 'stat_publications', 'value' => '200+', 'type' => 'text', 'group' => 'frontend_about', 'order' => 5],

            // Frontend - Contact Info
            ['key' => 'location_address', 'value' => 'Research Building, University Campus, City, Country', 'type' => 'textarea', 'group' => 'frontend_contact', 'order' => 1],
            ['key' => 'contact_email_2', 'value' => 'lab@research.edu', 'type' => 'text', 'group' => 'frontend_contact', 'order' => 2],
            ['key' => 'contact_hours', 'value' => 'Mon-Fri, 9AM-5PM', 'type' => 'text', 'group' => 'frontend_contact', 'order' => 3],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        $this->command->info('Settings seeded successfully!');
        $this->command->info('Total settings: ' . count($settings));
    }
}
