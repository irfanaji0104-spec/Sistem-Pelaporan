@extends('layouts.pelapor')

@section('title', 'Dashboard')

@section('content')

    @php
        $user = auth()->user();
        $firstName = explode(' ', trim($user->name))[0];
    @endphp

    {{-- BUNGKUS DENGAN MAX-WIDTH AGAR RAPI DI TENGAH --}}
    <div class="max-w-5xl mx-auto space-y-6">

        {{-- ==================== WELCOME BANNER (FIXED BACKGROUND) ==================== --}}
        {{-- Menggunakan inline-style agar warna 100% muncul tanpa perlu npm run dev --}}
        <div class="relative rounded-2xl p-6 sm:p-8 text-white shadow-md overflow-hidden flex flex-col sm:flex-row sm:items-center justify-between gap-6"
             style="background: linear-gradient(to right, #1e3a8a, #2563eb);">
            
            {{-- Dekorasi Background --}}
            <div class="absolute -right-10 -top-10 w-48 h-48 bg-white/10 rounded-full pointer-events-none" style="filter: blur(40px);"></div>
            <div class="absolute right-32 -bottom-12 w-32 h-32 bg-white/10 rounded-full pointer-events-none" style="filter: blur(24px);"></div>

            <div class="relative z-10">
                <h2 class="text-2xl lg:text-3xl font-bold mb-2 text-white">Halo, {{ $firstName }}! 👋</h2>
                <p class="text-blue-100 text-sm sm:text-base max-w-lg leading-relaxed">
                    Selamat datang di Dashboard Pelapor. Pantau terus status pengaduan sarana yang kamu ajukan atau laporkan kerusakan baru di sini.
                </p>
            </div>
            
            <div class="relative z-10 shrink-0">
                <a href="{{ route('pelapor.pengaduan.create') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 bg-white text-[#1e3a8a] text-sm font-bold rounded-xl hover:bg-blue-50 transition-all duration-200 shadow-sm"
                   style="color: #1e3a8a;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    AJUKAN PENGADUAN
                </a>
            </div>
        </div>

        <x-alert type="success" />

        {{-- ==================== STAT CARDS ==================== --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
            <x-stat-card label="Pending" :value="$stats['pending']" color="orange" />
            <x-stat-card label="Sedang Diproses" :value="$stats['approved']" color="blue-light" />
            <x-stat-card label="Selesai" :value="$stats['selesai']" color="green" />
        </div>

        {{-- ==================== RIWAYAT PENGADUAN ==================== --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mt-4">
            
            <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-lg">Riwayat Pengaduan Saya</h3>
            </div>

            @if ($riwayat->isEmpty())
                <div class="py-12">
                    <x-empty-state
                        title="Belum ada pengaduan"
                        message="Kamu belum pernah mengajukan pengaduan. Klik tombol di atas untuk membuat pengaduan baru."
                    />
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="border-b border-slate-200 bg-slate-50">
                                <th class="text-xs font-semibold uppercase tracking-wider text-slate-500 py-4 px-6 w-36">Tanggal</th>
                                <th class="text-xs font-semibold uppercase tracking-wider text-slate-500 py-4 px-6">Lokasi</th>
                                <th class="text-xs font-semibold uppercase tracking-wider text-slate-500 py-4 px-6">Kategori</th>
                                <th class="text-xs font-semibold uppercase tracking-wider text-slate-500 py-4 px-6 w-32">Status</th>
                                <th class="text-right text-xs font-semibold uppercase tracking-wider text-slate-500 py-4 px-6 w-24">Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($riwayat as $p)
                                <tr class="border-b border-slate-100 last:border-b-0 hover:bg-slate-50 transition">
                                    <td class="py-4 px-6 text-slate-600 whitespace-nowrap font-medium">
                                        {{ $p->created_at->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="py-4 px-6">
                                        <a href="{{ route('pelapor.pengaduan.show', $p) }}"
                                           class="text-[#1e3a8a] hover:underline font-semibold block">
                                            {{ $p->lokasi->nama_lokasi }}
                                        </a>
                                    </td>
                                    <td class="py-4 px-6 text-slate-600">{{ $p->kategori->nama_kategori }}</td>
                                    <td class="py-4 px-6"><x-status-badge :status="$p->status" /></td>
                                    <td class="py-4 px-6 text-right whitespace-nowrap">
                                        <a href="{{ route('pelapor.pengaduan.show', $p) }}"
                                           class="inline-flex items-center gap-1 text-[#1e3a8a] hover:text-blue-800 text-sm font-semibold transition">
                                            Lihat &rsaquo;
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/30">
                    {{ $riwayat->links() }}
                </div>
            @endif
        </div>

    </div>

@endsection