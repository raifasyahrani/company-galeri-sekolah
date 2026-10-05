<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('prestasis');
        Schema::create('prestasis', function (Blueprint $t) {
            $t->id();
            $t->string('judul');
            $t->string('tahun', 10);
            $t->string('gambar')->nullable();
            $t->timestamps();
        });

        $now = now();
        $data = [
            ['Futsal Juara 3 IBG Championship Festival 2026', '2026', 'images/FUTSAL.jpg'],
            ['Juara Madya 2 SMAN 7 Bogor', '2025', 'images/PASKIB.JUARA.jpg'],
            ['Juara Umum Tingkat Kota', '2025', 'images/PMR.PRESTASI.jpg'],
        ];
        foreach ($data as [$judul, $tahun, $gambar]) {
            DB::table('prestasis')->insert([
                'judul' => $judul, 'tahun' => $tahun, 'gambar' => $gambar,
                'created_at' => $now, 'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('prestasis');
    }
};