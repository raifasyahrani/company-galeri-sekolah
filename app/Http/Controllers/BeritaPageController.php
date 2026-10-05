<?php

namespace App\Http\Controllers;

use App\Models\Berita;

class BeritaPageController extends Controller
{
    public function index()
    {
        $jurusanInfo = [
            'TO'   => ['label' => 'Teknik Otomotif',                           'logo' => 'TKRO.png'],
            'PPLG' => ['label' => 'Pengembangan Perangkat Lunak dan Gim',       'logo' => 'PPLG.png'],
            'TJKT' => ['label' => 'Teknik Jaringan Komputer & Telekomunikasi',  'logo' => 'TJKT.png'],
            'TPFL' => ['label' => 'Teknik Pengelasan Fabrikasi Logam',          'logo' => 'TPFL.png'],
            'Umum' => ['label' => 'Umum / Seluruh Jurusan',                    'logo' => 'LOGO.png'],
        ];

        // Berita terbaru (id terbesar) tampil pertama dan menjadi berita unggulan
        $daftarBerita = Berita::orderByDesc('id')->get();
        $kategoriList = ['Semua', 'Prestasi', 'Kegiatan', 'Informasi'];

        return view('berita', compact('daftarBerita', 'jurusanInfo', 'kategoriList'));
    }
}