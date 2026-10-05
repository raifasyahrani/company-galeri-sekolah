<?php

namespace App\Http\Controllers;

use App\Models\Ekskul;

class EkstrakulikulerPageController extends Controller
{
    public function index()
    {
        // Kalau tabel masih kosong (pertama kali), 10 ekskul awal dimasukkan otomatis
        Ekskul::isiDataAwalJikaKosong();

        // Data diambil dari database (diatur lewat Dashboard Admin > Ekskul)
        $ekskuls = Ekskul::orderBy('urutan')->orderBy('nama')->get();

        return view('ekstrakulikuler', compact('ekskuls'));
    }
}