<?php

namespace App\Http\Controllers;

use App\Models\Galeri;

class GaleriPageController extends Controller
{
    public function index()
    {
        // Foto terbaru tampil paling atas
        $galeriList = Galeri::orderByDesc('id')->get();

        return view('galeri', compact('galeriList'));
    }
}