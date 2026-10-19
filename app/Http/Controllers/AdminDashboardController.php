<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $hitung = fn (string $tabel) => Schema::hasTable($tabel) ? DB::table($tabel)->count() : 0;

        return view('admin.dashboard', [
            'totalLayanan' => $hitung('layanans'),
            'totalArtikel' => $hitung('artikels'),
            'totalGaleri'  => $hitung('galeris'),
            'totalPesan'   => $hitung('pesans'),
        ]);
    }
}
