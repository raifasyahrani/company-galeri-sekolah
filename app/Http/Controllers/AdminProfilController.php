<?php

namespace App\Http\Controllers;

use App\Models\Profil;
use Illuminate\Http\Request;

class AdminProfilController extends Controller
{
    public function edit()
    {
        return view('admin.profil', ['profil' => Profil::first() ?? Profil::create([])]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'sejarah'       => 'nullable|string',
            'visi'          => 'nullable|string',
            'misi'          => 'nullable|string',
            'direktur'      => 'nullable|string|max:255',
            'legalitas'     => 'nullable|string|max:255',
            'tahun_berdiri' => 'nullable|string|max:10',
        ]);

        (Profil::first() ?? Profil::create([]))->update($data);

        return redirect()->route('admin.profil')->with('success', 'Profil perusahaan berhasil diperbarui.');
    }
}
