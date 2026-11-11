<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Tampilkan form login.
     */
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    /**
     * Proses login: cek by email ATAU no_induk.
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        // Cari user berdasarkan email ATAU no_induk
        $user = User::where('email', $credentials['login'])
            ->orWhere('no_induk', $credentials['login'])
            ->first();

        // Cek user ada & password benar
        if (!$user || !\Illuminate\Support\Facades\Hash::check($credentials['password'], $user->password)) {
            return back()
                ->withInput($request->only('login'))
                ->withErrors(['login' => 'Email / NIS / NIP atau password salah.']);
        }

        // Cek is_active
        if (!$user->is_active) {
            return back()
                ->withInput($request->only('login'))
                ->withErrors(['login' => 'Akun Anda dinonaktifkan. Hubungi Admin sekolah.']);
        }

        // Login + regenerate session
        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        // Redirect sesuai role
        return redirect()->intended($this->redirectPathFor($user));
    }

    /**
     * Logout.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }

    /**
     * Tentukan path redirect setelah login.
     */
    private function redirectPathFor(User $user): string
    {
        return $user->isAdmin()
            ? route('admin.dashboard')
            : route('pelapor.dashboard');
    }
}