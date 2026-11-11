@extends('layouts.pelapor')

@section('title', 'Form Pengaduan')

@section('content')

    {{-- Breadcrumb --}}
    <nav class="text-xs text-slate-500 mb-3">
        <a href="{{ route('pelapor.dashboard') }}" class="hover:text-slate-700">Dashboard</a>
        <span class="mx-1">/</span>
        <span class="text-slate-700 font-medium">Ajukan Pengaduan Baru</span>
    </nav>

    {{-- Judul --}}
    <h2 class="text-xl lg:text-2xl font-bold text-slate-800 mb-5">Form Pengaduan Kerusakan Sarana</h2>

    <x-alert type="error" />

    <form method="POST" action="{{ route('pelapor.pengaduan.store') }}"
          enctype="multipart/form-data" id="form-pengaduan" class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        @csrf

        {{-- ================= KOLOM KIRI: FORM ================= --}}
        <div class="lg:col-span-2 space-y-5">

            <div class="bg-white rounded-xl border border-slate-200 p-6 space-y-5">

                {{-- Lokasi --}}
                <div>
                    <label for="lokasi_id" class="block text-sm font-medium text-slate-700 mb-1">
                        Pilih Lokasi / Ruangan <span class="text-red-500">*</span>
                    </label>
                    <select id="lokasi_id" name="lokasi_id"
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-slate-300 bg-slate-50 focus:bg-white focus:border-[#1e3a8a] focus:ring-2 focus:ring-blue-100 outline-none transition">
                        <option value="">-- Pilih Lokasi / Ruangan --</option>
                        @foreach ($lokasi as $l)
                            <option value="{{ $l->id }}" @selected(old('lokasi_id') == $l->id)>
                                {{ $l->label_lengkap }}
                            </option>
                        @endforeach
                    </select>
                    @error('lokasi_id') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Kategori --}}
                <div>
                    <label for="kategori_id" class="block text-sm font-medium text-slate-700 mb-1">
                        Pilih Kategori Kerusakan <span class="text-red-500">*</span>
                    </label>
                    <select id="kategori_id" name="kategori_id"
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-slate-300 bg-slate-50 focus:bg-white focus:border-[#1e3a8a] focus:ring-2 focus:ring-blue-100 outline-none transition">
                        <option value="">-- Pilih Kategori Kerusakan --</option>
                        @foreach ($kategori as $k)
                            <option value="{{ $k->id }}" @selected(old('kategori_id') == $k->id)>
                                {{ $k->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-slate-700 mb-1">
                        Deskripsi Kerusakan <span class="text-red-500">*</span>
                    </label>
                    <textarea id="deskripsi" name="deskripsi" rows="5"
                              placeholder="Jelaskan kerusakan secara detail: apa yang rusak, seberapa parah, sudah berapa lama, dll."
                              class="w-full px-3 py-2.5 text-sm rounded-lg border border-slate-300 bg-slate-50 focus:bg-white focus:border-[#1e3a8a] focus:ring-2 focus:ring-blue-100 outline-none transition resize-y">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Upload foto --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Ambil Foto Bukti Kerusakan <span class="text-red-500">*</span>
                    </label>

                    <div class="flex items-center gap-4 p-4 border-2 border-dashed border-slate-300 rounded-lg bg-slate-50 hover:bg-slate-100 transition">
                        {{-- Preview --}}
                        <div class="w-20 h-20 rounded-lg bg-slate-200 flex items-center justify-center overflow-hidden shrink-0">
                            <img id="foto-preview" src="" alt="" class="hidden w-full h-full object-cover">
                            <svg id="foto-placeholder" xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>

                        <div class="flex-1 min-w-0">
                            {{-- [REVISI] Menambahkan atribut capture="environment" agar HP langsung membuka kamera --}}
                            <input type="file" id="foto_bukti" name="foto_bukti"
                                   accept="image/*" capture="environment" class="hidden">
                            <button type="button" onclick="document.getElementById('foto_bukti').click()"
                                    class="px-4 py-2 bg-white border border-slate-300 text-slate-700 text-xs font-semibold rounded-lg hover:bg-slate-50 transition shadow-sm inline-flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                </svg>
                                BUKA KAMERA
                            </button>
                            <p id="file-name" class="text-xs text-slate-500 mt-2">Format JPG/PNG, maks 2MB</p>
                        </div>
                    </div>

                    @error('foto_bukti') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

            </div>

            {{-- Tombol Aksi --}}
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('pelapor.dashboard') }}"
                   class="flex-1 text-center px-5 py-3 border border-slate-300 text-slate-700 text-sm font-semibold rounded-lg hover:bg-slate-50 transition">
                    BATAL
                </a>
                <button type="submit" id="btn-kirim"
                        class="flex-1 px-5 py-3 bg-[#1e3a8a] text-white text-sm font-semibold rounded-lg hover:bg-[#1e40af] transition disabled:opacity-60 disabled:cursor-not-allowed">
                    KIRIM PENGADUAN
                </button>
            </div>
        </div>

        {{-- ================= KOLOM KANAN: INFO ================= --}}
        <aside class="lg:col-span-1">
            <div class="bg-blue-50 border border-blue-100 rounded-xl p-6 sticky top-20">
                <h3 class="font-semibold text-slate-800 mb-3">Info Pengaduan</h3>

                <div class="space-y-3 text-sm text-slate-700">
                    <p>
                        <span class="font-semibold text-slate-800">Status awal: Pending</span>
                    </p>
                    <p>
                        Pengaduan kamu akan langsung masuk dengan status Pending.
                        Admin akan memverifikasi dalam 1x24 jam.
                    </p>

                    <ul class="space-y-2 pt-2">
                        <li class="flex gap-2">
                            <span class="text-blue-600 shrink-0 mt-0.5">•</span>
                            <span>Pastikan lokasi dan kategori dipilih dengan benar.</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="text-blue-600 shrink-0 mt-0.5">•</span>
                            <span>Ambil foto kerusakan dengan jelas (usahakan pencahayaan cukup).</span>
                        </li>
                    </ul>
                </div>
            </div>
        </aside>

    </form>

@endsection

@push('scripts')
<script>
    // Preview foto saat dipilih
    const input = document.getElementById('foto_bukti');
    const preview = document.getElementById('foto-preview');
    const placeholder = document.getElementById('foto-placeholder');
    const fileNameEl = document.getElementById('file-name');

    input.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        // Validasi client-side
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file melebihi 2MB. Silakan pilih file lain.');
            this.value = '';
            return;
        }

        if (!file.type.startsWith('image/')) {
            alert('Hanya diperbolehkan mengambil atau mengupload gambar.');
            this.value = '';
            return;
        }

        // Tampilkan preview
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        };
        reader.readAsDataURL(file);

        // Jika langsung dari kamera, biasanya format namanya ribet, jadi disederhanakan
        fileNameEl.textContent = 'Foto terlampir (' + (file.size / 1024).toFixed(0) + ' KB)';
    });

    // Cegah double submit
    document.getElementById('form-pengaduan').addEventListener('submit', function () {
        const btn = document.getElementById('btn-kirim');
        btn.disabled = true;
        btn.textContent = 'MENGIRIM...';
    });
</script>
@endpush