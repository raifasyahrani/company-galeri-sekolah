<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EkskulSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama' => 'Pramuka',
                'gambar' => 'images/LOGO PRAMUKA.png',
                'foto_sampul' => 'images/pramuka ekskul.jpeg',
                'ketua' => 'Satria Budhiyana (XII TO 1)',
                'pembina' => 'Ibu Sri Esti, S.Pd.',
                'hari_latihan' => 'Jumat',
                'jam_latihan' => '15.00 - 17.00 WIB',
                'jumlah_anggota' => 75,
                'deskripsi' => 'Melatih kemandirian, kepemimpinan, dan kepedulian sosial siswa melalui kegiatan kepramukaan, mulai dari baris-berbaris, tali-temali, hingga kegiatan perkemahan.',
            ],
            [
                'nama' => 'Paskibra',
                'gambar' => 'images/LOGO PASKIB.png',
                'foto_sampul' => 'images/paskib ekskul.JPG',
                'ketua' => 'Muhammad Faturahman (XII TJKT 2)',
                'pembina' => 'Bapak Sunggono, S.Pd.',
                'hari_latihan' => 'Rabu,Sabtu',
                'jam_latihan' => '15.00 - 17.00 WIB',
                'jumlah_anggota' => 50,
                'deskripsi' => 'Membina kedisiplinan dan kekompakan siswa melalui latihan baris-berbaris serta bertugas sebagai pengibar bendera pada upacara resmi sekolah.',
            ],
            [
                'nama' => 'PMR',
                'gambar' => 'images/LOGO PMR.png',
                'foto_sampul' => 'images/pmr ekskul.jpeg',
                'ketua' => 'Mawar Khaeriza Destri (XII PPLG 1)',
                'pembina' => 'Ibu Ruri Marlinawati, S.Pd.',
                'hari_latihan' => 'Kamis',
                'jam_latihan' => '14.00 - 16.00 WIB',
                'jumlah_anggota' => 45,
                'deskripsi' => 'Melatih siswa dalam pertolongan pertama pada kecelakaan (P3K), kepedulian kesehatan, dan siap menjadi relawan pada kegiatan sekolah.',
            ],
            [
                'nama' => 'Basket',
                'gambar' => 'images/LOGO BASKET.png',
                'foto_sampul' => 'images/basket ekskul.JPG',
                'ketua' => 'Fajar Ramadhan (XII TJKT 2)',
                'pembina' => 'Bapak Ade Eka Sastra, S.Pd.',
                'hari_latihan' => 'Selasa',
                'jam_latihan' => '15.30 - 17.00 WIB',
                'jumlah_anggota' => 20,
                'deskripsi' => 'Mengembangkan kemampuan teknik dan strategi bermain basket, aktif mengikuti berbagai turnamen antar sekolah tingkat kota maupun provinsi.',
            ],
            [
                'nama' => 'Futsal',
                'gambar' => 'images/LOGO FUTSAL.png',
                'foto_sampul' => 'images/futsal1.jpg',
                'ketua' => 'Nando (XII TPFL 2)',
                'pembina' => 'Bapak Ade Eka Sastra, S.Pd.',
                'hari_latihan' => 'Senin,Kamis',
                'jam_latihan' => '15.00 - 17.30 WIB',
                'jumlah_anggota' => 25,
                'deskripsi' => 'Tim futsal sekolah yang rutin berlatih dan mengikuti kompetisi antar sekolah, salah satu prestasinya adalah Juara 3 IBG Championship Festival 2026.',
            ],
            [
                'nama' => 'Pencak Silat',
                'gambar' => 'images/logo silat.png',
                'foto_sampul' => 'images/silat ekskul.jpeg',
                'ketua' => 'Melati (XII TJKT 1)',
                'pembina' => 'Bapak Ade Eka Sastra, S.Pd.',
                'hari_latihan' => 'Rabu,Sabtu',
                'jam_latihan' => '15.00 - 16.30 WIB',
                'jumlah_anggota' => 18,
                'deskripsi' => 'Melestarikan budaya bela diri asli Indonesia sekaligus melatih fisik, mental, dan sportivitas siswa. Meraih Juara 1 Regu Putri pada kejuaraan pencak silat tingkat kota.',
            ],
            [
                'nama' => 'Band',
                'gambar' => 'images/logo band.png',
                'foto_sampul' => 'images/band ekskul.jpg',
                'ketua' => 'Thariq (XII TPFL 1)',
                'pembina' => 'Bapak Tri Wahyono, S.Pd.',
                'hari_latihan' => 'Rabu',
                'jam_latihan' => '15.00 - 17.30 WIB',
                'jumlah_anggota' => 15,
                'deskripsi' => 'Menyalurkan minat siswa di bidang musik, tampil pada berbagai acara sekolah seperti perpisahan, MPLS, dan Pensi.',
            ],
            [
                'nama' => 'Paduan Suara',
                'gambar' => 'images/logo padus.png',
                'foto_sampul' => 'images/paduss.png',
                'ketua' => 'Keisha (XII PPLG 1)',
                'pembina' => 'Ibu Tresna Septiarti Amalia, S.Pd.',
                'hari_latihan' => 'Kamis',
                'jam_latihan' => '15.00 - 16.30 WIB',
                'jumlah_anggota' => 22,
                'deskripsi' => 'Bertugas mengisi paduan suara pada upacara bendera dan acara resmi sekolah, perpisahan, sekaligus melatih vokal dan kekompakan bernyanyi bersama.',
            ],
            [
                'nama' => 'Tari',
                'gambar' => 'images/logo tari.png',
                'foto_sampul' => 'images/tarii.jpeg',
                'ketua' => 'Raifa Hasna Syahrani (XII PPLG 2)',
                'pembina' => 'Ibu Vivi Safitri Desemberiyani, S.Pd.',
                'hari_latihan' => 'Sabtu',
                'jam_latihan' => '09.00 - 11.00 WIB',
                'jumlah_anggota' => 20,
                'deskripsi' => 'Melestarikan seni tari tradisional dan modern, sering tampil mewakili sekolah pada acara budaya dan perayaan hari besar.',
            ],
            [
                'nama' => 'Rohis',
                'gambar' => 'images/logo rohis.png',
                'foto_sampul' => 'images/rohis ekskul.jpg',
                'ketua' => 'M Davi (XII PPLG 1)',
                'pembina' => 'Bapak S, S.Pd.',
                'hari_latihan' => 'Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
                'jam_latihan' => '06.00 - 08.00 WIB',
                'jumlah_anggota' => 20,
                'deskripsi' => 'Ekstrakurikuler sekolah untuk memperdalam ilmu agama Islam, memperkuat keimanan, dan membentuk akhlak mulia siswa melalui kegiatan kajian, mentoring, serta penguatan karakter Islami yang toleran dan mandiri (kajian rutin, tahsin/tahfidz, peringatan hari besar Islam, dll).',
            ],
        ];

        foreach ($data as $i => $row) {
            $row['urutan'] = $i + 1;
            $row['updated_at'] = now();

            // updateOrInsert: aman dijalankan ulang, data tidak dobel
            DB::table('ekskuls')->updateOrInsert(
                ['nama' => $row['nama']],
                $row + ['created_at' => now()]
            );
        }
    }
}