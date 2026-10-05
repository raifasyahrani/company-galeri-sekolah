<?php

namespace App\Http\Controllers;

use App\Models\Beranda;

class WelcomeController extends Controller
{
    public function index()
    {
        $beranda = Beranda::first();
        return view('welcome', compact('beranda'));
    }
}