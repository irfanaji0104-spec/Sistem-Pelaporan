@props(['role' => 'siswa'])

@php
    $classes = match ($role) {
        'siswa' => 'bg-sky-100 text-sky-800',
        'guru'  => 'bg-purple-100 text-purple-800',
        'admin' => 'bg-yellow-100 text-yellow-800',
        default => 'bg-slate-100 text-slate-700',
    };
@endphp

<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $classes }}">
    {{ ucfirst($role) }}
</span>