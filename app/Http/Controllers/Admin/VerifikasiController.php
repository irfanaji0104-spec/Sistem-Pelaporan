<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ApprovePengaduanRequest;
use App\Http\Requests\Admin\CompletePengaduanRequest;
use App\Http\Requests\Admin\ProgressPengaduanRequest;
use App\Http\Requests\Admin\RejectPengaduanRequest;
use App\Models\Pengaduan;
use App\Models\Petugas;
use App\Models\RiwayatStatus;
use App\Notifications\PengaduanStatusUpdated;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class VerifikasiController extends Controller
{
    public function index(Request $request): View
    {
        $pengaduan = Pengaduan::query()
            ->with(['user', 'lokasi', 'kategori'])
            ->when($request->search, function ($q, $search) {
                $q->whereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('lokasi', fn($l) => $l->where('nama_lokasi', 'like', "%{$search}%"));
            })
            ->when($request->status, fn($q, $status) => $q->where('status', $status))
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.verifikasi.index', compact('pengaduan'));
    }

    public function show(Pengaduan $pengaduan): View
    {
        $pengaduan->load(['user', 'lokasi', 'kategori', 'petugas']);
        
        $riwayat = $pengaduan->riwayat()->with('user')->oldest()->get();
        $petugas = Petugas::orderBy('nama')->get();

        return view('admin.verifikasi.show', compact('pengaduan', 'riwayat', 'petugas'));
    }

    public function approve(ApprovePengaduanRequest $request, Pengaduan $pengaduan): RedirectResponse
    {
        if ($pengaduan->status !== 'pending') {
            return back()->with('error', 'Status pengaduan ini sudah diproses.');
        }

        DB::transaction(function () use ($request, $pengaduan) {
            $pengaduan->update([
                'status'     => 'approved',
                'petugas_id' => $request->petugas_id,
            ]);

            RiwayatStatus::create([
                'pengaduan_id'      => $pengaduan->id,
                'diubah_oleh'       => Auth::id(),
                'status_sebelumnya' => 'pending',
                'status_baru'       => 'approved',
                'keterangan'        => 'Pengaduan divalidasi dan ditugaskan ke ' . $pengaduan->petugas->nama . '.',
            ]);

            $pengaduan->user->notify(new PengaduanStatusUpdated(
                $pengaduan,
                "Pengaduan {$pengaduan->kode} telah disetujui dan sedang diproses."
            ));
        });

        return redirect()->route('admin.verifikasi.show', $pengaduan)->with('success', 'Pengaduan berhasil disetujui.');
    }

    public function reject(RejectPengaduanRequest $request, Pengaduan $pengaduan): RedirectResponse
    {
        if ($pengaduan->status !== 'pending') {
            return back()->with('error', 'Status pengaduan ini sudah diproses.');
        }

        DB::transaction(function () use ($request, $pengaduan) {
            $pengaduan->update([
                'status'        => 'rejected',
                'catatan_admin' => $request->catatan_admin,
            ]);

            RiwayatStatus::create([
                'pengaduan_id'      => $pengaduan->id,
                'diubah_oleh'       => Auth::id(),
                'status_sebelumnya' => 'pending',
                'status_baru'       => 'rejected',
                'keterangan'        => 'Pengaduan ditolak: ' . $request->catatan_admin,
            ]);

            $pengaduan->user->notify(new PengaduanStatusUpdated(
                $pengaduan,
                "Pengaduan {$pengaduan->kode} ditolak. Alasan: {$request->catatan_admin}"
            ));
        });

        return redirect()->route('admin.verifikasi.show', $pengaduan)->with('success', 'Pengaduan berhasil ditolak.');
    }

    public function storeProgress(ProgressPengaduanRequest $request, Pengaduan $pengaduan): RedirectResponse
    {
        if ($pengaduan->status !== 'approved') {
            return back()->with('error', 'Hanya pengaduan berstatus Diproses yang dapat ditambahkan progres.');
        }

        DB::transaction(function () use ($request, $pengaduan) {
            RiwayatStatus::create([
                'pengaduan_id'      => $pengaduan->id,
                'diubah_oleh'       => Auth::id(),
                'status_sebelumnya' => 'approved',
                'status_baru'       => 'approved',
                'keterangan'        => 'Progres: ' . $request->keterangan,
            ]);

            $pengaduan->user->notify(new PengaduanStatusUpdated(
                $pengaduan,
                "Update progres untuk pengaduan {$pengaduan->kode}: {$request->keterangan}"
            ));
        });

        return back()->with('success', 'Catatan progres berhasil ditambahkan.');
    }

    public function complete(CompletePengaduanRequest $request, Pengaduan $pengaduan): RedirectResponse
    {
        if ($pengaduan->status !== 'approved') {
            return back()->with('error', 'Hanya pengaduan berstatus Diproses yang dapat diselesaikan.');
        }

        DB::transaction(function () use ($request, $pengaduan) {
            $pengaduan->update([
                'status'          => 'selesai',
                'tanggal_selesai' => $request->tanggal_selesai,
            ]);

            RiwayatStatus::create([
                'pengaduan_id'      => $pengaduan->id,
                'diubah_oleh'       => Auth::id(),
                'status_sebelumnya' => 'approved',
                'status_baru'       => 'selesai',
                'keterangan'        => $request->keterangan ?: 'Perbaikan selesai.',
            ]);

            $pengaduan->user->notify(new PengaduanStatusUpdated(
                $pengaduan,
                "Pengaduan {$pengaduan->kode} telah selesai diperbaiki."
            ));
        });

        return redirect()->route('admin.verifikasi.show', $pengaduan)->with('success', 'Pengaduan telah ditandai selesai.');
    }
}