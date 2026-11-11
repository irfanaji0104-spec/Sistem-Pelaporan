@extends('layouts.admin')

@section('title', 'Edit Kategori')

@section('content')

    <x-page-header
        title="Edit Kategori Kerusakan"
        subtitle="Ubah data kategori {{ $kategori->nama_kategori }}"
        :backUrl="route('admin.data-master', ['tab' => 'kategori'])" />

    <div class="bg-white rounded-lg border border-slate-200 p-6 max-w-2xl">
        <form method="POST" action="{{ route('admin.kategori.update', $kategori) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <x-form-field name="nama_kategori" label="Nama Kategori" :value="$kategori->nama_kategori" required />
            <x-form-field name="deskripsi" label="Deskripsi" type="textarea" :value="$kategori->deskripsi" />

            <div class="pt-3 border-t border-slate-100 flex justify-end gap-2">
                <a href="{{ route('admin.data-master', ['tab' => 'kategori']) }}"
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