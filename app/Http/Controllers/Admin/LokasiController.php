<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LokasiRequest;
use App\Models\Lokasi;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LokasiController extends Controller
{
    public function create(): View
    {
        return view('admin.lokasi.create');
    }

    public function store(LokasiRequest $request): RedirectResponse
    {
        Lokasi::create($request->validated());

        return redirect()
            ->route('admin.data-master', ['tab' => 'lokasi'])
            ->with('success', 'Lokasi baru berhasil ditambahkan.');
    }

    public function edit(Lokasi $lokasi): View
    {
        return view('admin.lokasi.edit', compact('lokasi'));
    }

    public function update(LokasiRequest $request, Lokasi $lokasi): RedirectResponse
    {
        $lokasi->update($request->validated());

        return redirect()
            ->route('admin.data-master', ['tab' => 'lokasi'])
            ->with('success', 'Lokasi berhasil diperbarui.');
    }

    public function destroy(Lokasi $lokasi): RedirectResponse
    {
        if ($lokasi->pengaduan()->exists()) {
            return back()->with('error', "Lokasi '{$lokasi->nama_lokasi}' tidak dapat dihapus karena masih dipakai pada pengaduan.");
        }

        $lokasi->delete();

        return back()->with('success', 'Lokasi berhasil dihapus.');
    }
}