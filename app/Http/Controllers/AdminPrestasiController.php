<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;

class AdminPrestasiController extends AdminCrudController
{
    protected function cfg(): array
    {
        return [
            'model' => Prestasi::class, 'title' => 'Prestasi', 'subtitle' => 'Kelola prestasi yang tampil di beranda',
            'route' => 'admin.prestasi', 'folder' => 'prestasi', 'order' => ['id', 'desc'],
            'columns' => [
                ['name' => 'gambar', 'label' => 'Foto', 'type' => 'image'],
                ['name' => 'judul', 'label' => 'Judul'],
                ['name' => 'tahun', 'label' => 'Tahun'],
            ],
            'fields' => [
                ['name' => 'judul', 'label' => 'Judul prestasi', 'type' => 'text', 'rules' => 'required|string|max:255'],
                ['name' => 'tahun', 'label' => 'Tahun', 'type' => 'text', 'rules' => 'required|string|max:10'],
                ['name' => 'gambar', 'label' => 'Foto (maks 2 MB)', 'type' => 'image', 'rules' => 'nullable|image|max:2048'],
            ],
        ];
    }

    public function index()
    {
        $c = $this->cfg();
        $items = Prestasi::orderByDesc('id')->get();

        return view('admin.crud.prestasi', compact('c', 'items'));
    }

    public function create()
    {
        return view('admin.crud.prestasi_form', ['c' => $this->cfg(), 'item' => null]);
    }

    public function edit($id)
    {
        $c = $this->cfg();
        $item = Prestasi::findOrFail($id);

        return view('admin.crud.prestasi_form', compact('c', 'item'));
    }
}