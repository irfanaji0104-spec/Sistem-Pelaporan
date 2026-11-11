@extends('layouts.admin')

@section('title', 'Tambah Lokasi')

@section('content')

    <x-page-header
        title="Tambah Lokasi / Ruangan"
        subtitle="Buat lokasi baru untuk pengaduan"
        :backUrl="route('admin.data-master', ['tab' => 'lokasi'])" />

    <div class="bg-white rounded-lg border border-slate-200 p-6 max-w-2xl">
        <form method="POST" action="{{ route('admin.lokasi.store') }}" class="space-y-5">
            @csrf

            <x-form-field name="nama_lokasi" label="Nama Lokasi" placeholder="Contoh: Lab Komputer 1" required />
            <x-form-field name="gedung" label="Gedung" placeholder="Contoh: Gedung A" />
            <x-form-field name="lantai" label="Lantai" placeholder="Contoh: 1" />

            <div class="pt-3 border-t border-slate-100 flex justify-end gap-2">
                <a href="{{ route('admin.data-master', ['tab' => 'lokasi']) }}"
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