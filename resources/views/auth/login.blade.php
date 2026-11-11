@extends('layouts.guest')

@section('title', 'Masuk - Sistem Pengaduan Sarana Sekolah')

@section('content')

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm px-6 py-8 sm:px-8">

        {{-- Judul --}}
        <div class="text-center mb-6">
            <h2 class="text-xl font-bold text-slate-800">Masuk ke Akun</h2>
            <p class="text-sm text-slate-500 mt-1">Login sebagai Admin / Siswa / Guru / Petugas</p>
        </div>

        {{-- Flash success --}}
        @if (session('success'))
            <div class="mb-4 rounded-lg bg-green-50 border border-green-200 text-green-800 text-sm px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        {{-- Error umum --}}
        @if ($errors->has('login'))
            <div class="mb-4 rounded-lg bg-red-50 border border-red-200 text-red-800 text-sm px-4 py-3">
                {{ $errors->first('login') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}" class="space-y-4" novalidate>
            @csrf

            {{-- Email / NIS / NIP --}}
            <div>
                <label for="login" class="block text-sm font-medium text-slate-700 mb-1">
                    Email / NIS / NIP
                </label>
                <input
                    id="login"
                    name="login"
                    type="text"
                    value="{{ old('login') }}"
                    placeholder="Masukkan email, NIS, atau NIP"
                    autocomplete="username"
                    class="w-full px-3 py-2.5 text-sm rounded-lg border border-slate-300 bg-slate-50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition"
                >
                @error('login')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block text-sm font-medium text-slate-700 mb-1">
                    Password
                </label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    placeholder="Masukkan password"
                    autocomplete="current-password"
                    class="w-full px-3 py-2.5 text-sm rounded-lg border border-slate-300 bg-slate-50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition"
                >
                @error('password')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Lupa password --}}
            <div class="text-right">
                <span class="text-xs text-slate-500">Hubungi Admin sekolah jika lupa password.</span>
            </div>

            {{-- Tombol LOGIN --}}
            <button
                type="submit"
                class="w-full bg-[#1e3a8a] hover:bg-[#1e40af] text-white font-semibold text-sm uppercase tracking-wider rounded-lg py-3 transition shadow-sm"
            >
                Login
            </button>
        </form>

        {{-- [REVISI] Link ke daftar dihapus karena register dimatikan --}}

        <p class="text-center text-xs text-slate-400 mt-4">
            * Redirect otomatis ke Dashboard sesuai role setelah login.
        </p>
    </div>

@endsection