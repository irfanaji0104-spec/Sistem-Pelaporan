<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriKerusakan;
use App\Models\Lokasi;
use App\Models\Pengaduan;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use OpenSpout\Writer\XLSX\Writer;
use OpenSpout\Common\Entity\Row;

class LaporanController extends Controller
{
    private function getFilteredData(Request $request)
    {
        $query = Pengaduan::with(['user', 'lokasi', 'kategori']);

        // Filter Tanggal
        if ($request->rentang_tanggal) {
            if ($request->rentang_tanggal === 'hari_ini') {
                $query->whereDate('created_at', Carbon::today());
            } elseif ($request->rentang_tanggal === '7_hari') {
                $query->where('created_at', '>=', Carbon::now()->subDays(7));
            } elseif ($request->rentang_tanggal === '30_hari') {
                $query->where('created_at', '>=', Carbon::now()->subDays(30));
            } elseif ($request->rentang_tanggal === 'bulan_ini') {
                $query->whereMonth('created_at', Carbon::now()->month)
                      ->whereYear('created_at', Carbon::now()->year);
            } elseif ($request->rentang_tanggal === 'custom' && $request->start_date && $request->end_date) {
                $query->whereDate('created_at', '>=', $request->start_date)
                      ->whereDate('created_at', '<=', $request->end_date);
            }
        }

        // Filter Status, Kategori, Lokasi
        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->kategori_id) {
            $query->where('kategori_id', $request->kategori_id);
        }
        if ($request->lokasi_id) {
            $query->where('lokasi_id', $request->lokasi_id);
        }

        return $query->orderByDesc('created_at');
    }

    public function index(Request $request): View
    {
        $filteredQuery = $this->getFilteredData($request);

        // Hitung statistik persentase status berdasarkan data terfilter
        $statusCounts = [
            'pending'  => (clone $filteredQuery)->where('status', 'pending')->count(),
            'approved' => (clone $filteredQuery)->where('status', 'approved')->count(),
            'selesai'  => (clone $filteredQuery)->where('status', 'selesai')->count(),
            'rejected' => (clone $filteredQuery)->where('status', 'rejected')->count(),
        ];

        $data = $filteredQuery->paginate(20)->withQueryString();
        $kategori = KategoriKerusakan::orderBy('nama_kategori')->get();
        $lokasi = Lokasi::orderBy('nama_lokasi')->get();

        return view('admin.laporan.index', compact('data', 'kategori', 'lokasi', 'statusCounts'));
    }

    public function exportPdf(Request $request)
    {
        $data = $this->getFilteredData($request)->get();
        
        $pdf = Pdf::loadView('admin.laporan.pdf', compact('data'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('Laporan-Pengaduan-' . now()->format('Ymd-His') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $data = $this->getFilteredData($request)->get();
        
        $fileName = 'Laporan-Pengaduan-' . now()->format('Ymd-His') . '.xlsx';
        $filePath = storage_path('app/public/' . $fileName);

        // Inisialisasi OpenSpout
        $writer = new Writer();
        $writer->openToFile($filePath);

        // Header
        $writer->addRow(Row::fromValues([
            'ID', 'Pelapor', 'Role', 'Lokasi', 'Kategori', 'Tanggal', 'Status', 'Waktu Selesai'
        ]));

        // Data
        foreach ($data as $row) {
            $writer->addRow(Row::fromValues([
                $row->kode,
                $row->user->name,
                ucfirst($row->user->role),
                $row->lokasi->nama_lokasi,
                $row->kategori->nama_kategori,
                $row->created_at->format('d/m/Y H:i'),
                $row->status_label,
                $row->waktu_selesai ?? '-',
            ]));
        }

        $writer->close();

        return response()->download($filePath)->deleteFileAfterSend(true);
    }
}