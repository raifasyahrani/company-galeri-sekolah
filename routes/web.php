<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\BeritaPageController;
use App\Http\Controllers\GaleriPageController;
use App\Http\Controllers\EkstrakulikulerPageController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminAkunController;
use App\Http\Controllers\AdminBerandaController;
use App\Http\Controllers\AdminProfilController;
use App\Http\Controllers\AdminBeritaController;
use App\Http\Controllers\AdminJurusanController;
use App\Http\Controllers\AdminJurusanHubController;
use App\Http\Controllers\AdminJurusanSeragamController;
use App\Http\Controllers\AdminJurusanKegiatanController;
use App\Http\Controllers\AdminJurusanProdukController;
use App\Http\Controllers\AdminJurusanDokumentasiController;
use App\Http\Controllers\AdminPrestasiController;
use App\Http\Controllers\AdminGaleriController;
use App\Http\Controllers\AdminEkskulController;

// ================= HALAMAN PUBLIK =================
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
Route::get('/berita', [BeritaPageController::class, 'index'])->name('berita');
Route::get('/jurusan', function () { return view('jurusan'); })->name('jurusan');
Route::get('/galeri', [GaleriPageController::class, 'index'])->name('galeri');
Route::get('/ekstrakulikuler', [EkstrakulikulerPageController::class, 'index'])->name('ekstrakulikuler');

// ================= ADMIN =================
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::middleware('admin.auth')->group(function () {

        Route::get('/', fn () => redirect()->route('admin.dashboard'))->name('index');
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // ---- AKUN (halaman profil admin yang login) ----
        Route::get('/akun', [AdminAkunController::class, 'index'])->name('akun');

        // ---- BERANDA ----
        Route::get('/beranda', [AdminBerandaController::class, 'edit'])->name('beranda');
        Route::put('/beranda', [AdminBerandaController::class, 'update'])->name('beranda.update');

        // ---- PROFIL ----
        Route::get('/profil', [AdminProfilController::class, 'edit'])->name('profil');
        Route::put('/profil', [AdminProfilController::class, 'update'])->name('profil.update');

        // ---- CRUD BERITA ----
        Route::get('/berita', [AdminBeritaController::class, 'index'])->name('berita');
        Route::get('/berita/tambah', [AdminBeritaController::class, 'create'])->name('berita.create');
        Route::post('/berita', [AdminBeritaController::class, 'store'])->name('berita.store');
        Route::get('/berita/{berita}/edit', [AdminBeritaController::class, 'edit'])->name('berita.edit');
        Route::put('/berita/{berita}', [AdminBeritaController::class, 'update'])->name('berita.update');
        Route::delete('/berita/{berita}', [AdminBeritaController::class, 'destroy'])->name('berita.destroy');

        // ---- JURUSAN: halaman utama per jurusan (tab TO/PPLG/TJKT/TPFL) ----
        Route::get('/jurusan', [AdminJurusanHubController::class, 'index'])->name('jurusan');

        // ---- CRUD DATA JURUSAN (nama, deskripsi, gambar) ----
        Route::get('/jurusan/daftar', [AdminJurusanController::class, 'index'])->name('jurusan.daftar');
        Route::get('/jurusan/tambah', [AdminJurusanController::class, 'create'])->name('jurusan.create');
        Route::post('/jurusan', [AdminJurusanController::class, 'store'])->name('jurusan.store');
        Route::get('/jurusan/{jurusan}/edit', [AdminJurusanController::class, 'edit'])->name('jurusan.edit');
        Route::put('/jurusan/{jurusan}', [AdminJurusanController::class, 'update'])->name('jurusan.update');
        Route::delete('/jurusan/{jurusan}', [AdminJurusanController::class, 'destroy'])->name('jurusan.destroy');

        // ---- CRUD BAGIAN JURUSAN: seragam, kegiatan, produk, dokumentasi ----
        foreach ([
            'seragam'     => AdminJurusanSeragamController::class,
            'kegiatan'    => AdminJurusanKegiatanController::class,
            'produk'      => AdminJurusanProdukController::class,
            'dokumentasi' => AdminJurusanDokumentasiController::class,
        ] as $bagian => $kelas) {
            Route::get("/jurusan-$bagian/tambah", [$kelas, 'create'])->name("jurusan.$bagian.create");
            Route::post("/jurusan-$bagian", [$kelas, 'store'])->name("jurusan.$bagian.store");
            Route::get("/jurusan-$bagian/{id}/edit", [$kelas, 'edit'])->name("jurusan.$bagian.edit");
            Route::put("/jurusan-$bagian/{id}", [$kelas, 'update'])->name("jurusan.$bagian.update");
            Route::delete("/jurusan-$bagian/{id}", [$kelas, 'destroy'])->name("jurusan.$bagian.destroy");
        }

        // ---- CRUD PRESTASI ----
        Route::get('/prestasi', [AdminPrestasiController::class, 'index'])->name('prestasi');
        Route::get('/prestasi/tambah', [AdminPrestasiController::class, 'create'])->name('prestasi.create');
        Route::post('/prestasi', [AdminPrestasiController::class, 'store'])->name('prestasi.store');
        Route::get('/prestasi/{prestasi}/edit', [AdminPrestasiController::class, 'edit'])->name('prestasi.edit');
        Route::put('/prestasi/{prestasi}', [AdminPrestasiController::class, 'update'])->name('prestasi.update');
        Route::delete('/prestasi/{prestasi}', [AdminPrestasiController::class, 'destroy'])->name('prestasi.destroy');

        // ---- CRUD GALERI ----
        Route::get('/galeri', [AdminGaleriController::class, 'index'])->name('galeri');
        Route::get('/galeri/tambah', [AdminGaleriController::class, 'create'])->name('galeri.create');
        Route::post('/galeri', [AdminGaleriController::class, 'store'])->name('galeri.store');
        Route::get('/galeri/{galeri}/edit', [AdminGaleriController::class, 'edit'])->name('galeri.edit');
        Route::put('/galeri/{galeri}', [AdminGaleriController::class, 'update'])->name('galeri.update');
        Route::delete('/galeri/{galeri}', [AdminGaleriController::class, 'destroy'])->name('galeri.destroy');

        // ---- CRUD EKSKUL (tetap) ----
        Route::get('/ekskul', [AdminEkskulController::class, 'index'])->name('ekskul');
        Route::get('/ekskul/tambah', [AdminEkskulController::class, 'create'])->name('ekskul.create');
        Route::post('/ekskul', [AdminEkskulController::class, 'store'])->name('ekskul.store');
        Route::post('/ekskul/impor', [AdminEkskulController::class, 'impor'])->name('ekskul.impor');
        Route::get('/ekskul/{ekskul}/edit', [AdminEkskulController::class, 'edit'])->name('ekskul.edit');
        Route::put('/ekskul/{ekskul}', [AdminEkskulController::class, 'update'])->name('ekskul.update');
        Route::delete('/ekskul/{ekskul}', [AdminEkskulController::class, 'destroy'])->name('ekskul.destroy');
    });
});