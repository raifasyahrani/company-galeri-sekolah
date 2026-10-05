<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita - SMKN 4 Bogor</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .reveal { opacity: 0; transform: translateY(26px); transition: opacity .7s ease, transform .7s ease; }
        .reveal.is-visible { opacity: 1; transform: none; }
        @keyframes modalIn { from { opacity: 0; transform: translateY(24px) scale(.94); } to { opacity: 1; transform: none; } }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        #modal.is-open { animation: fadeIn .25s ease; }
        #modal.is-open .modal-box { animation: modalIn .35s cubic-bezier(.2,.9,.3,1.2); }
        .glow { box-shadow: 0 0 0 1px rgba(250,204,21,.25), 0 25px 60px -15px rgba(29,78,216,.6); }
    </style>
</head>
<body class="font-sans text-gray-800 bg-gray-50">

    {{-- NAVBAR --}}
    <header id="navbar" class="sticky top-0 z-50 bg-white shadow-sm">
        <div class="flex items-center justify-between px-8 py-3">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/LOGO.png') }}" alt="Logo SMKN 4 Bogor" class="w-12 h-12 object-contain">
                <div class="leading-tight">
                    <p class="font-extrabold text-navy-900 text-lg">SMKN 4 BOGOR</p>
                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest">Unggul, Kompeten, Berkarakter</p>
                </div>
            </div>
            <nav class="hidden md:flex items-center gap-6 text-sm font-semibold text-gray-500">
                <a href="{{ route('welcome') }}" class="pb-1 border-b-2 transition {{ request()->routeIs('welcome') ? 'text-blue-600 border-blue-600' : 'border-transparent hover:text-blue-600' }}">Beranda</a>
                <a href="{{ route('profil') }}" class="pb-1 border-b-2 transition {{ request()->routeIs('profil') ? 'text-blue-600 border-blue-600' : 'border-transparent hover:text-blue-600' }}">Profil</a>
                <a href="{{ route('berita') }}" class="pb-1 border-b-2 transition {{ request()->routeIs('berita') ? 'text-blue-600 border-blue-600' : 'border-transparent hover:text-blue-600' }}">Berita</a>
                <a href="{{ route('jurusan') }}" class="pb-1 border-b-2 transition {{ request()->routeIs('jurusan') ? 'text-blue-600 border-blue-600' : 'border-transparent hover:text-blue-600' }}">Jurusan</a>
                <a href="{{ route('galeri') }}" class="pb-1 border-b-2 transition {{ request()->routeIs('galeri') ? 'text-blue-600 border-blue-600' : 'border-transparent hover:text-blue-600' }}">Galeri</a>
                <a href="{{ route('ekstrakulikuler') }}" class="pb-1 border-b-2 transition {{ request()->routeIs('ekstrakulikuler') ? 'text-blue-600 border-blue-600' : 'border-transparent hover:text-blue-600' }}">Ekstrakulikuler</a>
                <a href="{{ route('admin.login') }}" class="flex items-center gap-2 bg-blue-600 text-white font-semibold px-4 py-2 rounded-full hover:bg-blue-700 transition">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                    Login Sebagai Admin
                </a>
            </nav>
        </div>
    </header>

    @php
        // $daftarBerita, $jurusanInfo, $kategoriList dikirim oleh BeritaPageController (dari database)
        $kategoriStyle = [
            'Prestasi'  => [
                'badge' => 'bg-yellow-400 text-navy-900',
                'icon'  => 'M5 3h14v3a5 5 0 0 1-4 4.9V13a3 3 0 0 0 2 2.8V18H7v-2.2A3 3 0 0 0 9 13v-2.1A5 5 0 0 1 5 6V3Zm-3 2h2v1a3 3 0 0 0 2 2.8V7H4V5H2Zm18 0h2v2h-2v1.8A3 3 0 0 0 22 6V5h-2ZM8 20h8v2H8v-2Z',
            ],
            'Kegiatan'  => [
                'badge' => 'bg-emerald-500 text-white',
                'icon'  => 'M7 2v2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-2V2h-2v2H9V2H7Zm12 8H5v10h14V10Z',
            ],
            'Informasi' => [
                'badge' => 'bg-blue-600 text-white',
                'icon'  => 'M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20Zm1 15h-2v-6h2v6Zm0-8h-2V7h2v2Z',
            ],
        ];
        $iconKalender = $kategoriStyle['Kegiatan']['icon'];

        $koleksi = collect($daftarBerita ?? [])->map(function ($b) use ($kategoriStyle, $jurusanInfo) {
            $kat = array_key_exists($b->kategori ?? '', $kategoriStyle) ? $b->kategori : 'Informasi';
            $jur = array_key_exists($b->jurusan ?? '', $jurusanInfo) ? $b->jurusan : 'Umum';
            return [
                'slug'      => $b->slug ?: 'berita-' . $b->id,
                'title'     => $b->judul,
                'img'       => $b->urlGambar('gambar') ?: asset('images/LOGO.png'),
                'kategori'  => $kat,
                'jurusan'   => $jur,
                'tanggal'   => $b->tanggal,
                'deskripsi' => $b->deskripsi,
                'isi'       => $b->isi ?: $b->deskripsi,
            ];
        });

        $unggulan = $koleksi->first();
        $lainnya  = $koleksi->slice(1)->values();
        $jumlah   = $koleksi->countBy('kategori');
        $total    = $koleksi->count();

        $dataModal = $koleksi->keyBy('slug')->map(fn ($x) => [
            'title' => $x['title'], 'img' => $x['img'], 'kategori' => $x['kategori'],
            'jurusan' => $x['jurusan'], 'tanggal' => $x['tanggal'], 'isi' => $x['isi'],
        ]);
        $urutanSlug = $koleksi->pluck('slug')->values();
    @endphp

    {{-- HERO --}}
    <section class="relative overflow-hidden" style="background:linear-gradient(120deg,#0b1b3f 0%,#12307a 60%,#1d4ed8 100%);">
        <img src="{{ asset('images/lapangan miring.JPG') }}" alt="" class="absolute inset-0 w-full h-full object-cover" style="opacity:.18;">
        <div class="absolute rounded-full" style="right:-90px;top:-90px;width:320px;height:320px;background:rgba(59,130,246,.25);filter:blur(40px);"></div>
        <div class="absolute rounded-full" style="left:35%;bottom:-130px;width:260px;height:260px;background:rgba(250,204,21,.18);filter:blur(40px);"></div>
        <span class="absolute right-6 md:right-16 bottom-0 text-[9rem] md:text-[13rem] font-black leading-none text-white/5 select-none pointer-events-none">NEWS</span>

        <div class="relative z-10 px-8 md:px-16 pt-14 pb-28 text-white">
            <span class="inline-flex items-center gap-2 bg-white/10 backdrop-blur border border-white/20 text-yellow-300 font-semibold text-xs px-4 py-1.5 rounded-full mb-4">
                <span class="w-2 h-2 rounded-full bg-yellow-400 animate-pulse"></span> Informasi Sekolah
            </span>
            <h1 class="text-3xl md:text-5xl font-extrabold leading-tight mb-3 max-w-2xl">Berita &amp; Artikel Sekolah</h1>
            <div class="w-20 h-1.5 rounded-full bg-gradient-to-r from-blue-400 to-yellow-400 mb-4"></div>
            <p class="text-sm md:text-base text-blue-100 max-w-xl mb-8">Kabar terbaru seputar prestasi, kegiatan, dan informasi penting dari SMKN 4 Bogor.</p>

            <div class="relative max-w-xl">
                <svg class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="M21 21l-4.3-4.3"/></svg>
                <input id="cari" type="text" placeholder="Cari berita: juara, LKS, SPMB..."
                       class="w-full rounded-2xl pl-12 pr-4 py-3.5 text-sm text-gray-800 shadow-xl focus:outline-none focus:ring-4 focus:ring-yellow-300/60">
            </div>
        </div>
    </section>

    {{-- STATISTIK --}}
    <section class="relative z-20 px-8 md:px-16 -mt-14">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="reveal bg-white rounded-2xl shadow-lg p-5 flex items-center gap-4 border-b-4 border-blue-600 hover:-translate-y-1 transition-all">
                <span class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l6 6v10a2 2 0 01-2 2z"/></svg>
                </span>
                <div>
                    <p class="text-2xl font-extrabold text-navy-900 leading-none">{{ $total }}</p>
                    <p class="text-xs text-gray-500 mt-1">Total Berita</p>
                </div>
            </div>
            @foreach (['Prestasi', 'Kegiatan', 'Informasi'] as $k)
                <div class="reveal bg-white rounded-2xl shadow-lg p-5 flex items-center gap-4 border-b-4 border-yellow-400 hover:-translate-y-1 transition-all">
                    <span class="w-12 h-12 rounded-xl {{ $kategoriStyle[$k]['badge'] }} flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor"><path d="{{ $kategoriStyle[$k]['icon'] }}"/></svg>
                    </span>
                    <div>
                        <p class="text-2xl font-extrabold text-navy-900 leading-none">{{ $jumlah[$k] ?? 0 }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $k }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- FILTER (menempel; offset dihitung otomatis dari tinggi navbar) --}}
    <section id="filterBar" class="sticky z-40 mt-10 bg-gray-50/95 backdrop-blur border-b border-gray-200" style="top:72px;">
        <div class="px-8 md:px-16 py-4 flex flex-wrap items-center gap-3">
            @foreach ($kategoriList as $kategori)
                <button type="button" data-filter="{{ $kategori }}"
                    class="filter-btn inline-flex items-center gap-2 text-sm font-semibold px-4 py-2 rounded-full border transition {{ $kategori === 'Semua' ? 'bg-blue-600 text-white border-blue-600 shadow-md' : 'bg-white text-gray-500 border-gray-200 hover:border-blue-300 hover:text-blue-600' }}">
                    {{ $kategori }}
                    <span class="filter-count text-[11px] font-bold px-2 py-0.5 rounded-full {{ $kategori === 'Semua' ? 'bg-white/20' : 'bg-gray-100' }}">
                        {{ $kategori === 'Semua' ? $total : ($jumlah[$kategori] ?? 0) }}
                    </span>
                </button>
            @endforeach
            <span id="result-count" class="ml-auto text-xs text-gray-400"></span>
        </div>
    </section>

    {{-- BERITA --}}
    <section class="px-8 md:px-16 py-10">

        {{-- UNGGULAN (navy) --}}
        @if ($unggulan)
        <article id="{{ $unggulan['slug'] }}" data-kategori="{{ $unggulan['kategori'] }}" data-baca="{{ $unggulan['slug'] }}"
                 data-cari="{{ strtolower($unggulan['title'] . ' ' . $unggulan['deskripsi'] . ' ' . $unggulan['kategori'] . ' ' . $unggulan['jurusan']) }}"
                 class="berita-card reveal glow scroll-mt-40 group relative grid grid-cols-1 md:grid-cols-5 rounded-3xl overflow-hidden bg-navy-900 hover:-translate-y-1 transition-all mb-8 cursor-pointer">

            <span class="absolute -bottom-10 -right-2 text-[11rem] font-black leading-none text-white/5 select-none pointer-events-none">TOP</span>

            <div class="relative overflow-hidden md:col-span-2 h-64 md:h-auto" style="min-height:20rem;">
                <img src="{{ $unggulan['img'] }}" alt="{{ $unggulan['title'] }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                <span class="absolute top-4 left-4 inline-flex items-center gap-1.5 bg-yellow-400 text-navy-900 text-xs font-bold px-3 py-1.5 rounded-full shadow">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3 6.5 7 .9-5.2 4.8 1.4 7L12 17.8 5.8 21.2l1.4-7L2 9.4l7-.9L12 2Z"/></svg>
                    Berita Unggulan
                </span>
            </div>

            <div class="relative z-10 md:col-span-3 p-6 md:p-9 flex flex-col justify-center text-white">
                <div class="flex flex-wrap items-center gap-2 mb-3">
                    <span class="{{ $kategoriStyle[$unggulan['kategori']]['badge'] }} text-xs font-semibold px-3 py-1 rounded-full">{{ $unggulan['kategori'] }}</span>
                    <span class="bg-white/10 border border-white/20 text-white text-[11px] font-bold px-2.5 py-1 rounded-full inline-flex items-center gap-1.5">
                        <img src="{{ asset('images/'.$jurusanInfo[$unggulan['jurusan']]['logo']) }}" alt="" class="w-4 h-4 object-contain">
                        {{ $unggulan['jurusan'] }}
                    </span>
                </div>
                <h2 class="text-xl md:text-3xl font-extrabold leading-snug mb-3">{{ $unggulan['title'] }}</h2>
                <div class="w-16 h-1 rounded-full bg-gradient-to-r from-blue-500 to-yellow-400 mb-4"></div>
                <p class="text-sm text-white/75 leading-relaxed mb-6 line-clamp-4">{{ $unggulan['deskripsi'] }}</p>
                <div class="flex items-center justify-between gap-4 mt-auto">
                    <span class="flex items-center gap-2 text-xs text-white/60">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="{{ $iconKalender }}"/></svg>
                        {{ $unggulan['tanggal'] }}
                    </span>
                    <span class="inline-flex items-center gap-2 bg-blue-600 group-hover:bg-yellow-400 group-hover:text-navy-900 text-white text-xs font-bold uppercase px-5 py-2.5 rounded-full transition">
                        Baca Selengkapnya &rarr;
                    </span>
                </div>
            </div>
        </article>
        @endif

        {{-- GRID --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-7" id="berita-grid">
            @foreach ($lainnya as $berita)
                <article id="{{ $berita['slug'] }}" data-kategori="{{ $berita['kategori'] }}" data-baca="{{ $berita['slug'] }}"
                         data-cari="{{ strtolower($berita['title'] . ' ' . $berita['deskripsi'] . ' ' . $berita['kategori'] . ' ' . $berita['jurusan']) }}"
                         class="berita-card reveal scroll-mt-40 relative rounded-2xl overflow-hidden bg-white shadow-md hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col group border border-gray-100 cursor-pointer">

                    <div class="relative overflow-hidden">
                        <img src="{{ $berita['img'] }}" alt="{{ $berita['title'] }}" class="w-full h-52 object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-navy-900/70 via-transparent to-transparent"></div>
                        <span class="absolute top-3 left-3 {{ $kategoriStyle[$berita['kategori']]['badge'] }} text-xs font-semibold px-3 py-1 rounded-full shadow">{{ $berita['kategori'] }}</span>
                        <span class="absolute top-3 right-3 bg-white/90 text-navy-900 text-[11px] font-bold px-2.5 py-1 rounded-full flex items-center gap-1">
                            <img src="{{ asset('images/'.$jurusanInfo[$berita['jurusan']]['logo']) }}" alt="" class="w-3.5 h-3.5 object-contain">
                            {{ $berita['jurusan'] }}
                        </span>
                        <span class="absolute bottom-3 left-3 inline-flex items-center gap-1.5 text-[11px] font-medium text-white">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="{{ $iconKalender }}"/></svg>
                            {{ $berita['tanggal'] }}
                        </span>
                        {{-- ikon "buka" muncul saat hover --}}
                        <span class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition" style="background:rgba(11,27,63,.45);">
                            <span class="bg-yellow-400 text-navy-900 text-xs font-extrabold px-4 py-2 rounded-full shadow-lg">Buka Berita</span>
                        </span>
                    </div>

                    <div class="relative p-5 flex flex-col flex-1 overflow-hidden">
                        <span class="absolute -bottom-4 -right-1 text-8xl font-black leading-none text-gray-100 select-none pointer-events-none">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        <h3 class="relative font-bold text-base text-gray-900 mb-2 leading-snug line-clamp-3 group-hover:text-blue-600 transition-colors">{{ $berita['title'] }}</h3>
                        <p class="relative text-sm text-gray-500 mb-5 flex-1 line-clamp-3">{{ $berita['deskripsi'] }}</p>
                        <span class="relative text-xs font-bold uppercase text-blue-600 inline-flex items-center gap-1 group-hover:gap-2 transition-all">
                            Baca Selengkapnya &rarr;
                        </span>
                    </div>
                    <span class="absolute bottom-0 left-0 h-1 w-0 group-hover:w-full transition-all duration-500 bg-gradient-to-r from-blue-600 to-yellow-400"></span>
                </article>
            @endforeach
        </div>

        <div id="empty-state" class="hidden text-center py-16">
            <span class="inline-flex w-16 h-16 rounded-full bg-blue-50 text-blue-600 items-center justify-center mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </span>
            <p class="font-bold text-navy-900 mb-1">Berita tidak ditemukan</p>
            <p class="text-sm text-gray-400 mb-5">Coba kata kunci lain atau pilih kategori berbeda.</p>
            <button type="button" id="reset-filter" class="text-sm font-semibold bg-blue-600 text-white px-5 py-2 rounded-full hover:bg-blue-700 transition">Tampilkan semua berita</button>
        </div>
    </section>

    {{-- POP-UP BERITA --}}
    <div id="modal" class="hidden fixed inset-0 z-[70] items-center justify-center p-4" style="background:rgba(7,15,40,.75);backdrop-filter:blur(6px);">
        <div class="modal-box bg-white rounded-3xl w-full overflow-hidden flex flex-col relative" style="max-width:780px;max-height:92vh;box-shadow:0 30px 80px rgba(0,0,0,.5);">

            {{-- FOTO UTUH (tidak terpotong) + latar blur dari foto yang sama --}}
            <div class="relative shrink-0 overflow-hidden" style="background:#0b1b3f;">
                <img id="m-bg" src="" alt="" aria-hidden="true"
                     class="absolute inset-0 w-full h-full object-cover" style="filter:blur(28px) brightness(.55);transform:scale(1.2);">
                <img id="m-img" src="" alt="" class="relative block mx-auto"
                     style="max-width:100%;max-height:55vh;width:auto;height:auto;object-fit:contain;">
                <button type="button" id="m-tutup" aria-label="Tutup"
                        class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/90 text-navy-900 font-bold text-xl hover:bg-yellow-400 transition shadow z-10">&times;</button>
            </div>

            <div class="px-6 md:px-8 pt-5 flex flex-wrap items-center gap-2 text-xs shrink-0">
                <span id="m-kat" class="font-semibold px-3 py-1 rounded-full"></span>
                <span id="m-jur" class="bg-gray-100 text-navy-900 font-bold px-2.5 py-1 rounded-full"></span>
                <span id="m-tgl" class="text-gray-400 ml-1"></span>
            </div>

            <div class="px-6 md:px-8 pt-3 pb-6 md:pb-8 overflow-y-auto">
                <h3 id="m-judul" class="text-xl md:text-2xl font-extrabold text-navy-900 leading-snug mb-3"></h3>
                <div class="w-16 h-1 rounded-full bg-gradient-to-r from-blue-600 to-yellow-400 mb-4"></div>
                <p id="m-isi" class="text-sm md:text-base text-gray-600 leading-relaxed" style="white-space:pre-line;"></p>
            </div>

            <div class="shrink-0 flex items-center justify-between gap-3 px-6 py-4 border-t border-gray-100 bg-gray-50">
                <button type="button" id="m-prev" class="text-sm font-semibold px-4 py-2 rounded-full border border-gray-200 bg-white text-gray-600 hover:border-blue-400 hover:text-blue-600 transition">&larr; Sebelumnya</button>
                <button type="button" id="m-salin" class="text-sm font-semibold px-4 py-2 rounded-full bg-navy-900 text-white hover:bg-blue-700 transition">Salin Link</button>
                <button type="button" id="m-next" class="text-sm font-semibold px-4 py-2 rounded-full border border-gray-200 bg-white text-gray-600 hover:border-blue-400 hover:text-blue-600 transition">Berikutnya &rarr;</button>
            </div>
        </div>
    </div>

    <script>
        const dataBerita = @json($dataModal);
        const urutan = @json($urutanSlug);
        const gayaKategori = @json(collect($kategoriStyle)->map(fn ($s) => $s['badge']));

        // offset bar filter = tinggi navbar
        const navbar = document.getElementById('navbar');
        const filterBar = document.getElementById('filterBar');
        const setOffset = () => { filterBar.style.top = navbar.offsetHeight + 'px'; };
        setOffset(); window.addEventListener('resize', setOffset);

        const buttons = document.querySelectorAll('.filter-btn');
        const cards = document.querySelectorAll('.berita-card');
        const emptyState = document.getElementById('empty-state');
        const resultCount = document.getElementById('result-count');
        const cari = document.getElementById('cari');
        let activeFilter = 'Semua';

        const setActiveButton = (btn) => {
            buttons.forEach(b => {
                b.classList.remove('bg-blue-600', 'text-white', 'border-blue-600', 'shadow-md');
                b.classList.add('bg-white', 'text-gray-500', 'border-gray-200');
                const c = b.querySelector('.filter-count'); c.classList.remove('bg-white/20'); c.classList.add('bg-gray-100');
            });
            btn.classList.add('bg-blue-600', 'text-white', 'border-blue-600', 'shadow-md');
            btn.classList.remove('bg-white', 'text-gray-500', 'border-gray-200');
            const c = btn.querySelector('.filter-count'); c.classList.add('bg-white/20'); c.classList.remove('bg-gray-100');
        };

        const applyFilter = () => {
            const q = cari.value.toLowerCase().trim();
            let n = 0;
            cards.forEach(card => {
                const show = (activeFilter === 'Semua' || card.dataset.kategori === activeFilter)
                          && (q === '' || card.dataset.cari.includes(q));
                card.style.display = show ? '' : 'none';
                if (show) n++;
            });
            emptyState.classList.toggle('hidden', n > 0);
            resultCount.textContent = 'Menampilkan ' + n + ' berita';
        };

        buttons.forEach(btn => btn.addEventListener('click', () => { activeFilter = btn.dataset.filter; setActiveButton(btn); applyFilter(); }));
        cari.addEventListener('input', applyFilter);
        document.getElementById('reset-filter').addEventListener('click', () => {
            cari.value = ''; document.querySelector('.filter-btn[data-filter="Semua"]').click();
        });

        // ===== POP-UP =====
        const modal = document.getElementById('modal');
        let sekarang = null;

        const bukaModal = (slug) => {
            const d = dataBerita[slug]; if (!d) return;
            sekarang = slug;
            document.getElementById('m-img').src = d.img;
            document.getElementById('m-bg').src = d.img;
            document.getElementById('m-judul').textContent = d.title;
            document.getElementById('m-isi').textContent = d.isi || '';
            document.getElementById('m-tgl').textContent = d.tanggal || '';
            document.getElementById('m-jur').textContent = d.jurusan;
            const k = document.getElementById('m-kat');
            k.textContent = d.kategori;
            k.className = 'font-semibold px-3 py-1 rounded-full ' + (gayaKategori[d.kategori] || 'bg-blue-600 text-white');
            const i = urutan.indexOf(slug);
            document.getElementById('m-prev').style.visibility = i > 0 ? 'visible' : 'hidden';
            document.getElementById('m-next').style.visibility = i < urutan.length - 1 ? 'visible' : 'hidden';
            document.querySelector('#modal .overflow-y-auto').scrollTop = 0;
            modal.classList.remove('hidden'); modal.classList.add('flex');
            modal.classList.remove('is-open'); void modal.offsetWidth; modal.classList.add('is-open');
            document.body.style.overflow = 'hidden';
            history.replaceState(null, '', '#' + slug);
        };
        const tutupModal = () => {
            modal.classList.add('hidden'); modal.classList.remove('flex', 'is-open');
            document.body.style.overflow = '';
            history.replaceState(null, '', location.pathname);
        };
        const geser = (arah) => { const i = urutan.indexOf(sekarang) + arah; if (urutan[i]) bukaModal(urutan[i]); };

        cards.forEach(c => c.addEventListener('click', () => bukaModal(c.dataset.baca)));
        document.getElementById('m-tutup').addEventListener('click', tutupModal);
        document.getElementById('m-prev').addEventListener('click', () => geser(-1));
        document.getElementById('m-next').addEventListener('click', () => geser(1));
        modal.addEventListener('click', e => { if (e.target === modal) tutupModal(); });
        document.addEventListener('keydown', e => {
            if (modal.classList.contains('hidden')) return;
            if (e.key === 'Escape') tutupModal();
            if (e.key === 'ArrowLeft') geser(-1);
            if (e.key === 'ArrowRight') geser(1);
        });
        document.getElementById('m-salin').addEventListener('click', function () {
            const url = location.origin + location.pathname + '#' + sekarang;
            const ok = () => { this.textContent = 'Link tersalin'; setTimeout(() => this.textContent = 'Salin Link', 1800); };
            (navigator.clipboard ? navigator.clipboard.writeText(url).then(ok) : (prompt('Salin link:', url), 0));
        });

        // animasi muncul saat di-scroll
        const reveals = document.querySelectorAll('.reveal');
        if ('IntersectionObserver' in window) {
            const io = new IntersectionObserver(es => es.forEach(e => {
                if (e.isIntersecting) { e.target.classList.add('is-visible'); io.unobserve(e.target); }
            }), { threshold: 0.08 });
            reveals.forEach(el => io.observe(el));
        } else { reveals.forEach(el => el.classList.add('is-visible')); }

        applyFilter();

        // datang dari link beranda (/berita#slug): langsung buka pop-up beritanya
        if (location.hash) {
            const slug = decodeURIComponent(location.hash.slice(1));
            if (dataBerita[slug]) bukaModal(slug);
        }
    </script>

</body>
</html>