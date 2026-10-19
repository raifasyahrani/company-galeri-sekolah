<?php

namespace App\Http\Controllers;

use App\Models\Pesan;
use Illuminate\Http\Request;

class KontakController extends Controller
{
    public function index()
    {
        return view('kontak');
    }

    public function kirim(Request $request)
    {
        $data = $request->validate([
            'nama'  => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'pesan' => 'required|string|max:2000',
        ], [
            'nama.required'  => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
            'pesan.required' => 'Pesan wajib diisi.',
        ]);

        Pesan::create($data);

        return redirect()->route('kontak')->with('success', 'Pesan Anda berhasil dikirim. Terima kasih!');
    }
}
