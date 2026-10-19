<?php

namespace App\Http\Controllers;

use App\Models\Galeri;

class GaleriPageController extends Controller
{
    public function index()
    {
        return view('galeri', ['galeris' => Galeri::orderByDesc('id')->get()]);
    }
}
