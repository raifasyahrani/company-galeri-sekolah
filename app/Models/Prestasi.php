<?php // app/Models/Prestasi.php
namespace App\Models;

use App\Models\Concerns\UrlGambar;
use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    use UrlGambar;
    protected $fillable = ['judul', 'tahun', 'gambar'];
}