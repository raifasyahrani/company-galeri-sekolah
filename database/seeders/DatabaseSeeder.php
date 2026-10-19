<?php

namespace Database\Seeders;

use App\Models\Artikel;
use App\Models\Layanan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $layanan = [
            ['Internet Dedicated', "Koneksi internet simetris dengan bandwidth terjamin untuk kantor pusat, pabrik, dan pusat data.\nDilengkapi SLA tertulis, alamat IP publik, dan pemantauan jaringan sepanjang waktu."],
            ['Jaringan Antar Kantor (VPN)', "Hubungkan kantor pusat dan cabang dalam satu jaringan privat yang aman.\nCocok untuk perusahaan dengan banyak lokasi yang berbagi sistem dan data."],
            ['Manajemen Jaringan & Wi-Fi', "Perancangan, pemasangan, dan pengelolaan jaringan LAN dan Wi-Fi area luas.\nKami menangani survei lokasi, instalasi, hingga pemeliharaan berkala."],
            ['Cloud & Hosting', "Hosting aplikasi, server virtual, dan penyimpanan cadangan di pusat data berstandar tinggi.\nSkalabilitas mengikuti pertumbuhan kebutuhan bisnis Anda."],
            ['Keamanan Jaringan', "Firewall terkelola, segmentasi jaringan, dan pemantauan ancaman.\nMelindungi data dan layanan perusahaan dari gangguan dan serangan siber."],
            ['Dukungan Teknis 24 Jam', "Pusat operasi jaringan menerima laporan gangguan setiap hari.\nTeknisi lapangan siap datang sesuai tingkat prioritas yang disepakati."],
        ];
        foreach ($layanan as [$nama, $deskripsi]) {
            Layanan::create(['nama' => $nama, 'deskripsi' => $deskripsi]);
        }

        $artikel = [
            ['Lima Hal yang Perlu Dinilai Sebelum Memilih Penyedia Internet Perusahaan', 'lima-hal-memilih-penyedia-internet-perusahaan', 'Panduan',
             'Bandwidth bukan satu-satunya ukuran. Kenali SLA, jalur cadangan, dan kecepatan respons dukungan teknis.',
             "Memilih penyedia internet untuk perusahaan berbeda dari memilih layanan rumahan.\n\nPertama, pastikan ada SLA tertulis yang menyebut target ketersediaan dan kompensasi bila terjadi gangguan. Kedua, tanyakan apakah tersedia jalur cadangan. Ketiga, periksa kecepatan respons dukungan teknis. Keempat, pastikan bandwidth simetris bila Anda sering mengunggah data. Kelima, nilai rekam jejak penyedia pada pelanggan sejenis."],
            ['Kami Memperluas Jangkauan Layanan Fiber di Wilayah Bogor Raya', 'perluasan-jangkauan-layanan-fiber-bogor-raya', 'Berita',
             'Jaringan fiber optik kami kini menjangkau lebih banyak kawasan industri dan perkantoran.',
             "PT Solusi Koneksi Anda menambah jaringan fiber optik di sejumlah kawasan industri dan perkantoran di Bogor Raya.\n\nPerluasan ini memungkinkan pelanggan bisnis memperoleh layanan dengan waktu pemasangan lebih singkat dan jalur yang lebih stabil."],
            ['Pelatihan Penanganan Gangguan Jaringan bagi Tim Teknis', 'pelatihan-penanganan-gangguan-jaringan', 'Kegiatan',
             'Seluruh teknisi mengikuti pelatihan untuk mempercepat pemulihan layanan pelanggan.',
             "Tim teknis mengikuti pelatihan penanganan gangguan jaringan yang mencakup diagnosis cepat, prosedur eskalasi, dan komunikasi dengan pelanggan.\n\nKegiatan ini menjadi bagian dari program peningkatan mutu layanan perusahaan."],
        ];
        foreach ($artikel as [$judul, $slug, $kategori, $deskripsi, $isi]) {
            Artikel::create([
                'judul' => $judul, 'slug' => $slug, 'kategori' => $kategori,
                'deskripsi' => $deskripsi, 'isi' => $isi, 'tanggal' => now()->toDateString(),
            ]);
        }
    }
}