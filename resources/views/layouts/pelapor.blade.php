<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Sistem Pengaduan Sarana Sekolah</title>

    {{-- FAVICON --}}
<link rel="icon" type="image/jpeg" href="{{ asset('asset/favicon.jpeg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-800 min-h-screen flex flex-col">

    {{-- HEADER --}}
    <header class="sticky top-0 z-10 bg-slate-900 text-white px-4 lg:px-6 py-3 flex items-center justify-between shadow-md">
        <h1 class="font-semibold text-sm lg:text-base">Sistem Pengaduan Sarana Sekolah - Dashboard Pelapor</h1>
        <div class="flex items-center gap-2">
            <x-notification-bell />
            <x-user-dropdown />
        </div>
    </header>

    {{-- KONTEN --}}
    <main class="flex-1 max-w-6xl w-full mx-auto p-4 lg:p-6">
        @yield('content')
    </main>

@stack('scripts')
</body>
</html>