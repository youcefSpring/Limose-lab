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
            <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">{{ __('Supported: JPG, PNG. Max: 2MB') }}</p>
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
            <span class="text-sm text-zinc-600 dark:text-zinc-400">{{ __('Enable') }}</span>
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