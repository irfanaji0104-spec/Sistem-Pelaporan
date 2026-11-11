<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PengaturanAkunController extends Controller
{
    /**
     * Tampilkan halaman pengaturan akun.
     */
    public function index(): View
    {
        return view('pengaturan-akun.index', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Update profil (nama, email, foto).
     */
    public function updateProfile(UpdateProfileRequest $request): RedirectResponse
    {
        $user = Auth::user();
        
        // [REVISI] Hanya mengambil file foto saja, name dan email diabaikan/tidak diupdate
        $dataToUpdate = [];

        // Handle upload foto profil
        if ($request->hasFile('foto_profil')) {
            // Hapus foto lama kalau ada
            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            $dataToUpdate['foto_profil'] = $request->file('foto_profil')->store('foto-profil', 'public');
            
            // Simpan update hanya untuk foto
            $user->update($dataToUpdate);
            return back()->with('success', 'Foto profil berhasil diperbarui.');
        }

        // Jika tidak ada upload foto (misalnya user submit form biasa), tidak ada yang diubah
        return back();
    }

    /**
     * Update password.
     */
    public function updatePassword(UpdatePasswordRequest $request): RedirectResponse
    {
        Auth::user()->update([
            'password' => Hash::make($request->validated()['password_baru']),
        ]);

        return back()->with('success', 'Password berhasil diubah.');
    }
}