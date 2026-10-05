<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel beritas sudah dibuat sebelumnya (data Berita sudah ada),
        // jadi kalau sudah ada, migration ini tidak melakukan apa-apa.
        if (Schema::hasTable('beritas')) {
            return;
        }

        // Untuk instalasi baru (komputer lain / database kosong)
        Schema::create('beritas', function (Blueprint $table) {
    $table->id();
    $table->string('judul');
    $table->text('isi');
    $table->string('gambar')->nullable();
    $table->date('tanggal')->nullable();
    $table->timestamps();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('beritas');
    }
};