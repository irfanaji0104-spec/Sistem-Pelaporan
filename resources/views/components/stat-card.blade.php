@props([
    'label' => '',
    'value' => 0,
    'color' => 'blue',   // blue-dark, orange, blue-light, green
])

@php
    $accent = match ($color) {
        'blue-dark'  => 'border-l-[#1e3a8a]',
        'orange'     => 'border-l-orange-400',
        'blue-light' => 'border-l-sky-400',
        'green'      => 'border-l-green-500',
        default      => 'border-l-slate-400',
    };
@endphp

<div class="bg-white rounded-lg border border-slate-200 border-l-4 {{ $accent }} px-5 py-4 shadow-sm">
    <p class="text-xs font-medium text-slate-500 mb-1">{{ $label }}</p>
    <p class="text-2xl lg:text-3xl font-bold text-slate-800">{{ $value }}</p>
</div>