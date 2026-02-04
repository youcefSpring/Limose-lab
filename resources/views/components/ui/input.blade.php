@props([
    'label' => null,
    'name' => '',
    'type' => 'text',
    'value' => '',
    'placeholder' => '',
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'min' => null,
    'max' => null,
    'step' => null,
    'help' => null,
])

@php
$rtlClass = app()->getLocale() === 'ar' ? 'text-right' : '';
$baseClasses = 'block w-full py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-indigo/50 focus:border-accent-indigo transition-all';
$errorClasses = $errors->has($name) ? 'border-accent-rose focus:ring-accent-rose/50 focus:border-accent-rose' : '';
$disabledClasses = $disabled ? 'opacity-60 cursor-not-allowed' : '';
$classes = trim("$baseClasses $rtlClass $errorClasses $disabledClasses");

if ($type === 'number') {
    $classes .= ' font-mono';
}
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

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        {{ $readonly ? 'readonly' : '' }}
        {{ $min ? "min=$min" : '' }}
        {{ $max ? "max=$max" : '' }}
        {{ $step ? "step=$step" : '' }}
        {{ $attributes->except(['class', 'label', 'help'])->merge(['class' => $classes]) }}
    />

    @if($help)
        <p class="mt-1.5 text-xs text-zinc-500 dark:text-zinc-400">{{ $help }}</p>
    @endif

    @error($name)
        <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
    @enderror
</div>
