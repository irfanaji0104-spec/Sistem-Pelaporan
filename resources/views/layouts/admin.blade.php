<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - Sistem Pengaduan Sarana Sekolah</title>

    {{-- FAVICON (Pastikan lu udah naruh file favicon.jpeg di folder public) --}}
<link rel="icon" type="image/jpeg" href="{{ asset('asset/favicon.jpeg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-800">

<div x-data="{ sidebarOpen: false }" class="min-h-screen">

    {{-- ==================== SIDEBAR ==================== --}}
    {{-- Pakai fixed, h-screen, dan flex-col biar bisa di-scroll internal tanpa ganggu konten --}}
    <aside
        class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 text-slate-300 transform transition-transform duration-200 lg:translate-x-0 flex flex-col h-screen"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    >
        {{-- Branding --}}
        <div class="px-5 py-5 border-b border-slate-800 shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-blue-800 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div class="leading-tight">
                    <p class="text-white font-bold text-sm">Sistem Pengaduan</p>
                    <p class="text-xs text-slate-400">Sarana Sekolah</p>
                </div>
            </div>
        </div>

        {{-- Menu (Bisa di-scroll sendiri kalau layar kecil) --}}
        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
            @php
                $items = [
                    ['route' => 'admin.dashboard',  'label' => 'Dashboard',             'icon' => 'home'],
                    ['route' => 'admin.data-master', 'label' => 'Data Master',           'icon' => 'folder'],
                    ['route' => 'admin.verifikasi', 'label' => 'Verifikasi Pengaduan',  'icon' => 'check'],
                    ['route' => 'admin.petugas',    'label' => 'Data Petugas',          'icon' => 'users'],
                    ['route' => 'admin.laporan',    'label' => 'Laporan',               'icon' => 'chart'],
                    ['route' => 'admin.pengaturan', 'label' => 'Pengaturan Akun',       'icon' => 'cog'],
                ];
            @endphp

            @foreach ($items as $item)
                @php
                    $active = request()->routeIs($item['route'].'*');
                    $href = \Illuminate\Support\Facades\Route::has($item['route']) ? route($item['route']) : '#';
                @endphp
                <a href="{{ $href }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                          {{ $active ? 'bg-blue-800 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        @switch($item['icon'])
                            @case('home')
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h3a1 1 0 001-1V10"/>
                                @break
                            @case('folder')
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7a2 2 0 012-2h4l2 2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V7z"/>
                                @break
                            @case('check')
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                @break
                            @case('users')
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M16 3.13a4 4 0 010 7.75M12 14a4 4 0 100-8 4 4 0 000 8z"/>
                                @break
                            @case('chart')
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                @break
                            @case('cog')
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                @break
                        @endswitch
                    </svg>
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>

        {{-- Logout (Nempel di bawah) --}}
        <div class="p-3 border-t border-slate-800 shrink-0">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-red-400 hover:bg-red-900/20 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- Overlay untuk mobile --}}
    <div x-show="sidebarOpen" @click="sidebarOpen = false"
         class="fixed inset-0 bg-black/50 z-40 lg:hidden" x-cloak></div>

    {{-- ==================== KONTEN UTAMA ==================== --}}
    {{-- Gunakan lg:pl-64 agar konten bergeser ke kanan (nggak ketutupan sidebar fixed) --}}
    <div class="flex flex-col min-h-screen lg:pl-64">

        {{-- HEADER --}}
        <header class="sticky top-0 z-30 bg-slate-900 text-white px-4 lg:px-6 py-3 flex items-center justify-between shadow-md">
            <div class="flex items-center gap-3">
                {{-- Hamburger (mobile) --}}
                <button @click="sidebarOpen = !sidebarOpen"
                        class="lg:hidden p-2 rounded-lg hover:bg-slate-800 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <h1 class="font-semibold text-sm lg:text-base">Sistem Pengaduan Sarana Sekolah</h1>
            </div>

            <div class="flex items-center gap-2">
                <x-notification-bell />
                <x-user-dropdown />
            </div>
        </header>

        {{-- KONTEN --}}
        <main class="flex-1 p-4 lg:p-6">
            @yield('content')
        </main>
    </div>
</div>

@stack('scripts')
</body>
</html>