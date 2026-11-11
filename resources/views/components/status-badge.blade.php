@props(['status' => 'pending'])

@php
    $classes = match ($status) {
        'pending'  => 'bg-yellow-100 text-yellow-800',
        'approved' => 'bg-blue-100 text-blue-800',
        'selesai'  => 'bg-green-100 text-green-800',
        'rejected' => 'bg-red-100 text-red-800',
        default    => 'bg-slate-100 text-slate-700',
    };
    $label = match ($status) {
        'pending'  => 'Pending',
        'approved' => 'Diproses',
        'selesai'  => 'Selesai',
        'rejected' => 'Rejected',
        default    => ucfirst($status),
    };
@endphp

<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $classes }}">
    {{ $label }}
</span>