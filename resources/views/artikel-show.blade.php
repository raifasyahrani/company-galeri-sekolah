@extends('layouts.public')
@section('title', $artikel->judul)

@section('content')
<style>
    /* Kelas halaman detail artikel berawalan "ar-" agar tidak bentrok dengan animasi bawaan layout */
    .ar-js .ar-rv { opacity: 0; transform: translateY(24px); transition: opacity .7s ease, transform .7s ease; transition-delay: var(--d, 0ms); }
    .ar-js .ar-rv.ar-on { opacity: 1; transform: none; }
    @media (prefers-reduced-motion: reduce) {
        .ar-js .ar-rv { opacity: 1; transform: none; transition: none; }
    }
</style>
<script>document.documentElement.classList.add('ar-js');</script>

@php
    $teks      = (string) ($artikel->isi ?: $artikel->deskripsi);
    $paragraf  = preg_split('/\R{2,}/', trim($teks), -1, PREG_SPLIT_NO_EMPTY);
    $kata      = preg_split('/\s+/u', trim(strip_tags($teks)), -1, PREG_SPLIT_NO_EMPTY);
    $menit     = max(1, (int) ceil(count($kata) / 200));
    $adaGambar = (bool) $artikel->urlGambar();
    $linkWa    = 'https://wa.me/?text=' . urlencode($artikel->judul . ' ' . url()->current());

    // Foto gedung (opsional) untuk latar header
    $foto = null;
    foreach (['images/gedung_pt.png', 'images/perusahaan.jpg'] as $berkas) {
        if (file_exists(public_path($berkas))) { $foto = asset($berkas); break; }
    }
@endphp

{{-- Progress bar baca --}}
<div id="progressBaca" class="fixed left-0 top-0 z-[60] h-1 w-0 bg-amber-400"></div>

{{-- ============ HEADER ARTIKEL ============ --}}
<header class="relative isolate overflow-hidden bg-navy-950 text-white">
    @if ($foto)
        <img src="{{ $foto }}" alt="" class="absolute inset-0 -z-10 h-full w-full object-cover object-[65%_35%] opacity-40" aria-hidden="true">
    @endif
    <div class="absolute inset-0 -z-10 bg-gradient-to-br from-navy-950 via-navy-900/95 to-navy-800/90"></div>
    <div class="absolute -right-20 -top-24 -z-10 h-80 w-80 rounded-full bg-white/5"></div>
    <div class="absolute -bottom-24 left-10 -z-10 h-56 w-56 rounded-full bg-amber-400/10"></div>

    <div class="relative mx-auto max-w-3xl px-6 pt-14 {{ $adaGambar ? 'pb-28' : 'pb-14' }}">
        <a href="{{ route('artikel') }}" class="ar-rv inline-flex items-center gap-2 text-sm font-medium text-blue-100 transition hover:text-white">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
            Kembali ke artikel
        </a>
        <span class="ar-rv mt-6 inline-block rounded-full bg-amber-400 px-4 py-1.5 text-xs font-bold text-navy-950" style="--d: 80ms">{{ $artikel->kategori }}</span>
        <h1 class="ar-rv mt-4 font-display text-3xl font-bold leading-tight md:text-4xl" style="--d: 160ms">{{ $artikel->judul }}</h1>
        <p class="ar-rv mt-5 text-sm text-blue-100" style="--d: 240ms">{{ $artikel->tanggalIndo() }} &middot; {{ $menit }} menit baca</p>
    </div>
</header>

{{-- ============ ISI ARTIKEL ============ --}}
<article class="mx-auto max-w-3xl px-6 {{ $adaGambar ? '-mt-20' : 'mt-12' }}">
    @if ($adaGambar)
        <img src="{{ $artikel->urlGambar() }}" alt="{{ $artikel->judul }}" class="ar-rv mb-10 w-full rounded-3xl object-cover shadow-2xl ring-1 ring-slate-200" style="max-height: 28rem;">
    @endif

    <div class="space-y-5 text-[17px] leading-8 text-slate-700">
        @foreach ($paragraf as $p)
            <p class="ar-rv">{!! nl2br(e($p)) !!}</p>
        @endforeach
    </div>

    {{-- Bagikan --}}
    <div class="ar-rv mt-12 flex flex-wrap items-center gap-3 border-t border-slate-200 pt-6">
        <span class="text-sm font-semibold text-navy-950">Bagikan:</span>
        <a href="{{ $linkWa }}" target="_blank" rel="noopener" class="rounded-full bg-emerald-500 px-5 py-2 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:bg-emerald-600">WhatsApp</a>
        <button type="button" id="salinLink" class="rounded-full bg-slate-100 px-5 py-2 text-sm font-semibold text-slate-700 transition hover:-translate-y-0.5 hover:bg-slate-200">Salin tautan</button>
    </div>
</article>

{{-- ============ ARTIKEL TERKAIT ============ --}}
@if ($terkait->isNotEmpty())
<section class="mt-20 bg-slate-50">
    <div class="mx-auto max-w-6xl px-6 py-16">
        <div class="ar-rv mb-10">
            <p class="text-sm font-semibold text-navy-700">Baca juga</p>
            <h2 class="mt-1 font-display text-2xl font-bold text-navy-950 md:text-3xl">Artikel terkait</h2>
        </div>
        <div class="grid gap-7 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($terkait as $t)
                <a href="{{ route('artikel.show', $t->slug) }}" class="ar-rv group flex flex-col overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 transition duration-300 hover:-translate-y-1.5 hover:shadow-xl" style="--d: {{ $loop->index * 120 }}ms">
                    <div class="relative aspect-[16/10] overflow-hidden bg-gradient-to-br from-navy-900 to-navy-700">
                        @if ($t->urlGambar())
                            <img src="{{ $t->urlGambar() }}" alt="{{ $t->judul }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-110">
                        @else
                            <div class="flex h-full items-center justify-center font-display text-6xl font-bold text-white/80">{{ mb_substr($t->judul, 0, 1) }}</div>
                        @endif
                    </div>
                    <div class="p-6">
                        <p class="text-xs text-slate-500"><span class="font-semibold text-navy-700">{{ $t->kategori }}</span> &middot; {{ $t->tanggalIndo() }}</p>
                        <h3 class="mt-2 font-display text-base font-bold leading-snug text-navy-950">{{ $t->judul }}</h3>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<script>
(function () {
    // Animasi muncul saat di-scroll
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

    // Progress bar baca
    var bar = document.getElementById('progressBaca');
    function hitung() {
        var tinggi = document.documentElement.scrollHeight - window.innerHeight;
        var persen = tinggi > 0 ? (window.scrollY / tinggi) * 100 : 0;
        bar.style.width = Math.min(100, persen) + '%';
    }
    window.addEventListener('scroll', hitung, { passive: true });
    hitung();

    // Salin tautan
    var tombol = document.getElementById('salinLink');
    tombol.addEventListener('click', function () {
        var teksAwal = tombol.textContent;
        var selesai = function () {
            tombol.textContent = 'Tautan tersalin';
            setTimeout(function () { tombol.textContent = teksAwal; }, 1800);
        };
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(window.location.href).then(selesai);
        } else {
            window.prompt('Salin tautan ini:', window.location.href);
        }
    });
})();
</script>
@endsection