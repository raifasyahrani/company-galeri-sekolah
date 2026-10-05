<?php

namespace App\Models;

use App\Models\Concerns\UrlGambar;
use Illuminate\Database\Eloquent\Model;

class JurusanSeragam extends Model
{
    use UrlGambar;

    protected $table = 'jurusan_seragams';
    protected $fillable = ['jurusan', 'label', 'gambar', 'urutan'];
}