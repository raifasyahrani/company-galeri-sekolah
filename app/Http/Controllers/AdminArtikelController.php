<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Support\Str;

class AdminArtikelController extends AdminCrudController
{
    protected function cfg(): array
    {
        return [
            'model' => Artikel::class, 'title' => 'Artikel', 'subtitle' => 'Kelola artikel dan informasi terkini perusahaan',
            'route' => 'admin.artikel', 'folder' => 'artikel', 'order' => ['id', 'desc'],
            'columns' => [
                ['name' => 'gambar', 'label' => 'Gambar', 'type' => 'image'],
                ['name' => 'judul', 'label' => 'Judul'],
                ['name' => 'deskripsi', 'label' => 'Ringkasan'],
                ['name' => 'kategori', 'label' => 'Kategori'],
                ['name' => 'tanggal', 'label' => 'Tanggal'],
            ],
            'fields' => [
                ['name' => 'judul', 'label' => 'Judul', 'type' => 'text', 'rules' => 'required|string|max:255'],
                ['name' => 'kategori', 'label' => 'Kategori', 'type' => 'select', 'options' => ['Panduan', 'Berita', 'Kegiatan', 'Informasi'], 'rules' => 'required|in:Panduan,Berita,Kegiatan,Informasi'],
                ['name' => 'tanggal', 'label' => 'Tanggal', 'type' => 'date', 'rules' => 'nullable|date'],
                ['name' => 'deskripsi', 'label' => 'Ringkasan (tampil di kartu)', 'type' => 'textarea', 'rules' => 'required|string'],
                ['name' => 'isi', 'label' => 'Isi lengkap (opsional)', 'type' => 'textarea', 'rows' => 8, 'rules' => 'nullable|string'],
                ['name' => 'gambar', 'label' => 'Gambar (maks 2 MB)', 'type' => 'image', 'rules' => 'nullable|image|max:2048'],
            ],
        ];
    }

    protected function beforeSave(array $data, $item): array
    {
        $data['tanggal'] = $data['tanggal'] ?? now()->toDateString();

        // Slug dibuat sekali saat artikel baru dibuat, dijamin unik
        if (! $item || empty($item->slug)) {
            $dasar = Str::slug($data['judul']) ?: 'artikel';
            $slug  = $dasar;
            $n     = 2;
            while (Artikel::where('slug', $slug)->exists()) {
                $slug = $dasar . '-' . $n++;
            }
            $data['slug'] = $slug;
        }

        return $data;
    }
}