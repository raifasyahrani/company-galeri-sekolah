@extends('layouts.public')
@section('title', 'Galeri Kegiatan')

@section('content')
<script>document.documentElement.classList.add('gl-js');</script>

@php
    $koleksi  = $galeris instanceof \Illuminate\Pagination\AbstractPaginator ? $galeris->getCollection() : collect($galeris);
    $berfoto  = $koleksi->filter(fn ($g) => $g->urlGambar())->values();

    // Tanggal Indonesia; aman jika created_at kosong
    $tgl = function ($g) {
        return $g->created_at ? $g->created_at->locale('id')->translatedFormat('d F Y') : '';
    };

    $dataFoto = $berfoto->map(fn ($g) => ['src' => $g->urlGambar(), 'judul' => $g->judul, 'ket' => $g->keterangan, 'tgl' => $tgl($g)]);
    $slider   = $berfoto->take(6)->values();
    $capSlide = $slider->map(fn ($g) => ['judul' => $g->judul, 'tgl' => $tgl($g)]);
    $pertama  = $slider->first();
    $noAwal   = '01 / ' . str_pad($slider->count(), 2, '0', STR_PAD_LEFT);
@endphp

{{-- ============ HERO (dua kolom: teks kiri, foto kanan) ============ --}}
<section id="galHero" class="relative isolate overflow-hidden bg-gradient-to-br from-navy-950 via-navy-900 to-navy-800 text-white">
    <div class="absolute -right-24 -top-24 -z-10 h-80 w-80 rounded-full bg-white/5"></div>
    <div class="absolute -bottom-28 left-1/3 -z-10 h-64 w-64 rounded-full bg-amber-400/10 blur-3xl"></div>

    <div class="mx-auto grid max-w-6xl items-center gap-12 px-6 py-14 md:py-20 lg:grid-cols-2 lg:gap-16">

        {{-- Kiri: teks --}}
        <div class="gl-in">
            <p class="text-sm text-blue-200"><a href="{{ route('welcome') }}" class="hover:text-white">Beranda</a> <span class="mx-2 text-blue-300/50">/</span> <span class="text-white">Galeri</span></p>

            <div class="mt-6 flex items-center gap-3">
                <span class="h-px w-8 bg-amber-400"></span>
                <p class="text-sm font-medium tracking-wide text-amber-300">Dokumentasi tim</p>
            </div>
            <h1 class="mt-4 font-display text-4xl font-semibold leading-tight md:text-5xl">Galeri <span class="text-amber-300">Kegiatan</span></h1>
            <p class="mt-4 max-w-md leading-relaxed text-blue-100">Potret aktivitas tim dan operasional kami dalam menjaga layanan tetap berjalan.</p>

            @if ($pertama)
                <div id="galCap" class="mt-8 max-w-md border-l-2 border-amber-400 pl-5">
                    <p id="galCapTgl" class="text-sm font-semibold text-amber-300">{{ $tgl($pertama) }}</p>
                    <p id="galCapJudul" class="mt-1 font-display text-lg font-semibold leading-snug text-white">{{ $pertama->judul }}</p>
                </div>

                <div class="mt-8 flex flex-wrap items-center gap-3">
                    <button type="button" id="galLihat" class="rounded-full bg-amber-400 px-7 py-3 text-sm font-semibold text-navy-950 transition hover:-translate-y-0.5 hover:bg-amber-300">Lihat foto</button>
                    <button type="button" id="galHPrev" class="flex h-11 w-11 items-center justify-center rounded-full ring-1 ring-white/30 transition hover:bg-white/15" aria-label="Foto sebelumnya">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button type="button" id="galHNext" class="flex h-11 w-11 items-center justify-center rounded-full ring-1 ring-white/30 transition hover:bg-white/15" aria-label="Foto berikutnya">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>

                <div class="mt-8 flex max-w-xs gap-2">
                    @foreach ($slider as $i => $f)
                        <button type="button" class="gal-seg relative h-5 flex-1" data-seg="{{ $i }}" aria-label="Foto {{ $i + 1 }}"><span class="absolute inset-x-0 top-1/2 h-[2px] -translate-y-1/2 overflow-hidden bg-white/25"><i class="absolute inset-0 bg-amber-400"></i></span></button>
                    @endforeach
                </div>
            @else
                <p class="mt-8 max-w-md text-blue-100/90">Foto kegiatan akan tampil di sini setelah ditambahkan lewat halaman admin.</p>
            @endif
        </div>

        {{-- Kanan: foto dalam bingkai --}}
        <div class="gl-in relative mx-auto w-full max-w-xl lg:max-w-none" style="--d: 180ms">
            <div class="absolute -bottom-4 -left-4 h-full w-full rounded-3xl border-2 border-amber-400/70"></div>
            <div class="relative aspect-[4/3] overflow-hidden rounded-3xl bg-navy-800 shadow-2xl shadow-black/30 ring-1 ring-white/10">
                @forelse ($slider as $i => $f)
                    <div class="gal-slide absolute inset-0 {{ $i === 0 ? 'is-aktif' : '' }}">
                        <img src="{{ $f->urlGambar() }}" alt="{{ $f->judul }}" class="h-full w-full object-cover">
                    </div>
                @empty
                    <svg viewBox="0 0 400 300" class="absolute inset-0 h-full w-full" fill="none" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
                        <path d="M70 220 C 130 150, 230 120, 340 112" stroke="#ffffff" stroke-width="10" stroke-linecap="round" stroke-opacity=".9"/>
                        <path d="M70 180 C 130 122, 230 92, 340 84" stroke="#ffffff" stroke-width="10" stroke-linecap="round" stroke-opacity=".4"/>
                        <circle cx="312" cy="224" r="12" fill="#fbbf24"/>
                    </svg>
                @endforelse

                @if ($pertama)
                    <span id="galNo" class="absolute right-4 top-4 rounded-full bg-navy-950/60 px-3 py-1 font-display text-xs font-semibold tracking-widest text-white backdrop-blur">{{ $noAwal }}</span>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- ============ KOLEKSI ============ --}}
<section id="koleksi" class="mx-auto max-w-6xl scroll-mt-20 px-6 py-20">
    @if ($berfoto->count())
        <div class="gl-rv mb-10 flex flex-col gap-2 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-sm font-semibold text-navy-700">Koleksi foto</p>
                <h2 class="mt-2 font-display text-3xl font-semibold text-navy-950">Dokumentasi kegiatan kami</h2>
            </div>
            <p class="text-sm text-slate-500">{{ $berfoto->count() }} foto</p>
        </div>

        <div class="grid gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($berfoto as $i => $g)
                <article class="gl-rv group" style="--d: {{ ($i % 3) * 90 }}ms">
                    <button type="button" data-lb="{{ $i }}" class="block w-full text-left" aria-label="Perbesar foto {{ $g->judul }}">
                        <div class="relative aspect-[4/3] overflow-hidden rounded-2xl bg-navy-900 ring-1 ring-slate-200">
                            <img src="{{ $g->urlGambar() }}" alt="{{ $g->judul }}" loading="lazy" decoding="async" class="h-full w-full object-cover transition duration-700 group-hover:scale-105">
                        </div>
                    </button>
                    <div class="mt-4">
                        <p class="text-xs text-slate-500">{{ $tgl($g) }}</p>
                        <h3 class="mt-1 font-display text-base font-semibold leading-snug text-navy-950">{{ $g->judul }}</h3>
                    </div>
                </article>
            @endforeach
        </div>

        @if ($galeris instanceof \Illuminate\Pagination\AbstractPaginator && $galeris->hasPages())
            <div class="mt-12">{{ $galeris->links() }}</div>
        @endif
    @else
        <div class="rounded-3xl border border-dashed border-slate-300 bg-slate-50 p-16 text-center">
            <p class="font-display text-lg font-semibold text-navy-950">Belum ada foto kegiatan</p>
            <p class="mt-1 text-sm text-slate-500">Foto akan tampil di sini setelah ditambahkan lewat halaman admin.</p>
        </div>
    @endif
</section>

{{-- ============ AJAKAN ============ --}}
<section class="px-6 pb-24">
    <div class="gl-rv mx-auto flex max-w-6xl flex-col gap-6 rounded-3xl bg-navy-900 px-8 py-12 text-white md:flex-row md:items-center md:justify-between md:px-14">
        <div class="max-w-xl">
            <h2 class="font-display text-2xl font-semibold leading-tight md:text-3xl">Ingin tahu lebih banyak tentang pekerjaan kami?</h2>
            <p class="mt-3 text-blue-100">Lihat layanan kami atau hubungi tim untuk konsultasi awal tanpa biaya.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('kontak') }}" class="rounded-full bg-amber-400 px-8 py-3.5 text-sm font-semibold text-navy-950 transition hover:bg-amber-300">Hubungi kami</a>
            <a href="{{ route('layanan') }}" class="rounded-full border border-white/40 px-8 py-3.5 text-sm font-semibold transition hover:bg-white/10">Lihat layanan</a>
        </div>
    </div>
</section>

{{-- ============ LIGHTBOX ============ --}}
<section aria-label="Penampil foto">
    <div id="galLightbox" class="fixed inset-0 z-[100] hidden flex-col items-center justify-center bg-navy-950/95 p-4 backdrop-blur-sm" role="dialog" aria-modal="true">
        <div class="absolute right-5 top-5 flex gap-2">
            <button type="button" id="galPlay" class="flex h-11 items-center rounded-full bg-white/10 px-4 text-sm font-semibold text-white transition hover:bg-white/25">Putar otomatis</button>
            <button type="button" id="galTutup" class="flex h-11 w-11 items-center justify-center rounded-full bg-white/10 text-white transition hover:bg-white/25" aria-label="Tutup">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12M18 6L6 18"/></svg>
            </button>
        </div>
        <button type="button" id="galPrev" class="absolute left-3 top-1/2 flex h-12 w-12 -translate-y-1/2 items-center justify-center rounded-full bg-white/10 text-white transition hover:bg-white/25 md:left-8" aria-label="Sebelumnya">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        </button>
        <button type="button" id="galNext" class="absolute right-3 top-1/2 flex h-12 w-12 -translate-y-1/2 items-center justify-center rounded-full bg-white/10 text-white transition hover:bg-white/25 md:right-8" aria-label="Berikutnya">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        </button>
        <div id="galKotak" class="w-full max-w-4xl">
            <img id="galGambar" src="" alt="" class="max-h-[62vh] w-full rounded-2xl object-contain shadow-2xl">
            <div class="mt-4 text-center text-white">
                <p id="galJudul" class="font-display text-lg font-semibold"></p>
                <p id="galKet" class="mx-auto mt-1 max-w-2xl text-sm leading-relaxed text-blue-100/80"></p>
                <p id="galHitung" class="mt-2 text-xs font-semibold tracking-widest text-amber-300"></p>
            </div>
            <div id="galThumbs" class="mt-4 flex gap-2 overflow-x-auto pb-1"></div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var $ = function (id) { return document.getElementById(id); };
    var foto = @json($dataFoto);
    var cap  = @json($capSlide);
    var DUR = 6000;
    var pad = function (n) { return (n < 10 ? '0' : '') + n; };

    /* ================= LIGHTBOX ================= */
    var kotak = $('galLightbox'), gambar = $('galGambar'), thumbs = $('galThumbs'), play = $('galPlay');
    var aktif = 0, timerLb = null;

    if (foto.length) {
        foto.forEach(function (f, i) {
            var t = document.createElement('button');
            t.type = 'button';
            t.className = 'h-14 w-20 shrink-0 overflow-hidden rounded-lg opacity-50 ring-2 ring-transparent transition hover:opacity-100';
            t.innerHTML = '<img src="' + f.src + '" alt="" class="h-full w-full object-cover">';
            t.addEventListener('click', function () { stopLb(); tampil(i); });
            thumbs.appendChild(t);
        });
    }
    function tampil(i) {
        aktif = (i + foto.length) % foto.length;
        var f = foto[aktif];
        gambar.src = f.src; gambar.alt = f.judul;
        gambar.classList.remove('gal-swap'); void gambar.offsetWidth; gambar.classList.add('gal-swap');
        $('galJudul').textContent = f.judul;
        $('galKet').textContent = (f.tgl || '') + (f.tgl && f.ket ? ' - ' : '') + (f.ket || '');
        $('galHitung').textContent = (aktif + 1) + ' / ' + foto.length;
        Array.prototype.forEach.call(thumbs.children, function (t, k) {
            var on = k === aktif;
            t.classList.toggle('opacity-50', !on);
            t.classList.toggle('ring-amber-400', on);
            t.classList.toggle('ring-transparent', !on);
            if (on) t.scrollIntoView({ inline: 'center', block: 'nearest', behavior: 'smooth' });
        });
        if (foto.length > 1) { new Image().src = foto[(aktif + 1) % foto.length].src; }
    }
    function stopLb() { clearInterval(timerLb); timerLb = null; play.textContent = 'Putar otomatis'; }
    function mulaiLb() { timerLb = setInterval(function () { tampil(aktif + 1); }, 3500); play.textContent = 'Jeda'; }
    function buka(i) { if (!foto.length) return; tampil(i); kotak.classList.add('terbuka'); document.body.style.overflow = 'hidden'; }
    function tutup() { stopLb(); kotak.classList.remove('terbuka'); document.body.style.overflow = ''; }

    document.querySelectorAll('[data-lb]').forEach(function (b) {
        b.addEventListener('click', function () { buka(parseInt(b.dataset.lb, 10)); });
    });
    $('galTutup').addEventListener('click', tutup);
    $('galPrev').addEventListener('click', function () { stopLb(); tampil(aktif - 1); });
    $('galNext').addEventListener('click', function () { stopLb(); tampil(aktif + 1); });
    play.addEventListener('click', function () { timerLb ? stopLb() : mulaiLb(); });
    kotak.addEventListener('click', function (e) { if (e.target === kotak) tutup(); });
    document.addEventListener('keydown', function (e) {
        if (!kotak.classList.contains('terbuka')) return;
        if (e.key === 'Escape') tutup();
        if (e.key === 'ArrowLeft') { stopLb(); tampil(aktif - 1); }
        if (e.key === 'ArrowRight') { stopLb(); tampil(aktif + 1); }
    });
    var awalX = null;
    kotak.addEventListener('touchstart', function (e) { awalX = e.touches[0].clientX; }, { passive: true });
    kotak.addEventListener('touchend', function (e) {
        if (awalX === null) return;
        var s = e.changedTouches[0].clientX - awalX;
        if (Math.abs(s) > 50) { stopLb(); tampil(s < 0 ? aktif + 1 : aktif - 1); }
        awalX = null;
    });

    /* ================= HERO SLIDESHOW ================= */
    var slides = [].slice.call(document.querySelectorAll('.gal-slide'));
    var segs   = [].slice.call(document.querySelectorAll('.gal-seg'));
    var hero   = $('galHero');
    var si = 0, t = null;

    function pergi(n) {
        if (!slides.length) return;
        si = (n + slides.length) % slides.length;
        slides.forEach(function (s, k) { s.classList.toggle('is-aktif', k === si); });
        segs.forEach(function (s, k) {
            s.classList.remove('is-isi', 'is-selesai', 'jeda');
            void s.offsetWidth;
            if (k < si) s.classList.add('is-selesai');
            if (k === si) s.classList.add('is-isi');
        });
        var c = $('galCap');
        if (c && cap[si]) {
            $('galCapTgl').textContent = cap[si].tgl;
            $('galCapJudul').textContent = cap[si].judul;
            c.classList.remove('gal-ganti'); void c.offsetWidth; c.classList.add('gal-ganti');
        }
        var no = $('galNo');
        if (no) { no.textContent = pad(si + 1) + ' / ' + pad(slides.length); }
        clearTimeout(t);
        if (slides.length > 1) t = setTimeout(function () { pergi(si + 1); }, DUR);
    }
    if (slides.length) {
        pergi(0);
        segs.forEach(function (s) { s.addEventListener('click', function () { pergi(parseInt(s.dataset.seg, 10)); }); });
        $('galHPrev').addEventListener('click', function () { pergi(si - 1); });
        $('galHNext').addEventListener('click', function () { pergi(si + 1); });
        $('galLihat').addEventListener('click', function () { buka(si); });
        hero.addEventListener('mouseenter', function () { clearTimeout(t); if (segs[si]) segs[si].classList.add('jeda'); });
        hero.addEventListener('mouseleave', function () { pergi(si); });
    }

    /* ================= MUNCUL HALUS SAAT DI-SCROLL ================= */
    var item = document.querySelectorAll('.gl-rv');
    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                if (e.isIntersecting) { e.target.classList.add('gl-on'); io.unobserve(e.target); }
            });
        }, { threshold: 0.08 });
        item.forEach(function (el) { io.observe(el); });
    } else {
        item.forEach(function (el) { el.classList.add('gl-on'); });
    }
});
</script>

<style>
    /* ===== Hero slideshow ===== */
    .gal-slide { opacity: 0; transition: opacity 1.3s ease; }
    .gal-slide.is-aktif { opacity: 1; }
    .gal-slide.is-aktif img { animation: galZoom 8s ease-out forwards; }
    @keyframes galZoom { from { transform: scale(1.1); } to { transform: scale(1); } }

    .gal-seg i { transform: scaleX(0); transform-origin: left; }
    .gal-seg.is-selesai i { transform: scaleX(1); }
    .gal-seg.is-isi i { animation: galIsi 6s linear forwards; }
    .gal-seg.jeda i { animation-play-state: paused; }
    @keyframes galIsi { to { transform: scaleX(1); } }

    .gal-ganti { animation: galNaik .7s cubic-bezier(.16,.84,.44,1); }
    @keyframes galNaik { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: none; } }

    /* ===== Lightbox ===== */
    @keyframes galMasuk { from { opacity: 0; transform: scale(.97); } to { opacity: 1; transform: none; } }
    #galLightbox.terbuka { display: flex; }
    #galLightbox.terbuka #galKotak { animation: galMasuk .25s ease; }
    @keyframes galSwap { from { opacity: 0; transform: scale(.985); } to { opacity: 1; transform: none; } }
    .gal-swap { animation: galSwap .35s ease; }
    #galThumbs { scrollbar-width: none; }
    #galThumbs::-webkit-scrollbar { display: none; }

    /* ===== Animasi (awalan "gl-" agar tidak bentrok dengan layout) ===== */
    @keyframes glNaik { from { opacity: 0; transform: translateY(24px); } to { opacity: 1; transform: none; } }
    .gl-in { opacity: 0; animation: glNaik .9s cubic-bezier(.2, .7, .2, 1) forwards; animation-delay: var(--d, 0ms); }

    .gl-js .gl-rv { opacity: 0; transform: translateY(24px); transition: opacity .8s ease, transform .8s ease; transition-delay: var(--d, 0ms); }
    .gl-js .gl-rv.gl-on { opacity: 1; transform: none; }

    @media (prefers-reduced-motion: reduce) {
        .gal-slide.is-aktif img, .gal-ganti, .gal-swap { animation: none; }
        .gal-slide { transition: none; }
        .gl-in { opacity: 1; animation: none; }
        .gl-js .gl-rv { opacity: 1; transform: none; transition: none; }
    }
</style>
@endsection