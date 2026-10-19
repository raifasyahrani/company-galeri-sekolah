@extends('layouts.public')
@section('title', 'Artikel')

@section('content')
<style>
    /* Kelas halaman artikel berawalan "ar-" agar tidak bentrok dengan animasi bawaan layout (.reveal, .is-visible) */

    /* ===== Animasi hero ===== */
    @keyframes arNaik { from { opacity: 0; transform: translateY(22px); } to { opacity: 1; transform: none; } }
    .ar-in { opacity: 0; animation: arNaik .9s cubic-bezier(.2, .7, .2, 1) forwards; animation-delay: var(--d, 0ms); }

    @keyframes arZoom { from { transform: scale(1.12); } to { transform: scale(1); } }
    .ar-zoom { animation: arZoom 14s ease-out forwards; }

    @keyframes arMelayang { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-14px); } }
    .ar-float      { animation: arMelayang 7s ease-in-out infinite; }
    .ar-float-slow { animation: arMelayang 10s ease-in-out infinite reverse; }

    @keyframes arCincin { 0% { transform: scale(.35); opacity: 0; } 30% { opacity: .4; } 100% { transform: scale(1.1); opacity: 0; } }
    .ar-cincin { transform-box: fill-box; transform-origin: center; animation: arCincin 6s ease-out infinite; animation-delay: var(--d, 0s); }

    @keyframes arGambar { to { stroke-dashoffset: 0; } }
    .ar-lengkung { stroke-dasharray: 520; stroke-dashoffset: 520; animation: arGambar 2.2s .4s ease forwards; }

    @keyframes arDenyut { 0%, 100% { transform: scale(1); opacity: 1; } 50% { transform: scale(1.5); opacity: .6; } }
    .ar-titik { transform-box: fill-box; transform-origin: center; animation: arDenyut 2.4s ease-in-out infinite; }

    @keyframes arGarisTumbuh { from { width: 0; } to { width: 4rem; } }
    .ar-garis-judul { width: 0; height: 4px; border-radius: 9999px; background: #fbbf24; animation: arGarisTumbuh .9s .7s ease forwards; }

    @keyframes arNaikTurun { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(6px); } }
    .ar-panah { animation: arNaikTurun 1.6s ease-in-out infinite; }

    /* ===== Animasi bagian artikel ===== */
    .ar-js .ar-rv { opacity: 0; transform: translateY(30px); transition: opacity .8s ease, transform .8s ease; transition-delay: var(--d, 0ms); }
    .ar-js .ar-rv.ar-on { opacity: 1; transform: none; }

    @keyframes arMasuk { from { opacity: 0; transform: translateY(18px) scale(.97); } to { opacity: 1; transform: none; } }
    .ar-masuk { animation: arMasuk .5s ease both; }

    .ar-amber { display: block; height: 3px; width: 2.5rem; border-radius: 9999px; background: #fbbf24; transition: width .4s ease; }
    .group:hover .ar-amber { width: 5rem; }

    .ar-filter { transition: background-color .25s, color .25s, transform .25s, box-shadow .25s; }
    .ar-filter:hover { transform: translateY(-2px); }
    .ar-filter.ar-aktif { background-color: #10297a; color: #fff; box-shadow: 0 10px 22px -10px rgba(16, 41, 122, .7); }

    @media (prefers-reduced-motion: reduce) {
        .ar-in { opacity: 1; animation: none; }
        .ar-zoom, .ar-float, .ar-float-slow, .ar-cincin, .ar-titik, .ar-panah { animation: none; }
        .ar-lengkung { stroke-dashoffset: 0; animation: none; }
        .ar-garis-judul { width: 4rem; animation: none; }
        .ar-js .ar-rv { opacity: 1; transform: none; transition: none; }
        .ar-masuk { animation: none; }
    }
</style>
<script>document.documentElement.classList.add('ar-js');</script>

@php
    // Warna badge tiap kategori (untuk lencana di atas foto)
    $warna = fn ($k) => match ($k) {
        'Panduan'   => 'bg-sky-500 text-white',
        'Berita'    => 'bg-amber-400 text-navy-950',
        'Kegiatan'  => 'bg-emerald-500 text-white',
        'Informasi' => 'bg-violet-500 text-white',
        default     => 'bg-navy-700 text-white',
    };

    // Warna teks kategori (untuk kartu putih)
    $warnaTeks = fn ($k) => match ($k) {
        'Panduan'   => 'text-sky-600',
        'Berita'    => 'text-amber-600',
        'Kegiatan'  => 'text-emerald-600',
        'Informasi' => 'text-violet-600',
        default     => 'text-navy-700',
    };

    // Perkiraan waktu baca (menit)
    $menitBaca = function ($a) {
        $kata = preg_split('/\s+/u', trim(strip_tags((string) ($a->isi ?: $a->deskripsi))), -1, PREG_SPLIT_NO_EMPTY);
        return max(1, (int) ceil(count($kata) / 200));
    };

    // Foto gedung (opsional): gedung_pt.png, cadangan perusahaan.jpg
    $foto = null;
    foreach (['images/gedung_pt.png', 'images/perusahaan.jpg'] as $berkas) {
        if (file_exists(public_path($berkas))) { $foto = asset($berkas); break; }
    }

    $utama    = $artikels->first();
    $kecil    = $artikels->skip(1)->take(2)->values();
    $lainnya  = $artikels->skip(3)->values();
    $kategoriList = $lainnya->pluck('kategori')->filter()->unique()->values();

    // Ukuran kartu sorotan menyesuaikan jumlah artikel
    $spanUtama    = $kecil->isEmpty() ? 'lg:col-span-5' : 'lg:col-span-3';
    $tinggiGambar = $kecil->isEmpty() ? 'h-64 md:h-72' : 'h-52 md:h-56';

    // Data untuk chip di hero
    $totalArtikel  = $artikels->count();
    $totalKategori = $artikels->pluck('kategori')->filter()->unique()->count();
@endphp

{{-- ============ HERO ARTIKEL (foto gedung, ringkas, beranimasi) ============ --}}
<section class="relative isolate overflow-hidden bg-navy-950 text-white">
    @if ($foto)
        <img src="{{ $foto }}" alt="Gedung {{ config('perusahaan.nama') }}" class="ar-zoom absolute inset-0 -z-10 h-full w-full object-cover object-[65%_35%]">
    @endif
    <div class="absolute inset-0 -z-10 bg-gradient-to-r from-navy-950 via-navy-950/90 to-navy-800/60"></div>
    <div class="absolute inset-0 -z-10 opacity-60" style="background-image: radial-gradient(rgba(255,255,255,.09) 1px, transparent 1px); background-size: 28px 28px;"></div>

    {{-- Lingkaran melayang --}}
    <div class="ar-float absolute -right-20 -top-24 -z-10 h-64 w-64 rounded-full bg-white/10"></div>
    <div class="ar-float-slow absolute -bottom-20 left-1/3 -z-10 h-40 w-40 rounded-full bg-amber-400/15"></div>

    {{-- Lengkung sinyal bergaya logo (hanya di layar lebar) --}}
    <div class="pointer-events-none absolute right-10 top-1/2 -z-10 hidden h-64 w-64 -translate-y-1/2 lg:block" aria-hidden="true">
        <svg viewBox="0 0 400 400" class="h-full w-full" fill="none">
            <circle class="ar-cincin" style="--d: 0s" cx="200" cy="200" r="190" stroke="#ffffff" stroke-width="2"/>
            <circle class="ar-cincin" style="--d: 2s" cx="200" cy="200" r="190" stroke="#fbbf24" stroke-width="2"/>
            <circle class="ar-cincin" style="--d: 4s" cx="200" cy="200" r="190" stroke="#ffffff" stroke-width="2"/>

            <path class="ar-lengkung" d="M60 290 C 120 190, 220 140, 350 130" stroke="#ffffff" stroke-width="14" stroke-linecap="round"/>
            <path class="ar-lengkung" style="animation-delay: .8s" d="M60 230 C 120 150, 220 105, 350 95" stroke="#ffffff" stroke-opacity=".5" stroke-width="14" stroke-linecap="round"/>
            <circle class="ar-titik" cx="320" cy="292" r="18" fill="#fbbf24"/>
        </svg>
    </div>

    <div class="relative mx-auto max-w-6xl px-6 py-10 md:py-14">
        <nav class="ar-in flex items-center gap-2 text-sm text-blue-100" style="--d: 0ms" aria-label="Breadcrumb">
            <a href="{{ route('welcome') }}" class="transition hover:text-white">Beranda</a>
            <span class="text-blue-200/60">/</span>
            <span class="font-semibold text-white">Artikel</span>
        </nav>

        <h1 class="ar-in mt-4 font-display text-3xl font-bold leading-tight md:text-4xl" style="--d: 120ms">
            Artikel &amp; Informasi <span class="text-amber-300">Terkini</span>
        </h1>
        <div class="ar-garis-judul mt-4"></div>

        <p class="ar-in mt-4 max-w-xl text-base leading-relaxed text-blue-100" style="--d: 300ms">
            Kabar, panduan, dan kegiatan terbaru dari perusahaan.
        </p>

        {{-- Chip ringkasan dan tombol, satu baris --}}
        <div class="ar-in mt-6 flex flex-wrap items-center gap-3" style="--d: 460ms">
            <div class="rounded-xl bg-white/10 px-4 py-2 ring-1 ring-white/15">
                <span class="font-display text-lg font-bold text-white">{{ $totalArtikel }}</span>
                <span class="ml-1 text-xs text-blue-100">Artikel</span>
            </div>
            <div class="rounded-xl bg-white/10 px-4 py-2 ring-1 ring-white/15">
                <span class="font-display text-lg font-bold text-white">{{ $totalKategori }}</span>
                <span class="ml-1 text-xs text-blue-100">Kategori</span>
            </div>
            @if ($utama)
                <div class="rounded-xl bg-white/10 px-4 py-2 ring-1 ring-white/15">
                    <span class="text-xs text-blue-100">Terbaru</span>
                    <span class="ml-1 font-display text-sm font-bold text-white">{{ $utama->tanggalIndo() }}</span>
                </div>
                <a href="#sorotan" class="inline-flex items-center gap-2 px-2 text-sm font-semibold text-amber-300 transition hover:text-amber-200">
                    Lihat sorotan
                    <svg class="ar-panah h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                </a>
            @endif
        </div>
    </div>
</section>

@if ($utama)
{{-- ============ SOROTAN (kartu putih bersih) ============ --}}
<section id="sorotan" class="mx-auto max-w-6xl scroll-mt-24 px-6 pt-14">
    <div class="ar-rv mb-7 flex items-end justify-between gap-4">
        <div>
            <p class="text-sm font-semibold text-navy-700">Sorotan</p>
            <h2 class="mt-1 font-display text-2xl font-bold text-navy-950 md:text-3xl">Kabar pilihan untuk Anda</h2>
        </div>
        <span class="hidden h-px flex-1 bg-slate-200 md:block"></span>
    </div>

    <div class="grid gap-6 lg:grid-cols-5">
        {{-- Artikel utama --}}
        <div class="ar-rv {{ $spanUtama }}">
            <a href="{{ route('artikel.show', $utama->slug) }}" class="group flex h-full flex-col overflow-hidden rounded-3xl bg-white shadow-md ring-1 ring-slate-200 transition duration-300 hover:-translate-y-1 hover:shadow-xl">
                <div class="relative {{ $tinggiGambar }} overflow-hidden bg-gradient-to-br from-navy-950 via-navy-900 to-navy-700">
                    @if ($utama->urlGambar())
                        <img src="{{ $utama->urlGambar() }}" alt="{{ $utama->judul }}" class="absolute inset-0 h-full w-full object-cover transition duration-[1200ms] group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-navy-950/40 to-transparent"></div>
                    @else
                        <svg viewBox="0 0 400 240" class="absolute inset-0 h-full w-full transition duration-[1200ms] group-hover:scale-105" fill="none" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
                            <circle cx="340" cy="30" r="130" fill="#ffffff" fill-opacity=".05"/>
                            <circle cx="40" cy="230" r="90" fill="#fbbf24" fill-opacity=".1"/>
                            <path d="M70 190 C 130 120, 230 92, 340 86" stroke="#ffffff" stroke-width="10" stroke-linecap="round" stroke-opacity=".9"/>
                            <path d="M70 150 C 130 92, 230 64, 340 58" stroke="#ffffff" stroke-width="10" stroke-linecap="round" stroke-opacity=".4"/>
                            <circle cx="312" cy="192" r="12" fill="#fbbf24"/>
                        </svg>
                    @endif
                    <div class="absolute left-5 top-5 flex flex-wrap gap-2">
                        <span class="rounded-full bg-amber-400 px-3.5 py-1 text-xs font-bold text-navy-950 shadow">Terbaru</span>
                        <span class="rounded-full px-3.5 py-1 text-xs font-bold shadow {{ $warna($utama->kategori) }}">{{ $utama->kategori }}</span>
                    </div>
                </div>

                <div class="flex flex-1 flex-col p-7">
                    <p class="text-xs text-slate-500">{{ $utama->tanggalIndo() }} &middot; {{ $menitBaca($utama) }} menit baca</p>
                    <h3 class="mt-2 font-display text-xl font-bold leading-snug text-navy-950 transition group-hover:text-navy-700 md:text-2xl">{{ $utama->judul }}</h3>
                    <span class="ar-amber mt-3"></span>
                    <p class="mt-3 flex-1 text-sm leading-relaxed text-slate-600">{{ \Illuminate\Support\Str::limit($utama->deskripsi, 140) }}</p>
                    <span class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-navy-700 group-hover:text-navy-950">
                        Baca artikel
                        <svg class="h-4 w-4 transition group-hover:translate-x-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </span>
                </div>
            </a>
        </div>

        {{-- Dua artikel berikutnya (kartu horizontal) --}}
        @if ($kecil->isNotEmpty())
            <div class="flex flex-col gap-6 lg:col-span-2">
                @foreach ($kecil as $k)
                    <div class="ar-rv flex-1" style="--d: {{ $loop->iteration * 140 }}ms">
                        <a href="{{ route('artikel.show', $k->slug) }}" class="group flex h-full gap-5 overflow-hidden rounded-3xl bg-white p-4 shadow-sm ring-1 ring-slate-200 transition duration-300 hover:-translate-y-1 hover:shadow-xl">
                            <div class="relative min-h-[8rem] w-28 shrink-0 self-stretch overflow-hidden rounded-2xl bg-gradient-to-br from-navy-900 to-navy-700 sm:w-36">
                                @if ($k->urlGambar())
                                    <img src="{{ $k->urlGambar() }}" alt="{{ $k->judul }}" class="absolute inset-0 h-full w-full object-cover transition duration-700 group-hover:scale-110">
                                @else
                                    <svg viewBox="0 0 100 100" class="absolute inset-0 h-full w-full transition duration-700 group-hover:scale-110" fill="none" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
                                        <circle cx="90" cy="10" r="40" fill="#ffffff" fill-opacity=".07"/>
                                        <path d="M16 70 C 32 46, 58 36, 88 32" stroke="#ffffff" stroke-width="6" stroke-linecap="round" stroke-opacity=".9"/>
                                        <path d="M16 54 C 32 34, 58 24, 88 20" stroke="#ffffff" stroke-width="6" stroke-linecap="round" stroke-opacity=".4"/>
                                        <circle cx="76" cy="72" r="6" fill="#fbbf24"/>
                                    </svg>
                                @endif
                            </div>

                            <div class="flex min-w-0 flex-1 flex-col justify-center py-1 pr-2">
                                <p class="text-xs font-bold uppercase tracking-wide {{ $warnaTeks($k->kategori) }}">{{ $k->kategori }}</p>
                                <h3 class="mt-2 font-display text-base font-bold leading-snug text-navy-950 transition group-hover:text-navy-700">{{ \Illuminate\Support\Str::limit($k->judul, 75) }}</h3>
                                <span class="ar-amber mt-3"></span>
                                <p class="mt-3 text-xs text-slate-500">{{ $k->tanggalIndo() }} &middot; {{ $menitBaca($k) }} menit baca</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endif

{{-- ============ SEMUA ARTIKEL ============ --}}
@if ($artikels->isEmpty())
    <section class="mx-auto max-w-6xl px-6 py-24">
        <p class="text-center text-slate-500">Belum ada artikel.</p>
    </section>
@elseif ($lainnya->isNotEmpty())
<section>
    <div class="mx-auto max-w-6xl px-6 pb-20 pt-20">
        <div class="ar-rv mb-10 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="text-sm font-semibold text-navy-700">Arsip</p>
                <h2 class="mt-1 font-display text-2xl font-bold text-navy-950 md:text-3xl">Artikel lainnya</h2>
                <p class="mt-1 text-sm text-slate-500">Menampilkan <span id="jumlah">{{ $lainnya->count() }}</span> artikel</p>
            </div>

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                <div class="relative">
                    <svg class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"/></svg>
                    <input id="cari" type="search" placeholder="Cari judul artikel" class="w-full rounded-full border border-slate-200 bg-white py-2.5 pl-11 pr-4 text-sm text-slate-700 shadow-sm transition focus:border-navy-700 focus:outline-none focus:ring-2 focus:ring-navy-700/20 sm:w-64">
                </div>
                <div class="flex flex-wrap gap-2">
                    <button type="button" data-filter="semua" class="ar-filter ar-aktif rounded-full bg-white px-5 py-2 text-sm font-semibold text-slate-700 ring-1 ring-slate-200">Semua</button>
                    @foreach ($kategoriList as $k)
                        <button type="button" data-filter="{{ $k }}" class="ar-filter rounded-full bg-white px-5 py-2 text-sm font-semibold text-slate-700 ring-1 ring-slate-200">{{ $k }}</button>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="grid gap-x-7 gap-y-10 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($lainnya as $a)
                <div class="ar-rv" data-kategori="{{ $a->kategori }}" data-judul="{{ \Illuminate\Support\Str::lower($a->judul) }}" style="--d: {{ ($loop->index % 3) * 120 }}ms">
                    <article class="group flex h-full flex-col">
                        <a href="{{ route('artikel.show', $a->slug) }}" class="relative block aspect-[4/3] overflow-hidden rounded-2xl bg-gradient-to-br from-navy-900 to-navy-700 shadow-md ring-1 ring-slate-200 transition duration-300 group-hover:-translate-y-1.5 group-hover:shadow-xl">
                            @if ($a->urlGambar())
                                <img src="{{ $a->urlGambar() }}" alt="{{ $a->judul }}" class="h-full w-full object-cover transition duration-700 group-hover:scale-110">
                            @else
                                <svg viewBox="0 0 400 300" class="absolute inset-0 h-full w-full transition duration-700 group-hover:scale-110" fill="none" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
                                    <circle cx="350" cy="30" r="120" fill="#ffffff" fill-opacity=".06"/>
                                    <path d="M70 220 C 130 150, 230 120, 340 112" stroke="#ffffff" stroke-width="10" stroke-linecap="round" stroke-opacity=".9"/>
                                    <path d="M70 180 C 130 122, 230 92, 340 84" stroke="#ffffff" stroke-width="10" stroke-linecap="round" stroke-opacity=".4"/>
                                    <circle cx="312" cy="224" r="12" fill="#fbbf24"/>
                                </svg>
                            @endif
                            <span class="absolute left-4 top-4 rounded-full px-3 py-1 text-[11px] font-bold shadow {{ $warna($a->kategori) }}">{{ $a->kategori }}</span>
                        </a>

                        <div class="flex flex-1 flex-col pt-5">
                            <p class="text-xs text-slate-500">{{ $a->tanggalIndo() }} &middot; {{ $menitBaca($a) }} menit baca</p>
                            <h3 class="mt-2 font-display text-lg font-bold leading-snug text-navy-950">
                                <a href="{{ route('artikel.show', $a->slug) }}" class="transition hover:text-navy-700">{{ $a->judul }}</a>
                            </h3>
                            <span class="ar-amber mt-3"></span>
                            <p class="mt-3 flex-1 text-sm leading-relaxed text-slate-600">{{ \Illuminate\Support\Str::limit($a->deskripsi, 110) }}</p>
                            <a href="{{ route('artikel.show', $a->slug) }}" class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-navy-700 hover:text-navy-950">
                                Baca selengkapnya
                                <svg class="h-4 w-4 transition group-hover:translate-x-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>

        <p id="kosong" class="hidden py-14 text-center text-slate-500">Tidak ada artikel yang cocok dengan pilihan Anda.</p>
    </div>
</section>
@endif

{{-- ============ AJAKAN PENUTUP ============ --}}
<section class="bg-white">
    <div class="mx-auto max-w-6xl px-6 pb-20 {{ $lainnya->isEmpty() ? 'pt-20' : '' }}">
        <div class="ar-rv relative overflow-hidden rounded-3xl bg-gradient-to-br from-navy-950 via-navy-900 to-navy-800 px-8 py-12 text-white shadow-2xl shadow-navy-900/20 md:px-14">
            <div class="absolute -right-16 -top-16 h-64 w-64 rounded-full bg-white/5"></div>
            <div class="absolute -bottom-20 right-40 h-48 w-48 rounded-full bg-amber-400/15"></div>
            <div class="relative flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                <div class="max-w-xl">
                    <p class="text-sm font-semibold text-amber-300">Konsultasi gratis</p>
                    <h2 class="mt-2 font-display text-2xl font-bold md:text-3xl">Ada yang ingin Anda tanyakan?</h2>
                    <p class="mt-2 text-blue-100">Tim kami siap membahas kebutuhan koneksi dan infrastruktur bisnis Anda.</p>
                </div>
                <a href="{{ route('kontak') }}" class="shrink-0 rounded-full bg-amber-400 px-8 py-3.5 text-sm font-semibold text-navy-950 transition hover:bg-amber-300">Hubungi kami</a>
            </div>
        </div>
    </div>
</section>

<script>
(function () {
    // 1) Animasi muncul saat di-scroll
    var items = document.querySelectorAll('.ar-rv');
    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                if (e.isIntersecting) { e.target.classList.add('ar-on'); io.unobserve(e.target); }
            });
        }, { threshold: 0.1 });
        items.forEach(function (el) { io.observe(el); });
    } else {
        items.forEach(function (el) { el.classList.add('ar-on'); });
    }

    // 2) Filter kategori + pencarian judul (berjalan di browser, tanpa route baru)
    var tombol = document.querySelectorAll('.ar-filter');
    var kartu  = document.querySelectorAll('[data-kategori]');
    var kosong = document.getElementById('kosong');
    var jumlah = document.getElementById('jumlah');
    var cari   = document.getElementById('cari');
    var pilih  = 'semua';
    var kata   = '';

    function terapkan() {
        var tampil = 0;
        kartu.forEach(function (c) {
            var cocokKategori = (pilih === 'semua') || (c.getAttribute('data-kategori') === pilih);
            var cocokCari = (kata === '') || (c.getAttribute('data-judul').indexOf(kata) !== -1);

            if (cocokKategori && cocokCari) {
                tampil++;
                c.classList.remove('hidden');
                c.classList.add('ar-on');
                c.classList.remove('ar-masuk');
                void c.offsetWidth; // memulai ulang animasi
                c.classList.add('ar-masuk');
            } else {
                c.classList.add('hidden');
            }
        });
        if (jumlah) { jumlah.textContent = tampil; }
        if (kosong) { kosong.classList.toggle('hidden', tampil !== 0); }
    }

    tombol.forEach(function (b) {
        b.addEventListener('click', function () {
            pilih = b.getAttribute('data-filter');
            tombol.forEach(function (x) { x.classList.remove('ar-aktif'); });
            b.classList.add('ar-aktif');
            terapkan();
        });
    });

    if (cari) {
        cari.addEventListener('input', function () {
            kata = cari.value.trim().toLowerCase();
            terapkan();
        });
    }
})();
</script>
@endsection