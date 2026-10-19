@extends('layouts.public')
@section('title', 'Kontak Kami')

@section('content')
<style>
    /* Animasi halaman kontak (kelas berawalan "kt-" agar tidak bentrok dengan layout) */
    @keyframes ktNaik { from { opacity: 0; transform: translateY(22px); } to { opacity: 1; transform: none; } }
    .kt-in { opacity: 0; animation: ktNaik .9s cubic-bezier(.2, .7, .2, 1) forwards; animation-delay: var(--d, 0ms); }

    @keyframes ktZoom { from { transform: scale(1.12); } to { transform: scale(1); } }
    .kt-zoom { animation: ktZoom 14s ease-out forwards; }

    @keyframes ktGaris { from { width: 0; } to { width: 4rem; } }
    .kt-garis { width: 0; height: 4px; border-radius: 9999px; background: #fbbf24; animation: ktGaris .9s .6s ease forwards; }

    .kt-js .kt-rv { opacity: 0; transform: translateY(26px); transition: opacity .8s ease, transform .8s ease; transition-delay: var(--d, 0ms); }
    .kt-js .kt-rv.kt-on { opacity: 1; transform: none; }

    @media (prefers-reduced-motion: reduce) {
        .kt-in { opacity: 1; animation: none; }
        .kt-zoom { animation: none; }
        .kt-garis { width: 4rem; animation: none; }
        .kt-js .kt-rv { opacity: 1; transform: none; transition: none; }
    }
</style>
<script>document.documentElement.classList.add('kt-js');</script>

@php
    $alamat  = config('perusahaan.alamat');
    if (! is_string($alamat) || $alamat === '') {
        $alamat = 'Jl. Raya Pajajaran No. 88F, Kota Bogor 16153';
    }
    $telepon = (string) config('perusahaan.telepon');
    $tel     = preg_replace('/[^0-9+]/', '', $telepon);
    $email   = (string) config('perusahaan.email');

    // WhatsApp (opsional): isi 'whatsapp' di config/perusahaan.php, contoh '6281234567890' atau '081234567890'
    $wa = preg_replace('/[^0-9]/', '', (string) config('perusahaan.whatsapp'));
    if ($wa !== '' && str_starts_with($wa, '0')) { $wa = '62' . substr($wa, 1); }

    // Tautan peta
    $linkMaps = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($alamat);
    $linkArah = 'https://www.google.com/maps/dir/?api=1&destination=' . urlencode($alamat);
    $srcPeta  = config('perusahaan.peta_embed')
        ?: 'https://www.google.com/maps?q=' . urlencode($alamat) . '&hl=id&z=17&output=embed';

    // Foto gedung (opsional): gedung_pt.png, cadangan perusahaan.jpg
    $foto = null;
    foreach (['images/gedung_pt.png', 'images/perusahaan.jpg'] as $berkas) {
        if (file_exists(public_path($berkas))) { $foto = asset($berkas); break; }
    }

    // Informasi kontak: [label, isi, tautan, buka tab baru?, ikon]
    $info = [
        ['Alamat', $alamat, $linkMaps, true, 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z'],
        ['Telepon', $telepon, $tel ? 'tel:' . $tel : null, false, 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z'],
        ['Email', $email, $email ? 'mailto:' . $email : null, false, 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
        ['Jam operasional', config('perusahaan.jam'), null, false, 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
    ];

    $langkah = [
        ['Kirim pesan', 'Sampaikan kebutuhan jaringan dan data kontak Anda lewat formulir.'],
        ['Penilaian awal', 'Tim kami mempelajari kebutuhan Anda lalu menghubungi Anda.'],
        ['Rancangan & penawaran', 'Kami menyiapkan rancangan dan penawaran yang sesuai.'],
    ];

    // Kelas kotak isian: merah jika ada kesalahan
    $kotak = 'w-full rounded-xl border bg-slate-50/60 px-4 py-3 text-sm text-slate-800 outline-none transition focus:bg-white focus:ring-2';
@endphp

{{-- ============ HERO (ringkas) ============ --}}
<section class="relative isolate overflow-hidden bg-navy-950 text-white">
    @if ($foto)
        <img src="{{ $foto }}" alt="Gedung {{ config('perusahaan.nama') }}" class="kt-zoom absolute inset-0 -z-10 h-full w-full object-cover object-[65%_35%]">
    @endif
    <div class="absolute inset-0 -z-10 bg-gradient-to-r from-navy-950 via-navy-950/90 to-navy-900/60"></div>

    <div class="mx-auto max-w-6xl px-6 py-10 md:py-14">
        <nav class="kt-in flex items-center gap-2 text-sm text-blue-100" aria-label="Breadcrumb">
            <a href="{{ route('welcome') }}" class="transition hover:text-white">Beranda</a>
            <span class="text-blue-200/60">/</span>
            <span class="font-semibold text-white">Kontak</span>
        </nav>

        <h1 class="kt-in mt-4 font-display text-3xl font-bold leading-tight md:text-4xl" style="--d: 120ms">
            Hubungi <span class="text-amber-300">Kami</span>
        </h1>
        <div class="kt-garis mt-4"></div>

        <p class="kt-in mt-4 max-w-xl text-base leading-relaxed text-blue-100" style="--d: 300ms">
            Sampaikan kebutuhan konektivitas dan infrastruktur TI Anda. Tim kami akan menghubungi Anda secepatnya.
        </p>
    </div>
</section>

{{-- ============ INFORMASI KONTAK + FORMULIR ============ --}}
<section class="bg-slate-50">
    <div class="mx-auto grid max-w-6xl items-stretch gap-8 px-6 py-16 lg:grid-cols-5">

        {{-- Kiri: informasi kontak --}}
        <div class="kt-rv relative overflow-hidden rounded-3xl bg-gradient-to-br from-navy-950 via-navy-900 to-navy-800 p-8 text-white shadow-xl lg:col-span-2">
            <div class="absolute -right-16 -top-16 h-56 w-56 rounded-full bg-white/5"></div>
            <div class="absolute -bottom-20 -left-10 h-48 w-48 rounded-full bg-amber-400/10"></div>

            <div class="relative flex h-full flex-col">
                <div class="flex items-center gap-3">
                    <span class="h-px w-8 bg-amber-400"></span>
                    <p class="text-sm font-semibold tracking-wide text-amber-300">Informasi kontak</p>
                </div>
                <h2 class="mt-3 font-display text-2xl font-bold">Terhubung langsung dengan tim kami</h2>

                <ul class="mt-8 divide-y divide-white/10">
                    @foreach ($info as [$label, $isi, $href, $baru, $ikon])
                        @php $tag = $href ? 'a' : 'div'; @endphp
                        <li>
                            <{{ $tag }} @if ($href) href="{{ $href }}" @if ($baru) target="_blank" rel="noopener" @endif @endif class="group flex items-start gap-4 py-5">
                                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white/10 text-amber-300 transition group-hover:bg-amber-400 group-hover:text-navy-950">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $ikon }}"/></svg>
                                </span>
                                <span class="min-w-0">
                                    <span class="block text-xs font-semibold uppercase tracking-wider text-amber-300">{{ $label }}</span>
                                    <span class="mt-1 block break-words text-sm leading-relaxed text-blue-50 transition {{ $href ? 'group-hover:text-white' : '' }}">{{ $isi ?: '-' }}</span>
                                </span>
                            </{{ $tag }}>
                        </li>
                    @endforeach
                </ul>

                <div class="mt-auto flex flex-wrap gap-3 pt-4">
                    @if ($tel)
                        <a href="tel:{{ $tel }}" class="rounded-full bg-amber-400 px-6 py-3 text-sm font-semibold text-navy-950 transition hover:-translate-y-0.5 hover:bg-amber-300">Telepon sekarang</a>
                    @endif
                    @if ($wa !== '')
                        <a href="https://wa.me/{{ $wa }}" target="_blank" rel="noopener" class="rounded-full border border-white/40 px-6 py-3 text-sm font-semibold transition hover:bg-white/10">Chat WhatsApp</a>
                    @endif
                </div>
            </div>
        </div>

        {{-- Kanan: formulir --}}
        <div id="formulir" class="kt-rv scroll-mt-28 rounded-3xl bg-white p-8 shadow-lg ring-1 ring-slate-200 md:p-10 lg:col-span-3" style="--d: 120ms">
            <div class="flex items-center gap-3">
                <span class="h-px w-8 bg-amber-400"></span>
                <p class="text-sm font-semibold tracking-wide text-navy-700">Formulir pesan</p>
            </div>
            <h2 class="mt-3 font-display text-2xl font-bold text-navy-950 md:text-3xl">Kirim pesan</h2>
            <p class="mt-2 text-sm text-slate-500">Lengkapi data berikut untuk berkonsultasi mengenai solusi jaringan bisnis Anda.</p>

            @if (session('success'))
                <div role="status" class="mt-6 flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-emerald-500 text-white">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    </span>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <form id="formKontak" method="POST" action="{{ route('kontak.kirim') }}" class="mt-7 space-y-5" novalidate>
                @csrf

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label for="nama" class="mb-1.5 block text-sm font-semibold text-navy-950">Nama lengkap</label>
                        <input type="text" id="nama" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama Anda"
                               class="{{ $kotak }} @error('nama') border-red-400 focus:border-red-500 focus:ring-red-200 @else border-slate-300 focus:border-navy-800 focus:ring-navy-800/20 @enderror">
                        @error('nama')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="email" class="mb-1.5 block text-sm font-semibold text-navy-950">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@domain.com"
                               class="{{ $kotak }} @error('email') border-red-400 focus:border-red-500 focus:ring-red-200 @else border-slate-300 focus:border-navy-800 focus:ring-navy-800/20 @enderror">
                        @error('email')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label for="pesan" class="mb-1.5 block text-sm font-semibold text-navy-950">Pesan</label>
                    <textarea id="pesan" name="pesan" rows="5" placeholder="Tuliskan kebutuhan internet atau pertanyaan Anda di sini..."
                              class="{{ $kotak }} @error('pesan') border-red-400 focus:border-red-500 focus:ring-red-200 @else border-slate-300 focus:border-navy-800 focus:ring-navy-800/20 @enderror">{{ old('pesan') }}</textarea>
                    @error('pesan')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="flex flex-wrap items-center gap-4 pt-1">
                    <button type="submit" id="kirimBtn" class="inline-flex items-center gap-3 rounded-full bg-navy-900 px-8 py-3.5 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:bg-navy-800 disabled:cursor-not-allowed disabled:opacity-70">
                        <span id="kirimTeks">Kirim pesan</span>
                        <svg class="h-4 w-4 text-amber-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>
                    <p class="text-xs text-slate-500">Data Anda hanya dipakai untuk menanggapi pesan ini.</p>
                </div>
            </form>
        </div>
    </div>
</section>

{{-- ============ SETELAH ANDA MENGIRIM PESAN ============ --}}
<section class="bg-white">
    <div class="mx-auto max-w-6xl px-6 py-20">
        <div class="kt-rv mx-auto mb-12 max-w-2xl text-center">
            <div class="flex items-center justify-center gap-3">
                <span class="h-px w-8 bg-amber-400"></span>
                <p class="text-sm font-semibold tracking-wide text-navy-700">Alur konsultasi</p>
                <span class="h-px w-8 bg-amber-400"></span>
            </div>
            <h2 class="mt-3 font-display text-2xl font-bold text-navy-950 md:text-3xl">Setelah Anda mengirim pesan</h2>
        </div>

        <ol class="grid gap-6 md:grid-cols-3">
            @foreach ($langkah as $i => [$judul, $isi])
                <li class="kt-rv group relative rounded-2xl bg-slate-50 p-7 ring-1 ring-slate-200 transition duration-300 hover:-translate-y-1.5 hover:bg-white hover:shadow-xl" style="--d: {{ $i * 110 }}ms">
                    <span class="absolute right-6 top-4 font-display text-5xl font-semibold text-slate-200/70 transition group-hover:text-amber-100">0{{ $i + 1 }}</span>
                    <span class="relative flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-navy-700 to-navy-900 font-display text-lg font-semibold text-white shadow-lg shadow-navy-700/30">{{ $i + 1 }}</span>
                    <p class="relative mt-6 font-display text-lg font-semibold text-navy-950">{{ $judul }}</p>
                    <p class="relative mt-2 text-sm leading-relaxed text-slate-600">{{ $isi }}</p>
                    @if ($i < 2)
                        <span class="absolute -right-6 top-1/2 hidden h-px w-6 bg-amber-400 md:block"></span>
                    @endif
                </li>
            @endforeach
        </ol>
    </div>
</section>

{{-- ============ PETA ============ --}}
<section class="bg-slate-50">
    <div class="mx-auto max-w-6xl px-6 py-20">
        <div class="kt-rv mb-8 flex flex-col gap-5 md:flex-row md:items-end md:justify-between">
            <div>
                <div class="flex items-center gap-3">
                    <span class="h-px w-8 bg-amber-400"></span>
                    <p class="text-sm font-semibold tracking-wide text-navy-700">Lokasi kami</p>
                </div>
                <h2 class="mt-3 font-display text-2xl font-bold text-navy-950 md:text-3xl">Kantor operasional</h2>
                <p class="mt-1 text-sm text-slate-500">{{ $alamat }}</p>
            </div>
            <div class="flex flex-wrap gap-3 text-sm font-semibold">
                <a href="{{ $linkMaps }}" target="_blank" rel="noopener" class="rounded-full bg-navy-900 px-6 py-3 text-white transition hover:-translate-y-0.5 hover:bg-navy-800">Buka di Google Maps</a>
                <a href="{{ $linkArah }}" target="_blank" rel="noopener" class="rounded-full border border-navy-900 px-6 py-3 text-navy-900 transition hover:bg-blue-50">Petunjuk arah</a>
            </div>
        </div>

        <div class="kt-rv h-96 overflow-hidden rounded-3xl bg-slate-200 shadow-lg ring-1 ring-slate-200" style="--d: 100ms">
            <iframe src="{{ $srcPeta }}" class="h-full w-full border-0" style="border:0;" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Lokasi kantor {{ config('perusahaan.nama') }}"></iframe>
        </div>
    </div>
</section>

<script>
(function () {
    // Muncul halus saat di-scroll
    var item = document.querySelectorAll('.kt-rv');
    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                if (e.isIntersecting) { e.target.classList.add('kt-on'); io.unobserve(e.target); }
            });
        }, { threshold: 0.1 });
        item.forEach(function (el) { io.observe(el); });
    } else {
        item.forEach(function (el) { el.classList.add('kt-on'); });
    }

    // Tombol kirim: cegah klik ganda
    var form = document.getElementById('formKontak');
    var btn  = document.getElementById('kirimBtn');
    var teks = document.getElementById('kirimTeks');
    if (form && btn) {
        form.addEventListener('submit', function () {
            btn.disabled = true;
            if (teks) { teks.textContent = 'Mengirim...'; }
        });
    }

    @if (session('success') || $errors->any())
    // Setelah kirim atau jika ada kesalahan, gulir ke formulir
    window.addEventListener('load', function () {
        var f = document.getElementById('formulir');
        if (f) { f.scrollIntoView({ behavior: 'smooth', block: 'start' }); }
    });
    @endif
})();
</script>
@endsection