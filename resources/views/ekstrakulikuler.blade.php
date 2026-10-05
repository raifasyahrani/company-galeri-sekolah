<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ekstrakulikuler - SMKN 4 Bogor</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-800 bg-gray-50">

    @include('partials.navbar')

    {{-- HERO EKSTRAKULIKULER --}}
    <section class="relative h-72 md:h-96 overflow-hidden">
        <img src="{{ asset('images/mpls.JPG') }}" alt="Ekstrakulikuler SMKN 4 Bogor" class="absolute inset-0 w-full h-full object-cover scale-105">
        <div class="absolute inset-0 bg-gradient-to-r from-navy-900 via-navy-900/85 to-navy-900/40"></div>

        {{-- watermark --}}
        <span class="absolute right-6 md:right-16 bottom-0 text-[7rem] md:text-[12rem] font-black leading-none text-white/5 select-none pointer-events-none">EKSKUL</span>

        <div class="relative z-10 h-full flex flex-col justify-center px-8 md:px-16 pb-10 text-white">
            <span class="inline-flex items-center gap-2 self-start bg-white/10 backdrop-blur border border-white/20 text-yellow-400 font-semibold text-xs px-4 py-1.5 rounded-full mb-4">
                <span class="w-2 h-2 rounded-full bg-yellow-400 animate-pulse"></span>
                Pengembangan Minat & Bakat
            </span>
            <h1 class="text-3xl md:text-5xl font-extrabold leading-tight mb-4 max-w-2xl">Ekstrakulikuler SMKN 4 Bogor</h1>
            <div class="w-20 h-1.5 rounded-full bg-gradient-to-r from-blue-600 to-yellow-400 mb-4"></div>
            <p class="text-sm md:text-base text-white/80 max-w-xl">Wadah siswa untuk mengembangkan potensi di luar kegiatan akademik, dibimbing oleh pembina dan digerakkan oleh ketua ekskul dari siswa sendiri.</p>
        </div>
    </section>

    @php
        // ===== DATA (nanti diganti dengan data dari database) =====
        $daftarEkskul = [
            [
                'nama' => 'Pramuka',
                'icon' => 'LOGO PRAMUKA.png',
                'foto' => 'pramuka ekskul.jpeg',
                'ketua' => 'Satria Budhiyana (XII TO 1)',
                'pembina' => 'Ibu Sri Esti, S.Pd.',
                'jadwal' => 'Jumat, 15.00 - 17.0 WIB',
                'anggota' => '75 Anggota',
                'deskripsi' => 'Melatih kemandirian, kepemimpinan, dan kepedulian sosial siswa melalui kegiatan kepramukaan, mulai dari baris-berbaris, tali-temali, hingga kegiatan perkemahan.',
            ],
            [
                'nama' => 'Paskibra',
                'icon' => 'LOGO PASKIB.png',
                'foto' => 'paskib ekskul.JPG',
                'ketua' => 'Muhammad Faturahman (XII TJKT 2)',
                'pembina' => 'Bapak Sunggono, S.Pd.',
                'jadwal' => 'Rabu & Sabtu, 15.00 - 17.00 WIB',
                'anggota' => '50 Anggota',
                'deskripsi' => 'Membina kedisiplinan dan kekompakan siswa melalui latihan baris-berbaris serta bertugas sebagai pengibar bendera pada upacara resmi sekolah.',
            ],
            [
                'nama' => 'PMR',
                'icon' => 'LOGO PMR.png',
                'foto' => 'pmr ekskul.jpeg',
                'ketua' => 'Mawar Khaeriza Destri (XII PPLG 1)',
                'pembina' => 'Ibu Ruri Marlinawati, S.Pd.',
                'jadwal' => 'Kamis, 14.00 - 16.00 WIB',
                'anggota' => '45 Anggota',
                'deskripsi' => 'Melatih siswa dalam pertolongan pertama pada kecelakaan (P3K), kepedulian kesehatan, dan siap menjadi relawan pada kegiatan sekolah.',
            ],
            [
                'nama' => 'Basket',
                'icon' => 'LOGO BASKET.png',
                'foto' => 'basket ekskul.JPG',
                'ketua' => 'Fajar Ramadhan (XII TJKT 2)',
                'pembina' => 'Bapak Ade Eka Sastra, S.Pd.',
                'jadwal' => 'Selasa, 15.30 - 17.00 WIB',
                'anggota' => '20 Anggota',
                'deskripsi' => 'Mengembangkan kemampuan teknik dan strategi bermain basket, aktif mengikuti berbagai turnamen antar sekolah tingkat kota maupun provinsi.',
            ],
            [
                'nama' => 'Futsal',
                'icon' => 'LOGO FUTSAL.png',
                'foto' => 'futsal1.jpg',
                'ketua' => 'Nando (XII TPFL 2)',
                'pembina' => 'Bapak Ade Eka Sastra, S.Pd.',
                'jadwal' => 'Senin & Kamis, 15.00 - 17.30 WIB',
                'anggota' => '25 Anggota',
                'deskripsi' => 'Tim futsal sekolah yang rutin berlatih dan mengikuti kompetisi antar sekolah, salah satu prestasinya adalah Juara 3 IBG Championship Festival 2026.',
            ],
            [
                'nama' => 'Pencak Silat',
                'icon' => 'logo silat.png',
                'foto' => 'silat ekskul.jpeg',
                'ketua' => 'Melati (XII TJKT 1)',
                'pembina' => 'Bapak Ade Eka Sastra, S.Pd.',
                'jadwal' => 'Rabu & Sabtu, 15.00 - 16.30 WIB',
                'anggota' => '18 Anggota',
                'deskripsi' => 'Melestarikan budaya bela diri asli Indonesia sekaligus melatih fisik, mental, dan sportivitas siswa. Meraih Juara 1 Regu Putri pada kejuaraan pencak silat tingkat kota.',
            ],
            [
                'nama' => 'Band',
                'icon' => 'logo band.png',
                'foto' => 'band ekskul.jpg',
                'ketua' => 'Thariq (XII TPFL 1)',
                'pembina' => 'Bapak Tri Wahyono, S.Pd.',
                'jadwal' => 'Rabu, 15.00 - 17.30 WIB',
                'anggota' => '15 Anggota',
                'deskripsi' => 'Menyalurkan minat siswa di bidang musik, tampil pada berbagai acara sekolah seperti perpisahan, MPLS, dan Pensi.',
            ],
            [
                'nama' => 'Paduan Suara',
                'icon' => 'logo padus.png',
                'foto' => 'paduss.png',
                'ketua' => 'Keisha (XII PPLG 1)',
                'pembina' => 'Ibu Tresna Septiarti Amalia, S.Pd.',
                'jadwal' => 'Kamis, 15.00 - 16.30 WIB',
                'anggota' => '22 Anggota',
                'deskripsi' => 'Bertugas mengisi paduan suara pada upacara bendera dan acara resmi sekolah, perpishan, sekaligus melatih vokal dan kekompakan bernyanyi bersama.',
            ],
            [
                'nama' => 'Tari',
                'icon' => 'logo tari.png',
                'foto' => 'tarii.jpeg',
                'ketua' => 'Raifa Hasna Syahrani (XII PPLG 2)',
                'pembina' => 'Ibu Vivi Safitri Desemberiyani, S.Pd.',
                'jadwal' => 'Sabtu, 09.00 - 11.00 WIB',
                'anggota' => '20 Anggota',
                'deskripsi' => 'Melestarikan seni tari tradisional dan modern, sering tampil mewakili sekolah pada acara budaya dan perayaan hari besar.',
            ],
            [
                'nama' => 'Rohis',
                'icon' => 'logo rohis.png',
                'foto' => 'rohis.jpeg',
                'ketua' => 'M Davi (XII PPLG 1)',
                'pembina' => 'Bapak Syamsul Budiman, S.Pd.',
                'jadwal' => 'Jumat - Sabtu, 06.00 - 08.00 WIB',
                'anggota' => '20 Anggota',
                'deskripsi' => 'ekstrakurikuler sekolah untuk memperdalam ilmu agama Islam, memperkuat keimanan, dan membentuk akhlak mulia siswa melalui kegiatan kajian, mentoring, serta penguatan karakter Islami yang toleran dan mandiri.(kajian rutin, tahsin/tahfidz, peringatan hari besar Islam, dll).',
            ],
        ];

        // ===== TURUNAN DATA =====
        $koleksi = collect($daftarEkskul);

        // Hari ini (Asia/Jakarta) untuk badge "Latihan Hari Ini"
        $hariIni = mb_strtolower(\Carbon\Carbon::now('Asia/Jakarta')->locale('id')->isoFormat('dddd'));
        $latihanHariIni = fn ($e) => str_contains(mb_strtolower($e['jadwal']), $hariIni);

        $totalEkskul  = $koleksi->count();
        $totalAnggota = $koleksi->sum(fn ($e) => (int) $e['anggota']);
        $totalPembina = $koleksi->pluck('pembina')->unique()->count();
        $jumlahHariIni = $koleksi->filter($latihanHariIni)->count();

        $statistik = [
            ['label' => 'Ekstrakulikuler', 'nilai' => $totalEkskul,   'warna' => 'border-blue-600',  'icon' => 'M12 2l3 6.5 7 .9-5.2 4.8 1.4 7L12 17.8 5.8 21.2l1.4-7L2 9.4l7-.9L12 2Z'],
            ['label' => 'Total Anggota',   'nilai' => $totalAnggota,  'warna' => 'border-yellow-400', 'icon' => 'M16 11a3 3 0 1 0-3-3 3 3 0 0 0 3 3Zm-8 0a3 3 0 1 0-3-3 3 3 0 0 0 3 3Zm0 2c-2.3 0-7 1.2-7 3.5V19h14v-2.5C15 14.2 10.3 13 8 13Zm8 0c-.3 0-.6 0-1 .1 1.2.9 2 2 2 3.4V19h6v-2.5c0-2.3-4.7-3.5-7-3.5Z'],
            ['label' => 'Pembina',         'nilai' => $totalPembina,  'warna' => 'border-yellow-400', 'icon' => 'M12 3 1 9l11 6 9-4.9V17h2V9L12 3Zm-6 9.2V16c0 1.7 2.7 3 6 3s6-1.3 6-3v-3.8l-6 3.3-6-3.3Z'],
            ['label' => 'Latihan Hari Ini','nilai' => $jumlahHariIni, 'warna' => 'border-yellow-400', 'icon' => 'M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20Zm1 5v5.4l3.7 2.2-.8 1.3L11 13V7h2Z'],
        ];
    @endphp

    {{-- KARTU STATISTIK (menumpuk di atas hero) --}}
    <section class="relative z-20 px-8 md:px-16 -mt-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach ($statistik as $stat)
                <div class="bg-white rounded-2xl shadow-lg p-5 flex items-center gap-4 border-b-4 {{ $stat['warna'] }} hover:-translate-y-1 transition-all">
                    <span class="w-12 h-12 rounded-xl {{ $loop->first ? 'bg-blue-50 text-blue-600' : 'bg-yellow-400 text-navy-900' }} flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor"><path d="{{ $stat['icon'] }}"/></svg>
                    </span>
                    <div>
                        <p class="text-2xl font-extrabold text-navy-900 leading-none">{{ $stat['nilai'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $stat['label'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- GRID EKSTRAKULIKULER --}}
    <section class="px-8 md:px-16 pt-14 pb-16">
        <div class="mb-10">
            <span class="inline-block bg-blue-50 text-blue-600 text-xs font-bold px-3 py-1 rounded-full mb-3">Pilih Minatmu</span>
            <h2 class="text-2xl md:text-3xl font-extrabold text-navy-900">Daftar Ekstrakulikuler</h2>
            <div class="w-16 h-1 rounded-full bg-gradient-to-r from-blue-600 to-yellow-400 mt-3"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach ($daftarEkskul as $ekskul)
                @php
                    [$hari, $jam] = array_pad(explode(',', $ekskul['jadwal'], 2), 2, '');
                    $hari = trim($hari);
                    $jam  = trim($jam);
                @endphp

                <article class="relative bg-white rounded-3xl shadow-md hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 overflow-hidden flex flex-col group">

                    {{-- FOTO --}}
                    <div class="relative h-56 overflow-hidden">
                        <img src="{{ asset('images/'.$ekskul['foto']) }}" alt="Kegiatan {{ $ekskul['nama'] }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-navy-900/90 via-navy-900/30 to-transparent"></div>

                        @if ($latihanHariIni($ekskul))
                            <span class="absolute top-4 left-4 inline-flex items-center gap-1.5 bg-yellow-400 text-navy-900 text-[11px] font-bold px-3 py-1 rounded-full shadow">
                                <span class="w-1.5 h-1.5 rounded-full bg-navy-900 animate-pulse"></span>
                                LATIHAN HARI INI
                            </span>
                        @endif

                        <span class="absolute top-4 right-4 bg-white/90 text-navy-900 text-[11px] font-bold px-3 py-1 rounded-full flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-blue-600" viewBox="0 0 24 24" fill="currentColor"><path d="{{ $statistik[1]['icon'] }}"/></svg>
                            {{ $ekskul['anggota'] }}
                        </span>

                        <div class="absolute bottom-0 left-0 right-0 p-5 flex items-center gap-4">
                            <span class="w-16 h-16 rounded-full bg-white ring-4 ring-yellow-400 flex items-center justify-center overflow-hidden shrink-0 shadow-lg group-hover:scale-105 transition-transform">
                                <img src="{{ asset('images/'.$ekskul['icon']) }}" alt="Logo {{ $ekskul['nama'] }}" class="w-10 h-10 object-contain">
                            </span>
                            <div>
                                <h3 class="text-white font-extrabold text-2xl leading-tight">{{ $ekskul['nama'] }}</h3>
                                <div class="w-12 h-1 rounded-full bg-gradient-to-r from-blue-600 to-yellow-400 mt-2"></div>
                            </div>
                        </div>
                    </div>

                    {{-- ISI --}}
                    <div class="relative p-6 flex flex-col flex-1 overflow-hidden">
                        {{-- watermark nomor --}}
                        <span class="absolute -top-2 -right-1 text-8xl font-black leading-none text-gray-100 select-none pointer-events-none">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>

                        <p class="relative text-sm text-gray-600 leading-relaxed mb-6 flex-1 pr-10">{{ $ekskul['deskripsi'] }}</p>

                        <div class="relative grid grid-cols-1 sm:grid-cols-3 gap-3">
                            {{-- Ketua --}}
                            <div class="bg-gray-50 group-hover:bg-blue-50 transition-colors rounded-xl p-3 flex items-start gap-2.5">
                                <div class="bg-blue-100 text-blue-600 rounded-full p-1.5 shrink-0">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-[10px] text-gray-400 uppercase font-semibold">Ketua Ekskul</p>
                                    <p class="text-xs font-semibold text-navy-900 leading-snug">{{ $ekskul['ketua'] }}</p>
                                </div>
                            </div>

                            {{-- Pembina --}}
                            <div class="bg-gray-50 group-hover:bg-blue-50 transition-colors rounded-xl p-3 flex items-start gap-2.5">
                                <div class="bg-blue-100 text-blue-600 rounded-full p-1.5 shrink-0">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.42A12.083 12.083 0 0121 19a12.083 12.083 0 01-9 5 12.083 12.083 0 01-9-5 12.083 12.083 0 012.84-8.42L12 14z"/></svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-[10px] text-gray-400 uppercase font-semibold">Pembina</p>
                                    <p class="text-xs font-semibold text-navy-900 leading-snug">{{ $ekskul['pembina'] }}</p>
                                </div>
                            </div>

                            {{-- Jadwal --}}
                            <div class="bg-gray-50 group-hover:bg-blue-50 transition-colors rounded-xl p-3 flex items-start gap-2.5">
                                <div class="bg-blue-100 text-blue-600 rounded-full p-1.5 shrink-0">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-[10px] text-gray-400 uppercase font-semibold">Jadwal</p>
                                    <p class="text-xs font-bold text-navy-900 leading-snug">{{ $hari }}</p>
                                    @if ($jam)
                                        <p class="text-[11px] text-gray-500 leading-snug">{{ $jam }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- garis aksen biru ke kuning, memanjang saat hover --}}
                    <span class="absolute bottom-0 left-0 h-1 w-0 group-hover:w-full transition-all duration-500 bg-gradient-to-r from-blue-600 to-yellow-400"></span>
                </article>
            @endforeach
        </div>
    </section>

</body>
</html>