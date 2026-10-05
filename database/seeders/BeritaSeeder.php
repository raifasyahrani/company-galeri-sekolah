<?php

namespace Database\Seeders;

use App\Models\Berita;
use Illuminate\Database\Seeder;

class BeritaSeeder extends Seeder
{
    public function run(): void
    {
        // [slug, judul, file gambar (public/images), kategori, jurusan, tanggal, deskripsi]
        $data = [
            ['juara-1-lks-network-cabling', 'Juara 1 LKS Tingkat Kota Bidang Keahlian Network Cabling', 'JUARA 1 LKS TKJ.jpg', 'Prestasi', 'TJKT', '16 Februari 2026',
                'Siswa jurusan TJKT berhasil menyabet juara 1 Lomba Kompetensi Siswa tingkat kota pada bidang keahlian Network Cabling.'],
            ['futsal-juara-3-ibg-championship', 'Futsal Juara 3 IBG Championship Festival 2026', 'FUTSAL.jpg', 'Prestasi', 'Umum', '31 Juli 2026',
                'Tim futsal SMKN 4 Bogor berhasil meraih juara 3 pada IBG Championship Festival 2026, menambah deretan prestasi olahraga sekolah.'],
            ['juara-1-silat-regu-putri', 'Juara 1 Regu Putri Cabang Pencak Silat', 'JUARA 1 SILAT.jpg', 'Prestasi', 'Umum', '10 Februari 2026',
                'Prestasi membanggakan dari cabang silat regu putri pada kejuaraan pencak silat.'],
            ['ldks-osis-mpk-2026', 'LDKS OSIS & MPK 2026', 'berita 1, kegiatan.jpg', 'Kegiatan', 'Umum', '20-21 Agustus 2026',
                'Calon anggota OSIS & MPK sedang melaksanakan Pelatihan LDKS 2026 sebelum resmi menjadi anggota OSIS & MPK 2026/2027.'],
            ['smkn4-peduli-lingkungan', 'SMKN 4 BOGOR Peduli Lingkungan', 'berita 2, kegiatan.jpg', 'Kegiatan', 'Umum', '11 Agustus 2026',
                'Uji Kompetensi Keahlian (UJIKOM) tahun ajaran 2026 resmi dilaksanakan untuk mengukur kompetensi siswa tingkat akhir.'],
            ['kunjungan-industri-otomotif', 'Kunjungan Industri Siswa Kelas XII ke Perusahaan Otomotif', 'berita4.jpg', 'Kegiatan', 'TO', '5 Februari 2026',
                'Siswa kelas XII jurusan Teknik Otomotif melakukan kunjungan industri untuk menambah wawasan dunia kerja.'],
            ['kr4bat-mengaji-tafsir', 'KR4BAT Mengaji & Tafsir', 'informasi.beranda.jpeg', 'Informasi', 'Umum', '11 September 2026',
                'Kegiatan ini diikuti oleh seluruh siswa, wali kelas, dan guru wali di kelas masing-masing sebagai sarana untuk meningkatkan pemahaman dan kebiasaan membaca Al-Qur’an.'],
            ['kr4bat-literasi-keuangan', 'KR4BAT x BJB: Literasi Keuangan', 'informasi.beranda2.jpeg', 'Informasi', 'Umum', '16 September 2026',
                'Kegiatan ini diikuti oleh seluruh siswa, wali kelas, dan guru wali dengan tujuan memberikan pemahaman tentang pentingnya mengelola dan menggunakan uang secara bijak sejak dini.'],
            ['snbt-2026-ui', 'Selamat Atas Diterimanya Murid SMKN 4 BOGOR di Perguruan Tinggi Negeri Jalur SNBT 2026', 'berita 3, informasi.jpg', 'Informasi', 'PPLG', '10 Juni 2026',
                'Selamat kepada ananda Hasanatun Nadiyyah Syakh XII PPLG 2 yang diterima di Hubungan Masyarakat (D3) - Universitas Indonesia.'],
        ];

        // Dimasukkan dari belakang supaya berita pertama (LKS) mendapat id terbesar
        // dan otomatis menjadi berita unggulan. Berita dengan slug sama dilewati.
        foreach (array_reverse($data) as [$slug, $judul, $gambar, $kategori, $jurusan, $tanggal, $deskripsi]) {
            Berita::firstOrCreate(
                ['slug' => $slug],
                [
                    'judul'     => $judul,
                    'gambar'    => 'images/' . $gambar,
                    'kategori'  => $kategori,
                    'jurusan'   => $jurusan,
                    'tanggal'   => $tanggal,
                    'deskripsi' => $deskripsi,
                ]
            );
        }
    }
}