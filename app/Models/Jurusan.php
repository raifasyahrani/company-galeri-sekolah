<?php // app/Models/Jurusan.php
namespace App\Models;

use App\Models\Concerns\UrlGambar;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use UrlGambar;
    protected $fillable = ['kode', 'nama', 'deskripsi', 'gambar', 'ikon'];
}