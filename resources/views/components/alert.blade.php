@props(['type' => 'success', 'message' => null])

@php
    $classes = match ($type) {
        'success' => 'bg-green-50 border-green-200 text-green-800',
        'error'   => 'bg-red-50 border-red-200 text-red-800',
        'warning' => 'bg-yellow-50 border-yellow-200 text-yellow-800',
        'info'    => 'bg-blue-50 border-blue-200 text-blue-800',
        default   => 'bg-slate-50 border-slate-200 text-slate-800',
    };
    $text = $message ?? session($type);
@endphp

@if ($text)
    <div class="mb-4 rounded-lg border px-4 py-3 text-sm {{ $classes }}">
        {{ $text }}
    </div>
@endif