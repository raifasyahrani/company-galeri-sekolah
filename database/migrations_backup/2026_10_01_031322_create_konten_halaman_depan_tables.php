<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();

        // ---------- BERITA ----------
        Schema::dropIfExists('beritas');
        Schema::create('beritas', function (Blueprint $t) {
            $t->id();
            $t->string('judul');
            $t->string('slug')->nullable()->index();
            $t->string('kategori')->default('Informasi');
            $t->string('tanggal')->nullable();
            $t->text('deskripsi');
            $t->longText('isi')->nullable();
            $t->string('gambar')->nullable();
            $t->timestamps();
        });

        $berita = [
            ['juara-1-lks-network-cabling', 'Juara 1 LKS Tingkat Kota Bidang Keahlian Network Cabling', 'Prestasi', '16 Februari 2026', 'Siswa jurusan TKJ berhasil menyabet juara 1 Lomba Kompetensi Siswa tingkat kota pada bidang keahlian Network Cabling.', 'images/JUARA 1 LKS TKJ.jpg'],
            ['juara-1-silat-regu-putri', 'Juara 1 Regu Putri', 'Prestasi', '31 Juli 2026', 'Mawar berhasil meraih Juara 1 Regu Putri Cabang Pencak Silat dalam ajang perlombaan. Prestasi ini menjadi salah satu pencapaian membanggakan bagi SMKN 4 Kota Bogor, serta dedikasi dalam bidang olahraga pencak silat.', 'images/JUARA 1 SILAT.jpg'],
            ['kr4bat-mengaji-tafsir', 'KR4BAT Mengaji & Tafsir', 'Informasi', '11 September 2026', 'Kegiatan ini diikuti oleh seluruh siswa, wali kelas, dan guru wali di kelas masing-masing sebagai sarana untuk meningkatkan pemahaman dan kebiasaan membaca Al-Qur’an.', 'images/informasi.beranda.jpeg'],
            ['ldks-osis-mpk-2026', 'LDKS OSIS & MPK 2026', 'Kegiatan', '20-21 Agustus 2026', 'Calon anggota OSIS & MPK sedang melaksanakan Pelatihan LDKS 2026 sebelum resmi menjadi anggota OSIS & MPK 2026/2027.', 'images/berita 1, kegiatan.jpg'],
            ['smkn4-peduli-lingkungan', 'SMKN 4 BOGOR Peduli Lingkungan', 'Kegiatan', '11 Agustus 2026', 'Uji Kompetensi Keahlian (UJIKOM) tahun ajaran 2026 resmi dilaksanakan untuk mengukur kompetensi siswa tingkat akhir.', 'images/berita 2, kegiatan.jpg'],
            ['kr4bat-literasi-keuangan', 'KR4BAT x BJB: Literasi Keuangan', 'Informasi', '16 September 2026', 'Kegiatan ini diikuti oleh seluruh siswa, wali kelas, dan guru wali dengan tujuan memberikan pemahaman tentang pentingnya mengelola dan menggunakan uang secara bijak sejak dini.', 'images/informasi.beranda2.jpeg'],
        ];
        // dibalik supaya urutan tampil (id terbesar = paling atas) sama seperti aslinya
        foreach (array_reverse($berita) as [$slug, $judul, $kat, $tgl, $desk, $img]) {
            DB::table('beritas')->insert([
                'slug' => $slug, 'judul' => $judul, 'kategori' => $kat, 'tanggal' => $tgl,
                'deskripsi' => $desk, 'isi' => $desk, 'gambar' => $img,
                'created_at' => $now, 'updated_at' => $now,
            ]);
        }

        // ---------- JURUSAN ----------
        Schema::dropIfExists('jurusans');
        Schema::create('jurusans', function (Blueprint $t) {
            $t->id();
            $t->string('kode');
            $t->string('nama');
            $t->text('deskripsi')->nullable();
            $t->string('gambar')->nullable();
            $t->string('ikon')->nullable();
            $t->timestamps();
        });

        $jurusan = [
            ['TO', 'Teknik Otomotif (TO)', 'Membekali siswa dengan kompetensi perawatan, perbaikan, dan diagnosis kendaraan ringan.', 'images/TKRO.BERANDA.jpg', 'images/TKRO.png'],
            ['PPLG', 'Pengembangan Perangkat Lunak dan Gim (PPLG)', 'Membekali siswa dengan kemampuan pemrograman, pengembangan aplikasi, dan pembuatan gim.', 'images/PPLG.BERANDA.jpeg', 'images/PPLG.png'],
            ['TJKT', 'Teknik Jaringan Komputer dan Telekomunikasi (TJKT)', 'Membekali siswa dengan kemampuan merancang, membangun, dan mengelola jaringan komputer dan telekomunikasi.', 'images/TJKT.BERANDA.jpeg', 'images/TJKT.png'],
            ['TPFL', 'Teknik Pengelasan Fabrikasi Logam (TPFL)', 'Membekali siswa dengan kemampuan pengelasan dan fabrikasi logam sesuai standar industri.', 'images/TPFL.BERANDA.jpg', 'images/TPFL.png'],
        ];
        foreach ($jurusan as [$kode, $nama, $desk, $gambar, $ikon]) {
            DB::table('jurusans')->insert([
                'kode' => $kode, 'nama' => $nama, 'deskripsi' => $desk, 'gambar' => $gambar, 'ikon' => $ikon,
                'created_at' => $now, 'updated_at' => $now,
            ]);
        }

        // ---------- PRESTASI ----------
        Schema::dropIfExists('prestasis');
        Schema::create('prestasis', function (Blueprint $t) {
            $t->id();
            $t->string('judul');
            $t->string('tahun', 10);
            $t->string('gambar')->nullable();
            $t->timestamps();
        });

        $prestasi = [
            ['Juara Umum Tingkat Kota', '2025', 'images/PMR.PRESTASI.jpg'],
            ['Juara Madya 2 SMAN 7 Bogor', '2025', 'images/PASKIB.JUARA.jpg'],
            ['Futsal Juara 3 IBG Championship Festival 2026', '2026', 'images/FUTSAL.jpg'],
        ];
        foreach (array_reverse($prestasi) as [$judul, $tahun, $img]) {
            DB::table('prestasis')->insert([
                'judul' => $judul, 'tahun' => $tahun, 'gambar' => $img,
                'created_at' => $now, 'updated_at' => $now,
            ]);
        }

        // ---------- GALERI ----------
        Schema::dropIfExists('galeris');
        Schema::create('galeris', function (Blueprint $t) {
            $t->id();
            $t->string('judul');
            $t->string('gambar')->nullable();
            $t->timestamps();
        });

        $galeri = [
            ['Lapangan SMKN 4 Bogor', 'images/lapangan miring.JPG'],
            ['Juara 1 LKS Network Cabling', 'images/JUARA 1 LKS TKJ.jpg'],
            ['Juara 1 Pencak Silat', 'images/JUARA 1 SILAT.jpg'],
            ['Juara Umum PMR', 'images/PMR.PRESTASI.jpg'],
            ['Juara Madya Paskibra', 'images/PASKIB.JUARA.jpg'],
            ['Futsal IBG Championship', 'images/FUTSAL.jpg'],
        ];
        foreach (array_reverse($galeri) as [$judul, $img]) {
            DB::table('galeris')->insert([
                'judul' => $judul, 'gambar' => $img, 'created_at' => $now, 'updated_at' => $now,
            ]);
        }

        // ---------- PROFIL (1 baris) ----------
        Schema::dropIfExists('profils');
        Schema::create('profils', function (Blueprint $t) {
            $t->id();
            $t->text('sejarah')->nullable();
            $t->text('visi')->nullable();
            $t->text('misi')->nullable();
            $t->string('kepala_sekolah')->nullable();
            $t->string('akreditasi')->nullable();
            $t->string('tahun_berdiri')->nullable();
            $t->timestamps();
        });

        DB::table('profils')->insert([
            'sejarah' => 'SMK Negeri 4 Kota Bogor berdiri sejak tahun 1985 dan terus berkembang menjadi sekolah kejuruan yang mencetak lulusan kompeten.',
            'visi' => 'Unggul, Kompeten, Berkarakter.',
            'misi' => "Menyelenggarakan pendidikan kejuruan yang berkualitas.\nMembentuk peserta didik yang berkarakter dan berakhlak mulia.\nMenjalin kerja sama dengan dunia usaha dan dunia industri.",
            'kepala_sekolah' => '',
            'akreditasi' => 'A',
            'tahun_berdiri' => '1985',
            'created_at' => $now, 'updated_at' => $now,
        ]);
    }

    public function down(): void
    {
        foreach (['profils', 'galeris', 'prestasis', 'jurusans', 'beritas'] as $t) {
            Schema::dropIfExists($t);
        }
    }
};