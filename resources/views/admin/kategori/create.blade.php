@extends('layouts.admin')

@section('title', 'Tambah Kategori')

@section('content')

    <x-page-header
        title="Tambah Kategori Kerusakan"
        subtitle="Buat kategori baru untuk pengaduan"
        :backUrl="route('admin.data-master', ['tab' => 'kategori'])" />

    <div class="bg-white rounded-lg border border-slate-200 p-6 max-w-2xl">
        <form method="POST" action="{{ route('admin.kategori.store') }}" class="space-y-5">
            @csrf

            <x-form-field name="nama_kategori" label="Nama Kategori" placeholder="Contoh: Elektronik" required />
            <x-form-field name="deskripsi" label="Deskripsi" type="textarea"
                placeholder="Penjelasan singkat tentang kategori ini" />

            <div class="pt-3 border-t border-slate-100 flex justify-end gap-2">
                <a href="{{ route('admin.data-master', ['tab' => 'kategori']) }}"
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