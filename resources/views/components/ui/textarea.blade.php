@props([
    'label' => null,
    'name' => '',
    'value' => '',
    'placeholder' => '',
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'rows' => 4,
    'help' => null,
])

@php
$rtlClass = app()->getLocale() === 'ar' ? 'text-right' : '';
$baseClasses = 'block w-full py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-indigo/50 focus:border-accent-indigo transition-all resize-none';
$errorClasses = $errors->has($name) ? 'border-accent-rose focus:ring-accent-rose/50 focus:border-accent-rose' : '';
$disabledClasses = $disabled ? 'opacity-60 cursor-not-allowed' : '';
$classes = trim("$baseClasses $rtlClass $errorClasses $disabledClasses");
@endphp

<div {{ $attributes->only('class') }}>
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium mb-2">
            {{ $label }}
            @if($required)
                <span class="text-accent-rose">*</span>
            @endif
        </label>
    @endif

    <textarea
        name="{{ $name }}"
        id="{{ $name }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        {{ $readonly ? 'readonly' : '' }}
        {{ $attributes->except(['class', 'label', 'help', 'rows'])->merge(['class' => $classes]) }}
    >{{ old($name, $value) }}</textarea>

    @if($help)
        <p class="mt-1.5 text-xs text-zinc-500 dark:text-zinc-400">{{ $help }}</p>
    @endif

    @error($name)
        <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
    @enderror
</div>
