<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('beritas', 'jurusan')) {
            Schema::table('beritas', function (Blueprint $table) {
                $table->string('jurusan', 20)->default('Umum')->after('kategori');
            });
        }

        // Tanggal disimpan sebagai teks supaya "20-21 Agustus 2026" bisa masuk
        Schema::table('beritas', function (Blueprint $table) {
            $table->string('tanggal', 50)->nullable()->change();
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('beritas', 'jurusan')) {
            Schema::table('beritas', function (Blueprint $table) {
                $table->dropColumn('jurusan');
            });
        }
    }
};