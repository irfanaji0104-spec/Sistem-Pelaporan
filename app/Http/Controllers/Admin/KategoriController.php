<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\KategoriRequest;
use App\Models\KategoriKerusakan;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class KategoriController extends Controller
{
    public function create(): View
    {
        return view('admin.kategori.create');
    }

    public function store(KategoriRequest $request): RedirectResponse
    {
        KategoriKerusakan::create($request->validated());

        return redirect()
            ->route('admin.data-master', ['tab' => 'kategori'])
            ->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    public function edit(KategoriKerusakan $kategori): View
    {
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(KategoriRequest $request, KategoriKerusakan $kategori): RedirectResponse
    {
        $kategori->update($request->validated());

        return redirect()
            ->route('admin.data-master', ['tab' => 'kategori'])
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(KategoriKerusakan $kategori): RedirectResponse
    {
        // Cek apakah masih dipakai di pengaduan
        if ($kategori->pengaduan()->exists()) {
            return back()->with('error', "Kategori '{$kategori->nama_kategori}' tidak dapat dihapus karena masih dipakai pada pengaduan.");
        }

        $kategori->delete();

        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}