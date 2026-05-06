@php
    $settingKeyMap = [
        'site_name' => 'site_name',
        'site_tagline' => 'site_tagline',
        'contact_email' => 'contact_email',
        'contact_phone' => 'contact_phone',
        'lab_name' => 'lab_name',
        'lab_full_name' => 'lab_full_name',
        'lab_description' => 'lab_description',
        'lab_mission' => 'lab_mission',
        'lab_vision' => 'lab_vision',
        'established_year' => 'established_year',
        'director_name' => 'director_name',
        'building_name' => 'building_name',
        'floor_number' => 'floor_number',
        'room_number' => 'room_number',
        'full_address' => 'full_address',
        'city' => 'city',
        'country' => 'country',
        'postal_code' => 'postal_code',
        'latitude' => 'latitude',
        'longitude' => 'longitude',
        'main_phone' => 'main_phone',
        'fax' => 'fax',
        'general_email' => 'general_email',
        'support_email' => 'support_email',
        'office_hours' => 'office_hours',
        'website_url' => 'website_url',
        'facebook_url' => 'facebook_url',
        'twitter_url' => 'twitter_url',
        'linkedin_url' => 'linkedin_url',
        'youtube_url' => 'youtube_url',
        'instagram_url' => 'instagram_url',
        'research_area_1_title' => 'research_area_1_title',
        'research_area_1_desc' => 'research_area_1_desc',
        'research_area_1_icon' => 'research_area_1_icon',
        'research_area_2_title' => 'research_area_2_title',
        'research_area_2_desc' => 'research_area_2_desc',
        'research_area_2_icon' => 'research_area_2_icon',
        'research_area_3_title' => 'research_area_3_title',
        'research_area_3_desc' => 'research_area_3_desc',
        'research_area_3_icon' => 'research_area_3_icon',
        'research_area_4_title' => 'research_area_4_title',
        'research_area_4_desc' => 'research_area_4_desc',
        'research_area_4_icon' => 'research_area_4_icon',
        'primary_logo' => 'primary_logo',
        'secondary_logo' => 'secondary_logo',
        'logo_dark' => 'logo_dark',
        'favicon' => 'favicon',
        'hero_background' => 'hero_background',
        'about_image' => 'about_image',
        'primary_color' => 'primary_color',
        'secondary_color' => 'secondary_color',
        'accent_color' => 'accent_color',
        'text_color' => 'text_color',
        'header_color' => 'header_color',
        'button_color' => 'button_color',
        'button_hover_color' => 'button_hover_color',
        'hero_title' => 'hero_title',
        'hero_subtitle' => 'hero_subtitle',
        'about_description' => 'about_description',
        'stat_equipment' => 'stat_equipment',
        'stat_projects' => 'stat_projects',
        'stat_researchers' => 'stat_researchers',
        'stat_publications' => 'stat_publications',
        'location_address' => 'location_address',
        'contact_email_2' => 'contact_email_2',
        'contact_hours' => 'contact_hours',
        'map_embed' => 'map_embed',
        'slider_enabled' => 'slider_enabled',
        'slider_speed' => 'slider_speed',
        'slider_slide_1_title' => 'slider_slide_1_title',
        'slider_slide_1_subtitle' => 'slider_slide_1_subtitle',
        'slider_slide_1_image' => 'slider_slide_1_image',
        'slider_slide_2_title' => 'slider_slide_2_title',
        'slider_slide_2_subtitle' => 'slider_slide_2_subtitle',
        'slider_slide_2_image' => 'slider_slide_2_image',
        'slider_slide_3_title' => 'slider_slide_3_title',
        'slider_slide_3_subtitle' => 'slider_slide_3_subtitle',
        'slider_slide_3_image' => 'slider_slide_3_image',
        'default_locale' => 'default_locale',
        'available_locales' => 'available_locales',
        'rtl_enabled' => 'rtl_enabled',
    ];
    
    $groupKeyMap = [
        'general' => 'general',
        'lab_info' => 'lab_info',
        'lab_location' => 'lab_location',
        'lab_contact' => 'lab_contact',
        'lab_social' => 'lab_social',
        'research_areas' => 'research_areas',
        'branding' => 'branding',
        'frontend_hero' => 'frontend_hero',
        'frontend_about' => 'frontend_about',
        'frontend_contact' => 'frontend_contact',
        'frontend_slider' => 'frontend_slider',
        'localization' => 'localization',
    ];
@endphp

<x-app-layout>
    <!-- Header -->
    <header class="mb-6 lg:mb-8">
        <h1 class="text-xl sm:text-2xl font-semibold">{{ __('messages.Settings') }}</h1>
        <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ __('settings.manage_website_settings') }}</p>
    </header>

    <!-- Alert Container -->
    <div id="settings-alert" class="hidden mb-6"></div>

    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Vertical Tabs Navigation -->
        <div class="lg:w-64 flex-shrink-0">
            <nav class="glass-card rounded-2xl p-3 lg:sticky lg:top-6 space-y-1">
                <button type="button" class="tab-button active w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all text-left" data-tab="general">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    {{ __('settings.general') }}
                </button>
                <button type="button" class="tab-button w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all text-left" data-tab="lab-info">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                    </svg>
                    {{ __('settings.lab_info') }}
                </button>
                <button type="button" class="tab-button w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all text-left" data-tab="branding">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                    </svg>
                    {{ __('settings.branding') }}
                </button>
                <button type="button" class="tab-button w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all text-left" data-tab="frontend">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                    </svg>
                    {{ __('settings.frontend_hero') }}
                </button>
                <button type="button" class="tab-button w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all text-left" data-tab="slider">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    {{ __('settings.frontend_slider') }}
                </button>
                <button type="button" class="tab-button w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all text-left" data-tab="localization">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                    </svg>
                    {{ __('settings.localization') }}
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="flex-1 glass-card rounded-2xl p-5 lg:p-6">
            <form id="settings-form" action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- General Tab -->
                <div id="general-tab" class="tab-content">
                    @foreach($settings as $group => $groupSettings)
                        @if(in_array($group, ['general']))
                            <div class="mb-8">
                                <h3 class="text-lg font-semibold mb-5 capitalize flex items-center gap-2">
                                    <span class="h-8 w-8 rounded-lg bg-accent-amber/10 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-accent-amber" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                        </svg>
                                    </span>
                                    {{ trans('settings.' . ($groupKeyMap[$group] ?? $group)) }}
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @foreach($groupSettings as $setting)
                                        <div class="{{ $setting->type === 'textarea' ? 'md:col-span-2' : '' }}">
                                            <label for="{{ $setting->key }}" class="block text-sm font-medium mb-2">
                                                {{ trans('settings.' . ($settingKeyMap[$setting->key] ?? str_replace('_', ' ', $setting->key))) }}
                                            </label>
                                            @include('settings.partials.field', ['setting' => $setting])
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <!-- Laboratory Info Tab -->
                <div id="lab-info-tab" class="tab-content hidden">
                    @foreach($settings as $group => $groupSettings)
                        @if(in_array($group, ['lab_info', 'lab_location', 'lab_contact', 'lab_social', 'research_areas']))
                            <div class="mb-8 pb-8 border-b border-black/10 dark:border-white/10 last:border-0 last:pb-0">
                                <h3 class="text-lg font-semibold mb-5 capitalize flex items-center gap-2">
                                    <span class="h-8 w-8 rounded-lg bg-accent-cyan/10 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-accent-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                        </svg>
                                    </span>
                                    {{ trans('settings.' . ($groupKeyMap[$group] ?? $group)) }}
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @foreach($groupSettings as $setting)
                                        <div class="{{ $setting->type === 'textarea' ? 'md:col-span-2' : '' }}">
                                            <label for="{{ $setting->key }}" class="block text-sm font-medium mb-2">
                                                {{ trans('settings.' . ($settingKeyMap[$setting->key] ?? str_replace('_', ' ', $setting->key))) }}
                                            </label>
                                            @include('settings.partials.field', ['setting' => $setting])
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <!-- Branding Tab -->
                <div id="branding-tab" class="tab-content hidden">
                    @php
                        $logoKeys = ['primary_logo', 'secondary_logo', 'logo_dark', 'favicon', 'hero_background', 'about_image'];
                        $colorKeys = ['primary_color', 'secondary_color', 'accent_color', 'text_color', 'header_color', 'button_color', 'button_hover_color'];
                    @endphp
                    @foreach($settings as $group => $groupSettings)
                        @if(in_array($group, ['branding']))
                            <!-- Logo Section -->
                            <div class="mb-8 pb-8 border-b border-black/10 dark:border-white/10">
                                <h3 class="text-lg font-semibold mb-5 flex items-center gap-2">
                                    <span class="h-8 w-8 rounded-lg bg-accent-violet/10 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-accent-violet" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </span>
                                    {{ trans('settings.logos') }}
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @foreach($groupSettings as $setting)
                                        @if(in_array($setting->key, $logoKeys))
                                            <div class="{{ $setting->type === 'textarea' ? 'md:col-span-2' : '' }}">
                                                <label for="{{ $setting->key }}" class="block text-sm font-medium mb-2">
                                                    {{ trans('settings.' . ($settingKeyMap[$setting->key] ?? str_replace('_', ' ', $setting->key))) }}
                                                </label>
                                                @include('settings.partials.field', ['setting' => $setting])
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <!-- Colors Section -->
                            <div class="mb-8">
                                <h3 class="text-lg font-semibold mb-5 flex items-center gap-2">
                                    <span class="h-8 w-8 rounded-lg bg-accent-rose/10 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-accent-rose" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                                        </svg>
                                    </span>
                                    {{ trans('settings.colors') }}
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @foreach($groupSettings as $setting)
                                        @if(in_array($setting->key, $colorKeys))
                                            <div class="{{ $setting->type === 'textarea' ? 'md:col-span-2' : '' }}">
                                                <label for="{{ $setting->key }}" class="block text-sm font-medium mb-2">
                                                    {{ trans('settings.' . ($settingKeyMap[$setting->key] ?? str_replace('_', ' ', $setting->key))) }}
                                                </label>
                                                @include('settings.partials.field', ['setting' => $setting])
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <!-- Frontend Content Tab -->
                <div id="frontend-tab" class="tab-content hidden">
                    @foreach($settings as $group => $groupSettings)
                        @if(in_array($group, ['frontend_hero', 'frontend_about', 'frontend_contact']))
                            <div class="mb-8 pb-8 border-b border-black/10 dark:border-white/10 last:border-0 last:pb-0">
                                <h3 class="text-lg font-semibold mb-5 capitalize flex items-center gap-2">
                                    <span class="h-8 w-8 rounded-lg bg-accent-indigo/10 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-accent-indigo" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </span>
                                    {{ trans('settings.' . ($groupKeyMap[$group] ?? $group)) }}
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @foreach($groupSettings as $setting)
                                        <div class="{{ $setting->type === 'textarea' ? 'md:col-span-2' : '' }}">
                                            <label for="{{ $setting->key }}" class="block text-sm font-medium mb-2">
                                                {{ trans('settings.' . ($settingKeyMap[$setting->key] ?? str_replace('_', ' ', $setting->key))) }}
                                            </label>
                                            @include('settings.partials.field', ['setting' => $setting])
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <!-- Slider Tab -->
                <div id="slider-tab" class="tab-content hidden">
                    @foreach($settings as $group => $groupSettings)
                        @if(in_array($group, ['frontend_slider']))
                            <div class="mb-8 pb-8 border-b border-black/10 dark:border-white/10 last:border-0 last:pb-0">
                                <h3 class="text-lg font-semibold mb-5 capitalize flex items-center gap-2">
                                    <span class="h-8 w-8 rounded-lg bg-accent-rose/10 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-accent-rose" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </span>
                                    {{ trans('settings.' . ($groupKeyMap[$group] ?? $group)) }}
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @foreach($groupSettings as $setting)
                                        <div class="{{ $setting->type === 'textarea' ? 'md:col-span-2' : '' }}">
                                            <label for="{{ $setting->key }}" class="block text-sm font-medium mb-2">
                                                {{ trans('settings.' . ($settingKeyMap[$setting->key] ?? str_replace('_', ' ', $setting->key))) }}
                                            </label>
                                            @include('settings.partials.field', ['setting' => $setting])
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <!-- Localization Tab -->
                <div id="localization-tab" class="tab-content hidden">
                    @foreach($settings as $group => $groupSettings)
                        @if(in_array($group, ['localization']))
                            <div class="mb-8">
                                <h3 class="text-lg font-semibold mb-5 capitalize flex items-center gap-2">
                                    <span class="h-8 w-8 rounded-lg bg-accent-emerald/10 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-accent-emerald" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                                        </svg>
                                    </span>
                                    {{ trans('settings.' . ($groupKeyMap[$group] ?? $group)) }}
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @foreach($groupSettings as $setting)
                                        <div class="{{ $setting->type === 'textarea' ? 'md:col-span-2' : '' }}">
                                            <label for="{{ $setting->key }}" class="block text-sm font-medium mb-2">
                                                {{ trans('settings.' . ($settingKeyMap[$setting->key] ?? str_replace('_', ' ', $setting->key))) }}
                                            </label>
                                            @include('settings.partials.field', ['setting' => $setting])
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <!-- Save Button -->
                <div class="flex justify-end gap-3 pt-6 mt-6 border-t border-black/10 dark:border-white/10">
                    <button type="submit" class="flex items-center gap-2 bg-gradient-to-r from-accent-amber to-accent-coral px-6 py-3 rounded-xl font-medium text-white hover:opacity-90 transition-opacity">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ __('settings.save_settings') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        // Tabs
        document.querySelectorAll('.tab-button').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                var tabName = this.getAttribute('data-tab');
                
                document.querySelectorAll('.tab-button').forEach(function(b) {
                    b.classList.remove('active', 'bg-accent-amber/10', 'text-accent-amber');
                    b.classList.add('text-zinc-500');
                });
                
                this.classList.add('active', 'bg-accent-amber/10', 'text-accent-amber');
                this.classList.remove('text-zinc-500');
                
                document.querySelectorAll('.tab-content').forEach(function(c) {
                    c.classList.add('hidden');
                });
                
                document.getElementById(tabName + '-tab').classList.remove('hidden');
            });
        });

        // Form - simple non-AJAX submit
        document.getElementById('settings-form').addEventListener('submit', function() {
            var btn = this.querySelector('button[type="submit"]');
            btn.disabled = true;
            btn.innerHTML = 'Saving...';
        });
    </script>
    @endpush
</x-app-layout>