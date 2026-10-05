<?php

namespace App\Models;

use App\Models\Concerns\UrlGambar;
use Illuminate\Database\Eloquent\Model;

class JurusanProduk extends Model
{
    use UrlGambar;

    protected $table = 'jurusan_produks';
    protected $fillable = ['jurusan', 'judul', 'deskripsi', 'gambar', 'urutan'];
}