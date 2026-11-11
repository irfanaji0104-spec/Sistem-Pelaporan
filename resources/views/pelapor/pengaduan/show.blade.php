@extends('layouts.pelapor')

@section('title', 'Detail Pengaduan ' . $pengaduan->kode)

@section('content')

       {{-- Tombol Kembali & Breadcrumb --}}
    <div class="mb-5 flex items-center gap-3">
        <a href="{{ route('pelapor.dashboard') }}" 
           class="inline-flex items-center gap-2 px-3 py-1.5 bg-white border border-slate-300 text-slate-600 text-sm font-medium rounded-lg hover:bg-slate-50 transition shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Dashboard
        </a>
        <span class="text-slate-300 text-sm hidden sm:inline">|</span>
        <span class="text-sm text-slate-500 hidden sm:inline">Detail Pengaduan {{ $pengaduan->kode }}</span>
    </div>

    <x-alert type="success" />

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- ================= KOLOM KIRI: DETAIL ================= --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Info Utama --}}
            <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">

                {{-- Header --}}
                <div class="px-6 py-5 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <p class="text-xs uppercase tracking-wider text-slate-500 font-semibold">
                            Pengaduan {{ $pengaduan->kode }}
                        </p>
                        <h2 class="text-lg font-bold text-slate-800 mt-1">
                            {{ $pengaduan->kategori->nama_kategori }} — {{ $pengaduan->lokasi->nama_lokasi }}
                        </h2>
                    </div>
                    <div class="shrink-0">
                        <x-status-badge :status="$pengaduan->status" />
                    </div>
                </div>

                {{-- Info grid --}}
                <div class="px-6 py-5 grid grid-cols-1 sm:grid-cols-2 gap-5 border-b border-slate-100">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Tanggal Pengaduan</p>
                        <p class="text-sm text-slate-800">{{ $pengaduan->created_at->translatedFormat('d F Y, H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Lokasi</p>
                        <p class="text-sm text-slate-800">{{ $pengaduan->lokasi->label_lengkap }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Kategori</p>
                        <p class="text-sm text-slate-800">{{ $pengaduan->kategori->nama_kategori }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Petugas</p>
                        <p class="text-sm text-slate-800">
                            {{ $pengaduan->petugas?->nama ?? 'Belum ditugaskan' }}
                        </p>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="px-6 py-5">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Deskripsi Kerusakan</p>
                    <p class="text-sm text-slate-700 leading-relaxed whitespace-pre-line">{{ $pengaduan->deskripsi }}</p>
                </div>

                {{-- Catatan admin (kalau ada) --}}
                @if ($pengaduan->catatan_admin)
                    <div class="px-6 pb-5">
                        <div class="rounded-lg border border-amber-200 bg-amber-50 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wider text-amber-800 mb-1">Catatan Admin</p>
                            <p class="text-sm text-amber-900 leading-relaxed">{{ $pengaduan->catatan_admin }}</p>
                        </div>
                    </div>
                @endif

                {{-- Tanggal selesai --}}
                @if ($pengaduan->tanggal_selesai)
                    <div class="px-6 pb-5">
                        <div class="rounded-lg border border-green-200 bg-green-50 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wider text-green-800 mb-1">Selesai Pada</p>
                            <p class="text-sm text-green-900">
                                {{ $pengaduan->tanggal_selesai->translatedFormat('d F Y, H:i') }}
                                <span class="text-green-700">· {{ $pengaduan->waktu_selesai }}</span>
                            </p>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Foto Bukti --}}
            <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200">
                    <h3 class="font-semibold text-slate-800">Foto Bukti</h3>
                </div>
                <div class="p-6">
                    @if ($pengaduan->foto_bukti)
                        <a href="{{ asset('storage/'.$pengaduan->foto_bukti) }}" target="_blank" class="block">
                            <img src="{{ asset('storage/'.$pengaduan->foto_bukti) }}"
                                 alt="Foto bukti pengaduan {{ $pengaduan->kode }}"
                                 class="w-full max-h-[400px] object-contain rounded-lg border border-slate-200 hover:opacity-95 transition">
                        </a>
                        <p class="text-xs text-slate-400 mt-2 text-center">Klik gambar untuk melihat ukuran penuh</p>
                    @else
                        <x-empty-state icon="photo" title="Tidak ada foto" />
                    @endif
                </div>
            </div>
        </div>

        {{-- ================= KOLOM KANAN: TIMELINE ================= --}}
        <aside class="lg:col-span-1">
            <div class="bg-white rounded-xl border border-slate-200 overflow-hidden sticky top-20">
                <div class="px-6 py-4 border-b border-slate-200">
                    <h3 class="font-semibold text-slate-800">Riwayat Status</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Timeline perubahan pengaduan</p>
                </div>

                <div class="p-6">
                    @if ($riwayat->isEmpty())
                        <p class="text-sm text-slate-400 text-center py-6">Belum ada riwayat.</p>
                    @else
                        <ol class="relative space-y-5">
                            @foreach ($riwayat as $i => $r)
                                @php
                                    $dotColor = match ($r->status_baru) {
                                        'pending'  => 'bg-yellow-400',
                                        'approved' => 'bg-sky-400',
                                        'selesai'  => 'bg-green-500',
                                        'rejected' => 'bg-red-500',
                                        default    => 'bg-slate-400',
                                    };
                                @endphp
                                <li class="relative pl-7">
                                    {{-- Garis --}}
                                    @if (!$loop->last)
                                        <span class="absolute left-[7px] top-4 bottom-[-20px] w-px bg-slate-200"></span>
                                    @endif

                                    {{-- Dot --}}
                                    <span class="absolute left-0 top-1.5 w-3.5 h-3.5 rounded-full {{ $dotColor }} ring-4 ring-white"></span>

                                    {{-- Konten --}}
                                    <div>
                                        <div class="flex items-center gap-2 mb-1">
                                            <x-status-badge :status="$r->status_baru" />
                                            <span class="text-xs text-slate-400">
                                                {{ $r->created_at->translatedFormat('d M Y, H:i') }}
                                            </span>
                                        </div>
                                        @if ($r->keterangan)
                                            <p class="text-sm text-slate-700 leading-relaxed">{{ $r->keterangan }}</p>
                                        @endif
                                        <p class="text-xs text-slate-400 mt-1">oleh {{ $r->user?->name ?? 'Sistem' }}</p>
                                    </div>
                                </li>
                            @endforeach
                        </ol>
                    @endif
                </div>
            </div>
        </aside>

    </div>

@endsection