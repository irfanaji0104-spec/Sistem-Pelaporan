<?php

namespace App\Http\Controllers\Pelapor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pelapor\StorePengaduanRequest;
use App\Models\KategoriKerusakan;
use App\Models\Lokasi;
use App\Models\Pengaduan;
use App\Models\RiwayatStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PengaduanController extends Controller
{
    /**
     * Dashboard pelapor — sapaan + stat + riwayat pengaduan.
     */
    public function dashboard(): View
    {
        $user = Auth::user();

        $base = Pengaduan::where('user_id', $user->id);

        $stats = [
            'pending'  => (clone $base)->where('status', 'pending')->count(),
            'approved' => (clone $base)->where('status', 'approved')->count(),
            'selesai'  => (clone $base)->where('status', 'selesai')->count(),
        ];

        $riwayat = (clone $base)
            ->with(['lokasi', 'kategori'])
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('pelapor.dashboard', compact('stats', 'riwayat'));
    }

    /**
     * Form pengaduan baru.
     */
    public function create(): View
    {
        return view('pelapor.pengaduan.create', [
            'lokasi'   => Lokasi::orderBy('nama_lokasi')->get(),
            'kategori' => KategoriKerusakan::orderBy('nama_kategori')->get(),
        ]);
    }

    /**
     * Simpan pengaduan baru.
     */
    public function store(StorePengaduanRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $pengaduan = DB::transaction(function () use ($data, $request) {
            // Upload foto
            $path = $request->file('foto_bukti')->store('pengaduan', 'public');

            // Simpan pengaduan
            $pengaduan = Pengaduan::create([
                'user_id'     => Auth::id(),
                'kategori_id' => $data['kategori_id'],
                'lokasi_id'   => $data['lokasi_id'],
                'deskripsi'   => $data['deskripsi'],
                'foto_bukti'  => $path,
                'status'      => 'pending',
            ]);

            // Riwayat awal
            RiwayatStatus::create([
                'pengaduan_id'      => $pengaduan->id,
                'diubah_oleh'       => Auth::id(),
                'status_sebelumnya' => null,
                'status_baru'       => 'pending',
                'keterangan'        => 'Pengaduan dibuat oleh pelapor.',
            ]);

            return $pengaduan;
        });

        return redirect()
            ->route('pelapor.pengaduan.show', $pengaduan)
            ->with('success', 'Pengaduan berhasil dikirim. Admin akan memverifikasi dalam 1x24 jam.');
    }

    /**
     * Detail pengaduan (read-only untuk pelapor).
     */
    public function show(Pengaduan $pengaduan): View
    {
        // Cegah akses ke pengaduan orang lain
        if ($pengaduan->user_id !== Auth::id()) {
            abort(403, 'Anda tidak dapat melihat pengaduan milik orang lain.');
        }

        $pengaduan->load(['lokasi', 'kategori', 'petugas']);

        $riwayat = $pengaduan->riwayat()
            ->with('user')
            ->oldest()
            ->get();

        return view('pelapor.pengaduan.show', compact('pengaduan', 'riwayat'));
    }
}