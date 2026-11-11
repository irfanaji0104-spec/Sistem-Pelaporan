@extends('layouts.admin')

@section('title', 'Detail Pengaduan ' . $pengaduan->kode)

@section('content')

    <div class="mb-5">
        <a href="{{ route('admin.verifikasi') }}" class="inline-flex items-center gap-1 text-sm text-slate-500 hover:text-slate-700 mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Daftar
        </a>
        <div class="flex items-center gap-3">
            <h2 class="text-xl lg:text-2xl font-bold text-slate-800">Detail Pengaduan {{ $pengaduan->kode }}</h2>
            <x-status-badge :status="$pengaduan->status" />
        </div>
    </div>

    <x-alert type="success" />
    <x-alert type="error" />

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- KIRI: DETAIL DATA --}}
        <div class="lg:col-span-2 space-y-5">
            
            <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-200 grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Pelapor</p>
                        <p class="text-sm text-slate-800 font-medium">{{ $pengaduan->user->name }} ({{ ucfirst($pengaduan->user->role) }})</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Tanggal Lapor</p>
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
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Petugas (Jika ada)</p>
                        <p class="text-sm text-slate-800">{{ $pengaduan->petugas?->nama ?? '-' }}</p>
                    </div>
                </div>

                <div class="px-6 py-5">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Deskripsi Kerusakan</p>
                    <p class="text-sm text-slate-700 leading-relaxed whitespace-pre-line">{{ $pengaduan->deskripsi }}</p>
                </div>

                @if ($pengaduan->foto_bukti)
                    <div class="px-6 pb-6">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Foto Bukti</p>
                        <a href="{{ asset('storage/'.$pengaduan->foto_bukti) }}" target="_blank">
                            <img src="{{ asset('storage/'.$pengaduan->foto_bukti) }}" class="w-full max-h-80 object-contain rounded-lg border border-slate-200" alt="Foto Bukti">
                        </a>
                    </div>
                @endif
            </div>

            {{-- FORM AKSI (Dinamis sesuai status) --}}
            @if ($pengaduan->status === 'pending')
                <div class="bg-white rounded-xl border border-slate-200 p-6">
                    <h3 class="font-semibold text-slate-800 mb-4">Verifikasi Pengaduan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        {{-- Form Approve --}}
                        <form method="POST" action="{{ route('admin.verifikasi.approve', $pengaduan) }}" class="space-y-4 p-4 border border-green-200 rounded-lg bg-green-50/50">
                            @csrf
                            <h4 class="font-medium text-green-800">Terima Pengaduan</h4>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Pilih Petugas</label>
                                <select name="petugas_id" required class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 bg-white outline-none">
                                    <option value="">-- Pilih Petugas --</option>
                                    @foreach ($petugas as $pt)
                                        <option value="{{ $pt->id }}">{{ $pt->nama }} ({{ $pt->spesialisasi }})</option>
                                    @endforeach
                                </select>
                                @error('petugas_id') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition">
                                SETUJUI & TUGASKAN
                            </button>
                        </form>

                        {{-- Form Reject --}}
                        <form method="POST" action="{{ route('admin.verifikasi.reject', $pengaduan) }}" class="space-y-4 p-4 border border-red-200 rounded-lg bg-red-50/50">
                            @csrf
                            <h4 class="font-medium text-red-800">Tolak Pengaduan</h4>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Alasan Penolakan</label>
                                <textarea name="catatan_admin" rows="3" required placeholder="Berikan alasan yang jelas..." class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 bg-white outline-none"></textarea>
                                @error('catatan_admin') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition">
                                TOLAK PENGADUAN
                            </button>
                        </form>

                    </div>
                </div>
            @elseif ($pengaduan->status === 'approved')
                <div class="bg-white rounded-xl border border-slate-200 p-6 space-y-6">
                    <h3 class="font-semibold text-slate-800">Aksi Lanjutan (Diproses)</h3>
                    
                    {{-- Form Progress --}}
                    <form method="POST" action="{{ route('admin.verifikasi.progress', $pengaduan) }}" class="space-y-3 p-4 border border-blue-200 rounded-lg bg-blue-50/50">
                        @csrf
                        <h4 class="font-medium text-blue-800">Tambah Catatan Progres</h4>
                        <textarea name="keterangan" rows="2" required placeholder="Contoh: Suku cadang sudah dipesan, estimasi selesai 2 hari..." class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 bg-white outline-none"></textarea>
                        @error('keterangan') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition">
                            SIMPAN PROGRES
                        </button>
                    </form>

                    {{-- Form Complete --}}
                    <form method="POST" action="{{ route('admin.verifikasi.complete', $pengaduan) }}" class="space-y-3 p-4 border border-green-200 rounded-lg bg-green-50/50">
                        @csrf
                        <h4 class="font-medium text-green-800">Tandai Selesai</h4>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Selesai</label>
                            <input type="datetime-local" name="tanggal_selesai" required value="{{ now()->format('Y-m-d\TH:i') }}" class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 bg-white outline-none">
                            @error('tanggal_selesai') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Catatan (Opsional)</label>
                            <input type="text" name="keterangan" placeholder="Contoh: Lampu sudah diganti baru." class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 bg-white outline-none">
                        </div>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white text-sm font-semibold rounded-lg hover:bg-green-700 transition">
                            TANDAI SELESAI
                        </button>
                    </form>
                </div>
            @endif

        </div>

        {{-- KANAN: TIMELINE RIWAYAT --}}
        <aside class="lg:col-span-1">
            <div class="bg-white rounded-xl border border-slate-200 overflow-hidden sticky top-20">
                <div class="px-6 py-4 border-b border-slate-200">
                    <h3 class="font-semibold text-slate-800">Riwayat & Timeline</h3>
                </div>
                <div class="p-6">
                    <ol class="relative space-y-5">
                        @foreach ($riwayat as $r)
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
                                @if (!$loop->last)
                                    <span class="absolute left-[7px] top-4 bottom-[-20px] w-px bg-slate-200"></span>
                                @endif
                                <span class="absolute left-0 top-1.5 w-3.5 h-3.5 rounded-full {{ $dotColor }} ring-4 ring-white"></span>
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <x-status-badge :status="$r->status_baru" />
                                        <span class="text-xs text-slate-400">{{ $r->created_at->format('d/m/y H:i') }}</span>
                                    </div>
                                    @if ($r->keterangan)
                                        <p class="text-sm text-slate-700 leading-relaxed">{{ $r->keterangan }}</p>
                                    @endif
                                    <p class="text-xs text-slate-400 mt-1">oleh {{ $r->user?->nama ?? 'Sistem' }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </aside>

    </div>

@endsection