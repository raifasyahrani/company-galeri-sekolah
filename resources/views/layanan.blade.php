@extends('layouts.public')
@section('title', 'Produk & Layanan')

@section('content')
<style>
    /* Animasi halaman layanan (kelas berawalan "ly-" agar tidak bentrok dengan layout) */
    @keyframes lyNaik { from { opacity: 0; transform: translateY(22px); } to { opacity: 1; transform: none; } }
    .ly-in { opacity: 0; animation: lyNaik .9s cubic-bezier(.2, .7, .2, 1) forwards; animation-delay: var(--d, 0ms); }

    @keyframes lyZoom { from { transform: scale(1.12); } to { transform: scale(1); } }
    .ly-zoom { animation: lyZoom 14s ease-out forwards; }

    @keyframes lyMelayang { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
    .ly-float      { animation: lyMelayang 6s ease-in-out infinite; }
    .ly-float-slow { animation: lyMelayang 9s ease-in-out infinite reverse; }

    @keyframes lyGaris { from { width: 0; } to { width: 4rem; } }
    .ly-garis { width: 0; height: 4px; border-radius: 9999px; background: #fbbf24; animation: lyGaris .9s .6s ease forwards; }

    /* Muncul saat di-scroll */
    .ly-js .ly-rv { opacity: 0; transform: translateY(28px); transition: opacity .8s ease, transform .8s ease; transition-delay: var(--d, 0ms); }
    .ly-js .ly-rv.ly-on { opacity: 1; transform: none; }

    @media (prefers-reduced-motion: reduce) {
        .ly-in { opacity: 1; animation: none; }
        .ly-zoom, .ly-float, .ly-float-slow { animation: none; }
        .ly-garis { width: 4rem; animation: none; }
        .ly-js .ly-rv { opacity: 1; transform: none; transition: none; }
    }
</style>
<script>document.documentElement.classList.add('ly-js');</script>

@php
    // Data dikirim oleh LayananPageController: $produks dan $jasas
    $total = $produks->count() + $jasas->count();

    // Foto gedung (opsional): gedung_pt.png, cadangan perusahaan.jpg
    $foto = null;
    foreach (['images/gedung_pt.png', 'images/perusahaan.jpg'] as $berkas) {
        if (file_exists(public_path($berkas))) { $foto = asset($berkas); break; }
    }

    $telepon = (string) config('perusahaan.telepon');
    $tel     = preg_replace('/[^0-9+]/', '', $telepon);

    $keunggulan = [
        ['Bandwidth dedicated', 'Koneksi tanpa pembagian bandwidth menjaga kecepatan unggah dan unduh tetap stabil.'],
        ['Jalur cadangan', 'Jalur koneksi cadangan siap aktif saat jalur utama mengalami gangguan.'],
        ['Pemantauan 24 jam', 'Jaringan dipantau terus-menerus agar gangguan terdeteksi lebih awal.'],
        ['Keamanan terenkripsi', 'Firewall dan jaringan privat terenkripsi menjaga kerahasiaan data bisnis Anda.'],
    ];

    $langkah = [
        ['Konsultasi kebutuhan', 'Diskusi lokasi, skala bisnis, dan kapasitas yang dibutuhkan.'],
        ['Survei & desain', 'Tim teknis meninjau lokasi dan menyiapkan rancangan jaringan.'],
        ['Instalasi & uji', 'Pemasangan perangkat dan pengujian performa hingga siap dipakai.'],
        ['Pendampingan', 'Layanan aktif dengan pemantauan dan dukungan teknis berkelanjutan.'],
    ];
@endphp

{{-- ============ HERO (ringkas) ============ --}}
<section class="relative isolate overflow-hidden bg-navy-950 text-white">
    @if ($foto)
        <img src="{{ $foto }}" alt="Gedung {{ config('perusahaan.nama') }}" class="ly-zoom absolute inset-0 -z-10 h-full w-full object-cover object-[65%_35%]">
    @endif
    <div class="absolute inset-0 -z-10 bg-gradient-to-r from-navy-950 via-navy-950/90 to-navy-900/60"></div>
    <div class="absolute inset-0 -z-10 opacity-60" style="background-image: radial-gradient(rgba(255,255,255,.09) 1px, transparent 1px); background-size: 28px 28px;"></div>
    <div class="ly-float-slow absolute -right-20 -top-24 -z-10 h-64 w-64 rounded-full bg-amber-400/15 blur-3xl"></div>

    <div class="mx-auto max-w-6xl px-6 py-10 md:py-14">
        <nav class="ly-in flex items-center gap-2 text-sm text-blue-100" aria-label="Breadcrumb">
            <a href="{{ route('welcome') }}" class="transition hover:text-white">Beranda</a>
            <span class="text-blue-200/60">/</span>
            <span class="font-semibold text-white">Produk &amp; Layanan</span>
        </nav>

        <h1 class="ly-in mt-4 font-display text-3xl font-bold leading-tight md:text-4xl" style="--d: 120ms">
            Produk &amp; Layanan <span class="text-amber-300">Konektivitas Unggulan</span>
        </h1>
        <div class="ly-garis mt-4"></div>

        <p class="ly-in mt-4 max-w-2xl text-base leading-relaxed text-blue-100" style="--d: 300ms">
            Internet dedicated, jaringan antar kantor, manajemen Wi-Fi, cloud, dan keamanan jaringan yang dirancang untuk mendukung stabilitas bisnis Anda.
        </p>

        <div class="ly-in mt-6 flex flex-wrap items-center gap-3" style="--d: 460ms">
            <div class="rounded-xl bg-white/10 px-4 py-2 ring-1 ring-white/15">
                <span class="font-display text-lg font-bold">{{ $produks->count() }}</span>
                <span class="ml-1 text-xs text-blue-100">Produk</span>
            </div>
            <div class="rounded-xl bg-white/10 px-4 py-2 ring-1 ring-white/15">
                <span class="font-display text-lg font-bold">{{ $jasas->count() }}</span>
                <span class="ml-1 text-xs text-blue-100">Layanan</span>
            </div>
            <div class="rounded-xl bg-white/10 px-4 py-2 text-xs text-blue-100 ring-1 ring-white/15">SLA tertulis</div>
            <a href="#katalog" class="inline-flex items-center gap-2 px-2 text-sm font-semibold text-amber-300 transition hover:text-amber-200">
                Lihat katalog
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
            </a>
        </div>
    </div>
</section>

{{-- ============ KATALOG (dinamis dari database) ============ --}}
<div id="katalog" class="scroll-mt-24"></div>

@if ($total === 0)
    <section class="bg-slate-50">
        <div class="mx-auto max-w-6xl px-6 py-24">
            <p class="text-center text-slate-500">Belum ada produk atau layanan. Tambahkan lewat menu Layanan di halaman admin.</p>
        </div>
    </section>
@endif

{{-- PRODUK --}}
@if ($produks->isNotEmpty())
<section id="produk" class="scroll-mt-24 bg-slate-50">
    <div class="mx-auto max-w-6xl px-6 py-20">
        <div class="ly-rv mb-12 max-w-2xl">
            <div class="flex items-center gap-3">
                <span class="h-px w-8 bg-amber-400"></span>
                <p class="text-sm font-semibold tracking-wide text-navy-700">Produk</p>
            </div>
            <h2 class="mt-3 font-display text-2xl font-bold leading-tight text-navy-950 md:text-3xl">Produk konektivitas untuk bisnis Anda</h2>
            <p class="mt-3 text-slate-600">Solusi koneksi dan infrastruktur yang siap dirancang sesuai skala usaha.</p>
        </div>

        <div class="grid gap-7 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($produks as $l)
                <div class="ly-rv [&>article]:h-full" style="--d: {{ ($loop->index % 3) * 110 }}ms">
                    @include('partials.kartu-layanan', ['l' => $l])
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- LAYANAN --}}
@if ($jasas->isNotEmpty())
<section id="layanan-terkelola" class="scroll-mt-24 {{ $produks->isNotEmpty() ? 'bg-white' : 'bg-slate-50' }}">
    <div class="mx-auto max-w-6xl px-6 py-20">
        <div class="ly-rv mb-12 max-w-2xl">
            <div class="flex items-center gap-3">
                <span class="h-px w-8 bg-amber-400"></span>
                <p class="text-sm font-semibold tracking-wide text-navy-700">Layanan</p>
            </div>
            <h2 class="mt-3 font-display text-2xl font-bold leading-tight text-navy-950 md:text-3xl">Layanan pendukung agar jaringan tetap andal</h2>
            <p class="mt-3 text-slate-600">Pengelolaan, pengamanan, dan pendampingan teknis dari tim kami.</p>
        </div>

        <div class="grid gap-7 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($jasas as $l)
                <div class="ly-rv [&>article]:h-full" style="--d: {{ ($loop->index % 3) * 110 }}ms">
                    @include('partials.kartu-layanan', ['l' => $l])
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ============ STANDAR KUALITAS (gelap) ============ --}}
<section class="relative overflow-hidden bg-navy-950 text-white">
    <div class="absolute inset-0 opacity-50" style="background-image: radial-gradient(rgba(255,255,255,.08) 1px, transparent 1px); background-size: 24px 24px;"></div>
    <div class="absolute -right-24 top-0 h-80 w-80 rounded-full bg-navy-700/40 blur-3xl"></div>
    <svg class="ly-float-slow pointer-events-none absolute -right-10 bottom-6 hidden h-80 w-80 opacity-20 lg:block" viewBox="0 0 400 400" fill="none" aria-hidden="true">
        <path d="M60 290 C 120 190, 220 140, 350 130" stroke="#ffffff" stroke-width="14" stroke-linecap="round"/>
        <path d="M60 230 C 120 150, 220 105, 350 95" stroke="#ffffff" stroke-opacity=".5" stroke-width="14" stroke-linecap="round"/>
        <circle cx="320" cy="292" r="18" fill="#fbbf24"/>
    </svg>

    <div class="relative mx-auto max-w-6xl px-6 py-24">
        <div class="ly-rv max-w-2xl">
            <div class="flex items-center gap-3">
                <span class="h-px w-8 bg-amber-400"></span>
                <p class="text-sm font-semibold tracking-wide text-amber-300">Keunggulan layanan</p>
            </div>
            <h2 class="mt-3 font-display text-3xl font-bold leading-tight md:text-4xl">Standar kualitas jaringan untuk kebutuhan bisnis</h2>
        </div>
        <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($keunggulan as $i => [$judul, $isi])
                <div class="ly-rv group rounded-2xl bg-white/5 p-7 ring-1 ring-white/10 backdrop-blur transition duration-300 hover:-translate-y-1.5 hover:bg-white/10 hover:ring-amber-400/40" style="--d: {{ $i * 110 }}ms">
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
<section class="mx-auto max-w-6xl px-6 py-24">
    <div class="ly-rv mx-auto mb-14 max-w-2xl text-center">
        <div class="flex items-center justify-center gap-3">
            <span class="h-px w-8 bg-amber-400"></span>
            <p class="text-sm font-semibold tracking-wide text-navy-700">Cara kerja</p>
            <span class="h-px w-8 bg-amber-400"></span>
        </div>
        <h2 class="mt-3 font-display text-3xl font-bold text-navy-950 md:text-4xl">Dari konsultasi hingga layanan berjalan</h2>
    </div>
    <ol class="grid gap-6 md:grid-cols-4">
        @foreach ($langkah as $i => [$judul, $isi])
            <li class="ly-rv group relative rounded-2xl bg-white p-7 shadow-sm ring-1 ring-slate-200 transition duration-300 hover:-translate-y-1.5 hover:shadow-xl" style="--d: {{ $i * 110 }}ms">
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

{{-- ============ AJAKAN PENUTUP ============ --}}
<section class="px-6 pb-24">
    <div class="ly-rv relative mx-auto max-w-6xl overflow-hidden rounded-3xl bg-gradient-to-br from-navy-950 via-navy-900 to-navy-800 px-8 py-14 text-white shadow-2xl shadow-navy-900/20 md:px-14">
        <div class="ly-float-slow absolute -right-16 -top-16 h-64 w-64 rounded-full bg-white/5"></div>
        <div class="ly-float absolute -bottom-20 right-40 h-48 w-48 rounded-full bg-amber-400/15"></div>
        <div class="relative flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between">
            <div class="max-w-xl">
                <p class="text-sm font-semibold text-amber-300">Konsultasi tanpa biaya</p>
                <h2 class="mt-2 font-display text-2xl font-bold md:text-3xl">Belum menemukan yang Anda cari?</h2>
                <p class="mt-2 text-blue-100">Sampaikan kebutuhan lokasi dan jaringan perusahaan Anda, kami rancang solusi yang sesuai.</p>
            </div>
            <div class="flex shrink-0 flex-col gap-3 sm:flex-row sm:items-center">
                <a href="{{ route('kontak') }}" class="inline-flex items-center justify-center rounded-full bg-amber-400 px-8 py-3.5 text-sm font-semibold text-navy-950 transition hover:-translate-y-0.5 hover:bg-amber-300">Hubungi kami</a>
                @if ($tel)
                    <a href="tel:{{ $tel }}" class="inline-flex items-center justify-center rounded-full border border-white/30 px-7 py-3.5 text-sm font-semibold transition hover:bg-white/10">{{ $telepon }}</a>
                @endif
            </div>
        </div>
    </div>
</section>

<script>
(function () {
    // Animasi muncul saat di-scroll
    var items = document.querySelectorAll('.ly-rv');
    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                if (e.isIntersecting) { e.target.classList.add('ly-on'); io.unobserve(e.target); }
            });
        }, { threshold: 0.1 });
        items.forEach(function (el) { io.observe(el); });
    } else {
        items.forEach(function (el) { el.classList.add('ly-on'); });
    }
})();
</script>
@endsection