@extends('layouts.admin')

@section('title', 'Data Petugas')

@section('content')

    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-6">
        <div>
            <h2 class="text-xl lg:text-2xl font-bold text-slate-800">Data Petugas</h2>
            <p class="text-sm text-slate-500 mt-1">Kelola petugas dan spesialisasi perbaikan sarana</p>
        </div>
        <div>
            <a href="{{ route('admin.petugas.create') }}"
               class="inline-block px-5 py-2.5 bg-[#1e3a8a] text-white text-sm font-semibold rounded-lg hover:bg-[#1e40af] transition">
                + Tambah Petugas
            </a>
        </div>
    </div>

    <x-alert type="success" />
    <x-alert type="error" />

    {{-- KOTAK PENCARIAN DIHAPUS DARI SINI --}}

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-200">
                        <th class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500 py-4 px-6">Nama Petugas</th>
                        <th class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500 py-4 px-6 w-48">Kontak</th>
                        <th class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500 py-4 px-6 w-44">Spesialisasi</th>
                        <th class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500 py-4 px-6 w-36">Tugas Aktif</th>
                        <th class="text-right text-xs font-semibold uppercase tracking-wider text-slate-500 py-4 px-6 w-40">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($petugas as $p)
                        <tr class="border-b border-slate-100 last:border-b-0 hover:bg-slate-50/60 transition">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-[#1e3a8a] text-white text-sm font-bold flex items-center justify-center shrink-0">
                                        {{ $p->inisial }}
                                    </div>
                                    <span class="font-medium text-slate-800">{{ $p->nama }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-slate-600">{{ $p->kontak ?? '-' }}</td>
                            <td class="py-4 px-6">
                                @if ($p->spesialisasi)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                        {{ $p->spesialisasi }}
                                    </span>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                @if ($p->tugas_aktif_count > 0)
                                    <span class="font-semibold text-slate-800">{{ $p->tugas_aktif_count }}</span>
                                    <span class="text-xs text-slate-500 ml-1">tugas</span>
                                @else
                                    <span class="text-slate-400 font-medium">0</span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center justify-end gap-4">
                                    <a href="{{ route('admin.petugas.edit', $p) }}"
                                       class="text-blue-600 hover:text-blue-800 text-sm font-medium transition">Edit</a>
                                    <form method="POST" action="{{ route('admin.petugas.destroy', $p) }}"
                                          onsubmit="return confirm('Yakin hapus petugas ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-600 hover:text-red-800 text-sm font-medium transition">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-400">Tidak ada petugas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-5">{{ $petugas->links() }}</div>

@endsection