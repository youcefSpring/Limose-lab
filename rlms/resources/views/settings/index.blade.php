<x-app-layout>
    <!-- Header -->
    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 lg:mb-8">
        <div>
            <h1 class="text-xl sm:text-2xl font-semibold">{{ __('Settings') }}</h1>
            <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ __('Manage website settings and frontend content') }}</p>
        </div>
    </header>

    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @foreach($settings as $group => $groupSettings)
            <div class="glass-card rounded-2xl p-5 lg:p-6 mb-6">
                <h2 class="text-lg font-semibold mb-4 capitalize">{{ __(str_replace('_', ' ', $group)) }}</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($groupSettings as $setting)
                        <div class="{{ $setting->type === 'textarea' ? 'md:col-span-2' : '' }}">
                            <label for="{{ $setting->key }}" class="block text-sm font-medium mb-2">
                                {{ __(ucfirst(str_replace('_', ' ', $setting->key))) }}
                            </label>

                            @if($setting->type === 'text')
                                <input
                                    type="text"
                                    id="{{ $setting->key }}"
                                    name="settings[{{ $setting->key }}]"
                                    value="{{ $setting->value }}"
                                    class="w-full px-4 py-2.5 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all"
                                >

                            @elseif($setting->type === 'textarea')
                                <textarea
                                    id="{{ $setting->key }}"
                                    name="settings[{{ $setting->key }}]"
                                    rows="4"
                                    class="w-full px-4 py-2.5 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all"
                                >{{ $setting->value }}</textarea>

                            @elseif($setting->type === 'image')
                                <div>
                                    @if($setting->value)
                                        <div class="mb-3">
                                            <img src="{{ asset('storage/' . $setting->value) }}"
                                                 alt="{{ $setting->key }}"
                                                 class="h-32 w-auto rounded-lg border border-black/10 dark:border-white/10"
                                                 onerror="this.src='/images/default-logo.png'">
                                        </div>
                                    @endif
                                    <input
                                        type="file"
                                        id="{{ $setting->key }}"
                                        name="settings[{{ $setting->key }}]"
                                        accept="image/*"
                                        class="w-full px-4 py-2.5 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all"
                                    >
                                    <input type="hidden" name="settings[{{ $setting->key }}]" value="{{ $setting->value }}">
                                </div>
                            @endif

                            @error('settings.' . $setting->key)
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <!-- Save Button -->
        <div class="flex justify-end gap-3">
            <button type="submit" class="flex items-center gap-2 bg-gradient-to-r from-accent-amber to-accent-coral px-6 py-3 rounded-xl font-medium text-white hover:opacity-90 transition-opacity">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                {{ __('Save Settings') }}
            </button>
        </div>
    </form>
</x-app-layout>
