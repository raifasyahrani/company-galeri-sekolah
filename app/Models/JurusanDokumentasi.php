<?php

namespace App\Models;

use App\Models\Concerns\UrlGambar;
use Illuminate\Database\Eloquent\Model;

class JurusanDokumentasi extends Model
{
    use UrlGambar;

    protected $table = 'jurusan_dokumentasis';
    protected $fillable = ['jurusan', 'keterangan', 'gambar', 'urutan'];
}