@extends('layouts.admin')

@section('title', 'Data Master')

@section('content')

    <div class="mb-6">
        <h2 class="text-xl lg:text-2xl font-bold text-slate-800">Data Master</h2>
        <p class="text-sm text-slate-500 mt-1">Kelola pengguna, kategori, dan lokasi</p>
    </div>

    <x-alert type="success" />
    <x-alert type="error" />

    @php
        $tabs = [
            'pengguna' => 'Data Pengguna',
            'kategori' => 'Kategori Kerusakan',
            'lokasi'   => 'Lokasi / Ruangan',
        ];
    @endphp

    {{-- TABS --}}
    <div class="border-b border-slate-200 mb-6">
        <div class="flex gap-8 overflow-x-auto">
            @foreach ($tabs as $key => $label)
                <a href="{{ route('admin.data-master', ['tab' => $key]) }}"
                   class="pb-3 text-sm font-medium whitespace-nowrap border-b-2 transition
                          {{ $tab === $key
                                ? 'border-[#1e3a8a] text-[#1e3a8a] font-semibold'
                                : 'border-transparent text-slate-500 hover:text-slate-700' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- ==================== TAB: PENGGUNA ==================== --}}
    @if ($tab === 'pengguna')

        <div class="flex flex-col sm:flex-row sm:items-center gap-3 mb-5">
            <form method="GET" class="flex-1 max-w-sm">
                <input type="hidden" name="tab" value="pengguna">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari nama / email..."
                       class="w-full px-4 py-2.5 text-sm rounded-lg border border-slate-300 bg-white focus:border-[#1e3a8a] focus:ring-2 focus:ring-blue-100 outline-none transition">
            </form>
            <div class="sm:ml-auto">
                <a href="{{ route('admin.users.create') }}"
                   class="inline-block px-5 py-2.5 bg-[#1e3a8a] text-white text-sm font-semibold rounded-lg hover:bg-[#1e40af] transition">
                    + Tambah Pengguna
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-200">
                            <th class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500 py-4 px-6">Nama</th>
                            <th class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500 py-4 px-6">Email</th>
                            <th class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500 py-4 px-6 w-32">Role</th>
                            <th class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500 py-4 px-6 w-32">Status</th>
                            <th class="text-right text-xs font-semibold uppercase tracking-wider text-slate-500 py-4 px-6 w-48">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr class="border-b border-slate-100 last:border-b-0 hover:bg-slate-50/60 transition">
                                <td class="py-4 px-6 font-medium text-slate-800">{{ $user->name }}</td>
                                <td class="py-4 px-6 text-slate-600">{{ $user->email }}</td>
                                <td class="py-4 px-6"><x-role-badge :role="$user->role" /></td>
                                <td class="py-4 px-6"><x-active-badge :active="$user->is_active" /></td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center justify-end gap-4">
                                        <a href="{{ route('admin.users.edit', $user) }}"
                                           class="text-blue-600 hover:text-blue-800 text-sm font-medium transition">Edit</a>

                                        @if ($user->id !== auth()->id())
                                            <form method="POST" action="{{ route('admin.users.toggle', $user) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        class="{{ $user->is_active ? 'text-red-600 hover:text-red-800' : 'text-blue-600 hover:text-blue-800' }} text-sm font-medium transition">
                                                    {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-slate-300 text-sm">—</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-slate-400">Tidak ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-5">{{ $users->links() }}</div>

    {{-- ==================== TAB: KATEGORI ==================== --}}
    @elseif ($tab === 'kategori')

        <div class="flex flex-col sm:flex-row sm:items-center gap-3 mb-5">
            <form method="GET" class="flex-1 max-w-sm">
                <input type="hidden" name="tab" value="kategori">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari kategori..."
                       class="w-full px-4 py-2.5 text-sm rounded-lg border border-slate-300 bg-white focus:border-[#1e3a8a] focus:ring-2 focus:ring-blue-100 outline-none transition">
            </form>
            <div class="sm:ml-auto">
                <a href="{{ route('admin.kategori.create') }}"
                   class="inline-block px-5 py-2.5 bg-[#1e3a8a] text-white text-sm font-semibold rounded-lg hover:bg-[#1e40af] transition">
                    + Tambah Kategori
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-200">
                            <th class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500 py-4 px-6 w-64">Nama Kategori</th>
                            <th class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500 py-4 px-6">Deskripsi</th>
                            <th class="text-right text-xs font-semibold uppercase tracking-wider text-slate-500 py-4 px-6 w-40">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kategori as $k)
                            <tr class="border-b border-slate-100 last:border-b-0 hover:bg-slate-50/60 transition">
                                <td class="py-4 px-6 font-medium text-slate-800">{{ $k->nama_kategori }}</td>
                                <td class="py-4 px-6 text-slate-600">{{ $k->deskripsi ?: '-' }}</td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center justify-end gap-4">
                                        <a href="{{ route('admin.kategori.edit', $k) }}"
                                           class="text-blue-600 hover:text-blue-800 text-sm font-medium transition">Edit</a>
                                        <form method="POST" action="{{ route('admin.kategori.destroy', $k) }}"
                                              onsubmit="return confirm('Yakin hapus kategori ini?')">
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
                                <td colspan="3" class="py-12 text-center text-slate-400">Tidak ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-5">{{ $kategori->links() }}</div>

    {{-- ==================== TAB: LOKASI ==================== --}}
    @elseif ($tab === 'lokasi')

        <div class="flex flex-col sm:flex-row sm:items-center gap-3 mb-5">
            <form method="GET" class="flex-1 max-w-sm">
                <input type="hidden" name="tab" value="lokasi">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari lokasi..."
                       class="w-full px-4 py-2.5 text-sm rounded-lg border border-slate-300 bg-white focus:border-[#1e3a8a] focus:ring-2 focus:ring-blue-100 outline-none transition">
            </form>
            <div class="sm:ml-auto">
                <a href="{{ route('admin.lokasi.create') }}"
                   class="inline-block px-5 py-2.5 bg-[#1e3a8a] text-white text-sm font-semibold rounded-lg hover:bg-[#1e40af] transition">
                    + Tambah Lokasi
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-200">
                            <th class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500 py-4 px-6">Nama Lokasi</th>
                            <th class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500 py-4 px-6 w-48">Gedung</th>
                            <th class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500 py-4 px-6 w-32">Lantai</th>
                            <th class="text-right text-xs font-semibold uppercase tracking-wider text-slate-500 py-4 px-6 w-40">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($lokasi as $l)
                            <tr class="border-b border-slate-100 last:border-b-0 hover:bg-slate-50/60 transition">
                                <td class="py-4 px-6 font-medium text-slate-800">{{ $l->nama_lokasi }}</td>
                                <td class="py-4 px-6 text-slate-600">{{ $l->gedung ?? '-' }}</td>
                                <td class="py-4 px-6 text-slate-600">{{ $l->lantai ?? '-' }}</td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center justify-end gap-4">
                                        <a href="{{ route('admin.lokasi.edit', $l) }}"
                                           class="text-blue-600 hover:text-blue-800 text-sm font-medium transition">Edit</a>
                                        <form method="POST" action="{{ route('admin.lokasi.destroy', $l) }}"
                                              onsubmit="return confirm('Yakin hapus lokasi ini?')">
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
                                <td colspan="4" class="py-12 text-center text-slate-400">Tidak ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-5">{{ $lokasi->links() }}</div>

    @endif

@endsection