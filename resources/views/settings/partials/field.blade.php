@php
    $locales = ['en' => 'English', 'fr' => 'French', 'ar' => 'العربية'];
    $currentLocale = app()->getLocale();
    $isMultilingual = !empty($setting->is_multilingual);
@endphp

@if(!$isMultilingual || in_array($setting->type, ['image', 'color', 'boolean', 'select']))
    @switch($setting->type)
        @case('text')
            <input type="text" id="{{ $setting->key }}" name="settings[{{ $setting->key }}]" value="{{ $setting->value }}" class="w-full px-4 py-2.5 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all">
            @break

        @case('textarea')
            <textarea id="{{ $setting->key }}" name="settings[{{ $setting->key }}]" rows="4" class="w-full px-4 py-2.5 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all resize-y">{{ $setting->value }}</textarea>
            @break

        @case('image')
            <div>
                @if($setting->value)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $setting->value) }}" alt="{{ $setting->key }}" class="h-32 w-auto rounded-lg border border-black/10 dark:border-white/10" onerror="this.style.display='none'">
                    </div>
                @endif
                <input type="file" id="{{ $setting->key }}" name="settings[{{ $setting->key }}]" accept="image/*" class="w-full px-4 py-2.5 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-accent-amber/10 file:text-accent-amber hover:file:bg-accent-amber/20 file:cursor-pointer">
                <input type="hidden" name="settings[{{ $setting->key }}]" value="{{ $setting->value }}">
                <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">{{ __('messages.Supported: JPG, PNG. Max: 2MB') }}</p>
            </div>
            @break

        @case('color')
            <div class="flex items-center gap-3">
                <input type="color" id="{{ $setting->key }}" name="settings[{{ $setting->key }}]" value="{{ $setting->value ?? '#8C1515' }}" class="h-12 w-20 rounded-lg border border-black/10 dark:border-white/10 cursor-pointer">
                <input type="text" value="{{ $setting->value ?? '#8C1515' }}" readonly class="flex-1 px-4 py-2.5 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl font-mono text-sm">
            </div>
            @break

        @case('boolean')
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" id="{{ $setting->key }}" name="settings[{{ $setting->key }}]" value="1" {{ $setting->value ? 'checked' : '' }} class="w-5 h-5 text-accent-amber bg-white dark:bg-surface-700/50 border-black/10 dark:border-white/10 rounded focus:ring-2 focus:ring-accent-amber/50">
                <span class="text-sm text-zinc-600 dark:text-zinc-400">{{ __('messages.Enable') }}</span>
            </label>
            @break

        @case('select')
            <select id="{{ $setting->key }}" name="settings[{{ $setting->key }}]" class="w-full px-4 py-2.5 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all">
                @foreach(explode(',', $setting->options ?? '') as $option)
                    <option value="{{ trim($option) }}" {{ trim($option) === $setting->value ? 'selected' : '' }}>{{ trim($option) }}</option>
                @endforeach
            </select>
            @break

        @default
            <input type="text" id="{{ $setting->key }}" name="settings[{{ $setting->key }}]" value="{{ $setting->value }}" class="w-full px-4 py-2.5 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all">
    @endswitch

@else
    <div class="mb-2 p-1 bg-black/5 dark:bg-white/5 rounded-lg flex gap-1">
        @foreach($locales as $code => $label)
            <button type="button" onclick="showLangField('{{ $setting->key }}', '{{ $code }}')" id="btn_{{ $setting->key }}_{{ $code }}" class="flex-1 px-3 py-1.5 rounded-md text-xs font-medium bg-white dark:bg-surface-700 shadow">
                {{ $label }}
            </button>
        @endforeach
    </div>

    @foreach($locales as $code => $label)
        <div id="field_{{ $setting->key }}_{{ $code }}" class="{{ $loop->first ? '' : 'hidden' }}">
            @if($setting->type === 'textarea')
                <textarea id="{{ $setting->key }}_{{ $code }}" name="settings[{{ $setting->key }}_{{ $code }}]" rows="4" class="w-full px-4 py-2.5 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all resize-y" placeholder="{{ $label }}">{{ $setting->value }}</textarea>
            @else
                <input type="text" id="{{ $setting->key }}_{{ $code }}" name="settings[{{ $setting->key }}_{{ $code }}]" value="{{ $setting->value }}" class="w-full px-4 py-2.5 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all" placeholder="{{ $label }}">
            @endif
        </div>
    @endforeach

    <script>
        function showLangField(key, lang) {
            var locales = ['en', 'fr', 'ar'];
            locales.forEach(function(l) {
                var field = document.getElementById('field_' + key + '_' + l);
                var btn = document.getElementById('btn_' + key + '_' + l);
                if (field) {
                    field.classList.add('hidden');
                }
                if (btn) {
                    btn.classList.remove('bg-accent-amber', 'text-white');
                    btn.classList.add('bg-white', 'dark:bg-surface-700');
                }
            });
            var selectedField = document.getElementById('field_' + key + '_' + lang);
            var selectedBtn = document.getElementById('btn_' + key + '_' + lang);
            if (selectedField) selectedField.classList.remove('hidden');
            if (selectedBtn) {
                selectedBtn.classList.add('bg-accent-amber', 'text-white');
                selectedBtn.classList.remove('bg-white', 'dark:bg-surface-700');
            }
        }
        window.addEventListener('DOMContentLoaded', function() {
            var keys = ['hero_title', 'hero_subtitle', 'lab_name', 'lab_description', 'lab_mission', 'lab_vision'];
            keys.forEach(function(key) {
                if (document.getElementById('field_' + key + '_en')) {
                    showLangField(key, 'en');
                }
            });
        });
    </script>
@endif