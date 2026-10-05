<?php

namespace App\Providers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Model yang dicatat => nama modul yang tampil.
        // Nama model yang tidak ada di proyekmu aman, tidak akan pernah terpicu.
        $modul = [
            \App\Models\Beranda::class            => 'Beranda',
            \App\Models\Berita::class             => 'Berita',
            \App\Models\Jurusan::class            => 'Jurusan',
            \App\Models\JurusanSeragam::class     => 'Jurusan: Seragam',
            \App\Models\JurusanKegiatan::class    => 'Jurusan: Kegiatan',
            \App\Models\JurusanProduk::class      => 'Jurusan: Produk',
            \App\Models\JurusanDokumentasi::class => 'Jurusan: Dokumentasi',
            \App\Models\Prestasi::class           => 'Prestasi',
            \App\Models\Galeri::class             => 'Galeri',
            \App\Models\Ekskul::class             => 'Ekskul',
            \App\Models\Profil::class             => 'Profil',
        ];

        $aksi = ['created' => 'tambah', 'updated' => 'ubah', 'deleted' => 'hapus'];

        foreach ($aksi as $event => $namaAksi) {
            Event::listen("eloquent.$event: *", function ($nama, $data) use ($modul, $namaAksi) {
                // Lewati tinker, migration, dan seeder
                if (app()->runningInConsole()) {
                    return;
                }

                $model = $data[0] ?? null;
                if (! $model || ! isset($modul[get_class($model)])) {
                    return;
                }

                $judul = $model->judul ?? $model->nama ?? $model->hero_judul
                    ?? $model->keterangan ?? $model->kode ?? null;

                try {
                    ActivityLog::create([
                        'aksi'        => $namaAksi,
                        'modul'       => $modul[get_class($model)],
                        'judul'       => $judul ? mb_substr((string) $judul, 0, 120) : null,
                        'admin_email' => session('admin_email'),
                    ]);

                    // Simpan 100 catatan terakhir saja
                    $batas = ActivityLog::max('id') - 100;
                    if ($batas > 0) {
                        ActivityLog::where('id', '<=', $batas)->delete();
                    }
                } catch (\Throwable $e) {
                    // Pencatatan tidak boleh membuat simpan data gagal
                }
            });
        }
    }
}