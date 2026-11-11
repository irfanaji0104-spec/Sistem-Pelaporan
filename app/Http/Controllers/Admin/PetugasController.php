<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PetugasRequest;
use App\Models\Petugas;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PetugasController extends Controller
{
    public function index(Request $request): View
    {
        $petugas = Petugas::query()
            ->when($request->search, fn($q, $s) =>
                $q->where('nama', 'like', "%{$s}%")->orWhere('spesialisasi', 'like', "%{$s}%")
            )
            ->withCount(['tugasAktif'])
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        return view('admin.petugas.index', compact('petugas'));
    }

    public function create(): View
    {
        return view('admin.petugas.create');
    }

    public function store(PetugasRequest $request): RedirectResponse
    {
        Petugas::create($request->validated());

        return redirect()
            ->route('admin.petugas')
            ->with('success', 'Petugas baru berhasil ditambahkan.');
    }

    public function edit(Petugas $petugas): View
    {
        return view('admin.petugas.edit', compact('petugas'));
    }

    public function update(PetugasRequest $request, Petugas $petugas): RedirectResponse
    {
        $petugas->update($request->validated());

        return redirect()
            ->route('admin.petugas')
            ->with('success', 'Data petugas berhasil diperbarui.');
    }

    public function destroy(Petugas $petugas): RedirectResponse
    {
        if ($petugas->pengaduan()->exists()) {
            return back()->with('error', "Petugas '{$petugas->nama}' tidak dapat dihapus karena masih terkait dengan pengaduan.");
        }

        $petugas->delete();

        return back()->with('success', 'Petugas berhasil dihapus.');
    }
}