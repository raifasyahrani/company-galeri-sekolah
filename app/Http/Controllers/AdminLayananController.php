<?php

namespace App\Http\Controllers;

use App\Models\Layanan;

class AdminLayananController extends AdminCrudController
{
    protected function cfg(): array
    {
        return [
            'model' => Layanan::class, 'title' => 'Produk & Layanan', 'subtitle' => 'Kelola produk dan layanan perusahaan',
            'route' => 'admin.layanan', 'folder' => 'layanan', 'order' => ['id', 'desc'],
            'columns' => [
                ['name' => 'gambar', 'label' => 'Gambar', 'type' => 'image'],
                ['name' => 'nama', 'label' => 'Nama'],
                ['name' => 'jenis', 'label' => 'Jenis'],
                ['name' => 'deskripsi', 'label' => 'Deskripsi'],
            ],
            'fields' => [
                ['name' => 'nama', 'label' => 'Nama produk / layanan', 'type' => 'text', 'rules' => 'required|string|max:255'],
                ['name' => 'jenis', 'label' => 'Jenis', 'type' => 'select', 'options' => ['Produk', 'Layanan'], 'rules' => 'required|in:Produk,Layanan'],
                ['name' => 'deskripsi', 'label' => 'Deskripsi (baris 1 = pembuka, baris berikutnya = daftar fitur)', 'type' => 'textarea', 'rows' => 8, 'rules' => 'required|string'],
                ['name' => 'gambar', 'label' => 'Gambar (maks 2 MB)', 'type' => 'image', 'rules' => 'nullable|image|max:2048'],
            ],
        ];
    }
}