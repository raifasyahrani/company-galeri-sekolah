<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Galeri;
use App\Models\Layanan;
use App\Models\Profil;

class WelcomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'profil'   => Profil::first(),
            'layanans' => Layanan::orderBy('id')->take(6)->get(),
            'artikels' => Artikel::orderByDesc('id')->take(3)->get(),
            'galeris'  => Galeri::orderByDesc('id')->take(6)->get(),
        ]);
    }
}