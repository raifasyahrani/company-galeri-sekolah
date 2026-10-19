<?php

namespace App\Http\Controllers;

use App\Models\Artikel;

class ArtikelPageController extends Controller
{
    public function index()
    {
        return view('artikel', ['artikels' => Artikel::orderByDesc('id')->get()]);
    }

    public function show(string $slug)
    {
        $artikel = Artikel::where('slug', $slug)->firstOrFail();

        // Artikel terkait: utamakan kategori yang sama, lalu yang terbaru
        $terkait = Artikel::where('id', '!=', $artikel->id)
            ->orderByRaw('kategori = ? desc', [$artikel->kategori])
            ->orderByDesc('id')
            ->take(3)
            ->get();

        return view('artikel-show', compact('artikel', 'terkait'));
    }
}