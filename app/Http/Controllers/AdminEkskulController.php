<?php

namespace App\Http\Controllers;

use App\Models\Ekskul;

class AdminEkskulController extends AdminCrudController
{
    protected function cfg(): array
    {
        return [
            'model' => Ekskul::class, 'title' => 'Ekskul', 'subtitle' => 'Kelola ekstrakurikuler yang tampil di halaman publik',
            'route' => 'admin.ekskul', 'folder' => 'ekskul', 'order' => ['urutan', 'asc'],
            'columns' => [
                ['name' => 'foto_sampul', 'label' => 'Sampul', 'type' => 'image'],
                ['name' => 'nama', 'label' => 'Nama'],
                ['name' => 'ketua', 'label' => 'Ketua'],
                ['name' => 'pembina', 'label' => 'Pembina'],
                ['name' => 'jumlah_anggota', 'label' => 'Anggota'],
            ],
            'fields' => [
                ['name' => 'nama', 'label' => 'Nama Ekskul', 'type' => 'text', 'rules' => 'required|string|max:255'],
                ['name' => 'deskripsi', 'label' => 'Deskripsi', 'type' => 'textarea', 'rows' => 5, 'rules' => 'required|string'],
                ['name' => 'ketua', 'label' => 'Ketua Ekskul', 'type' => 'text', 'rules' => 'nullable|string|max:255'],
                ['name' => 'pembina', 'label' => 'Pembina', 'type' => 'text', 'rules' => 'nullable|string|max:255'],
                ['name' => 'jumlah_anggota', 'label' => 'Jumlah Anggota', 'type' => 'text', 'rules' => 'nullable|integer|min:0'],
                ['name' => 'hari_latihan', 'label' => 'Hari Latihan', 'type' => 'text', 'placeholder' => 'contoh: Rabu,Sabtu (pisahkan dengan koma)', 'rules' => 'nullable|string|max:100'],
                ['name' => 'jam_latihan', 'label' => 'Jam Latihan', 'type' => 'text', 'placeholder' => 'contoh: 15.00 - 17.00 WIB', 'rules' => 'nullable|string|max:100'],
                ['name' => 'urutan', 'label' => 'Urutan Tampil', 'type' => 'text', 'placeholder' => 'angka kecil tampil lebih dulu', 'rules' => 'nullable|integer|min:0'],
                ['name' => 'gambar', 'label' => 'Logo (maks 2 MB)', 'type' => 'image', 'rules' => 'nullable|image|max:2048'],
                ['name' => 'foto_sampul', 'label' => 'Foto Sampul (maks 2 MB)', 'type' => 'image', 'rules' => 'nullable|image|max:2048'],
            ],
        ];
    }

    // Daftar kartu
    public function index()
    {
        $c = $this->cfg();
        $items = $c['model']::orderBy('urutan')->get();

        return view('admin.crud.ekskul', compact('c', 'items'));
    }

    // Form tambah
    public function create()
    {
        return view('admin.crud.ekskul_form', ['c' => $this->cfg(), 'item' => null]);
    }

    // Form edit
    public function edit($id)
    {
        $c = $this->cfg();
        $item = $c['model']::findOrFail($id);

        return view('admin.crud.ekskul_form', compact('c', 'item'));
    }
}