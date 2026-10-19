<?php

namespace Database\Seeders;

use App\Models\Layanan;
use Illuminate\Database\Seeder;

class LayananSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // ===== PRODUK =====
            ['Internet Dedicated', 'Produk',
             "Koneksi internet simetris dengan bandwidth terjamin untuk kantor pusat, pabrik, dan pusat data.\nBandwidth simetris, kecepatan unggah sama dengan unduh\nAlamat IP publik statis tersedia\nSLA tertulis dengan target ketersediaan 99,9%\nPemantauan jaringan dan trafik selama 24 jam\nJalur cadangan opsional untuk kelangsungan operasional\nPaket bandwidth fleksibel dan dapat ditingkatkan"],
            ['Paket Internet Bisnis Fiber', 'Produk',
             "Paket internet fiber optik untuk kantor, toko, dan usaha kecil menengah.\nKecepatan stabil untuk karyawan dan pelanggan\nPemasangan cepat dengan perangkat disediakan\nPilihan kecepatan sesuai jumlah pengguna\nDukungan teknis prioritas untuk pelanggan bisnis\nTagihan bulanan dengan harga yang jelas\nUpgrade paket kapan saja tanpa ganti perangkat"],
            ['Jaringan Antar Kantor (VPN)', 'Produk',
             "Hubungkan kantor pusat dan cabang dalam satu jaringan privat yang aman.\nKoneksi privat antar lokasi dengan enkripsi\nAkses terpusat ke aplikasi dan server perusahaan\nDapat menghubungkan puluhan cabang sekaligus\nKualitas layanan diprioritaskan untuk aplikasi penting\nPenambahan lokasi baru tanpa merombak jaringan\nPantauan status setiap lokasi dari satu panel"],
            ['Perangkat Jaringan Bisnis', 'Produk',
             "Router, switch, dan access point berkualitas untuk kebutuhan kantor Anda.\nPerangkat bergaransi resmi\nTersedia untuk pembelian maupun sewa\nDipasang dan dikonfigurasi oleh teknisi kami\nCocok untuk kantor kecil hingga gedung bertingkat\nKompatibel dengan layanan internet kami\nDukungan penggantian bila perangkat bermasalah"],

            // ===== LAYANAN =====
            ['Manajemen Jaringan & Wi-Fi', 'Layanan',
             "Perancangan, pemasangan, dan pengelolaan jaringan LAN dan Wi-Fi area luas.\nSurvei lokasi dan pemetaan sinyal sebelum pemasangan\nInstalasi kabel terstruktur dan titik akses nirkabel\nPengaturan jaringan tamu dan pembagian akses karyawan\nPemantauan dan pemeliharaan berkala\nLaporan kinerja jaringan setiap bulan\nDukungan teknisi di lokasi bila diperlukan"],
            ['Cloud & Hosting', 'Layanan',
             "Hosting aplikasi, server virtual, dan penyimpanan cadangan di pusat data berstandar tinggi.\nServer virtual dengan sumber daya yang bisa ditambah\nPenyimpanan cadangan otomatis dan terjadwal\nHosting aplikasi dan situs web perusahaan\nPemantauan ketersediaan selama 24 jam\nPemulihan data cepat saat terjadi gangguan\nBiaya mengikuti pemakaian sebenarnya"],
            ['Keamanan Jaringan', 'Layanan',
             "Firewall terkelola, segmentasi jaringan, dan pemantauan ancaman.\nFirewall terkelola dengan aturan sesuai kebijakan perusahaan\nFilter situs berbahaya dan konten yang tidak diinginkan\nSegmentasi jaringan untuk membatasi dampak gangguan\nPemantauan ancaman dan peringatan dini\nLaporan keamanan berkala untuk manajemen\nKonsultasi peningkatan kebijakan keamanan"],
            ['Dukungan Teknis 24 Jam', 'Layanan',
             "Pusat operasi jaringan menerima laporan gangguan setiap hari.\nSaluran laporan melalui telepon dan email\nPenanganan berdasarkan tingkat prioritas yang disepakati\nTeknisi lapangan siap dikirim ke lokasi pelanggan\nPembaruan status penanganan secara berkala\nLaporan insiden dan analisis penyebab gangguan\nKontak khusus untuk pelanggan korporat"],
        ];

        foreach ($data as [$nama, $jenis, $deskripsi]) {
            Layanan::updateOrCreate(['nama' => $nama], ['jenis' => $jenis, 'deskripsi' => $deskripsi]);
        }
    }
}