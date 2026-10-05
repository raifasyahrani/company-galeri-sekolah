<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use Illuminate\Database\Seeder;

class JurusanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'singkatan' => 'TO',
                'nama' => 'Teknik Otomotif',
                'deskripsi' => 'Program keahlian yang mempelajari cara merancang, memproduksi, merawat, dan memperbaiki kendaraan bermotor seperti mobil, sepeda motor, dan alat berat.',
            ],
            [
                'singkatan' => 'PPLG',
                'nama' => 'Pengembangan Perangkat Lunak dan Gim',
                'deskripsi' => 'Jurusan yang fokus pada cara membuat dan merancang aplikasi, website, hingga game, termasuk coding, desain tampilan, dan basis data.',
            ],
            [
                'singkatan' => 'TJKT',
                'nama' => 'Teknik Jaringan Komputer dan Telekomunikasi',
                'deskripsi' => 'Program keahlian yang fokus pada instalasi, konfigurasi, pengoperasian, dan pemeliharaan jaringan komputer serta infrastruktur telekomunikasi.',
            ],
            [
                'singkatan' => 'TPFL',
                'nama' => 'Teknik Pengelasan dan Fabrikasi Logam',
                'deskripsi' => 'Program keahlian yang mempelajari cara memotong, membentuk, merakit, dan menyambung bahan logam dengan teknik las modern seperti SMAW, MIG, atau TIG.',
            ],
        ];

        foreach ($data as $item) {
            Jurusan::updateOrCreate(
                ['singkatan' => $item['singkatan']],
                ['nama' => $item['nama'], 'deskripsi' => $item['deskripsi']]
            );
        }
    }
}