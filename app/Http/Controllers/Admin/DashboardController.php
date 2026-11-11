<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // 1. Statistik
        $stats = [
            'total'    => Pengaduan::count(),
            'pending'  => Pengaduan::where('status', 'pending')->count(),
            'approved' => Pengaduan::where('status', 'approved')->count(),
            'selesai'  => Pengaduan::where('status', 'selesai')->count(),
        ];

        // 2. Data Grafik 6 Bulan Terakhir
        $months = collect();
        $chartData = collect();

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months->push($date->translatedFormat('M')); // ex: Mei, Jun
            $chartData->push(Pengaduan::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count());
        }

        // 3. Pengaduan Terbaru (5 data khusus PENDING)
        $recent = Pengaduan::with(['user', 'lokasi', 'kategori'])
            ->where('status', 'pending')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'months', 'chartData', 'recent'));
    }
}