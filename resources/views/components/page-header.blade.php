@props(['title', 'subtitle' => null, 'backUrl' => null])

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
    <div>
        @if ($backUrl)
            <a href="{{ $backUrl }}" class="inline-flex items-center gap-1 text-sm text-slate-500 hover:text-slate-700 mb-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali
            </a>
        @endif
        <h2 class="text-xl lg:text-2xl font-bold text-slate-800">{{ $title }}</h2>
        @if ($subtitle)
            <p class="text-sm text-slate-500 mt-1">{{ $subtitle }}</p>
        @endif
    </div>

    @if (isset($action))
        <div class="shrink-0">{{ $action }}</div>
    @endif
</div>