<?php

namespace App\Models;

use App\Models\Concerns\UrlGambar;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    use UrlGambar;

    protected $fillable = ['judul', 'keterangan', 'gambar'];
}
