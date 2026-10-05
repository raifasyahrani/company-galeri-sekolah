<?php // app/Http/Controllers/AdminJurusanController.php
namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class AdminJurusanController extends AdminCrudController
{
    protected function cfg(): array
    {
        return [
            'model' => Jurusan::class, 'title' => 'Jurusan', 'subtitle' => 'Kelola jurusan yang tampil di halaman depan',
            'route' => 'admin.jurusan', 'folder' => 'jurusan', 'order' => ['id', 'asc'],
            'columns' => [
                ['name' => 'gambar', 'label' => 'Gambar', 'type' => 'image'],
                ['name' => 'nama', 'label' => 'Nama Jurusan'],
            ],
            'fields' => [
                ['name' => 'nama', 'label' => 'Nama Jurusan', 'type' => 'text', 'rules' => 'required|string|max:255'],
                ['name' => 'deskripsi', 'label' => 'Deskripsi', 'type' => 'textarea', 'rows' => 6, 'rules' => 'required|string'],
                ['name' => 'gambar', 'label' => 'Gambar (maks 2 MB)', 'type' => 'image', 'rules' => 'nullable|image|max:2048'],
            ],
        ];
    }

    protected function beforeSave(array $data, $item): array
    {
        // Slug hanya dibuat kalau tabel jurusans memang punya kolom slug
        if (Schema::hasColumn('jurusans', 'slug') && (! $item || empty($item->slug))) {
            $data['slug'] = Str::slug($data['nama']);
        }
        return $data;
    }
}