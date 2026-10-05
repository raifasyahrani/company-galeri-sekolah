<?php // app/Models/Profil.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
    protected $fillable = ['sejarah', 'visi', 'misi', 'kepala_sekolah', 'akreditasi', 'tahun_berdiri'];
}