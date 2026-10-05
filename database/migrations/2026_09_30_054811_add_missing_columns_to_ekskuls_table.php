<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom yang seharusnya sudah ada dari migration sebelumnya
     * (create_ekskuls_table & add_detail_columns_to_ekskuls_table) tapi
     * ternyata tidak pernah benar-benar masuk ke tabel. Setiap kolom dicek
     * dulu dengan hasColumn supaya migration ini aman dijalankan meski
     * sebagian kolom sudah ada.
     */
    public function up(): void
    {
        Schema::table('ekskuls', function (Blueprint $table) {
            if (! Schema::hasColumn('ekskuls', 'nama')) {
                $table->string('nama')->nullable();
            }
            if (! Schema::hasColumn('ekskuls', 'deskripsi')) {
                $table->text('deskripsi')->nullable();
            }
            if (! Schema::hasColumn('ekskuls', 'gambar')) {
                $table->string('gambar')->nullable();
            }
            if (! Schema::hasColumn('ekskuls', 'ketua')) {
                $table->string('ketua')->nullable();
            }
            if (! Schema::hasColumn('ekskuls', 'jumlah_anggota')) {
                $table->unsignedInteger('jumlah_anggota')->nullable();
            }
            if (! Schema::hasColumn('ekskuls', 'hari_latihan')) {
                $table->string('hari_latihan')->nullable();
            }
            if (! Schema::hasColumn('ekskuls', 'jam_latihan')) {
                $table->string('jam_latihan')->nullable();
            }
            if (! Schema::hasColumn('ekskuls', 'foto_sampul')) {
                $table->string('foto_sampul')->nullable();
            }
            if (! Schema::hasColumn('ekskuls', 'urutan')) {
                $table->unsignedInteger('urutan')->default(0);
            }
        });
    }

    public function down(): void
    {
        // Sengaja dikosongkan: kolom-kolom ini adalah kolom inti yang dipakai
        // Model & Controller, jadi tidak aman dihapus lewat rollback otomatis.
    }
};