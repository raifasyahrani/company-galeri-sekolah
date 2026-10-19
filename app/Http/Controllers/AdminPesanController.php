<?php

namespace App\Http\Controllers;

use App\Models\Pesan;

class AdminPesanController extends Controller
{
    public function index()
    {
        return view('admin.pesan', ['pesans' => Pesan::latest()->get()]);
    }

    public function destroy(Pesan $pesan)
    {
        $pesan->delete();

        return back()->with('success', 'Pesan berhasil dihapus.');
    }
}
