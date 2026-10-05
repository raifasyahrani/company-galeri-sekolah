<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beranda extends Model
{
    protected $fillable = [
        'hero_judul', 'hero_subjudul', 'hero_gambar', 'tombol_teks', 'tombol_link',
        'tentang_judul', 'tentang_isi',
        'stat_siswa', 'stat_guru', 'stat_jurusan', 'stat_prestasi',
        'alamat', 'telepon', 'email_sekolah',
    ];
}