<?php

namespace App\Http\Controllers;

use App\Models\Layanan;

class LayananPageController extends Controller
{
    public function index()
    {
        return view('layanan', [
            'produks' => Layanan::where('jenis', 'Produk')->orderBy('id')->get(),
            'jasas'   => Layanan::where('jenis', 'Layanan')->orderBy('id')->get(),
        ]);
    }

    public function show(Layanan $layanan)
    {
        $lainnya = Layanan::where('id', '!=', $layanan->id)->inRandomOrder()->take(3)->get();

        return view('layanan-show', compact('layanan', 'lainnya'));
    }
}