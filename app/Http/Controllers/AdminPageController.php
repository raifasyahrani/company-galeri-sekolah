<?php

namespace App\Http\Controllers;

use App\Models\Ekskul;

class AdminPageController extends Controller
{
    public function index()
    {
        $ekskuls = Ekskul::orderBy('urutan')->orderBy('nama')->get();

        return view('ekstrakulikuler', compact('ekskuls'));
    }

    public function profil()
    {
        return view('admin.profil'); // sesuaikan dengan nama file view kamu
    }
}