<?php

namespace App\Http\Controllers;

use App\Models\JurusanDokumentasi;
use App\Models\JurusanKegiatan;
use App\Models\JurusanProduk;
use App\Models\JurusanSeragam;
use Illuminate\Http\Request;

class AdminJurusanHubController extends Controller
{
    public function index(Request $request)
    {
        $daftar = [
            'TO'   => 'Teknik Otomotif',
            'PPLG' => 'Pengembangan Perangkat Lunak dan Gim',
            'TJKT' => 'Teknik Jaringan Komputer dan Telekomunikasi',
            'TPFL' => 'Teknik Pengelasan dan Fabrikasi Logam',
        ];

        $kode = strtoupper((string) $request->query('jurusan', 'TO'));
        abort_unless(isset($daftar[$kode]), 404);

        $ambil = fn (string $model) => $model::where('jurusan', $kode)->orderBy('urutan')->orderBy('id')->get();

        $bagian = [
            ['judul' => 'Baju Seragam',        'info' => 'Foto seragam per angkatan',                'route' => 'admin.jurusan.seragam',     'teks' => 'label',      'deskripsi' => null,        'items' => $ambil(JurusanSeragam::class)],
            ['judul' => 'Kegiatan Jurusan',    'info' => 'Kegiatan praktik dan non-praktik siswa',   'route' => 'admin.jurusan.kegiatan',    'teks' => 'judul',      'deskripsi' => 'deskripsi', 'items' => $ambil(JurusanKegiatan::class)],
            ['judul' => 'Produk Jurusan',      'info' => 'Karya dan hasil proyek siswa',             'route' => 'admin.jurusan.produk',      'teks' => 'judul',      'deskripsi' => 'deskripsi', 'items' => $ambil(JurusanProduk::class)],
            ['judul' => 'Dokumentasi Lainnya', 'info' => 'Galeri foto tambahan jurusan',             'route' => 'admin.jurusan.dokumentasi', 'teks' => 'keterangan', 'deskripsi' => null,        'items' => $ambil(JurusanDokumentasi::class)],
        ];

        return view('admin.jurusan.hub', compact('kode', 'daftar', 'bagian'));
    }
}