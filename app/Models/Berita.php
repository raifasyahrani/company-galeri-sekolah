<?php // app/Models/Berita.php
namespace App\Models;

use App\Models\Concerns\UrlGambar;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use UrlGambar;
    protected $fillable = ['judul', 'slug', 'kategori', 'jurusan', 'tanggal', 'deskripsi', 'isi', 'gambar'];
}