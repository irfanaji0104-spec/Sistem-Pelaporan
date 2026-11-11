@extends('layouts.admin')

@section('title', 'Edit Pengguna')

@section('content')

    <x-page-header
        title="Edit Pengguna"
        subtitle="Ubah data akun {{ $user->name }}"
        :backUrl="route('admin.data-master', ['tab' => 'pengguna'])" />

    <div class="bg-white rounded-lg border border-slate-200 p-6 max-w-2xl">

        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <x-form-field name="name"  label="Nama Lengkap" :value="$user->name" required />
            <x-form-field name="email" label="Email" type="email" :value="$user->email" required />

            <x-form-field name="role" label="Role" type="select" required
                :value="$user->role"
                :options="['siswa' => 'Siswa', 'guru' => 'Guru', 'admin' => 'Admin']" />

            <x-form-field name="no_induk" label="NIS / NIP" :value="$user->no_induk"
                help="Opsional untuk admin" />

            <div class="pt-3 border-t border-slate-100">
                <p class="text-sm font-medium text-slate-700 mb-3">Reset Password (opsional)</p>
                <div class="space-y-5">
                    <x-form-field name="password" label="Password Baru" type="password"
                        placeholder="Kosongkan jika tidak ingin mengubah password"
                        help="Minimal 6 karakter. Kosong = tidak diubah." />

                    <x-form-field name="password_confirmation" label="Konfirmasi Password Baru"
                        type="password" placeholder="Ulangi password baru" />
                </div>
            </div>

            <div>
                <label class="inline-flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $user->is_active))
                           class="rounded border-slate-300 text-blue-700 focus:ring-blue-500">
                    <span class="text-sm text-slate-700">Akun aktif</span>
                </label>
            </div>

            <div class="pt-3 border-t border-slate-100 flex justify-end gap-2">
                <a href="{{ route('admin.data-master', ['tab' => 'pengguna']) }}"
                   class="px-5 py-2.5 border border-slate-300 text-slate-700 text-sm font-semibold rounded-lg hover:bg-slate-50 transition">
                    BATAL
                </a>
                <button type="submit"
                        class="px-5 py-2.5 bg-[#1e3a8a] text-white text-sm font-semibold rounded-lg hover:bg-[#1e40af] transition">
                    SIMPAN PERUBAHAN
                </button>
            </div>
        </form>
    </div>

@endsection