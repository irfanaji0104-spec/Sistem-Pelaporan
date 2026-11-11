@extends('layouts.admin')

@section('title', 'Tambah Pengguna')

@section('content')

    <x-page-header
        title="Tambah Pengguna"
        subtitle="Buat akun baru untuk admin, siswa, atau guru"
        :backUrl="route('admin.data-master', ['tab' => 'pengguna'])" />

    <div class="bg-white rounded-lg border border-slate-200 p-6 max-w-2xl">

        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-5">
            @csrf

            <x-form-field name="name"  label="Nama Lengkap" placeholder="Masukkan nama lengkap" required />
            <x-form-field name="email" label="Email" type="email" placeholder="nama@smkn5ska.sch.id" required />

            <x-form-field name="role" label="Role" type="select" required
                :options="['' => '-- Pilih Role --', 'siswa' => 'Siswa', 'guru' => 'Guru', 'admin' => 'Admin']" />

            <x-form-field name="no_induk" label="NIS / NIP" placeholder="Opsional untuk admin"
                help="Wajib untuk siswa (NIS) dan guru (NIP)" />

            <x-form-field name="password" label="Password" type="password"
                placeholder="Minimal 6 karakter" required
                help="Admin yang menentukan password awal pengguna" />

            <x-form-field name="password_confirmation" label="Konfirmasi Password"
                type="password" placeholder="Ulangi password" required />

            <div>
                <label class="inline-flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" checked
                           class="rounded border-slate-300 text-blue-700 focus:ring-blue-500">
                    <span class="text-sm text-slate-700">Aktifkan akun setelah dibuat</span>
                </label>
            </div>

            <div class="pt-3 border-t border-slate-100 flex justify-end gap-2">
                <a href="{{ route('admin.data-master', ['tab' => 'pengguna']) }}"
                   class="px-5 py-2.5 border border-slate-300 text-slate-700 text-sm font-semibold rounded-lg hover:bg-slate-50 transition">
                    BATAL
                </a>
                <button type="submit"
                        class="px-5 py-2.5 bg-[#1e3a8a] text-white text-sm font-semibold rounded-lg hover:bg-[#1e40af] transition">
                    SIMPAN
                </button>
            </div>
        </form>
    </div>

@endsection