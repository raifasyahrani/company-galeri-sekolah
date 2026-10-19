<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Profil;

class ProfilController extends Controller
{
    public function index()
    {
        // Profil bersifat statis: hanya ada satu baris data
        $profil = Profil::first() ?? new Profil();

        // Ringkasan bidang usaha diambil dari data layanan (dinamis dari admin)
        $layanans = Layanan::orderBy('id')->take(6)->get();

        return view('profil', compact('profil', 'layanans'));
    }
}