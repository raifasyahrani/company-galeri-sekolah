<?php

namespace App\Http\Controllers;

use App\Models\JurusanProduk;

class AdminJurusanProdukController extends AdminJurusanBagianController
{
    protected function cfg(): array
    {
        return [
            'model' => JurusanProduk::class, 'title' => 'Produk Jurusan', 'subtitle' => 'Karya dan hasil proyek siswa tiap jurusan',
            'route' => 'admin.jurusan.produk', 'folder' => 'jurusan/produk', 'order' => ['jurusan', 'asc'],
            'columns' => [
                ['name' => 'gambar', 'label' => 'Gambar', 'type' => 'image'],
                ['name' => 'judul', 'label' => 'Judul'],
            ],
            'fields' => [
                $this->fieldJurusan(),
                ['name' => 'judul', 'label' => 'Nama produk', 'type' => 'text', 'rules' => 'required|string|max:255'],
                ['name' => 'deskripsi', 'label' => 'Deskripsi singkat', 'type' => 'textarea', 'rules' => 'nullable|string'],
                $this->fieldUrutan(),
                ['name' => 'gambar', 'label' => 'Foto produk (maks 2 MB)', 'type' => 'image', 'rules' => 'nullable|image|max:2048'],
            ],
        ];
    }
}