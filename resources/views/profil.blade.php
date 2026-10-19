@extends('layouts.public')
@section('title', 'Profil Perusahaan')

@section('content')
<style>
    /* Animasi halaman profil (kelas berawalan "pf-" agar tidak bentrok dengan layout) */
    @keyframes pfNaik { from { opacity: 0; transform: translateY(24px); } to { opacity: 1; transform: none; } }
    .pf-in { opacity: 0; animation: pfNaik .9s cubic-bezier(.2, .7, .2, 1) forwards; animation-delay: var(--d, 0ms); }

    @keyframes pfZoom { from { transform: scale(1.12); } to { transform: scale(1); } }
    .pf-zoom { animation: pfZoom 14s ease-out forwards; }

    @keyframes pfMelayang { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
    .pf-float      { animation: pfMelayang 6s ease-in-out infinite; }
    .pf-float-slow { animation: pfMelayang 9s ease-in-out infinite reverse; }

    @keyframes pfGaris { from { width: 0; } to { width: 4rem; } }
    .pf-garis { width: 0; height: 4px; border-radius: 9999px; background: #fbbf24; animation: pfGaris .9s .6s ease forwards; }

    /* Muncul saat di-scroll */
    .pf-js .pf-rv { opacity: 0; transform: translateY(28px); transition: opacity .8s ease, transform .8s ease; transition-delay: var(--d, 0ms); }
    .pf-js .pf-rv.pf-on { opacity: 1; transform: none; }

    @media (prefers-reduced-motion: reduce) {
        .pf-in { opacity: 1; animation: none; }
        .pf-zoom, .pf-float, .pf-float-slow { animation: none; }
        .pf-garis { width: 4rem; animation: none; }
        .pf-js .pf-rv { opacity: 1; transform: none; transition: none; }
    }
</style>
<script>document.documentElement.classList.add('pf-js');</script>

@php
    $profil    = $profil ?? new \App\Models\Profil();
    $layanans  = $layanans ?? collect();

    // Misi disimpan satu baris per poin
    $misi = array_values(array_filter(array_map('trim', explode("\n", (string) $profil->misi))));

    // Foto gedung (opsional): gedung_pt.png, cadangan perusahaan.jpg
    $foto = null;
    foreach (['images/gedung_pt.png', 'images/perusahaan.jpg'] as $berkas) {
        if (file_exists(public_path($berkas))) { $foto = asset($berkas); break; }
    }

    $statistik = config('perusahaan.statistik', []);
    $wilayah   = config('perusahaan.wilayah', 'Jawa Barat dan sekitarnya');

    $fakta = [
        ['Tahun berdiri',   $profil->tahun_berdiri],
        ['Direktur utama',  $profil->direktur],
        ['Legalitas usaha', $profil->legalitas],
        ['Wilayah layanan', $wilayah],
    ];

    $centang = 'M5 13l4 4L19 7';
@endphp

{{-- ============ HERO ============ --}}
<section class="relative isolate overflow-hidden bg-navy-950 text-white">
    @if ($foto)
        <img src="{{ $foto }}" alt="Gedung {{ config('perusahaan.nama') }}" class="pf-zoom absolute inset-0 -z-10 h-full w-full object-cover object-[65%_35%]">
    @endif
    <div class="absolute inset-0 -z-10 bg-gradient-to-r from-navy-950 via-navy-950/85 to-navy-900/50"></div>
    <div class="absolute inset-0 -z-10 opacity-60" style="background-image: radial-gradient(rgba(255,255,255,.09) 1px, transparent 1px); background-size: 28px 28px;"></div>
    <div class="pf-float-slow absolute -right-24 -top-28 -z-10 h-80 w-80 rounded-full bg-amber-400/15 blur-3xl"></div>

    <div class="mx-auto grid max-w-6xl items-center gap-12 px-6 pb-32 pt-16 md:pt-20 lg:grid-cols-5">
        <div class="lg:col-span-3">
            <nav class="pf-in flex items-center gap-2 text-sm text-blue-100" aria-label="Breadcrumb">
                <a href="{{ route('welcome') }}" class="transition hover:text-white">Beranda</a>
                <span class="text-blue-200/60">/</span>
                <span class="font-semibold text-white">Profil</span>
            </nav>

            <h1 class="pf-in mt-5 font-display text-4xl font-bold leading-tight md:text-5xl" style="--d: 120ms">
                {{ config('perusahaan.nama') }}
                <span class="mt-1 block bg-gradient-to-r from-amber-300 to-amber-100 bg-clip-text text-transparent">Mitra infrastruktur TI terpercaya.</span>
            </h1>
            <div class="pf-garis mt-6"></div>

            <p class="pf-in mt-6 max-w-xl text-lg leading-relaxed text-blue-100" style="--d: 300ms">
                Mengenal sejarah, visi, misi, nilai, dan perjalanan kami dalam menghadirkan konektivitas yang andal untuk bisnis.
            </p>

            <div class="pf-in mt-8 flex flex-wrap gap-4" style="--d: 450ms">
                <a href="{{ route('layanan') }}" class="rounded-full bg-amber-400 px-8 py-3.5 text-sm font-semibold text-navy-950 shadow-lg shadow-amber-400/20 transition hover:-translate-y-0.5 hover:bg-amber-300">Lihat layanan</a>
                <a href="{{ route('kontak') }}" class="rounded-full border border-white/40 px-8 py-3.5 text-sm font-semibold backdrop-blur transition hover:bg-white/10">Hubungi kami</a>
            </div>
        </div>

        {{-- Kartu kaca: data dari tabel profil --}}
        <div class="pf-in hidden lg:col-span-2 lg:block" style="--d: 350ms">
            <div class="pf-float rounded-3xl bg-white/10 p-7 shadow-2xl ring-1 ring-white/20 backdrop-blur-md">
                <p class="text-xs font-semibold uppercase tracking-wider text-amber-300">Data perusahaan</p>
                <dl class="mt-5 space-y-4">
                    @foreach (array_slice($fakta, 0, 3) as [$label, $nilai])
                        <div class="flex items-center justify-between gap-4 border-b border-white/10 pb-4 last:border-0 last:pb-0">
                            <dt class="text-sm text-blue-100/80">{{ $label }}</dt>
                            <dd class="text-right font-display text-sm font-semibold">{{ $nilai ?: '-' }}</dd>
                        </div>
                    @endforeach
                </dl>
            </div>
        </div>
    </div>
</section>

{{-- ============ ANGKA KINERJA ============ --}}
@if (count($statistik))
<div class="relative z-10 mx-auto -mt-16 max-w-6xl px-6">
    <dl class="pf-rv grid grid-cols-2 overflow-hidden rounded-2xl bg-white shadow-2xl shadow-navy-900/15 ring-1 ring-slate-200/70 md:grid-cols-4">
        @foreach ($statistik as $i => [$angka, $label])
            <div class="px-8 py-8 {{ $i > 0 ? 'md:border-l md:border-slate-200' : '' }} {{ $i > 1 ? 'border-t border-slate-200 md:border-t-0' : '' }}">
                <dt class="font-display text-3xl font-semibold text-navy-800">{{ $angka }}</dt>
                <dd class="mt-1.5 text-sm text-slate-500">{{ $label }}</dd>
            </div>
        @endforeach
    </dl>
</div>
@endif

{{-- ============ TENTANG PERUSAHAAN ============ --}}
<section class="mx-auto grid max-w-6xl items-center gap-16 px-6 py-28 lg:grid-cols-2">
    <div class="pf-rv relative mx-auto w-full max-w-md lg:mx-0">
        <div class="absolute -left-5 -top-5 h-full w-full rounded-t-[10rem] rounded-b-3xl border-2 border-amber-400"></div>
        <div class="relative aspect-[4/5] overflow-hidden rounded-t-[10rem] rounded-b-3xl bg-gradient-to-br from-navy-900 to-navy-700 shadow-2xl">
            @if ($foto)
                <img src="{{ $foto }}" alt="Kantor {{ config('perusahaan.nama') }}" class="h-full w-full object-cover object-[60%_40%]">
            @else
                <div class="flex h-full items-center justify-center font-display text-7xl font-bold text-white/20">{{ config('perusahaan.singkat') }}</div>
            @endif
        </div>
        @if ($profil->tahun_berdiri)
            <div class="pf-float absolute -bottom-6 right-4 rounded-2xl bg-white px-6 py-4 shadow-xl ring-1 ring-slate-200">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Sejak</p>
                <p class="font-display text-3xl font-bold text-navy-900">{{ $profil->tahun_berdiri }}</p>
            </div>
        @endif
    </div>

    <div class="pf-rv" style="--d: 120ms">
        <div class="flex items-center gap-3">
            <span class="h-px w-8 bg-amber-400"></span>
            <p class="text-sm font-semibold tracking-wide text-navy-700">Tentang perusahaan</p>
        </div>
        <h2 class="mt-3 font-display text-3xl font-bold leading-tight text-navy-950 md:text-4xl">Mitra teknologi yang tumbuh bersama pelanggannya.</h2>
        <p class="mt-6 whitespace-pre-line leading-relaxed text-slate-600">{{ $profil->sejarah ?: '-' }}</p>

        <dl class="mt-8 grid gap-x-8 gap-y-5 border-t border-slate-200 pt-6 sm:grid-cols-2">
            @foreach ($fakta as [$label, $nilai])
                <div>
                    <dt class="text-sm text-slate-500">{{ $label }}</dt>
                    <dd class="mt-1 font-display font-bold text-navy-950">{{ $nilai ?: '-' }}</dd>
                </div>
            @endforeach
        </dl>
    </div>
</section>

{{-- ============ VISI & MISI ============ --}}
<section class="bg-slate-50">
    <div class="mx-auto max-w-6xl px-6 py-28">
        <div class="pf-rv mx-auto mb-14 max-w-2xl text-center">
            <div class="flex items-center justify-center gap-3">
                <span class="h-px w-8 bg-amber-400"></span>
                <p class="text-sm font-semibold tracking-wide text-navy-700">Visi &amp; misi</p>
                <span class="h-px w-8 bg-amber-400"></span>
            </div>
            <h2 class="mt-3 font-display text-3xl font-bold text-navy-950 md:text-4xl">Arah dan komitmen kami</h2>
        </div>

        <div class="grid gap-8 lg:grid-cols-5">
            <div class="pf-rv relative overflow-hidden rounded-3xl bg-gradient-to-br from-navy-950 via-navy-900 to-navy-700 p-9 text-white shadow-xl lg:col-span-2">
                <div class="pf-float-slow absolute -right-12 -top-12 h-44 w-44 rounded-full bg-white/10"></div>
                <div class="absolute -bottom-10 -left-10 h-32 w-32 rounded-full bg-amber-400/20"></div>
                <p class="relative text-sm font-semibold uppercase tracking-wider text-amber-300">Visi</p>
                <p class="relative mt-4 font-display text-2xl font-semibold leading-snug">{{ $profil->visi ?: '-' }}</p>
            </div>

            <div class="lg:col-span-3">
                <p class="mb-4 text-sm font-semibold uppercase tracking-wider text-navy-700">Misi</p>
                <ol class="space-y-4">
                    @forelse ($misi as $i => $poin)
                        <li class="pf-rv group flex gap-4 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200 transition duration-300 hover:-translate-y-1 hover:shadow-lg hover:ring-amber-400/60" style="--d: {{ $i * 100 }}ms">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-amber-400 font-display font-bold text-navy-950">{{ $i + 1 }}</span>
                            <p class="leading-relaxed text-slate-700">{{ $poin }}</p>
                        </li>
                    @empty
                        <li class="rounded-2xl bg-white p-5 text-slate-500 ring-1 ring-slate-200">Misi belum diisi. Isi lewat menu Profil di halaman admin.</li>
                    @endforelse
                </ol>
            </div>
        </div>
    </div>
</section>

{{-- ============ NILAI PERUSAHAAN ============ --}}
<section class="mx-auto max-w-6xl px-6 py-28">
    <div class="pf-rv mx-auto mb-14 max-w-2xl text-center">
        <div class="flex items-center justify-center gap-3">
            <span class="h-px w-8 bg-amber-400"></span>
            <p class="text-sm font-semibold tracking-wide text-navy-700">Nilai perusahaan</p>
            <span class="h-px w-8 bg-amber-400"></span>
        </div>
        <h2 class="mt-3 font-display text-3xl font-bold text-navy-950 md:text-4xl">Prinsip yang kami pegang</h2>
    </div>
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        @foreach (config('perusahaan.nilai', []) as $i => [$judul, $isi, $ikon])
            <div class="pf-rv group rounded-2xl bg-white p-7 shadow-md ring-1 ring-slate-200 transition duration-300 hover:-translate-y-1.5 hover:shadow-xl" style="--d: {{ $i * 110 }}ms">
                <span class="flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-navy-700 to-navy-900 text-white shadow-lg shadow-navy-700/30 transition group-hover:scale-110">
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $ikon }}"/></svg>
                </span>
                <p class="mt-5 font-display text-lg font-bold text-navy-950">{{ $judul }}</p>
                <span class="mt-3 block h-0.5 w-8 rounded-full bg-amber-400 transition-all duration-300 group-hover:w-14"></span>
                <p class="mt-3 text-sm leading-relaxed text-slate-600">{{ $isi }}</p>
            </div>
        @endforeach
    </div>
</section>

{{-- ============ KEUNGGULAN (gelap) ============ --}}
<section class="relative overflow-hidden bg-navy-950 text-white">
    <div class="absolute inset-0 opacity-50" style="background-image: radial-gradient(rgba(255,255,255,.08) 1px, transparent 1px); background-size: 24px 24px;"></div>
    <div class="absolute -right-24 top-0 h-80 w-80 rounded-full bg-navy-700/40 blur-3xl"></div>
    <svg class="pf-float-slow pointer-events-none absolute -right-10 bottom-6 hidden h-80 w-80 opacity-20 lg:block" viewBox="0 0 400 400" fill="none" aria-hidden="true">
        <path d="M60 290 C 120 190, 220 140, 350 130" stroke="#ffffff" stroke-width="14" stroke-linecap="round"/>
        <path d="M60 230 C 120 150, 220 105, 350 95" stroke="#ffffff" stroke-opacity=".5" stroke-width="14" stroke-linecap="round"/>
        <circle cx="320" cy="292" r="18" fill="#fbbf24"/>
    </svg>

    <div class="relative mx-auto max-w-6xl px-6 py-28">
        <div class="pf-rv max-w-2xl">
            <div class="flex items-center gap-3">
                <span class="h-px w-8 bg-amber-400"></span>
                <p class="text-sm font-semibold tracking-wide text-amber-300">Keunggulan kami</p>
            </div>
            <h2 class="mt-3 font-display text-3xl font-bold leading-tight md:text-4xl">Alasan pelanggan mempercayakan jaringannya kepada kami</h2>
        </div>
        <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach (config('perusahaan.keunggulan', []) as $i => [$judul, $isi])
                <div class="pf-rv group rounded-2xl bg-white/5 p-7 ring-1 ring-white/10 backdrop-blur transition duration-300 hover:-translate-y-1.5 hover:bg-white/10 hover:ring-amber-400/40" style="--d: {{ $i * 110 }}ms">
                    <p class="font-display text-4xl font-semibold text-amber-400">0{{ $i + 1 }}</p>
                    <span class="mt-4 block h-0.5 w-8 rounded-full bg-amber-400 transition-all duration-300 group-hover:w-16"></span>
                    <p class="mt-5 font-display text-lg font-semibold">{{ $judul }}</p>
                    <p class="mt-2 text-sm leading-relaxed text-blue-100/80">{{ $isi }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============ BIDANG USAHA (dari database layanan) ============ --}}
@if ($layanans->isNotEmpty())
<section class="bg-slate-50">
    <div class="mx-auto grid max-w-6xl gap-12 px-6 py-28 lg:grid-cols-5">
        <div class="pf-rv lg:col-span-2">
            <div class="flex items-center gap-3">
                <span class="h-px w-8 bg-amber-400"></span>
                <p class="text-sm font-semibold tracking-wide text-navy-700">Bidang usaha</p>
            </div>
            <h2 class="mt-3 font-display text-3xl font-bold leading-tight text-navy-950 md:text-4xl">Layanan yang menopang bisnis Anda.</h2>
            <p class="mt-4 leading-relaxed text-slate-600">Dari koneksi internet hingga keamanan jaringan, kami menyediakan layanan terpadu agar Anda fokus pada pertumbuhan usaha.</p>
            <a href="{{ route('layanan') }}" class="mt-8 inline-block rounded-full bg-navy-900 px-7 py-3 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:bg-navy-800">Lihat semua layanan</a>
        </div>
        <div class="grid gap-4 sm:grid-cols-2 lg:col-span-3">
            @foreach ($layanans as $i => $layanan)
                @php
                    $barisPertama = trim(explode("\n", (string) $layanan->deskripsi)[0] ?? '');
                    $tujuan = \Illuminate\Support\Facades\Route::has('layanan.show') ? route('layanan.show', $layanan) : route('layanan');
                @endphp
                <a href="{{ $tujuan }}" class="pf-rv group rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200 transition duration-300 hover:-translate-y-1 hover:shadow-lg hover:ring-navy-700/30" style="--d: {{ ($i % 2) * 100 }}ms">
                    <span class="font-display text-sm font-bold text-amber-500">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    <p class="mt-2 font-display text-base font-bold text-navy-950 transition group-hover:text-navy-700">{{ $layanan->nama }}</p>
                    <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ \Illuminate\Support\Str::limit($barisPertama, 90) }}</p>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ============ PERJALANAN PERUSAHAAN ============ --}}
<section class="mx-auto max-w-6xl px-6 py-28">
    <div class="pf-rv mx-auto mb-16 max-w-2xl text-center">
        <div class="flex items-center justify-center gap-3">
            <span class="h-px w-8 bg-amber-400"></span>
            <p class="text-sm font-semibold tracking-wide text-navy-700">Perjalanan perusahaan</p>
            <span class="h-px w-8 bg-amber-400"></span>
        </div>
        <h2 class="mt-3 font-display text-3xl font-bold text-navy-950 md:text-4xl">Tonggak penting kami</h2>
    </div>

    <ol class="relative mx-auto max-w-4xl">
        <span class="absolute left-4 top-0 h-full w-px bg-gradient-to-b from-amber-400 via-slate-200 to-transparent md:left-1/2"></span>
        @foreach (config('perusahaan.tonggak', []) as $i => [$tahun, $judul, $isi])
            <li class="pf-rv relative pb-12 pl-12 last:pb-0 md:grid md:grid-cols-2 md:gap-16 md:pl-0">
                <span class="absolute left-4 top-1.5 h-4 w-4 -translate-x-1/2 rounded-full bg-amber-400 ring-4 ring-white md:left-1/2"></span>
                <div class="{{ $i % 2 === 0 ? 'md:text-right' : 'md:col-start-2' }}">
                    <p class="font-display text-2xl font-bold text-navy-700">{{ $tahun }}</p>
                    <p class="mt-1 text-lg font-semibold text-navy-950">{{ $judul }}</p>
                    <p class="mt-1 text-sm leading-relaxed text-slate-600">{{ $isi }}</p>
                </div>
            </li>
        @endforeach
    </ol>
</section>

{{-- ============ LEGALITAS & SERTIFIKASI ============ --}}
<section class="bg-slate-50">
    <div class="mx-auto grid max-w-6xl gap-10 px-6 py-28 lg:grid-cols-2 lg:items-center">
        <div class="pf-rv">
            <div class="flex items-center gap-3">
                <span class="h-px w-8 bg-amber-400"></span>
                <p class="text-sm font-semibold tracking-wide text-navy-700">Legalitas &amp; sertifikasi</p>
            </div>
            <h2 class="mt-3 font-display text-3xl font-bold leading-tight text-navy-950 md:text-4xl">Beroperasi resmi dan sesuai standar.</h2>
            <p class="mt-4 leading-relaxed text-slate-600">Kami menjalankan layanan sesuai ketentuan perizinan dan standar mutu agar pelanggan memperoleh layanan yang dapat dipercaya.</p>
            <p class="mt-6 inline-block rounded-xl bg-white px-5 py-3 text-sm shadow-sm ring-1 ring-slate-200">
                <span class="text-slate-500">Nomor legalitas:</span>
                <span class="font-semibold text-navy-800">{{ $profil->legalitas ?: '-' }}</span>
            </p>
        </div>
        <ul class="grid gap-4 sm:grid-cols-2">
            @foreach (config('perusahaan.sertifikasi', []) as $i => $s)
                <li class="pf-rv flex items-start gap-3 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200 transition duration-300 hover:-translate-y-1 hover:shadow-lg" style="--d: {{ ($i % 2) * 100 }}ms">
                    <span class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-navy-700 text-white">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="3.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $centang }}"/></svg>
                    </span>
                    <span class="text-sm font-medium leading-snug text-slate-700">{{ $s }}</span>
                </li>
            @endforeach
        </ul>
    </div>
</section>

{{-- ============ AJAKAN PENUTUP ============ --}}
<section class="px-6 py-24">
    <div class="pf-rv relative mx-auto max-w-6xl overflow-hidden rounded-3xl bg-gradient-to-br from-navy-950 via-navy-900 to-navy-800 px-8 py-14 text-white shadow-2xl shadow-navy-900/20 md:px-14">
        <div class="pf-float-slow absolute -right-16 -top-16 h-64 w-64 rounded-full bg-white/5"></div>
        <div class="pf-float absolute -bottom-20 right-40 h-48 w-48 rounded-full bg-amber-400/15"></div>
        <div class="relative flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
            <div class="max-w-xl">
                <p class="text-sm font-semibold text-amber-300">Mari berkolaborasi</p>
                <h2 class="mt-2 font-display text-2xl font-bold md:text-3xl">Tertarik bekerja sama dengan kami?</h2>
                <p class="mt-2 text-blue-100">Ceritakan kebutuhan Anda, tim kami akan menghubungi secepatnya.</p>
            </div>
            <a href="{{ route('kontak') }}" class="shrink-0 rounded-full bg-amber-400 px-8 py-3.5 text-sm font-semibold text-navy-950 transition hover:-translate-y-0.5 hover:bg-amber-300">Hubungi kami</a>
        </div>
    </div>
</section>

<script>
(function () {
    // Animasi muncul saat di-scroll
    var items = document.querySelectorAll('.pf-rv');
    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                if (e.isIntersecting) { e.target.classList.add('pf-on'); io.unobserve(e.target); }
            });
        }, { threshold: 0.1 });
        items.forEach(function (el) { io.observe(el); });
    } else {
        items.forEach(function (el) { el.classList.add('pf-on'); });
    }
})();
</script>
@endsection