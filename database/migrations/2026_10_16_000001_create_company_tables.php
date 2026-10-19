<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // PROFIL (statis: hanya 1 baris, admin hanya bisa mengedit)
        Schema::create('profils', function (Blueprint $table) {
            $table->id();
            $table->text('sejarah')->nullable();
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();
            $table->string('direktur')->nullable();
            $table->string('legalitas')->nullable();
            $table->string('tahun_berdiri', 10)->nullable();
            $table->timestamps();
        });

        DB::table('profils')->insert([
            'sejarah'       => "PT Solusi Koneksi Anda didirikan di Bogor pada tahun 2012 oleh sekelompok insinyur jaringan yang melihat banyak perusahaan daerah kesulitan memperoleh koneksi yang stabil dan dukungan teknis yang cepat.\n\nBerawal dari layanan internet untuk perkantoran, kami berkembang menjadi penyedia solusi konektivitas dan infrastruktur teknologi informasi bagi perusahaan, instansi pemerintah, dan institusi pendidikan di Jawa Barat. Hingga kini kami melayani lebih dari seribu pelanggan bisnis dengan pusat operasi jaringan yang memantau layanan sepanjang waktu.",
            'visi'          => 'Menjadi mitra teknologi pilihan di Jawa Barat yang menghadirkan konektivitas andal untuk pertumbuhan bisnis pelanggan.',
            'misi'          => "Menyediakan jaringan yang stabil, aman, dan dapat diukur kinerjanya melalui SLA yang jelas\nMemberikan dukungan teknis yang cepat dan transparan setiap hari\nMengembangkan tenaga ahli yang bersertifikasi dan berintegritas\nMenjalin hubungan jangka panjang yang saling menguntungkan dengan pelanggan dan mitra",
            'direktur'      => 'Nama Direktur Utama',
            'legalitas'     => 'NIB 1234567890123',
            'tahun_berdiri' => '2012',
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        // PRODUK / LAYANAN
        Schema::create('layanans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('deskripsi');
            $table->string('gambar')->nullable();
            $table->timestamps();
        });

        // ARTIKEL / INFORMASI TERKINI
        Schema::create('artikels', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->string('kategori', 50)->default('Informasi');
            $table->text('deskripsi');
            $table->text('isi')->nullable();
            $table->string('gambar')->nullable();
            $table->date('tanggal')->nullable();
            $table->timestamps();
        });

        // GALERI KEGIATAN
        Schema::create('galeris', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('keterangan')->nullable();
            $table->string('gambar')->nullable();
            $table->timestamps();
        });

        // PESAN DARI FORM KONTAK
        Schema::create('pesans', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('email');
            $table->text('pesan');
            $table->timestamps();
        });

        // CATATAN AKTIVITAS ADMIN (dipakai dashboard)
        Schema::create('activity_logs', function (Blueprint $t) {
            $t->id();
            $t->string('aksi', 10);
            $t->string('modul', 50);
            $t->string('judul')->nullable();
            $t->string('admin_email')->nullable();
            $t->timestamps();
        });
    }

    public function down(): void
    {
        foreach (['activity_logs', 'pesans', 'galeris', 'artikels', 'layanans', 'profils'] as $tabel) {
            Schema::dropIfExists($tabel);
        }
    }
};
