<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class AdminAkunController extends Controller
{
    public function index(): View
    {
        return view('admin.akun');
    }
}