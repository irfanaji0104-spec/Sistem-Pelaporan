<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriKerusakan;
use App\Models\Lokasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DataMasterController extends Controller
{
    public function index(Request $request): View
    {
        $tab = $request->query('tab', 'pengguna'); // pengguna | kategori | lokasi

        $users = User::query()
            ->when($request->search, fn($q, $s) =>
                $q->where('name', 'like', "%{$s}%")->orWhere('email', 'like', "%{$s}%")
            )
            ->orderBy('role')->orderBy('name')
            ->paginate(10, ['*'], 'users_page')
            ->withQueryString();

        $kategori = KategoriKerusakan::orderBy('nama_kategori')
            ->paginate(10, ['*'], 'kategori_page')
            ->withQueryString();

        $lokasi = Lokasi::orderBy('nama_lokasi')
            ->paginate(10, ['*'], 'lokasi_page')
            ->withQueryString();

        return view('admin.data-master.index', compact('users', 'kategori', 'lokasi', 'tab'));
    }
}