@extends('layouts.public')
@section('title', 'Beranda')

@section('content')
<style>
    /* Animasi khusus beranda (nama kelas diawali "hm-" agar tidak bentrok dengan layout) */
    @keyframes hmMelayang { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-12px); } }
    .hm-float      { animation: hmMelayang 6s ease-in-out infinite; }
    .hm-float-slow { animation: hmMelayang 10s ease-in-out infinite reverse; }

    @keyframes hmJalan { from { transform: translateX(0); } to { transform: translateX(-50%); } }
    .hm-track { animation: hmJalan 45s linear infinite; }
    .hm-marquee:hover .hm-track { animation-play-state: paused; }

    /* Kilau pada tombol saat disorot */
    .hm-shine { position: relative; overflow: hidden; }
    .hm-shine::after { content: ""; position: absolute; inset: 0; background: linear-gradient(110deg, transparent 30%, rgba(255,255,255,.55) 50%, transparent 70%); transform: translateX(-120%); }
    .hm-shine:hover::after { transform: translateX(120%); transition: transform .8s ease; }

    @media (prefers-reduced-motion: reduce) {
        .hm-float, .hm-float-slow, .hm-track { animation: none; }
        .hm-shine::after { display: none; }
    }
</style>

@php
    $gedung = file_exists(public_path('images/gedung_pt.png')) ? asset('images/gedung_pt.png') : null;
    $utama  = $artikels->first();
    $sisa   = $artikels->slice(1);
    $centang = 'M5 13l4 4L19 7';

    $statistik = config('perusahaan.statistik');
    $stat2     = $statistik[1] ?? null;

    // Galeri: 5 foto agar grid terisi penuh (1 besar + 4 kecil)
    $galeriTampil = $galeris->take(5);

    // Nomor telepon untuk tautan tel:
    $tel = preg_replace('/[^0-9+]/', '', (string) config('perusahaan.telepon'));

    $langkah = [
        ['Konsultasi', 'Kami mendengarkan target bisnis, jumlah pengguna, dan kondisi jaringan Anda.'],
        ['Survei & rancangan', 'Tim teknis meninjau lokasi dan menyusun rancangan beserta penawaran yang jelas.'],
        ['Instalasi & uji', 'Perangkat dipasang, diuji, dan diserahterimakan dengan laporan hasil pengujian.'],
        ['Pemantauan', 'Jaringan dipantau terus-menerus dan gangguan ditangani sesuai SLA.'],
    ];
    $faq = [
        ['Berapa lama proses pemasangan layanan?', 'Setelah survei dan kesepakatan, pemasangan umumnya selesai dalam beberapa hari kerja. Waktu pastinya bergantung pada lokasi dan jenis layanan.'],
        ['Apakah tersedia jaminan kualitas layanan (SLA)?', 'Ya. Setiap paket layanan bisnis dilengkapi SLA tertulis yang memuat target ketersediaan dan waktu penanganan gangguan.'],
        ['Bagaimana cara melaporkan gangguan jaringan?', 'Hubungi pusat operasi jaringan kami melalui telepon atau email. Laporan ditangani sesuai tingkat prioritas yang disepakati.'],
        ['Apakah layanan bisa disesuaikan dengan kebutuhan kantor kami?', 'Bisa. Tim kami merancang solusi berdasarkan jumlah pengguna, jumlah lokasi, dan kebutuhan aplikasi perusahaan Anda.'],
        ['Bagaimana cara meminta penawaran?', 'Isi formulir di halaman Kontak atau hubungi kami langsung. Tim kami akan menghubungi Anda untuk penilaian awal tanpa biaya.'],
    ];
@endphp

{{-- ============ HERO (foto gedung) ============ --}}
<section class="relative isolate overflow-hidden bg-navy-950 text-white">
    @if ($gedung)
        <img src="{{ $gedung }}" alt="Gedung {{ config('perusahaan.nama') }}" class="absolute inset-0 -z-10 h-full w-full object-cover object-[65%_30%]">
    @endif
    <div class="absolute inset-0 -z-10 bg-gradient-to-r from-navy-950 via-navy-950/80 to-navy-950/10"></div>
    <div class="absolute inset-x-0 bottom-0 -z-10 h-48 bg-gradient-to-t from-navy-950/80 to-transparent"></div>

    <div class="mx-auto flex min-h-[40rem] max-w-6xl items-center px-6 pb-40 pt-20">
        <div class="max-w-2xl">
            <div class="mb-7 flex items-center gap-3">
                <span class="h-px w-10 bg-amber-400"></span>
                <p class="text-sm font-medium tracking-wide text-amber-300">Konektivitas &amp; infrastruktur jaringan</p>
            </div>
            <h1 class="font-display text-4xl font-semibold leading-[1.12] md:text-[3.5rem]">
                Jaringan andal untuk bisnis yang <span class="bg-gradient-to-r from-amber-300 to-amber-100 bg-clip-text text-transparent">terus bertumbuh.</span>
            </h1>
            <p class="mt-7 max-w-xl text-lg leading-relaxed text-blue-50/90">
                Internet dedicated, jaringan antar kantor, cloud, dan keamanan jaringan, ditangani satu tim yang siap mendampingi Anda setiap hari.
            </p>
            <div class="mt-10 flex flex-wrap items-center gap-4">
                <a href="{{ route('layanan') }}" class="hm-shine rounded-full bg-amber-400 px-8 py-3.5 text-sm font-semibold text-navy-950 shadow-lg shadow-amber-400/20 transition hover:-translate-y-0.5 hover:bg-amber-300">Jelajahi layanan</a>
                <a href="{{ route('kontak') }}" class="rounded-full border border-white/40 px-8 py-3.5 text-sm font-semibold backdrop-blur transition hover:bg-white/10">Minta penawaran</a>
            </div>
            <ul class="mt-10 flex flex-wrap gap-x-7 gap-y-3 text-sm text-blue-50">
                @foreach (['Pusat operasi 24 jam', 'SLA tertulis', 'Jangkauan Jawa Barat'] as $chip)
                    <li class="flex items-center gap-2">
                        <span class="flex h-5 w-5 items-center justify-center rounded-full bg-amber-400 text-navy-950">
                            <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="3.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $centang }}"/></svg>
                        </span>
                        {{ $chip }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- Kartu kaca melayang (hanya di layar lebar) --}}
    <div class="hm-float absolute bottom-48 right-8 hidden w-72 rounded-2xl bg-white/10 p-5 shadow-2xl ring-1 ring-white/20 backdrop-blur-md lg:block xl:right-16">
        <div class="flex items-center gap-3">
            <span class="relative flex h-3 w-3">
                <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex h-3 w-3 rounded-full bg-emerald-400"></span>
            </span>
            <p class="text-xs font-semibold uppercase tracking-wider text-emerald-300">Pusat operasi aktif</p>
        </div>
        <p class="mt-3 font-display text-lg font-semibold">Dipantau 24 jam</p>
        <p class="mt-1 text-sm leading-relaxed text-blue-100/80">Tim teknis siap menerima laporan gangguan setiap hari.</p>
    </div>
</section>

{{-- ============ ANGKA KINERJA ============ --}}
<div class="relative z-10 mx-auto -mt-24 max-w-6xl px-6">
    <dl class="grid grid-cols-2 overflow-hidden rounded-2xl bg-white shadow-2xl shadow-navy-900/15 ring-1 ring-slate-200/70 md:grid-cols-4">
        @foreach (config('perusahaan.statistik') as $i => [$angka, $label])
            <div class="px-8 py-8 {{ $i > 0 ? 'md:border-l md:border-slate-200' : '' }} {{ $i > 1 ? 'border-t border-slate-200 md:border-t-0' : '' }}">
                <dt class="font-display text-3xl font-semibold text-navy-800">{{ $angka }}</dt>
                <dd class="mt-1.5 text-sm text-slate-500">{{ $label }}</dd>
            </div>
        @endforeach
    </dl>
</div>

{{-- ============ TENTANG KAMI ============ --}}
<section class="mx-auto grid max-w-6xl items-center gap-16 px-6 py-28 lg:grid-cols-2">
    <div class="relative">
        <div class="absolute -bottom-5 -left-5 h-full w-full rounded-3xl bg-blue-50"></div>
        @if ($gedung)
            <img src="{{ $gedung }}" alt="Kantor {{ config('perusahaan.nama') }}" class="relative h-[26rem] w-full rounded-3xl object-cover object-[60%_40%] shadow-xl">
        @else
            <div class="relative flex h-[26rem] w-full items-center justify-center rounded-3xl bg-gradient-to-br from-navy-800 to-navy-950 font-display text-6xl font-semibold text-white/20">{{ config('perusahaan.singkat') }}</div>
        @endif
        <div class="hm-float absolute -right-4 top-10 rounded-2xl bg-navy-900 px-6 py-4 text-white shadow-xl">
            <p class="font-display text-2xl font-semibold text-amber-300">{{ $profil?->tahun_berdiri ?: '-' }}</p>
            <p class="text-xs text-blue-100">Tahun berdiri</p>
        </div>
        @if ($stat2)
            <div class="hm-float-slow absolute -bottom-6 right-8 rounded-2xl bg-white px-6 py-4 shadow-xl ring-1 ring-slate-200">
                <p class="font-display text-2xl font-semibold text-navy-800">{{ $stat2[0] }}</p>
                <p class="text-xs text-slate-500">{{ $stat2[1] }}</p>
            </div>
        @endif
    </div>
    <div>
        <div class="flex items-center gap-3">
            <span class="h-px w-8 bg-amber-400"></span>
            <p class="text-sm font-semibold tracking-wide text-navy-700">Tentang kami</p>
        </div>
        <h2 class="mt-3 font-display text-3xl font-semibold leading-tight text-navy-950 md:text-4xl">Mitra teknologi yang menjaga bisnis Anda tetap terhubung.</h2>
        <p class="mt-6 leading-relaxed text-slate-600">{{ \Illuminate\Support\Str::limit($profil?->sejarah ?? '', 280) }}</p>
        <ul class="mt-8 grid gap-4 sm:grid-cols-2">
            @foreach (config('perusahaan.keunggulan') as [$judul, $isi])
                <li class="flex items-start gap-3">
                    <span class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-blue-100 text-navy-700">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="3.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $centang }}"/></svg>
                    </span>
                    <span class="text-sm font-medium leading-snug text-slate-700">{{ $judul }}</span>
                </li>
            @endforeach
        </ul>
        <a href="{{ route('profil') }}" class="group mt-9 inline-flex items-center gap-2 text-sm font-semibold text-navy-700 hover:text-navy-950">
            Baca profil lengkap
            <svg class="h-4 w-4 transition group-hover:translate-x-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
    </div>
</section>

{{-- ============ PITA LAYANAN (berjalan otomatis) ============ --}}
@if ($layanans->isNotEmpty())
<div class="hm-marquee overflow-hidden bg-navy-950 py-5" aria-hidden="true">
    <div class="hm-track flex w-max items-center">
        @for ($ulang = 0; $ulang < 2; $ulang++)
            @foreach ($layanans as $l)
                <span class="flex shrink-0 items-center gap-10 pr-10 font-display text-sm font-semibold tracking-wide text-blue-100/80">
                    {{ $l->nama }}
                    <span class="h-1.5 w-1.5 rounded-full bg-amber-400"></span>
                </span>
            @endforeach
        @endfor
    </div>
</div>
@endif

{{-- ============ PRODUK & LAYANAN ============ --}}
<section class="relative overflow-hidden bg-slate-50">
    <div class="absolute -right-32 top-10 h-96 w-96 rounded-full bg-blue-100/60 blur-3xl"></div>
    <div class="relative mx-auto max-w-6xl px-6 py-28">
        <div class="mb-14 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div class="max-w-xl">
                <div class="flex items-center gap-3">
                    <span class="h-px w-8 bg-amber-400"></span>
                    <p class="text-sm font-semibold tracking-wide text-navy-700">Produk &amp; layanan</p>
                </div>
                <h2 class="mt-3 font-display text-3xl font-semibold leading-tight text-navy-950 md:text-4xl">Solusi lengkap untuk setiap skala usaha</h2>
            </div>
            <a href="{{ route('layanan') }}" class="text-sm font-semibold text-navy-700 hover:text-navy-950">Lihat semua layanan &rarr;</a>
        </div>
        <div class="grid gap-7 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($layanans as $l)
                @include('partials.kartu-layanan', ['l' => $l])
            @empty
                <p class="col-span-full text-center text-slate-500">Belum ada layanan.</p>
            @endforelse
        </div>

        <div class="mt-12 flex flex-col items-start justify-between gap-5 rounded-2xl bg-white p-7 shadow-sm ring-1 ring-slate-200 md:flex-row md:items-center">
            <div>
                <p class="font-display text-lg font-semibold text-navy-950">Butuh paket yang disesuaikan?</p>
                <p class="mt-1 text-sm text-slate-500">Ceritakan jumlah pengguna dan lokasi kantor Anda, kami siapkan rancangan dan penawaran.</p>
            </div>
            <a href="{{ route('kontak') }}" class="hm-shine shrink-0 rounded-full bg-navy-900 px-7 py-3 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:bg-navy-800">Minta penawaran</a>
        </div>
    </div>
</section>

{{-- ============ KEUNGGULAN (gelap) ============ --}}
<section class="relative overflow-hidden bg-navy-950 text-white">
    <div class="absolute inset-0 opacity-50" style="background-image: radial-gradient(rgba(255,255,255,.08) 1px, transparent 1px); background-size: 24px 24px;"></div>
    <div class="absolute -right-24 top-0 h-80 w-80 rounded-full bg-navy-700/40 blur-3xl"></div>

    {{-- Lengkung sinyal bergaya logo --}}
    <svg class="hm-float-slow pointer-events-none absolute -right-10 bottom-6 hidden h-96 w-96 opacity-20 lg:block" viewBox="0 0 400 400" fill="none" aria-hidden="true">
        <path d="M60 290 C 120 190, 220 140, 350 130" stroke="#ffffff" stroke-width="14" stroke-linecap="round"/>
        <path d="M60 230 C 120 150, 220 105, 350 95" stroke="#ffffff" stroke-opacity=".5" stroke-width="14" stroke-linecap="round"/>
        <circle cx="320" cy="292" r="18" fill="#fbbf24"/>
    </svg>

    <div class="relative mx-auto max-w-6xl px-6 py-28">
        <div class="max-w-2xl">
            <div class="flex items-center gap-3">
                <span class="h-px w-8 bg-amber-400"></span>
                <p class="text-sm font-semibold tracking-wide text-amber-300">Mengapa kami</p>
            </div>
            <h2 class="mt-3 font-display text-3xl font-semibold leading-tight md:text-4xl">Alasan perusahaan mempercayakan jaringannya kepada kami</h2>
        </div>
        <div class="mt-16 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach (config('perusahaan.keunggulan') as $i => [$judul, $isi])
                <div class="group rounded-2xl bg-white/5 p-7 ring-1 ring-white/10 backdrop-blur transition duration-300 hover:-translate-y-1.5 hover:bg-white/10 hover:ring-amber-400/40">
                    <p class="font-display text-4xl font-semibold text-amber-400">0{{ $i + 1 }}</p>
                    <span class="mt-4 block h-0.5 w-8 rounded-full bg-amber-400 transition-all duration-300 group-hover:w-16"></span>
                    <p class="mt-5 font-display text-lg font-semibold">{{ $judul }}</p>
                    <p class="mt-2 text-sm leading-relaxed text-blue-100/80">{{ $isi }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============ CARA KERJA ============ --}}
<section class="mx-auto max-w-6xl px-6 py-28">
    <div class="mx-auto mb-16 max-w-2xl text-center">
        <div class="flex items-center justify-center gap-3">
            <span class="h-px w-8 bg-amber-400"></span>
            <p class="text-sm font-semibold tracking-wide text-navy-700">Cara kerja</p>
            <span class="h-px w-8 bg-amber-400"></span>
        </div>
        <h2 class="mt-3 font-display text-3xl font-semibold text-navy-950 md:text-4xl">Dari konsultasi hingga layanan berjalan</h2>
    </div>
    <ol class="grid gap-6 md:grid-cols-4">
        @foreach ($langkah as $i => [$judul, $isi])
            <li class="group relative rounded-2xl bg-white p-7 shadow-sm ring-1 ring-slate-200 transition duration-300 hover:-translate-y-1.5 hover:shadow-xl">
                <span class="absolute right-6 top-4 font-display text-5xl font-semibold text-slate-100 transition group-hover:text-amber-100">0{{ $i + 1 }}</span>
                <span class="relative flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-navy-700 to-navy-900 font-display text-lg font-semibold text-white shadow-lg shadow-navy-700/30">{{ $i + 1 }}</span>
                <p class="relative mt-6 font-display text-lg font-semibold text-navy-950">{{ $judul }}</p>
                <p class="relative mt-2 text-sm leading-relaxed text-slate-600">{{ $isi }}</p>
                @if ($i < 3)
                    <span class="absolute -right-6 top-1/2 hidden h-px w-6 bg-amber-400 md:block"></span>
                @endif
            </li>
        @endforeach
    </ol>
</section>

{{-- ============ ARTIKEL (gaya majalah) ============ --}}
<section class="bg-slate-50">
    <div class="mx-auto max-w-6xl px-6 py-28">
        <div class="mb-12 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <div class="flex items-center gap-3">
                    <span class="h-px w-8 bg-amber-400"></span>
                    <p class="text-sm font-semibold tracking-wide text-navy-700">Artikel &amp; informasi terkini</p>
                </div>
                <h2 class="mt-3 font-display text-3xl font-semibold text-navy-950 md:text-4xl">Kabar dan panduan terbaru</h2>
            </div>
            <a href="{{ route('artikel') }}" class="text-sm font-semibold text-navy-700 hover:text-navy-950">Semua artikel &rarr;</a>
        </div>

        @if ($utama)
            <div class="grid gap-8 lg:grid-cols-5">
                <a href="{{ route('artikel.show', $utama->slug) }}" class="group relative block min-h-[24rem] overflow-hidden rounded-3xl bg-navy-900 shadow-xl lg:col-span-3">
                    @if ($utama->urlGambar())
                        <img src="{{ $utama->urlGambar() }}" alt="{{ $utama->judul }}" class="absolute inset-0 h-full w-full object-cover transition duration-700 group-hover:scale-105">
                    @else
                        <div class="absolute inset-0 bg-gradient-to-br from-navy-700 to-navy-950"></div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-navy-950 via-navy-950/60 to-transparent"></div>
                    <span class="absolute left-6 top-6 rounded-full bg-amber-400 px-3.5 py-1 text-xs font-bold text-navy-950 shadow">Terbaru</span>
                    <div class="absolute inset-x-0 bottom-0 p-8 text-white">
                        <p class="text-xs font-semibold text-amber-300">{{ $utama->kategori }} &middot; {{ $utama->tanggalIndo() }}</p>
                        <h3 class="mt-2 font-display text-2xl font-semibold leading-snug md:text-3xl">{{ $utama->judul }}</h3>
                        <p class="mt-3 max-w-xl text-sm leading-relaxed text-blue-100/90">{{ \Illuminate\Support\Str::limit($utama->deskripsi, 130) }}</p>
                        <span class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-amber-300">
                            Baca artikel
                            <svg class="h-4 w-4 transition group-hover:translate-x-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </span>
                    </div>
                </a>
                <div class="flex flex-col gap-6 lg:col-span-2">
                    @forelse ($sisa as $a)
                        <a href="{{ route('artikel.show', $a->slug) }}" class="group flex flex-1 gap-5 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200 transition duration-300 hover:-translate-y-1 hover:shadow-lg">
                            @if ($a->urlGambar())
                                <img src="{{ $a->urlGambar() }}" alt="{{ $a->judul }}" class="h-28 w-28 shrink-0 rounded-xl object-cover">
                            @else
                                <div class="flex h-28 w-28 shrink-0 items-center justify-center rounded-xl bg-blue-50 font-display text-3xl font-semibold text-navy-700/40">{{ mb_substr($a->judul, 0, 1) }}</div>
                            @endif
                            <div class="flex flex-col justify-center">
                                <p class="text-xs font-semibold text-navy-700">{{ $a->kategori }} &middot; {{ $a->tanggalIndo() }}</p>
                                <h3 class="mt-1.5 font-display text-base font-semibold leading-snug text-navy-950 group-hover:text-navy-700">{{ \Illuminate\Support\Str::limit($a->judul, 70) }}</h3>
                                <span class="mt-3 block h-0.5 w-8 rounded-full bg-amber-400 transition-all duration-300 group-hover:w-14"></span>
                            </div>
                        </a>
                    @empty
                        <p class="text-sm text-slate-500">Artikel lainnya akan tampil di sini.</p>
                    @endforelse
                </div>
            </div>
        @else
            <p class="text-slate-500">Belum ada artikel.</p>
        @endif
    </div>
</section>

{{-- ============ GALERI KEGIATAN ============ --}}
<section class="mx-auto max-w-6xl px-6 py-28">
    <div class="mb-12 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
        <div>
            <div class="flex items-center gap-3">
                <span class="h-px w-8 bg-amber-400"></span>
                <p class="text-sm font-semibold tracking-wide text-navy-700">Galeri kegiatan</p>
            </div>
            <h2 class="mt-3 font-display text-3xl font-semibold text-navy-950 md:text-4xl">Aktivitas tim kami</h2>
        </div>
        <a href="{{ route('galeri') }}" class="text-sm font-semibold text-navy-700 hover:text-navy-950">Semua foto &rarr;</a>
    </div>
    @if ($galeriTampil->count())
        <div class="grid auto-rows-[12rem] grid-cols-2 gap-4 md:grid-cols-4">
            @foreach ($galeriTampil as $i => $g)
                <figure class="group relative overflow-hidden rounded-2xl bg-slate-100 shadow-sm ring-1 ring-slate-200 {{ $i === 0 ? 'col-span-2 row-span-2' : '' }}">
                    @if ($g->urlGambar())
                        <img src="{{ $g->urlGambar() }}" alt="{{ $g->judul }}" class="h-full w-full object-cover transition duration-700 group-hover:scale-110">
                    @else
                        <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-navy-700 to-navy-950 font-display text-5xl font-semibold text-white/25">{{ mb_substr($g->judul, 0, 1) }}</div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-navy-950/80 via-transparent to-transparent opacity-0 transition duration-300 group-hover:opacity-100"></div>
                    <figcaption class="absolute inset-x-0 bottom-0 translate-y-3 p-4 text-sm font-semibold text-white opacity-0 transition duration-300 group-hover:translate-y-0 group-hover:opacity-100">
                        <span class="mb-2 block h-0.5 w-8 rounded-full bg-amber-400"></span>
                        {{ $g->judul }}
                    </figcaption>
                </figure>
            @endforeach
        </div>
    @else
        <div class="rounded-3xl border border-dashed border-slate-300 bg-slate-50 p-14 text-center text-slate-500">Foto kegiatan akan tampil di sini. Tambahkan lewat menu Galeri di halaman admin.</div>
    @endif
</section>

{{-- ============ PERTANYAAN UMUM ============ --}}
<section class="bg-slate-50">
    <div class="mx-auto grid max-w-6xl gap-12 px-6 py-28 lg:grid-cols-5">
        <div class="lg:col-span-2">
            <div class="flex items-center gap-3">
                <span class="h-px w-8 bg-amber-400"></span>
                <p class="text-sm font-semibold tracking-wide text-navy-700">Pertanyaan umum</p>
            </div>
            <h2 class="mt-3 font-display text-3xl font-semibold leading-tight text-navy-950 md:text-4xl">Yang sering ditanyakan calon pelanggan</h2>
            <p class="mt-5 leading-relaxed text-slate-600">Tidak menemukan jawabannya? Tim kami siap membantu langsung.</p>
            <a href="{{ route('kontak') }}" class="mt-7 inline-block rounded-full border border-navy-700 px-7 py-3 text-sm font-semibold text-navy-700 transition hover:bg-navy-700 hover:text-white">Tanya tim kami</a>
        </div>
        <div class="space-y-3 lg:col-span-3">
            @foreach ($faq as [$tanya, $jawab])
                <details class="group rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200 transition open:shadow-md open:ring-navy-700/30">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-display font-semibold text-navy-950">
                        {{ $tanya }}
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-blue-50 text-navy-700 transition group-open:rotate-45 group-open:bg-amber-400 group-open:text-navy-950">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" d="M12 5v14M5 12h14"/></svg>
                        </span>
                    </summary>
                    <p class="mt-4 text-sm leading-relaxed text-slate-600">{{ $jawab }}</p>
                </details>
            @endforeach
        </div>
    </div>
</section>

{{-- ============ AJAKAN ============ --}}
<section class="px-6 py-28">
    <div class="relative mx-auto max-w-6xl overflow-hidden rounded-3xl bg-gradient-to-br from-navy-900 via-navy-800 to-navy-700 px-8 py-16 text-white shadow-2xl shadow-navy-900/20 md:px-16">
        <div class="hm-float-slow absolute -right-16 -top-16 h-72 w-72 rounded-full bg-white/10"></div>
        <div class="hm-float absolute -bottom-20 right-40 h-56 w-56 rounded-full bg-amber-400/20"></div>
        <div class="relative grid items-center gap-10 lg:grid-cols-5">
            <div class="lg:col-span-3">
                <h2 class="font-display text-3xl font-semibold leading-tight md:text-4xl">Siap membangun jaringan yang lebih andal?</h2>
                <p class="mt-4 max-w-lg text-blue-100">Ceritakan kebutuhan Anda. Tim kami memberi penilaian awal dan penawaran tanpa biaya.</p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('kontak') }}" class="hm-shine rounded-full bg-amber-400 px-8 py-3.5 text-sm font-semibold text-navy-950 transition hover:-translate-y-0.5 hover:bg-amber-300">Hubungi kami</a>
                    <a href="{{ route('layanan') }}" class="rounded-full border border-white/40 px-8 py-3.5 text-sm font-semibold transition hover:bg-white/10">Lihat layanan</a>
                </div>
            </div>
            <dl class="grid gap-3 text-sm lg:col-span-2">
                <div class="rounded-xl bg-white/10 px-5 py-3.5 ring-1 ring-white/15 transition hover:bg-white/15">
                    <dt class="text-xs text-blue-200">Telepon</dt>
                    <dd class="mt-0.5 font-semibold">
                        @if ($tel)<a href="tel:{{ $tel }}" class="hover:text-amber-300">{{ config('perusahaan.telepon') }}</a>@else{{ config('perusahaan.telepon') }}@endif
                    </dd>
                </div>
                <div class="rounded-xl bg-white/10 px-5 py-3.5 ring-1 ring-white/15 transition hover:bg-white/15">
                    <dt class="text-xs text-blue-200">Email</dt>
                    <dd class="mt-0.5 font-semibold">
                        <a href="mailto:{{ config('perusahaan.email') }}" class="hover:text-amber-300">{{ config('perusahaan.email') }}</a>
                    </dd>
                </div>
                <div class="rounded-xl bg-white/10 px-5 py-3.5 ring-1 ring-white/15 transition hover:bg-white/15">
                    <dt class="text-xs text-blue-200">Jam operasional</dt>
                    <dd class="mt-0.5 font-semibold">{{ config('perusahaan.jam') }}</dd>
                </div>
            </dl>
        </div>
    </div>
</section>
@endsection