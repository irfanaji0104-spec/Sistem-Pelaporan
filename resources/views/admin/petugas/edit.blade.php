@extends('layouts.admin')

@section('title', 'Edit Petugas')

@section('content')

    <x-page-header
        title="Edit Petugas"
        subtitle="Ubah data petugas {{ $petugas->nama }}"
        :backUrl="route('admin.petugas')" />

    <div class="bg-white rounded-lg border border-slate-200 p-6 max-w-2xl">
        <form method="POST" action="{{ route('admin.petugas.update', $petugas) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <x-form-field name="nama" label="Nama Petugas" :value="$petugas->nama" required />
            <x-form-field name="kontak" label="Kontak" :value="$petugas->kontak" required />
            <x-form-field name="spesialisasi" label="Spesialisasi" :value="$petugas->spesialisasi" required />

            <div class="pt-3 border-t border-slate-100 flex justify-end gap-2">
                <a href="{{ route('admin.petugas') }}"
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