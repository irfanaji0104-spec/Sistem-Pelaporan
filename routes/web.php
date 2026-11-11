<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
// use App\Http\Controllers\Auth\RegisterController; // [REVISI] Register dimatikan
use App\Http\Controllers\PengaturanAkunController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Pelapor\PengaduanController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DataMasterController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\LokasiController;
use App\Http\Controllers\Admin\PetugasController;
use App\Http\Controllers\Admin\VerifikasiController;
use App\Http\Controllers\Admin\LaporanController;

// ============ Redirect root ============
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('pelapor.dashboard');
    }
    return redirect()->route('login');
});

// ============ Guest ============
Route::middleware('guest')->group(function () {
    Route::get('/login',     [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login',    [LoginController::class, 'login'])->name('login.post');

    // [REVISI] Route Register Dihapus agar siswa tidak bisa daftar sendiri
    // Route::get('/register',  [RegisterController::class, 'showRegisterForm'])->name('register');
    // Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
});

// ============ Logout ============
Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ============ Auth Routes ============
Route::middleware('auth')->group(function () {
    // Pengaturan Akun
    Route::get('/pengaturan-akun', [PengaturanAkunController::class, 'index'])->name('pengaturan.index');
    Route::put('/pengaturan-akun/profile',  [PengaturanAkunController::class, 'updateProfile'])->name('pengaturan.update-profile');
    Route::put('/pengaturan-akun/password', [PengaturanAkunController::class, 'updatePassword'])->name('pengaturan.update-password');

    // Notifikasi
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/mark-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all');
});

// ============ AREA ADMIN ============
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        
        // Dashboard & Pengaturan
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/pengaturan-akun', [PengaturanAkunController::class, 'index'])->name('pengaturan');

        // Data Master
        Route::get('/data-master', [DataMasterController::class, 'index'])->name('data-master');
        
        Route::get('/data-master/users/create',        [UserController::class, 'create'])->name('users.create');
        Route::post('/data-master/users',              [UserController::class, 'store'])->name('users.store');
        Route::get('/data-master/users/{user}/edit',   [UserController::class, 'edit'])->name('users.edit');
        Route::put('/data-master/users/{user}',        [UserController::class, 'update'])->name('users.update');
        Route::patch('/data-master/users/{user}/toggle', [UserController::class, 'toggleActive'])->name('users.toggle');

        Route::get('/data-master/kategori/create',     [KategoriController::class, 'create'])->name('kategori.create');
        Route::post('/data-master/kategori',           [KategoriController::class, 'store'])->name('kategori.store');
        Route::get('/data-master/kategori/{kategori}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
        Route::put('/data-master/kategori/{kategori}', [KategoriController::class, 'update'])->name('kategori.update');
        Route::delete('/data-master/kategori/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

        Route::get('/data-master/lokasi/create',       [LokasiController::class, 'create'])->name('lokasi.create');
        Route::post('/data-master/lokasi',             [LokasiController::class, 'store'])->name('lokasi.store');
        Route::get('/data-master/lokasi/{lokasi}/edit', [LokasiController::class, 'edit'])->name('lokasi.edit');
        Route::put('/data-master/lokasi/{lokasi}',     [LokasiController::class, 'update'])->name('lokasi.update');
        Route::delete('/data-master/lokasi/{lokasi}',  [LokasiController::class, 'destroy'])->name('lokasi.destroy');

        // Data Petugas
        Route::get('/petugas',                    [PetugasController::class, 'index'])->name('petugas');
        Route::get('/petugas/create',             [PetugasController::class, 'create'])->name('petugas.create');
        Route::post('/petugas',                   [PetugasController::class, 'store'])->name('petugas.store');
        Route::get('/petugas/{petugas}/edit',     [PetugasController::class, 'edit'])->name('petugas.edit');
        Route::put('/petugas/{petugas}',          [PetugasController::class, 'update'])->name('petugas.update');
        Route::delete('/petugas/{petugas}',       [PetugasController::class, 'destroy'])->name('petugas.destroy');

        // Verifikasi Pengaduan
        Route::get('/verifikasi',                    [VerifikasiController::class, 'index'])->name('verifikasi');
        Route::get('/verifikasi/{pengaduan}',        [VerifikasiController::class, 'show'])->name('verifikasi.show');
        Route::post('/verifikasi/{pengaduan}/approve', [VerifikasiController::class, 'approve'])->name('verifikasi.approve');
        Route::post('/verifikasi/{pengaduan}/reject',  [VerifikasiController::class, 'reject'])->name('verifikasi.reject');
        Route::post('/verifikasi/{pengaduan}/progress',[VerifikasiController::class, 'storeProgress'])->name('verifikasi.progress');
        Route::post('/verifikasi/{pengaduan}/complete',[VerifikasiController::class, 'complete'])->name('verifikasi.complete');

        // Laporan
        Route::get('/laporan',          [LaporanController::class, 'index'])->name('laporan');
        Route::get('/laporan/pdf',      [LaporanController::class, 'exportPdf'])->name('laporan.pdf');
        Route::get('/laporan/excel',    [LaporanController::class, 'exportExcel'])->name('laporan.excel');
    });

// ============ AREA PELAPOR ============
// [REVISI] Menambahkan akses role petugas jika petugas juga mengakses panel yang mirip
Route::middleware(['auth', 'role:siswa,guru,petugas'])
    ->prefix('pelapor')
    ->name('pelapor.')
    ->group(function () {
        Route::get('/dashboard', [PengaduanController::class, 'dashboard'])->name('dashboard');
        Route::get('/pengaduan/create', [PengaduanController::class, 'create'])->name('pengaduan.create');
        Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');
        Route::get('/pengaduan/{pengaduan}', [PengaduanController::class, 'show'])->name('pengaduan.show');
        
        Route::get('/pengaturan-akun', [PengaturanAkunController::class, 'index'])->name('pengaturan');
    });