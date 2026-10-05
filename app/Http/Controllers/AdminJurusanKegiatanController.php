<?php

namespace App\Http\Controllers;

use App\Models\JurusanKegiatan;

class AdminJurusanKegiatanController extends AdminJurusanBagianController
{
    protected function cfg(): array
    {
        return [
            'model' => JurusanKegiatan::class, 'title' => 'Kegiatan Jurusan', 'subtitle' => 'Kegiatan praktik dan non-praktik tiap jurusan',
            'route' => 'admin.jurusan.kegiatan', 'folder' => 'jurusan/kegiatan', 'order' => ['jurusan', 'asc'],
            'columns' => [
                ['name' => 'gambar', 'label' => 'Gambar', 'type' => 'image'],
                ['name' => 'judul', 'label' => 'Judul'],
            ],
            'fields' => [
                $this->fieldJurusan(),
                ['name' => 'judul', 'label' => 'Judul kegiatan', 'type' => 'text', 'rules' => 'required|string|max:255'],
                ['name' => 'deskripsi', 'label' => 'Deskripsi singkat', 'type' => 'textarea', 'rules' => 'nullable|string'],
                $this->fieldUrutan(),
                ['name' => 'gambar', 'label' => 'Foto kegiatan (maks 2 MB)', 'type' => 'image', 'rules' => 'nullable|image|max:2048'],
            ],
        ];
    }
}