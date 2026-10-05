<?php // app/Http/Controllers/AdminBeritaController.php
namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Support\Str;

class AdminBeritaController extends AdminCrudController
{
    protected function cfg(): array
    {
        return [
            'model' => Berita::class, 'title' => 'Berita', 'subtitle' => 'Kelola berita yang tampil di halaman depan',
            'route' => 'admin.berita', 'folder' => 'berita', 'order' => ['id', 'desc'],
            'columns' => [
                ['name' => 'gambar', 'label' => 'Gambar', 'type' => 'image'],
                ['name' => 'judul', 'label' => 'Judul'],
                ['name' => 'deskripsi', 'label' => 'Ringkasan'],
                ['name' => 'kategori', 'label' => 'Kategori'],
                ['name' => 'jurusan', 'label' => 'Jurusan'],
                ['name' => 'tanggal', 'label' => 'Tanggal'],
            ],
            'fields' => [
                ['name' => 'judul', 'label' => 'Judul', 'type' => 'text', 'rules' => 'required|string|max:255'],
                ['name' => 'kategori', 'label' => 'Kategori', 'type' => 'select', 'options' => ['Prestasi', 'Informasi', 'Kegiatan'], 'rules' => 'required|in:Prestasi,Informasi,Kegiatan'],
                ['name' => 'jurusan', 'label' => 'Jurusan (lencana di kartu)', 'type' => 'select', 'options' => ['Umum', 'TO', 'PPLG', 'TJKT', 'TPFL'], 'rules' => 'required|in:Umum,TO,PPLG,TJKT,TPFL'],
                ['name' => 'tanggal', 'label' => 'Tanggal', 'type' => 'text', 'placeholder' => 'contoh: 16 Februari 2026', 'rules' => 'nullable|string|max:50'],
                ['name' => 'deskripsi', 'label' => 'Ringkasan (tampil di kartu)', 'type' => 'textarea', 'rules' => 'required|string'],
                ['name' => 'isi', 'label' => 'Isi lengkap (opsional)', 'type' => 'textarea', 'rows' => 8, 'rules' => 'nullable|string'],
                ['name' => 'gambar', 'label' => 'Gambar (maks 2 MB)', 'type' => 'image', 'rules' => 'nullable|image|max:2048'],
            ],
        ];
    }

    protected function beforeSave(array $data, $item): array
    {
        if (! $item || empty($item->slug)) {
            $slug  = Str::slug($data['judul']);
            $dasar = $slug;
            $n     = 2;
            while (Berita::where('slug', $slug)->exists()) {
                $slug = $dasar . '-' . $n++;
            }
            $data['slug'] = $slug;
        }
        return $data;
    }
}