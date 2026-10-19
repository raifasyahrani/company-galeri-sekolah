<?php

namespace App\Models;

use App\Models\Concerns\UrlGambar;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use UrlGambar;

    protected $fillable = ['nama', 'jenis', 'deskripsi', 'gambar'];
}