<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Hitung jumlah baris tabel. Kalau tabel belum ada, hasilnya 0 (tidak error).
        $hitung = fn (string $tabel) => Schema::hasTable($tabel) ? DB::table($tabel)->count() : 0;

        return view('admin.dashboard', [
            'totalBerita'  => $hitung('beritas'),
            'totalProduk'  => $hitung('produks'),
            'totalJurusan' => $hitung('jurusans'),
            'totalEkskul'  => $hitung('ekskuls'),
            'totalGaleri'  => $hitung('galeris'),
        ]);
    }
}