@extends('layouts.admin')

@section('title', 'Edit Lokasi')

@section('content')

    <x-page-header
        title="Edit Lokasi / Ruangan"
        subtitle="Ubah data lokasi {{ $lokasi->nama_lokasi }}"
        :backUrl="route('admin.data-master', ['tab' => 'lokasi'])" />

    <div class="bg-white rounded-lg border border-slate-200 p-6 max-w-2xl">
        <form method="POST" action="{{ route('admin.lokasi.update', $lokasi) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <x-form-field name="nama_lokasi" label="Nama Lokasi" :value="$lokasi->nama_lokasi" required />
            <x-form-field name="gedung" label="Gedung" :value="$lokasi->gedung" />
            <x-form-field name="lantai" label="Lantai" :value="$lokasi->lantai" />

            <div class="pt-3 border-t border-slate-100 flex justify-end gap-2">
                <a href="{{ route('admin.data-master', ['tab' => 'lokasi']) }}"
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