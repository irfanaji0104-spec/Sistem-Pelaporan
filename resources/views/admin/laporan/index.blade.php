@extends('layouts.admin')

@section('title', 'Laporan Pengaduan')

@section('content')

    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl lg:text-2xl font-bold text-slate-800">Laporan Pengaduan</h2>
            <p class="text-sm text-slate-500 mt-1">Rekap dan ekspor data pengaduan sarana sekolah</p>
        </div>
        <div class="shrink-0 flex flex-wrap gap-2">
            {{-- Tombol Export --}}
            <a href="{{ route('admin.laporan.pdf', request()->query()) }}" 
               class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white text-sm font-semibold rounded-lg hover:bg-emerald-700 transition shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Export PDF
            </a>
            
            <a href="{{ route('admin.laporan.excel', request()->query()) }}" 
               class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white text-sm font-semibold rounded-lg hover:bg-emerald-700 transition shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 01-2-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Export Excel
            </a>
        </div>
    </div>

    {{-- Filter Card --}}
    <div class="bg-white rounded-xl border border-slate-200 p-5 mb-5">
        <h3 class="font-semibold text-slate-800 mb-4">Filter Laporan</h3>
        
        <form method="GET" action="{{ route('admin.laporan') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
            
            {{-- Tanggal --}}
            <div>
                <label class="block text-xs font-medium text-slate-700 mb-1">Rentang Tanggal</label>
                <select name="rentang_tanggal" id="filter-tanggal" class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 bg-white outline-none">
                    <option value="">Semua Tanggal</option>
                    <option value="hari_ini" @selected(request('rentang_tanggal') == 'hari_ini')>Hari ini</option>
                    <option value="7_hari" @selected(request('rentang_tanggal') == '7_hari')>7 hari terakhir</option>
                    <option value="30_hari" @selected(request('rentang_tanggal') == '30_hari')>30 hari terakhir</option>
                    <option value="bulan_ini" @selected(request('rentang_tanggal') == 'bulan_ini')>Bulan ini</option>
                    <option value="custom" @selected(request('rentang_tanggal') == 'custom')>Pilih tanggal</option>
                </select>
            </div>

            {{-- Status --}}
            <div>
                <label class="block text-xs font-medium text-slate-700 mb-1">Status</label>
                <select name="status" class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 bg-white outline-none">
                    <option value="">Semua Status</option>
                    <option value="pending" @selected(request('status') == 'pending')>Pending</option>
                    <option value="approved" @selected(request('status') == 'approved')>Diproses</option>
                    <option value="selesai" @selected(request('status') == 'selesai')>Selesai</option>
                    <option value="rejected" @selected(request('status') == 'rejected')>Rejected</option>
                </select>
            </div>

            {{-- Kategori --}}
            <div>
                <label class="block text-xs font-medium text-slate-700 mb-1">Kategori</label>
                <select name="kategori_id" class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 bg-white outline-none">
                    <option value="">Semua Kategori</option>
                    @foreach ($kategori as $k)
                        <option value="{{ $k->id }}" @selected(request('kategori_id') == $k->id)>{{ $k->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Lokasi --}}
            <div>
                <label class="block text-xs font-medium text-slate-700 mb-1">Lokasi</label>
                <select name="lokasi_id" class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 bg-white outline-none">
                    <option value="">Semua Lokasi</option>
                    @foreach ($lokasi as $l)
                        <option value="{{ $l->id }}" @selected(request('lokasi_id') == $l->id)>{{ $l->nama_lokasi }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Tombol Filter --}}
            <div>
                <button type="submit" class="w-full px-4 py-2 bg-[#1e3a8a] text-white text-sm font-semibold rounded-lg hover:bg-[#1e40af] transition">
                    TERAPKAN FILTER
                </button>
            </div>

            <div id="custom-date" class="hidden lg:col-span-5 grid grid-cols-2 gap-4 mt-2">
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1">Dari</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 bg-white outline-none">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1">Sampai</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 bg-white outline-none">
                </div>
            </div>
        </form>
    </div>

    {{-- ==================== VISUALISASI PIE CHART LOKASI & STATUS ==================== --}}
    <div class="bg-white rounded-xl border border-slate-200 p-5 mb-5 shadow-sm">
        <h3 class="font-bold text-slate-800 text-base mb-1">Statistik Perbandingan Status Laporan</h3>
        <p class="text-xs text-slate-500 mb-4">Persentase distribusi status pengaduan sesuai filter saat ini</p>
        <div class="flex justify-center items-center py-2" style="height: 260px;">
            <canvas id="statusPieChart"></canvas>
        </div>
    </div>

    {{-- Menampilkan N data --}}
    <div class="mb-4">
        <span class="inline-block px-3 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded-full border border-blue-200">
            Menampilkan {{ $data->total() }} data hasil filter
        </span>
    </div>

    {{-- Tabel Data --}}
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-200">
                        <th class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500 py-4 px-6 w-24">ID</th>
                        <th class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500 py-4 px-6">Pelapor</th>
                        <th class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500 py-4 px-6">Lokasi</th>
                        <th class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500 py-4 px-6">Kategori</th>
                        <th class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500 py-4 px-6 w-32">Waktu Laporan</th>
                        <th class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500 py-4 px-6 w-28">Status</th>
                        <th class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500 py-4 px-6 w-32">Waktu Selesai</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $p)
                        <tr class="border-b border-slate-100 last:border-b-0 hover:bg-slate-50/60 transition">
                            <td class="py-4 px-6 font-medium text-slate-600">{{ $p->kode }}</td>
                            <td class="py-4 px-6">
                                <span class="font-medium text-slate-800">{{ $p->user->name }}</span>
                                <span class="text-xs text-slate-500 block">({{ ucfirst($p->user->role) }})</span>
                            </td>
                            <td class="py-4 px-6 text-slate-600">{{ $p->lokasi->nama_lokasi }}</td>
                            <td class="py-4 px-6 text-slate-600">{{ $p->kategori->nama_kategori }}</td>
                            <td class="py-4 px-6">
                                <span class="block text-slate-800 font-medium">{{ $p->created_at->format('d/m/Y') }}</span>
                                <span class="block text-xs text-slate-500">{{ $p->created_at->format('H:i') }} WIB</span>
                            </td>
                            <td class="py-4 px-6"><x-status-badge :status="$p->status" /></td>
                            <td class="py-4 px-6 text-slate-600">{{ $p->waktu_selesai ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">Tidak ada data ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-100">{{ $data->links() }}</div>
    </div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const filterTanggal = document.getElementById('filter-tanggal');
    const customDate = document.getElementById('custom-date');

    function toggleCustomDate() {
        if (filterTanggal.value === 'custom') {
            customDate.classList.remove('hidden');
        } else {
            customDate.classList.add('hidden');
        }
    }

    filterTanggal.addEventListener('change', toggleCustomDate);
    toggleCustomDate(); 

    // Chart.js Pie Chart Status
    const pieCtx = document.getElementById('statusPieChart').getContext('2d');
    new Chart(pieCtx, {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Diproses', 'Selesai', 'Rejected'],
            datasets: [{
                data: [
                    {{ $statusCounts['pending'] }},
                    {{ $statusCounts['approved'] }},
                    {{ $statusCounts['selesai'] }},
                    {{ $statusCounts['rejected'] }}
                ],
                backgroundColor: [
                    '#f59e0b', // Pending (Kuning/Orange)
                    '#3b82f6', // Diproses (Biru)
                    '#10b981', // Selesai (Hijau)
                    '#ef4444'  // Rejected (Merah)
                ],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        padding: 15,
                        font: { size: 12, family: 'Inter' }
                    }
                }
            }
        }
    });
</script>
@endpush