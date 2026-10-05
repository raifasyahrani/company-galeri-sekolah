<?php

namespace App\Http\Controllers;

use App\Models\Beranda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminBerandaController extends Controller
{
    public function edit()
    {
        $beranda = Beranda::first();
        return view('admin.beranda.edit', compact('beranda'));
    }

    public function update(Request $request)
    {
        $beranda = Beranda::firstOrFail();

        $data = $request->validate([
            'hero_judul'    => 'required|string|max:255',
            'hero_subjudul' => 'nullable|string|max:255',
            'hero_gambar'   => 'nullable|image|max:2048',
            'tombol_teks'   => 'nullable|string|max:50',
            'tombol_link'   => 'nullable|string|max:255',
            'tentang_judul' => 'required|string|max:255',
            'tentang_isi'   => 'required|string',
            'stat_siswa'    => 'required|integer|min:0',
            'stat_guru'     => 'required|integer|min:0',
            'stat_jurusan'  => 'required|integer|min:0',
            'stat_prestasi' => 'required|integer|min:0',
            'alamat'        => 'nullable|string|max:255',
            'telepon'       => 'nullable|string|max:50',
            'email_sekolah' => 'nullable|email|max:255',
        ]);

        if ($request->hasFile('hero_gambar')) {
            if ($beranda->hero_gambar) {
                Storage::disk('public')->delete($beranda->hero_gambar);
            }
            $data['hero_gambar'] = $request->file('hero_gambar')->store('beranda', 'public');
        } else {
            unset($data['hero_gambar']);
        }

        $beranda->update($data);

        return redirect()->route('admin.beranda')->with('success', 'Beranda berhasil diperbarui.');
    }
}