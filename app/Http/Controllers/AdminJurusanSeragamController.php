<?php

namespace App\Http\Controllers;

use App\Models\JurusanSeragam;

class AdminJurusanSeragamController extends AdminJurusanBagianController
{
    protected function cfg(): array
    {
        return [
            'model' => JurusanSeragam::class, 'title' => 'Seragam Jurusan', 'subtitle' => 'Foto baju seragam tiap jurusan',
            'route' => 'admin.jurusan.seragam', 'folder' => 'jurusan/seragam', 'order' => ['jurusan', 'asc'],
            'columns' => [
                ['name' => 'gambar', 'label' => 'Gambar', 'type' => 'image'],
                ['name' => 'label', 'label' => 'Label'],
            ],
            'fields' => [
                $this->fieldJurusan(),
                ['name' => 'label', 'label' => 'Label seragam', 'type' => 'text', 'placeholder' => 'contoh: Angkatan 2024 (Kelas XII)', 'rules' => 'required|string|max:255'],
                $this->fieldUrutan(),
                ['name' => 'gambar', 'label' => 'Foto seragam (maks 2 MB)', 'type' => 'image', 'rules' => 'nullable|image|max:2048'],
            ],
        ];
    }
}