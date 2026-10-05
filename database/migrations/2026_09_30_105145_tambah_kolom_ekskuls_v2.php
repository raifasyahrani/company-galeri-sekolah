<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ekskuls', function (Blueprint $table) {
            if (!Schema::hasColumn('ekskuls', 'deskripsi')) {
                $table->text('deskripsi')->nullable();
            }
            if (!Schema::hasColumn('ekskuls', 'pembina')) {
                $table->string('pembina')->nullable();
            }
            if (!Schema::hasColumn('ekskuls', 'ketua')) {
                $table->string('ketua')->nullable();
            }
            if (!Schema::hasColumn('ekskuls', 'jumlah_anggota')) {
                $table->unsignedInteger('jumlah_anggota')->default(0);
            }
            if (!Schema::hasColumn('ekskuls', 'hari_latihan')) {
                $table->string('hari_latihan')->nullable();
            }
            if (!Schema::hasColumn('ekskuls', 'jam_latihan')) {
                $table->string('jam_latihan')->nullable();
            }
            if (!Schema::hasColumn('ekskuls', 'gambar')) {
                $table->string('gambar')->nullable();
            }
            if (!Schema::hasColumn('ekskuls', 'foto_sampul')) {
                $table->string('foto_sampul')->nullable();
            }
            if (!Schema::hasColumn('ekskuls', 'urutan')) {
                $table->unsignedInteger('urutan')->default(0);
            }
        });
    }

    public function down(): void
    {
        // dibiarkan kosong agar data tidak hilang
    }
};