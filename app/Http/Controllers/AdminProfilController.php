<?php

namespace App\Http\Controllers;

use App\Models\Profil;
use Illuminate\Http\Request;

class AdminProfilController extends Controller
{
    public function edit()
    {
        return view('admin.profil', ['profil' => Profil::first()]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'sejarah'        => 'nullable|string',
            'visi'           => 'nullable|string',
            'misi'           => 'nullable|string',
            'kepala_sekolah' => 'nullable|string|max:255',
            'akreditasi'     => 'nullable|string|max:20',
            'tahun_berdiri'  => 'nullable|string|max:10',
        ]);

        Profil::firstOrFail()->update($data);

        return redirect()->route('admin.profil')->with('success', 'Profil berhasil diperbarui.');
    }
}