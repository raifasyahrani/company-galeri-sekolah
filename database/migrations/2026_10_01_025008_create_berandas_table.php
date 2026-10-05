<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berandas', function (Blueprint $table) {
            $table->id();
            $table->string('hero_judul');
            $table->string('hero_subjudul')->nullable();
            $table->string('hero_gambar')->nullable();
            $table->string('tombol_teks')->nullable();
            $table->string('tombol_link')->nullable();
            $table->string('tentang_judul');
            $table->text('tentang_isi');
            $table->unsignedInteger('stat_siswa')->default(0);
            $table->unsignedInteger('stat_guru')->default(0);
            $table->unsignedInteger('stat_jurusan')->default(0);
            $table->unsignedInteger('stat_prestasi')->default(0);
            $table->string('alamat')->nullable();
            $table->string('telepon')->nullable();
            $table->string('email_sekolah')->nullable();
            $table->timestamps();
        });

        // Data awal
        DB::table('berandas')->insert([
            'hero_judul'    => 'Selamat Datang di SMKN 4 Bogor',
            'hero_subjudul' => 'Mencetak lulusan yang kompeten, berkarakter, dan siap kerja.',
            'hero_gambar'   => null,
            'tombol_teks'   => 'Lihat Jurusan',
            'tombol_link'   => '/jurusan',
            'tentang_judul' => 'Tentang Sekolah',
            'tentang_isi'   => 'SMKN 4 Bogor adalah sekolah menengah kejuruan negeri yang berkomitmen menghasilkan lulusan unggul dan siap bersaing di dunia usaha maupun dunia industri.',
            'stat_siswa'    => 1500,
            'stat_guru'     => 100,
            'stat_jurusan'  => 6,
            'stat_prestasi' => 50,
            'alamat'        => 'Kota Bogor, Jawa Barat',
            'telepon'       => '(0251) 000000',
            'email_sekolah' => 'info@smkn4bogor.sch.id',
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('berandas');
    }
};