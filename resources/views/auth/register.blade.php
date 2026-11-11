@extends('layouts.guest')

@section('title', 'Daftar - Sistem Pengaduan Sarana Sekolah')

@section('content')

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm px-6 py-8 sm:px-8">

        <div class="text-center mb-6">
            <h2 class="text-xl font-bold text-slate-800">Daftar Akun</h2>
            <p class="text-sm text-slate-500 mt-1">Khusus Siswa & Guru SMK Negeri 5 Surakarta</p>
        </div>

        <form method="POST" action="{{ route('register.post') }}" class="space-y-4" novalidate>
            @csrf

            {{-- Nama Lengkap --}}
            <div>
                <label for="name" class="block text-sm font-medium text-slate-700 mb-1">
                    Nama Lengkap
                </label>
                <input
                    id="name" name="name" type="text"
                    value="{{ old('name') }}"
                    placeholder="Masukkan nama lengkap"
                    class="w-full px-3 py-2.5 text-sm rounded-lg border border-slate-300 bg-slate-50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition"
                >
                @error('name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Daftar Sebagai --}}
            <div>
                <label for="role" class="block text-sm font-medium text-slate-700 mb-1">
                    Daftar sebagai
                </label>
                <select
                    id="role" name="role"
                    class="w-full px-3 py-2.5 text-sm rounded-lg border border-slate-300 bg-slate-50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition"
                >
                    <option value="">-- Pilih Role --</option>
                    <option value="siswa" @selected(old('role') === 'siswa')>Siswa</option>
                    <option value="guru"  @selected(old('role') === 'guru')>Guru</option>
                </select>
                @error('role') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- NIS / NIP --}}
            <div>
                <label for="no_induk" class="block text-sm font-medium text-slate-700 mb-1">
                    <span id="label-no-induk">NIS / NIP</span>
                </label>
                <input
                    id="no_induk" name="no_induk" type="text"
                    value="{{ old('no_induk') }}"
                    placeholder="Masukkan NIS / NIP"
                    class="w-full px-3 py-2.5 text-sm rounded-lg border border-slate-300 bg-slate-50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition"
                >
                @error('no_induk') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-slate-700 mb-1">
                    Email
                </label>
                <input
                    id="email" name="email" type="email"
                    value="{{ old('email') }}"
                    placeholder="nama@smkn5ska.sch.id"
                    class="w-full px-3 py-2.5 text-sm rounded-lg border border-slate-300 bg-slate-50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition"
                >
                @error('email') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block text-sm font-medium text-slate-700 mb-1">
                    Password
                </label>
                <input
                    id="password" name="password" type="password"
                    placeholder="Minimal 6 karakter"
                    class="w-full px-3 py-2.5 text-sm rounded-lg border border-slate-300 bg-slate-50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition"
                >
                @error('password') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">
                    Konfirmasi Password
                </label>
                <input
                    id="password_confirmation" name="password_confirmation" type="password"
                    placeholder="Ulangi password"
                    class="w-full px-3 py-2.5 text-sm rounded-lg border border-slate-300 bg-slate-50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition"
                >
            </div>

            {{-- Tombol DAFTAR --}}
            <button
                type="submit"
                class="w-full bg-[#1e3a8a] hover:bg-[#1e40af] text-white font-semibold text-sm uppercase tracking-wider rounded-lg py-3 transition shadow-sm"
            >
                Daftar
            </button>
        </form>

        <p class="text-center text-sm text-slate-600 mt-6">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-blue-700 font-semibold hover:underline">
                Masuk
            </a>
        </p>
    </div>

@endsection

@push('scripts')
<script>
    // Ubah label & placeholder NIS/NIP sesuai pilihan role
    const roleSelect = document.getElementById('role');
    const labelNoInduk = document.getElementById('label-no-induk');
    const inputNoInduk = document.getElementById('no_induk');

    function updateNoInduk() {
        if (roleSelect.value === 'siswa') {
            labelNoInduk.textContent = 'NIS';
            inputNoInduk.placeholder = 'Masukkan NIS';
        } else if (roleSelect.value === 'guru') {
            labelNoInduk.textContent = 'NIP';
            inputNoInduk.placeholder = 'Masukkan NIP';
        } else {
            labelNoInduk.textContent = 'NIS / NIP';
            inputNoInduk.placeholder = 'Masukkan NIS / NIP';
        }
    }

    roleSelect.addEventListener('change', updateNoInduk);
    updateNoInduk();
</script>
@endpush