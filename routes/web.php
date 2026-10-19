<?php

use App\Http\Controllers\AdminAkunController;
use App\Http\Controllers\AdminArtikelController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminGaleriController;
use App\Http\Controllers\AdminLayananController;
use App\Http\Controllers\AdminPesanController;
use App\Http\Controllers\AdminProfilController;
use App\Http\Controllers\ArtikelPageController;
use App\Http\Controllers\GaleriPageController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\LayananPageController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

// ================= HALAMAN PUBLIK =================
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
Route::get('/layanan', [LayananPageController::class, 'index'])->name('layanan');
Route::get('/layanan/{layanan}', [LayananPageController::class, 'show'])->name('layanan.show');
Route::get('/artikel', [ArtikelPageController::class, 'index'])->name('artikel');
Route::get('/artikel/{slug}', [ArtikelPageController::class, 'show'])->name('artikel.show');
Route::get('/galeri', [GaleriPageController::class, 'index'])->name('galeri');
Route::get('/kontak', [KontakController::class, 'index'])->name('kontak');
Route::post('/kontak', [KontakController::class, 'kirim'])->name('kontak.kirim');

// ================= ADMIN =================
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::middleware('admin.auth')->group(function () {

        Route::get('/', fn () => redirect()->route('admin.dashboard'))->name('index');
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/akun', [AdminAkunController::class, 'index'])->name('akun');

        // ---- PROFIL (statis: hanya edit, tidak ada tambah/hapus) ----
        Route::get('/profil', [AdminProfilController::class, 'edit'])->name('profil');
        Route::put('/profil', [AdminProfilController::class, 'update'])->name('profil.update');

        // ---- CRUD LAYANAN ----
        Route::get('/layanan', [AdminLayananController::class, 'index'])->name('layanan');
        Route::get('/layanan/tambah', [AdminLayananController::class, 'create'])->name('layanan.create');
        Route::post('/layanan', [AdminLayananController::class, 'store'])->name('layanan.store');
        Route::get('/layanan/{layanan}/edit', [AdminLayananController::class, 'edit'])->name('layanan.edit');
        Route::put('/layanan/{layanan}', [AdminLayananController::class, 'update'])->name('layanan.update');
        Route::delete('/layanan/{layanan}', [AdminLayananController::class, 'destroy'])->name('layanan.destroy');

        // ---- CRUD ARTIKEL ----
        Route::get('/artikel', [AdminArtikelController::class, 'index'])->name('artikel');
        Route::get('/artikel/tambah', [AdminArtikelController::class, 'create'])->name('artikel.create');
        Route::post('/artikel', [AdminArtikelController::class, 'store'])->name('artikel.store');
        Route::get('/artikel/{artikel}/edit', [AdminArtikelController::class, 'edit'])->name('artikel.edit');
        Route::put('/artikel/{artikel}', [AdminArtikelController::class, 'update'])->name('artikel.update');
        Route::delete('/artikel/{artikel}', [AdminArtikelController::class, 'destroy'])->name('artikel.destroy');

        // ---- CRUD GALERI ----
        Route::get('/galeri', [AdminGaleriController::class, 'index'])->name('galeri');
        Route::get('/galeri/tambah', [AdminGaleriController::class, 'create'])->name('galeri.create');
        Route::post('/galeri', [AdminGaleriController::class, 'store'])->name('galeri.store');
        Route::get('/galeri/{galeri}/edit', [AdminGaleriController::class, 'edit'])->name('galeri.edit');
        Route::put('/galeri/{galeri}', [AdminGaleriController::class, 'update'])->name('galeri.update');
        Route::delete('/galeri/{galeri}', [AdminGaleriController::class, 'destroy'])->name('galeri.destroy');

        // ---- PESAN MASUK (dari form Kontak Kami) ----
        Route::get('/pesan', [AdminPesanController::class, 'index'])->name('pesan');
        Route::delete('/pesan/{pesan}', [AdminPesanController::class, 'destroy'])->name('pesan.destroy');
    });
});