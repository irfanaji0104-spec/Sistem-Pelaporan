<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Pengaduan Sarana Sekolah')</title>

    {{-- FAVICON --}}
<link rel="icon" type="image/jpeg" href="{{ asset('asset/favicon.jpeg') }}">
    {{-- Font Inter dari Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50">

<div class="min-h-screen flex flex-col lg:flex-row">

    {{-- ==================== KIRI: BRANDING ==================== --}}
    <div class="lg:w-1/2 bg-[#1e3a8a] text-white flex flex-col justify-center items-center px-8 py-12 lg:py-0">
        <div class="max-w-md text-center">
            {{-- Ikon Kotak SPSS --}}
            <div class="mx-auto w-28 h-28 bg-white/10 backdrop-blur rounded-2xl border border-white/20 flex items-center justify-center mb-8">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-14 h-14 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>

            <h1 class="text-2xl lg:text-3xl font-bold leading-tight mb-3">
                Sistem Pengaduan<br>Sarana Sekolah
            </h1>

            <p class="text-sm lg:text-base text-blue-100 font-medium mb-4">
                SMK Negeri 5 Surakarta
            </p>

            <p class="text-sm text-blue-200 leading-relaxed">
                Platform digital untuk melaporkan kerusakan sarana dan prasarana sekolah secara cepat dan terstruktur.
            </p>
        </div>
    </div>

    {{-- ==================== KANAN: FORM ==================== --}}
    <div class="lg:w-1/2 flex items-center justify-center px-4 py-10 lg:py-0 bg-slate-50">
        <div class="w-full max-w-md">
            @yield('content')
        </div>
    </div>

</div>

@stack('scripts')
</body>
</html>