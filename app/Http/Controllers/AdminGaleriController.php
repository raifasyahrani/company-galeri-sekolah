<?php

namespace App\Http\Controllers;

use App\Models\Galeri;

class AdminGaleriController extends AdminCrudController
{
    protected function cfg(): array
    {
        return [
            'model' => Galeri::class, 'title' => 'Galeri', 'subtitle' => 'Kelola foto kegiatan perusahaan',
            'route' => 'admin.galeri', 'folder' => 'galeri', 'order' => ['id', 'desc'],
            'columns' => [
                ['name' => 'gambar', 'label' => 'Foto', 'type' => 'image'],
                ['name' => 'judul', 'label' => 'Judul'],
            ],
            'fields' => [
                ['name' => 'judul', 'label' => 'Judul kegiatan', 'type' => 'text', 'rules' => 'required|string|max:255'],
                ['name' => 'keterangan', 'label' => 'Keterangan (opsional)', 'type' => 'textarea', 'rows' => 3, 'rules' => 'nullable|string'],
                ['name' => 'gambar', 'label' => 'Foto (maks 2 MB)', 'type' => 'image', 'rules' => 'nullable|image|max:2048'],
            ],
        ];
    }

    // Tampilan khusus galeri: grid kartu foto (bukan tabel)
    public function index()
    {
        $c = $this->cfg();
        $items = $c['model']::orderBy($c['order'][0], $c['order'][1])->get();

        return view('admin.crud.galeri_grid', compact('c', 'items'));
    }
}
