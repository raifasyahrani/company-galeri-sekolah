<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $t) {
            $t->id();
            $t->string('aksi', 10);            // tambah | ubah | hapus
            $t->string('modul', 50);           // Berita, Galeri, dst.
            $t->string('judul')->nullable();   // nama data yang diubah
            $t->string('admin_email')->nullable();
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};