<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('jurusan_seragams')) {
            Schema::create('jurusan_seragams', function (Blueprint $t) {
                $t->id();
                $t->string('jurusan', 10);
                $t->string('label');
                $t->string('gambar')->nullable();
                $t->unsignedInteger('urutan')->default(0);
                $t->timestamps();
            });
        }

        if (! Schema::hasTable('jurusan_kegiatans')) {
            Schema::create('jurusan_kegiatans', function (Blueprint $t) {
                $t->id();
                $t->string('jurusan', 10);
                $t->string('judul');
                $t->text('deskripsi')->nullable();
                $t->string('gambar')->nullable();
                $t->unsignedInteger('urutan')->default(0);
                $t->timestamps();
            });
        }

        if (! Schema::hasTable('jurusan_produks')) {
            Schema::create('jurusan_produks', function (Blueprint $t) {
                $t->id();
                $t->string('jurusan', 10);
                $t->string('judul');
                $t->text('deskripsi')->nullable();
                $t->string('gambar')->nullable();
                $t->unsignedInteger('urutan')->default(0);
                $t->timestamps();
            });
        }

        if (! Schema::hasTable('jurusan_dokumentasis')) {
            Schema::create('jurusan_dokumentasis', function (Blueprint $t) {
                $t->id();
                $t->string('jurusan', 10);
                $t->string('keterangan')->nullable();
                $t->string('gambar')->nullable();
                $t->unsignedInteger('urutan')->default(0);
                $t->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('jurusan_dokumentasis');
        Schema::dropIfExists('jurusan_produks');
        Schema::dropIfExists('jurusan_kegiatans');
        Schema::dropIfExists('jurusan_seragams');
    }
};