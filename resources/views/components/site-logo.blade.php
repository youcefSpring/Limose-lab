@props(['class' => ''])

@php
    $settings = \App\Models\Setting::getAllSettings();
    $logoUrl = $settings['primary_logo'] ?? null;
@endphp

@if($logoUrl && file_exists(public_path('storage/' . $logoUrl)))
    <img 
        src="{{ asset('storage/' . $logoUrl) }}" 
        alt="{{ $settings['site_name'] ?? config('app.name', 'RLMS') }}"
        {{ $attributes->merge(['class' => $class]) }}
    >
@else
    <x-application-logo {{ $attributes->merge(['class' => $class]) }} />
@endif