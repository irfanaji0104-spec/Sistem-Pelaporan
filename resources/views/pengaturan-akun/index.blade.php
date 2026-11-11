@php
    $layout = auth()->user()->isAdmin() ? 'layouts.admin' : 'layouts.pelapor';
    $dashboardUrl = auth()->user()->isAdmin() ? route('admin.dashboard') : route('pelapor.dashboard');
@endphp

@extends($layout)

@section('title', 'Pengaturan Akun')

@section('content')

    <div class="mb-6">
        {{-- Tombol Kembali Dinamis --}}
        <div class="mb-4">
            <a href="{{ $dashboardUrl }}" 
               class="inline-flex items-center gap-2 px-3 py-1.5 bg-white border border-slate-300 text-slate-600 text-sm font-medium rounded-lg hover:bg-slate-50 transition shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Dashboard
            </a>
        </div>

        <h2 class="text-xl lg:text-2xl font-bold text-slate-800">Pengaturan Akun</h2>
        <p class="text-sm text-slate-500 mt-1">Kelola informasi profil dan password Anda</p>
    </div>

    @if (session('success'))
        <div class="mb-4 rounded-lg bg-green-50 border border-green-200 text-green-800 text-sm px-4 py-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- ============ KOLOM KIRI: FOTO PROFIL ============ --}}
        <div class="lg:col-span-1 space-y-5">

            <div class="bg-white rounded-lg border border-slate-200 p-6">
                <h3 class="font-semibold text-slate-800 mb-4">Foto Profil</h3>

                <div class="flex flex-col items-center text-center">
                    @if ($user->foto_profil)
                        <img src="{{ asset('storage/'.$user->foto_profil) }}"
                             alt="{{ $user->name }}"
                             class="w-24 h-24 rounded-full object-cover border-4 border-slate-100 mb-3">
                    @else
                        <div class="w-24 h-24 rounded-full bg-blue-700 text-white text-3xl font-bold flex items-center justify-center mb-3 border-4 border-slate-100">
                            {{ $user->inisial }}
                        </div>
                    @endif

                    <p class="font-semibold text-slate-800">{{ $user->name }}</p>
                    <p class="text-xs text-slate-500 mb-4">{{ ucfirst($user->role) }} · SMK Negeri 5 Surakarta</p>

                    <form id="form-foto" method="POST" action="{{ route('pengaturan.update-profile') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <!-- [REVISI] Name dan Email tetap dikirim sebagai hidden meskipun form di sebelah kanannya readonly -->
                        <input type="hidden" name="name" value="{{ $user->name }}">
                        <input type="hidden" name="email" value="{{ $user->email }}">
                        <input type="file" name="foto_profil" id="input-foto" accept="image/jpeg,image/png" class="hidden">
                        <button type="button" onclick="document.getElementById('input-foto').click()"
                                class="px-4 py-2 bg-[#1e3a8a] text-white text-sm font-medium rounded-lg hover:bg-[#1e40af] transition">
                            Ganti Foto
                        </button>
                    </form>
                    <p class="text-xs text-slate-400 mt-2">JPG/PNG, maks 2MB</p>
                </div>
            </div>

        </div>

        {{-- ============ KOLOM KANAN: INFO + PASSWORD ============ --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Card: Informasi Akun --}}
            <div class="bg-white rounded-lg border border-slate-200 p-6">
                <h3 class="font-semibold text-slate-800 mb-4">Informasi Akun</h3>

                <form method="POST" action="{{ route('pengaturan.update-profile') }}">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">
                                Nama Lengkap <span class="text-slate-400">(tidak dapat diubah)</span>
                            </label>
                            <!-- [REVISI] Menambahkan 'readonly' dan styling 'cursor-not-allowed' -->
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" readonly
                                   class="w-full px-3 py-2.5 text-sm rounded-lg border border-slate-200 bg-slate-100 text-slate-500 cursor-not-allowed outline-none">
                            @error('name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">
                                Email <span class="text-slate-400">(tidak dapat diubah)</span>
                            </label>
                            <!-- [REVISI] Menambahkan 'readonly' dan styling 'cursor-not-allowed' -->
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" readonly
                                   class="w-full px-3 py-2.5 text-sm rounded-lg border border-slate-200 bg-slate-100 text-slate-500 cursor-not-allowed outline-none">
                            @error('email') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">
                                {{ $user->label_no_induk ?? 'NIS/NIP' }} <span class="text-slate-400">(tidak dapat diubah)</span>
                            </label>
                            <input type="text" value="{{ $user->no_induk ?? '-' }}" readonly
                                   class="w-full px-3 py-2.5 text-sm rounded-lg border border-slate-200 bg-slate-100 text-slate-500 cursor-not-allowed outline-none">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Role</label>
                            <div class="flex items-center gap-2">
                                <input type="text" value="{{ ucfirst($user->role) }}" readonly
                                       class="flex-1 px-3 py-2.5 text-sm rounded-lg border border-slate-200 bg-slate-100 text-slate-500 cursor-not-allowed outline-none">
                                <x-role-badge :role="$user->role" />
                            </div>
                        </div>
                    </div>

                    {{-- [REVISI] Tombol 'Simpan Perubahan' dihilangkan karena data profil tidak bisa diubah lagi --}}
                </form>
            </div>

            {{-- Card: Ubah Password --}}
            <div class="bg-white rounded-lg border border-slate-200 p-6">
                <h3 class="font-semibold text-slate-800 mb-4">Ubah Password</h3>

                <form method="POST" action="{{ route('pengaturan.update-password') }}">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Password Lama</label>
                            <input type="password" name="password_lama" placeholder="Masukkan password lama"
                                   class="w-full px-3 py-2.5 text-sm rounded-lg border border-slate-300 bg-slate-50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition">
                            @error('password_lama') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Password Baru</label>
                            <input type="password" name="password_baru" placeholder="Minimal 6 karakter"
                                   class="w-full px-3 py-2.5 text-sm rounded-lg border border-slate-300 bg-slate-50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition">
                            @error('password_baru') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Password Baru</label>
                            <input type="password" name="password_baru_confirmation" placeholder="Ulangi password baru"
                                   class="w-full px-3 py-2.5 text-sm rounded-lg border border-slate-300 bg-slate-50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition">
                        </div>
                    </div>

                    <div class="mt-5 pt-4 border-t border-slate-100 flex justify-end">
                        <button type="submit"
                                class="px-5 py-2.5 bg-[#1e3a8a] text-white text-sm font-semibold rounded-lg hover:bg-[#1e40af] transition">
                            SIMPAN PERUBAHAN
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

@endsection

@push('scripts')
<script>
    // Auto-submit form foto setelah user pilih file
    document.getElementById('input-foto')?.addEventListener('change', function () {
        if (this.files.length > 0) {
            document.getElementById('form-foto').submit();
        }
    });
</script>
@endpush