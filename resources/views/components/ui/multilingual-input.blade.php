@props([
    'label' => null,
    'name', // Base name (e.g., 'title')
    'type' => 'text', // 'text' or 'textarea'
    'required' => false,
    'rows' => 3,
    'values' => [], // ['en' => 'English value', 'fr' => 'French value', 'ar' => 'Arabic value']
    'errors' => [], // ['en' => 'Error message', 'fr' => 'Error message', 'ar' => 'Error message']
    'hints' => [], // ['en' => 'Hint message', ...]
])

@php
$tabs = [
    ['id' => 'en', 'label' => __('English'), 'icon' => '🇬🇧'],
    ['id' => 'fr', 'label' => __('French'), 'icon' => '🇫🇷'],
    ['id' => 'ar', 'label' => __('Arabic'), 'icon' => '🇸🇦'],
];

$enValue = $values['en'] ?? old($name);
$frValue = $values['fr'] ?? old($name . '_fr');
$arValue = $values['ar'] ?? old($name . '_ar');

$enError = $errors['en'] ?? null;
$frError = $errors['fr'] ?? null;
$arError = $errors['ar'] ?? null;
@endphp

<div class="space-y-2">
    @if($label)
        <label class="block text-sm font-medium">
            {{ $label }}
            @if($required)
                <span class="text-accent-rose">*</span>
            @endif
        </label>
    @endif

    <x-ui.tabs :tabs="$tabs" active-tab="en">
        <!-- English Panel -->
        <x-ui.tab-panel id="en">
            @if($type === 'textarea')
                <textarea
                    name="{{ $name }}"
                    id="{{ $name }}"
                    rows="{{ $rows }}"
                    {{ $required ? 'required' : '' }}
                    class="block w-full px-4 py-2.5 bg-white dark:bg-surface-700/50 border {{ $enError ? 'border-accent-rose' : 'border-black/10 dark:border-white/10' }} rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-indigo/50 focus:border-accent-indigo transition-all resize-none"
                    placeholder="{{ __('Enter') }} {{ strtolower($label ?? $name) }} {{ __('in English') }}"
                >{{ $enValue }}</textarea>
            @else
                <input
                    type="{{ $type }}"
                    name="{{ $name }}"
                    id="{{ $name }}"
                    value="{{ $enValue }}"
                    {{ $required ? 'required' : '' }}
                    class="block w-full px-4 py-2.5 bg-white dark:bg-surface-700/50 border {{ $enError ? 'border-accent-rose' : 'border-black/10 dark:border-white/10' }} rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-indigo/50 focus:border-accent-indigo transition-all"
                    placeholder="{{ __('Enter') }} {{ strtolower($label ?? $name) }} {{ __('in English') }}"
                />
            @endif
            @if($enError)
                <p class="mt-2 text-xs text-accent-rose">{{ $enError }}</p>
            @endif
            @if(isset($hints['en']))
                <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400">{{ $hints['en'] }}</p>
            @endif
        </x-ui.tab-panel>

        <!-- French Panel -->
        <x-ui.tab-panel id="fr">
            @if($type === 'textarea')
                <textarea
                    name="{{ $name }}_fr"
                    id="{{ $name }}_fr"
                    rows="{{ $rows }}"
                    class="block w-full px-4 py-2.5 bg-white dark:bg-surface-700/50 border {{ $frError ? 'border-accent-rose' : 'border-black/10 dark:border-white/10' }} rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-indigo/50 focus:border-accent-indigo transition-all resize-none"
                    placeholder="{{ __('Enter') }} {{ strtolower($label ?? $name) }} {{ __('in French') }}"
                >{{ $frValue }}</textarea>
            @else
                <input
                    type="{{ $type }}"
                    name="{{ $name }}_fr"
                    id="{{ $name }}_fr"
                    value="{{ $frValue }}"
                    class="block w-full px-4 py-2.5 bg-white dark:bg-surface-700/50 border {{ $frError ? 'border-accent-rose' : 'border-black/10 dark:border-white/10' }} rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-indigo/50 focus:border-accent-indigo transition-all"
                    placeholder="{{ __('Enter') }} {{ strtolower($label ?? $name) }} {{ __('in French') }}"
                />
            @endif
            @if($frError)
                <p class="mt-2 text-xs text-accent-rose">{{ $frError }}</p>
            @endif
            @if(isset($hints['fr']))
                <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400">{{ $hints['fr'] }}</p>
            @endif
        </x-ui.tab-panel>

        <!-- Arabic Panel -->
        <x-ui.tab-panel id="ar">
            @if($type === 'textarea')
                <textarea
                    name="{{ $name }}_ar"
                    id="{{ $name }}_ar"
                    rows="{{ $rows }}"
                    dir="rtl"
                    class="block w-full px-4 py-2.5 bg-white dark:bg-surface-700/50 border {{ $arError ? 'border-accent-rose' : 'border-black/10 dark:border-white/10' }} rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-indigo/50 focus:border-accent-indigo transition-all resize-none text-right"
                    placeholder="{{ __('Enter') }} {{ strtolower($label ?? $name) }} {{ __('in Arabic') }}"
                >{{ $arValue }}</textarea>
            @else
                <input
                    type="{{ $type }}"
                    name="{{ $name }}_ar"
                    id="{{ $name }}_ar"
                    value="{{ $arValue }}"
                    dir="rtl"
                    class="block w-full px-4 py-2.5 bg-white dark:bg-surface-700/50 border {{ $arError ? 'border-accent-rose' : 'border-black/10 dark:border-white/10' }} rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-indigo/50 focus:border-accent-indigo transition-all text-right"
                    placeholder="{{ __('Enter') }} {{ strtolower($label ?? $name) }} {{ __('in Arabic') }}"
                />
            @endif
            @if($arError)
                <p class="mt-2 text-xs text-accent-rose">{{ $arError }}</p>
            @endif
            @if(isset($hints['ar']))
                <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400">{{ $hints['ar'] }}</p>
            @endif
        </x-ui.tab-panel>
    </x-ui.tabs>
</div>
