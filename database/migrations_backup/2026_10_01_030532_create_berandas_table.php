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

        // Data awal (sama dengan tampilan beranda yang lama)
        DB::table('berandas')->insert([
            'hero_judul'    => 'SMKN 4 BOGOR',
            'hero_subjudul' => 'Sekolah Menengah Kejuruan Negeri yang berkomitmen mencetak generasi muda yang kompeten, berkarakter, dan siap bersaing di dunia kerja.',
            'hero_gambar'   => null,
            'tombol_teks'   => 'Tentang Kami',
            'tombol_link'   => '/profil',
            'tentang_judul' => 'Tentang Sekolah',
            'tentang_isi'   => 'SMKN 4 Bogor adalah sekolah menengah kejuruan negeri yang berkomitmen menghasilkan lulusan unggul dan siap bersaing di dunia usaha maupun dunia industri.',
            'stat_siswa'    => 1500,
            'stat_guru'     => 50,
            'stat_jurusan'  => 4,
            'stat_prestasi' => 50,
            'alamat'        => 'Jalan Raya Tajur Kp. Buntar RT02/RW08 Kel. Muarasari Kec. Bogor Selatan Kota Bogor - Jawa Barat 16137',
            'telepon'       => '+62 821 226 2442',
            'email_sekolah' => 'smkn4@smkn4bogor.sch.id',
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('berandas');
    }
};