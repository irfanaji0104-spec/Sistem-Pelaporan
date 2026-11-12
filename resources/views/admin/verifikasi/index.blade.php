@extends('layouts.admin')

@section('title', 'Verifikasi Pengaduan')

@section('content')

    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-6">
        <div>
            <h2 class="text-xl lg:text-2xl font-bold text-slate-800">Data Pengaduan Masuk</h2>
            <p class="text-sm text-slate-500 mt-1">Kelola dan verifikasi pengaduan dari siswa & guru</p>
        </div>
        {{-- TOMBOL EXPORT DIHAPUS DARI SINI --}}
    </div>

    <x-alert type="success" />

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <div class="p-5 border-b border-slate-200 flex flex-col sm:flex-row gap-3">
            <form method="GET" class="flex-1 max-w-sm flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari nama pelapor / lokasi..."
                       class="w-full px-4 py-2 text-sm rounded-lg border border-slate-300 bg-white focus:border-[#1e3a8a] focus:ring-2 focus:ring-blue-100 outline-none transition">
                <select name="status" class="px-4 py-2 text-sm rounded-lg border border-slate-300 bg-white focus:border-[#1e3a8a] outline-none transition">
                    <option value="">Semua Status</option>
                    <option value="pending" @selected(request('status') == 'pending')>Pending</option>
                    <option value="approved" @selected(request('status') == 'approved')>Diproses</option>
                    <option value="selesai" @selected(request('status') == 'selesai')>Selesai</option>
                    <option value="rejected" @selected(request('status') == 'rejected')>Rejected</option>
                </select>
                <button type="submit" class="px-4 py-2 bg-slate-800 text-white text-sm font-semibold rounded-lg hover:bg-slate-900 transition">Filter</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-200">
                        <th class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500 py-4 px-6 w-24">ID</th>
                        <th class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500 py-4 px-6">Pelapor</th>
                        <th class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500 py-4 px-6">Lokasi</th>
                        <th class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500 py-4 px-6">Kategori</th>
                        <th class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500 py-4 px-6 w-32">Tanggal</th>
                        <th class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500 py-4 px-6 w-28">Status</th>
                        <th class="text-right text-xs font-semibold uppercase tracking-wider text-slate-500 py-4 px-6 w-40">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengaduan as $p)
                        <tr class="border-b border-slate-100 last:border-b-0 hover:bg-slate-50/60 transition">
                            <td class="py-4 px-6 font-medium text-slate-600">{{ $p->kode }}</td>
                            <td class="py-4 px-6">
                                <span class="font-medium text-slate-800">{{ $p->user->name }}</span>
                                <span class="text-xs text-slate-500 block">({{ ucfirst($p->user->role) }})</span>
                            </td>
                            <td class="py-4 px-6 text-slate-600">{{ $p->lokasi->nama_lokasi }}</td>
                            <td class="py-4 px-6 text-slate-600">{{ $p->kategori->nama_kategori }}</td>
                            <td class="py-4 px-6 text-slate-600">{{ $p->created_at->format('d/m/y') }}</td>
                            <td class="py-4 px-6"><x-status-badge :status="$p->status" /></td>
                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.verifikasi.show', $p) }}" class="text-[#1e3a8a] hover:underline text-sm font-medium">
                                        {{ $p->status === 'pending' ? 'Verifikasi' : 'Detail' }}
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">Tidak ada pengaduan ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-slate-100">{{ $pengaduan->links() }}</div>
    </div>

@endsection