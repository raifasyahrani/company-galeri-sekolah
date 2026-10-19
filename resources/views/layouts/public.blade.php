<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ config('perusahaan.nama') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Sora:wght@500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
        @theme {
            --color-navy-950: #0b1b4d;
            --color-navy-900: #10297a;
            --color-navy-800: #1741b5;
            --color-navy-700: #2159e0;
            --font-sans: "Plus Jakarta Sans", ui-sans-serif, system-ui, sans-serif;
            --font-display: "Sora", ui-sans-serif, system-ui, sans-serif;
        }
    </style>
    <style>
        /* ===== Animasi ===== */
        .intro { opacity: 0; animation: introUp .9s cubic-bezier(.2,.7,.2,1) forwards; }
        @keyframes introUp { from { opacity: 0; transform: translateY(26px); } to { opacity: 1; transform: none; } }

        .reveal { opacity: 0; transform: translateY(32px); transition: opacity .8s cubic-bezier(.2,.7,.2,1), transform .8s cubic-bezier(.2,.7,.2,1); }
        .reveal.is-visible { opacity: 1; transform: none; }

        /* foto hero perlahan mengecil (efek sinematik) */
        main > section:first-child > img { animation: kenburns 26s ease-out both; }
        @keyframes kenburns { from { transform: scale(1.12); } to { transform: scale(1); } }

        /* lingkaran dekorasi bergerak pelan */
        main .blur-3xl, footer .blur-3xl { animation: drift 14s ease-in-out infinite alternate; }
        @keyframes drift { from { transform: translate(0, 0); } to { transform: translate(24px, -18px); } }

        /* header: bayangan muncul saat halaman digulir */
        #siteHeader { transition: box-shadow .3s ease, background-color .3s ease; }
        #siteHeader.is-scrolled { box-shadow: 0 10px 30px rgba(11, 27, 77, .12); }

        /* tombol kembali ke atas */
        #toTop { transition: opacity .3s ease, transform .3s ease, background-color .2s ease; }
        #toTop.is-hidden { opacity: 0; transform: translateY(16px); pointer-events: none; }

        @media (prefers-reduced-motion: reduce) {
            .intro, main > section:first-child > img, main .blur-3xl, footer .blur-3xl { animation: none !important; opacity: 1; }
            .reveal { opacity: 1; transform: none; transition: none; }
        }
    </style>
</head>
<body class="font-sans text-slate-700 bg-white antialiased">
@php
    $menu = [
        ['welcome', 'welcome',  'Beranda'],
        ['profil',  'profil',   'Profil'],
        ['layanan', 'layanan',  'Produk & Layanan'],
        ['artikel', 'artikel*', 'Artikel'],
        ['galeri',  'galeri',   'Galeri'],
        ['kontak',  'kontak',   'Kontak'],
    ];
    $alamatQ   = urlencode(config('perusahaan.alamat'));
    $petaEmbed = 'https://www.google.com/maps?q=' . $alamatQ . '&output=embed';
    $petaLink  = 'https://www.google.com/maps/search/?api=1&query=' . $alamatQ;
@endphp

<header id="siteHeader" class="sticky top-0 z-50 bg-white/95 backdrop-blur shadow-sm">
    <div class="mx-auto max-w-6xl px-6 h-20 flex items-center justify-between">
        <a href="{{ route('welcome') }}" class="group flex items-center gap-3">
            <svg viewBox="0 0 40 40" class="h-11 w-11 transition duration-300 group-hover:rotate-6 group-hover:scale-105" aria-hidden="true">
                <rect width="40" height="40" rx="10" fill="#2159e0"/>
                <path d="M7 27c6-10 14-14 26-14" stroke="#fff" stroke-width="3.2" fill="none" stroke-linecap="round"/>
                <path d="M7 20c6-7 14-10 26-10" stroke="#fff" stroke-width="3.2" fill="none" stroke-linecap="round" opacity=".5"/>
                <circle cx="31" cy="30" r="3.5" fill="#fbbf24"/>
            </svg>
            <span class="leading-tight">
                <span class="block font-display text-[17px] font-bold text-navy-950">{{ config('perusahaan.nama') }}</span>
                <span class="block text-[11px] text-slate-500">{{ config('perusahaan.slogan') }}</span>
            </span>
        </a>
        <nav class="hidden lg:flex items-center gap-1 text-sm font-medium">
            @foreach ($menu as [$rute, $pola, $label])
                <a href="{{ route($rute) }}" class="rounded-full px-4 py-2 transition duration-200 {{ request()->routeIs($pola) ? 'bg-navy-700 text-white font-semibold shadow-md shadow-navy-700/30' : 'text-slate-600 hover:bg-blue-50 hover:text-navy-800 hover:-translate-y-0.5' }}">{{ $label }}</a>
            @endforeach
        </nav>
        <button id="menuBtn" type="button" class="lg:hidden p-2 text-navy-950" aria-label="Buka menu">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
    </div>
    <div id="mobileMenu" class="hidden lg:hidden px-6 pb-4">
        @foreach ($menu as [$rute, $pola, $label])
            <a href="{{ route($rute) }}" class="block py-2.5 text-sm {{ request()->routeIs($pola) ? 'font-semibold text-navy-700' : 'text-slate-600' }}">{{ $label }}</a>
        @endforeach
    </div>
</header>

<main>@yield('content')</main>

<footer class="relative overflow-hidden bg-navy-950 text-slate-300">
    <div class="absolute -right-24 -top-24 h-80 w-80 rounded-full bg-navy-700/30 blur-3xl"></div>
    <div class="absolute -left-20 bottom-0 h-56 w-56 rounded-full bg-amber-400/10 blur-3xl"></div>

    <div class="relative mx-auto max-w-6xl px-6 pt-16 grid gap-12 md:grid-cols-5 text-sm">
        <div class="md:col-span-2">
            <p class="font-display text-2xl font-semibold text-white">Terhubung dengan kami</p>
            <p class="mt-3 max-w-sm leading-relaxed text-slate-300">Sampaikan kebutuhan koneksi dan infrastruktur Anda. Tim kami siap membantu dari penilaian awal hingga pemeliharaan.</p>
            <a href="{{ route('kontak') }}" class="mt-6 inline-block rounded-full bg-amber-400 px-7 py-3 font-semibold text-navy-950 transition hover:-translate-y-0.5 hover:bg-amber-300">Hubungi kami</a>
        </div>
        <div>
            <p class="mb-3 font-semibold text-white">Navigasi</p>
            <ul class="space-y-2">
                @foreach ($menu as [$rute, $pola, $label])
                    <li><a href="{{ route($rute) }}" class="inline-block transition hover:translate-x-1 hover:text-white">{{ $label }}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="md:col-span-2">
            <p class="mb-3 font-semibold text-white">Kantor pusat</p>
            <ul class="space-y-2 text-slate-300">
                <li>{{ config('perusahaan.nama') }}</li>
                <li>{{ config('perusahaan.alamat') }}</li>
                <li>{{ config('perusahaan.telepon') }}</li>
                <li>{{ config('perusahaan.email') }}</li>
                <li>{{ config('perusahaan.jam') }}</li>
            </ul>
        </div>
    </div>

    {{-- Peta lokasi --}}
    <div class="relative mx-auto max-w-6xl px-6 pb-14 pt-12">
        <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <p class="font-semibold text-white">Lokasi kami</p>
            <a href="{{ $petaLink }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 text-sm font-semibold text-amber-300 hover:text-amber-200">
                Buka di Google Maps
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </a>
        </div>
        <div class="overflow-hidden rounded-2xl ring-1 ring-white/20 shadow-2xl shadow-black/30">
            <iframe src="{{ $petaEmbed }}" title="Peta lokasi {{ config('perusahaan.nama') }}" class="h-72 w-full md:h-80" style="border:0;" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>

    <div class="relative border-t border-white/10">
        <div class="mx-auto max-w-6xl px-6 py-5 flex flex-col gap-2 text-xs text-slate-400 sm:flex-row sm:justify-between">
            <p>&copy; {{ date('Y') }} {{ config('perusahaan.nama') }}. Hak cipta dilindungi.</p>
            <a href="{{ route('admin.login') }}" class="hover:text-white">Login admin</a>
        </div>
    </div>
</footer>

{{-- Tombol kembali ke atas --}}
<button id="toTop" type="button" aria-label="Kembali ke atas" class="is-hidden fixed bottom-6 right-6 z-40 flex h-12 w-12 items-center justify-center rounded-full bg-amber-400 text-navy-950 shadow-xl shadow-navy-950/30 hover:bg-amber-300">
    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/></svg>
</button>

<script>
(function () {
    var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    // ---- Menu layar kecil ----
    document.getElementById('menuBtn').addEventListener('click', function () {
        document.getElementById('mobileMenu').classList.toggle('hidden');
    });

    // ---- Header berbayang & tombol ke atas saat digulir ----
    var header = document.getElementById('siteHeader');
    var toTop = document.getElementById('toTop');
    function onScroll() {
        var y = window.scrollY;
        header.classList.toggle('is-scrolled', y > 8);
        toTop.classList.toggle('is-hidden', y < 600);
    }
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
    toTop.addEventListener('click', function () { window.scrollTo({ top: 0, behavior: 'smooth' }); });

    if (reduce) return;

    // ---- Animasi masuk bagian hero (muncul berurutan) ----
    var hero = document.querySelector('main > section:first-child');
    var judul = hero && hero.querySelector('h1');
    if (judul) {
        Array.prototype.forEach.call(judul.parentElement.children, function (el, i) {
            el.classList.add('intro');
            el.style.animationDelay = (120 + i * 140) + 'ms';
        });
    }

    // ---- Angka berhitung naik ----
    function countUp(el) {
        var asli = el.textContent.trim();
        var m = asli.match(/^(\d[\d.,]*)(.*)$/);
        if (!m || /^(19|20)\d\d$/.test(m[1])) return;
        var desimal = m[1].indexOf(',') > -1 ? m[1].split(',')[1].length : 0;
        var target = parseFloat(m[1].replace(/\./g, '').replace(',', '.'));
        if (isNaN(target)) return;
        var mulai = null, durasi = 1400;
        function langkah(t) {
            if (!mulai) mulai = t;
            var p = Math.min((t - mulai) / durasi, 1);
            var e = 1 - Math.pow(1 - p, 3);
            el.textContent = (target * e).toLocaleString('id-ID', { minimumFractionDigits: desimal, maximumFractionDigits: desimal }) + m[2];
            if (p < 1) requestAnimationFrame(langkah); else el.textContent = asli;
        }
        requestAnimationFrame(langkah);
    }

    // ---- Animasi muncul saat digulir (bertahap) ----
    var target = [];
    document.querySelectorAll('main > div').forEach(function (el) { target.push(el); });
    Array.prototype.slice.call(document.querySelectorAll('main > section'), 1).forEach(function (sec) {
        sec.querySelectorAll('h2, .grid > *, dl > div, ol > li, ul > li, details, figure').forEach(function (el) {
            if (target.indexOf(el) === -1) target.push(el);
        });
    });

    if (!('IntersectionObserver' in window)) return;
    var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (!entry.isIntersecting) return;
            var el = entry.target;
            el.classList.add('is-visible');
            el.querySelectorAll('dt').forEach(countUp);
            io.unobserve(el);
            // lepas kelas animasi setelah selesai agar efek hover bawaan kartu tetap berjalan normal
            setTimeout(function () {
                el.classList.remove('reveal', 'is-visible');
                el.style.transitionDelay = '';
            }, 1200 + (parseInt(el.style.transitionDelay) || 0));
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

    target.forEach(function (el) {
        var urutan = Array.prototype.indexOf.call(el.parentElement.children, el);
        el.classList.add('reveal');
        el.style.transitionDelay = Math.min(urutan, 6) * 90 + 'ms';
        io.observe(el);
    });
})();
</script>
</body>
</html>