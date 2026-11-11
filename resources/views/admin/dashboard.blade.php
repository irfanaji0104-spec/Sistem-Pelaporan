@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

    <div class="mb-6">
        <h2 class="text-xl lg:text-2xl font-bold text-slate-800">Dashboard</h2>
        <p class="text-sm text-slate-500 mt-1">Ringkasan pengaduan sarana sekolah</p>
    </div>

    {{-- ==================== STAT CARDS ==================== --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <x-stat-card label="Total Pengaduan" :value="$stats['total']" color="blue-dark" />
        <x-stat-card label="Pending" :value="$stats['pending']" color="orange" />
        <x-stat-card label="Approved / Diproses" :value="$stats['approved']" color="blue-light" />
        <x-stat-card label="Selesai" :value="$stats['selesai']" color="green" />
    </div>

    {{-- ==================== PENGADUAN TERBARU (KHUSUS PENDING 5 DATA) ==================== --}}
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden mb-8 shadow-sm">
        <div class="px-6 py-5 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="font-bold text-slate-800 text-lg">Pengaduan Terbaru (Pending)</h3>
                <p class="text-sm text-slate-500 mt-1">Daftar 5 laporan pending terbaru yang membutuhkan verifikasi Anda</p>
            </div>
            <a href="{{ route('admin.verifikasi') }}" 
               class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-slate-100 text-slate-700 text-sm font-semibold rounded-lg hover:bg-slate-200 transition">
                Lihat Semua Pengaduan
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50">
                        <th class="text-xs font-semibold uppercase tracking-wider text-slate-500 py-4 px-6 w-24">ID</th>
                        <th class="text-xs font-semibold uppercase tracking-wider text-slate-500 py-4 px-6">Pelapor</th>
                        <th class="text-xs font-semibold uppercase tracking-wider text-slate-500 py-4 px-6">Lokasi / Kategori</th>
                        <th class="text-xs font-semibold uppercase tracking-wider text-slate-500 py-4 px-6 w-36">Tanggal</th>
                        <th class="text-xs font-semibold uppercase tracking-wider text-slate-500 py-4 px-6 w-32">Status</th>
                        <th class="text-right text-xs font-semibold uppercase tracking-wider text-slate-500 py-4 px-6 w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recent as $p)
                        <tr class="border-b border-slate-100 last:border-b-0 hover:bg-slate-50 transition">
                            <td class="py-4 px-6 font-medium text-slate-600">{{ $p->kode }}</td>
                            <td class="py-4 px-6">
                                <span class="font-bold text-slate-800">{{ $p->user->name }}</span>
                                <span class="text-xs text-slate-500 block mt-0.5">({{ ucfirst($p->user->role) }})</span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="block font-medium text-slate-800">{{ $p->lokasi->nama_lokasi }}</span>
                                <span class="text-xs text-slate-500 block mt-0.5">{{ $p->kategori->nama_kategori }}</span>
                            </td>
                            <td class="py-4 px-6 text-slate-600 whitespace-nowrap">
                                {{ $p->created_at->format('d/m/y H:i') }}
                            </td>
                            <td class="py-4 px-6">
                                <x-status-badge :status="$p->status" />
                            </td>
                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                <a href="{{ route('admin.verifikasi.show', $p) }}" 
                                   class="inline-flex items-center gap-1 text-[#1e3a8a] hover:text-blue-800 font-semibold text-sm transition">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                Belum ada pengaduan pending.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ==================== GRAFIK PENGADUAN ==================== --}}
    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
        <div class="mb-6">
            <h3 class="font-bold text-slate-800 text-lg">Grafik Pengaduan per Bulan</h3>
            <p class="text-sm text-slate-500 mt-1">Statistik jumlah laporan dalam 6 bulan terakhir</p>
        </div>
        
        <div class="relative w-full" style="height: 500px; min-height: 500px;">
            <canvas id="pengaduanChart" style="width: 100% !important; height: 100% !important;"></canvas>
        </div>
    </div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('pengaduanChart').getContext('2d');
    const labels = @json($months);
    const dataCounts = @json($chartData);

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Pengaduan',
                data: dataCounts,
                backgroundColor: '#3b82f6', 
                borderRadius: 6,
                maxBarThickness: 80, 
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    padding: 12,
                    titleFont: { size: 14 },
                    bodyFont: { size: 14 }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, color: '#64748b', font: { size: 12 } },
                    grid: { color: '#f1f5f9', drawBorder: false }
                },
                x: {
                    ticks: { color: '#64748b', font: { size: 12, weight: 'bold' } },
                    grid: { display: false, drawBorder: false }
                }
            }
        }
    });
</script>
@endpush