<x-app-layout>
    <!-- Header -->
    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 lg:mb-8">
        <div>
            <h1 class="text-xl sm:text-2xl font-semibold">{{ __('Settings') }}</h1>
            <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ __('Manage website settings and frontend content') }}</p>
        </div>
    </header>

    <div class="glass-card rounded-2xl p-5 lg:p-6">
        <!-- Tabs Navigation -->
        <div class="flex items-center gap-2 mb-6 overflow-x-auto pb-2 border-b border-black/10 dark:border-white/10" role="tablist">
            <button type="button" class="tab-button active px-4 py-2.5 rounded-xl text-sm font-medium transition-all whitespace-nowrap" data-tab="general">
                <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                {{ __('General') }}
            </button>
            <button type="button" class="tab-button px-4 py-2.5 rounded-xl text-sm font-medium transition-all whitespace-nowrap" data-tab="lab-info">
                <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                </svg>
                {{ __('Laboratory Info') }}
            </button>
            <button type="button" class="tab-button px-4 py-2.5 rounded-xl text-sm font-medium transition-all whitespace-nowrap" data-tab="branding">
                <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                </svg>
                {{ __('Branding') }}
            </button>
            <button type="button" class="tab-button px-4 py-2.5 rounded-xl text-sm font-medium transition-all whitespace-nowrap" data-tab="frontend">
                <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                </svg>
                {{ __('Frontend Content') }}
            </button>
            <button type="button" class="tab-button px-4 py-2.5 rounded-xl text-sm font-medium transition-all whitespace-nowrap" data-tab="localization">
                <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                </svg>
                {{ __('Localization') }}
            </button>
        </div>

        <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
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
                                {{ __(str_replace('_', ' ', $group)) }}
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($groupSettings as $setting)
                                    <div class="{{ $setting->type === 'textarea' ? 'md:col-span-2' : '' }}">
                                        <label for="{{ $setting->key }}" class="block text-sm font-medium mb-2">
                                            {{ __(ucfirst(str_replace('_', ' ', $setting->key))) }}
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
                                {{ __(str_replace('_', ' ', $group)) }}
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($groupSettings as $setting)
                                    <div class="{{ $setting->type === 'textarea' ? 'md:col-span-2' : '' }}">
                                        <label for="{{ $setting->key }}" class="block text-sm font-medium mb-2">
                                            {{ __(ucfirst(str_replace('_', ' ', $setting->key))) }}
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
                @foreach($settings as $group => $groupSettings)
                    @if(in_array($group, ['branding']))
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold mb-5 capitalize flex items-center gap-2">
                                <span class="h-8 w-8 rounded-lg bg-accent-violet/10 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-accent-violet" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                                    </svg>
                                </span>
                                {{ __(str_replace('_', ' ', $group)) }}
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($groupSettings as $setting)
                                    <div class="{{ $setting->type === 'textarea' ? 'md:col-span-2' : '' }}">
                                        <label for="{{ $setting->key }}" class="block text-sm font-medium mb-2">
                                            {{ __(ucfirst(str_replace('_', ' ', $setting->key))) }}
                                        </label>
                                        @include('settings.partials.field', ['setting' => $setting])
                                    </div>
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
                                {{ __(str_replace('_', ' ', $group)) }}
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($groupSettings as $setting)
                                    <div class="{{ $setting->type === 'textarea' ? 'md:col-span-2' : '' }}">
                                        <label for="{{ $setting->key }}" class="block text-sm font-medium mb-2">
                                            {{ __(ucfirst(str_replace('_', ' ', $setting->key))) }}
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
                                {{ __(str_replace('_', ' ', $group)) }}
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($groupSettings as $setting)
                                    <div class="{{ $setting->type === 'textarea' ? 'md:col-span-2' : '' }}">
                                        <label for="{{ $setting->key }}" class="block text-sm font-medium mb-2">
                                            {{ __(ucfirst(str_replace('_', ' ', $setting->key))) }}
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
                    {{ __('Save Settings') }}
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const tabName = this.getAttribute('data-tab');

                    // Remove active class from all buttons
                    tabButtons.forEach(btn => {
                        btn.classList.remove('active', 'bg-accent-amber/10', 'text-accent-amber');
                        btn.classList.add('text-zinc-500', 'hover:bg-black/5', 'dark:hover:bg-white/5');
                    });

                    // Add active class to clicked button
                    this.classList.add('active', 'bg-accent-amber/10', 'text-accent-amber');
                    this.classList.remove('text-zinc-500', 'hover:bg-black/5', 'dark:hover:bg-white/5');

                    // Hide all tab contents
                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                    });

                    // Show selected tab content
                    document.getElementById(tabName + '-tab').classList.remove('hidden');
                });
            });

            // Set initial active state
            tabButtons[0].classList.add('bg-accent-amber/10', 'text-accent-amber');
            tabButtons[0].classList.remove('text-zinc-500');
        });
    </script>
    @endpush

    <style>
        .tab-button {
            position: relative;
        }
        .tab-button.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(to right, #F59E0B, #FF6B6B);
        }
    </style>
</x-app-layout>
