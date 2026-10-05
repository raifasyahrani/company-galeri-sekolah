<?php

namespace App\Http\Controllers;

use App\Models\JurusanDokumentasi;

class AdminJurusanDokumentasiController extends AdminJurusanBagianController
{
    protected function cfg(): array
    {
        return [
            'model' => JurusanDokumentasi::class, 'title' => 'Dokumentasi Jurusan', 'subtitle' => 'Galeri foto dokumentasi kegiatan tiap jurusan',
            'route' => 'admin.jurusan.dokumentasi', 'folder' => 'jurusan/dokumentasi', 'order' => ['jurusan', 'asc'],
            'columns' => [
                ['name' => 'gambar', 'label' => 'Gambar', 'type' => 'image'],
                ['name' => 'keterangan', 'label' => 'Keterangan'],
            ],
            'fields' => [
                $this->fieldJurusan(),
                ['name' => 'keterangan', 'label' => 'Keterangan foto', 'type' => 'textarea', 'rules' => 'nullable|string'],
                $this->fieldUrutan(),
                ['name' => 'gambar', 'label' => 'Foto dokumentasi (maks 2 MB)', 'type' => 'image', 'rules' => 'nullable|image|max:2048'],
            ],
        ];
    }
}