<?php

namespace App\Models;

use App\Models\Concerns\UrlGambar;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    use UrlGambar;

    protected $fillable = ['judul', 'slug', 'kategori', 'deskripsi', 'isi', 'gambar', 'tanggal'];

    public function tanggalIndo(): string
    {
        return $this->tanggal
            ? Carbon::parse($this->tanggal)->locale('id')->translatedFormat('d F Y')
            : '';
    }
}
