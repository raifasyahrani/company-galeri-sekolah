<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri - SMKN 4 Bogor</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-800 bg-gray-50">

    @include('partials.navbar')

    {{-- HERO GALERI --}}
    <section class="relative h-72 md:h-96 overflow-hidden">
        <img src="{{ asset('images/lapangan miring.JPG') }}" alt="Galeri SMKN 4 Bogor" class="absolute inset-0 w-full h-full object-cover scale-105">
        <div class="absolute inset-0 bg-gradient-to-r from-navy-900 via-navy-900/85 to-navy-900/40"></div>

        {{-- watermark --}}
        <span class="absolute right-6 md:right-16 bottom-0 text-[8rem] md:text-[13rem] font-black leading-none text-white/5 select-none pointer-events-none">FOTO</span>

        <div class="relative z-10 h-full flex flex-col justify-center px-8 md:px-16 pb-10 text-white">
            <span class="inline-flex items-center gap-2 self-start bg-white/10 backdrop-blur border border-white/20 text-yellow-400 font-semibold text-xs px-4 py-1.5 rounded-full mb-4">
                <span class="w-2 h-2 rounded-full bg-yellow-400 animate-pulse"></span>
                Dokumentasi Sekolah
            </span>
            <h1 class="text-3xl md:text-5xl font-extrabold leading-tight mb-4 max-w-2xl">Galeri SMKN 4 Bogor</h1>
            <div class="w-20 h-1.5 rounded-full bg-gradient-to-r from-blue-600 to-yellow-400 mb-4"></div>
            <p class="text-sm md:text-base text-white/80 max-w-lg">Kumpulan foto kegiatan, prestasi, fasilitas, dan momen berharga di SMKN 4 Bogor.</p>
        </div>
    </section>

    @php
        $kategoriGaleri = ['Semua', 'Kegiatan', 'Prestasi', 'Fasilitas', 'Ekstrakulikuler', 'Jurusan'];

        // Gaya badge & ikon per kategori
        $kategoriStyle = [
            'Semua'           => ['badge' => 'bg-navy-900 text-white',      'icon' => 'M3 3h8v8H3V3Zm10 0h8v8h-8V3ZM3 13h8v8H3v-8Zm10 0h8v8h-8v-8Z'],
            'Kegiatan'        => ['badge' => 'bg-blue-600 text-white',      'icon' => 'M7 2v2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-2V2h-2v2H9V2H7Zm12 8H5v10h14V10Z'],
            'Prestasi'        => ['badge' => 'bg-yellow-400 text-navy-900', 'icon' => 'M5 3h14v3a5 5 0 0 1-4 4.9V13a3 3 0 0 0 2 2.8V18H7v-2.2A3 3 0 0 0 9 13v-2.1A5 5 0 0 1 5 6V3Zm-3 2h2v1a3 3 0 0 0 2 2.8V7H4V5H2Zm18 0h2v2h-2v1.8A3 3 0 0 0 22 6V5h-2ZM8 20h8v2H8v-2Z'],
            'Fasilitas'       => ['badge' => 'bg-navy-900 text-white',      'icon' => 'M3 21V8l9-5 9 5v13h-6v-6H9v6H3Z'],
            'Ekstrakulikuler' => ['badge' => 'bg-sky-500 text-white',       'icon' => 'M12 2l3 6.5 7 .9-5.2 4.8 1.4 7L12 17.8 5.8 21.2l1.4-7L2 9.4l7-.9L12 2Z'],
            'Jurusan'         => ['badge' => 'bg-indigo-600 text-white',    'icon' => 'M12 3 1 9l11 6 9-4.9V17h2V9L12 3Zm-6 9.2V16c0 1.7 2.7 3 6 3s6-1.3 6-3v-3.8l-6 3.3-6-3.3Z'],
        ];

        // ===== DATA DARI DATABASE (tabel galeris, dikirim GaleriPageController) =====
        $daftarGaleri = collect($galeriList ?? [])->map(function ($g) use ($kategoriGaleri) {
            $kat = $g->kategori ?? null;
            $kat = ($kat && $kat !== 'Semua' && in_array($kat, $kategoriGaleri, true)) ? $kat : 'Kegiatan';

            $img = method_exists($g, 'urlGambar')
                ? $g->urlGambar('gambar')
                : ($g->gambar ? asset('storage/' . $g->gambar) : null);

            return ['judul' => $g->judul, 'kategori' => $kat, 'img' => $img];
        })->filter(fn ($f) => !empty($f['img']))->values();

        $jumlah = $daftarGaleri->countBy('kategori');
        $total  = $daftarGaleri->count();
    @endphp

    {{-- KARTU KATEGORI / FILTER (menumpuk di atas hero) --}}
    <section class="relative z-20 px-8 md:px-16 -mt-12">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4" id="filter-galeri">
                @foreach ($kategoriGaleri as $kategori)
                    @php $n = $kategori === 'Semua' ? $total : ($jumlah[$kategori] ?? 0); @endphp
                    <button
                        type="button"
                        data-filter="{{ $kategori }}"
                        class="filter-btn-galeri text-left rounded-2xl p-4 border-b-4 shadow-lg hover:-translate-y-1 transition-all duration-300 flex items-center gap-3 {{ $loop->first ? 'bg-navy-900 text-white border-yellow-400' : 'bg-white text-navy-900 border-transparent' }}">
                        <span class="filter-icon w-11 h-11 rounded-xl flex items-center justify-center shrink-0 {{ $loop->first ? 'bg-yellow-400 text-navy-900' : 'bg-blue-50 text-blue-600' }}">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="{{ $kategoriStyle[$kategori]['icon'] }}"/></svg>
                        </span>
                        <span class="min-w-0">
                            <span class="block text-sm font-extrabold leading-tight truncate">{{ $kategori }}</span>
                            <span class="filter-sub block text-[11px] mt-1 {{ $loop->first ? 'text-white/70' : 'text-gray-500' }}">{{ $n }} foto</span>
                        </span>
                    </button>
                @endforeach
            </div>
        </div>
    </section>

    {{-- GRID GALERI --}}
    <section class="px-8 md:px-16 pt-14 pb-16">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-8">
                <div>
                    <span class="inline-block bg-blue-50 text-blue-600 text-xs font-bold px-3 py-1 rounded-full mb-3">Koleksi Foto</span>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-navy-900">Momen Berharga di Sekolah</h2>
                    <div class="w-16 h-1 rounded-full bg-gradient-to-r from-blue-600 to-yellow-400 mt-3"></div>
                </div>
                <p class="text-xs text-gray-400" id="result-count-galeri"></p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 auto-rows-[10rem] md:auto-rows-[11rem] grid-flow-dense gap-4" id="galeri-grid">
                @foreach ($daftarGaleri as $index => $foto)
                    <button
                        type="button"
                        class="galeri-item relative rounded-2xl overflow-hidden shadow-md hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 group text-left bg-gray-200"
                        data-kategori="{{ $foto['kategori'] }}"
                        data-img="{{ $foto['img'] }}"
                        data-judul="{{ $foto['judul'] }}">
                        <img src="{{ $foto['img'] }}" alt="{{ $foto['judul'] }}" loading="lazy" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">

                        {{-- gradasi bawah --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-navy-900/85 via-navy-900/10 to-transparent opacity-60 group-hover:opacity-100 transition-opacity duration-300"></div>

                        {{-- badge kategori --}}
                        <span class="absolute top-3 left-3 {{ $kategoriStyle[$foto['kategori']]['badge'] }} text-[11px] font-semibold px-2.5 py-1 rounded-full shadow">{{ $foto['kategori'] }}</span>

                        {{-- ikon perbesar --}}
                        <span class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white/90 text-navy-900 flex items-center justify-center opacity-0 scale-75 group-hover:opacity-100 group-hover:scale-100 transition-all duration-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4h4M20 8V4h-4M4 16v4h4M20 16v4h-4"/></svg>
                        </span>

                        {{-- judul --}}
                        <div class="absolute bottom-0 left-0 right-0 p-4 translate-y-2 group-hover:translate-y-0 opacity-0 group-hover:opacity-100 transition-all duration-300">
                            <p class="text-white text-sm font-bold leading-snug">{{ $foto['judul'] }}</p>
                        </div>

                        {{-- garis aksen biru ke kuning --}}
                        <span class="absolute bottom-0 left-0 h-1 w-0 group-hover:w-full transition-all duration-500 bg-gradient-to-r from-blue-600 to-yellow-400"></span>
                    </button>
                @endforeach
            </div>

            {{-- EMPTY STATE --}}
            <div id="empty-state-galeri" class="hidden text-center py-16">
                <span class="inline-flex w-16 h-16 rounded-full bg-blue-50 text-blue-600 items-center justify-center mb-4">
                    <svg class="w-8 h-8" viewBox="0 0 24 24" fill="currentColor"><path d="{{ $kategoriStyle['Semua']['icon'] }}"/></svg>
                </span>
                <p class="font-bold text-navy-900 mb-1">Foto belum tersedia</p>
                <p class="text-sm text-gray-400">Belum ada foto untuk kategori ini.</p>
            </div>
        </div>
    </section>

    {{-- LIGHTBOX --}}
    <div id="lightbox" class="fixed inset-0 z-[999] bg-navy-900/95 hidden items-center justify-center p-4 md:p-8">
        <button id="lightbox-close" type="button" class="absolute top-5 right-6 w-11 h-11 rounded-full bg-white/10 hover:bg-white/20 text-white text-2xl leading-none flex items-center justify-center transition" aria-label="Tutup">&times;</button>

        <button id="lightbox-prev" type="button" class="absolute left-3 md:left-8 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-white/10 hover:bg-yellow-400 hover:text-navy-900 text-white flex items-center justify-center transition" aria-label="Sebelumnya">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
        </button>
        <button id="lightbox-next" type="button" class="absolute right-3 md:right-8 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-white/10 hover:bg-yellow-400 hover:text-navy-900 text-white flex items-center justify-center transition" aria-label="Berikutnya">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
        </button>

        <div class="max-w-4xl w-full">
            <img id="lightbox-img" src="" alt="" class="w-full max-h-[72vh] object-contain rounded-2xl shadow-2xl">
            <div class="mt-5 text-center">
                <span id="lightbox-kategori" class="inline-block bg-yellow-400 text-navy-900 text-xs font-bold px-3 py-1 rounded-full mb-2"></span>
                <p id="lightbox-judul" class="text-white font-bold text-lg"></p>
                <div class="w-16 h-1 rounded-full bg-gradient-to-r from-blue-600 to-yellow-400 mx-auto mt-3 mb-2"></div>
                <p id="lightbox-counter" class="text-white/60 text-xs"></p>
            </div>
        </div>
    </div>

    <script>
        const filterButtons = document.querySelectorAll('.filter-btn-galeri');
        const galeriGrid = document.getElementById('galeri-grid');
        const galeriItems = Array.from(document.querySelectorAll('.galeri-item'));
        const emptyStateGaleri = document.getElementById('empty-state-galeri');
        const resultCount = document.getElementById('result-count-galeri');

        const activeBtn = ['bg-navy-900', 'text-white', 'border-yellow-400'];
        const inactiveBtn = ['bg-white', 'text-navy-900', 'border-transparent'];
        const activeIcon = ['bg-yellow-400', 'text-navy-900'];
        const inactiveIcon = ['bg-blue-50', 'text-blue-600'];

        // ===== Tata letak mozaik (ukuran foto bervariasi) =====
        // - Kurang dari 5 foto  : semua foto berukuran sedang yang sama (tidak ada yang raksasa)
        // - 5 foto atau lebih   : pola berulang 8 foto = 1 besar (2x2), 1 lebar (2x1), 6 kecil (1x1)
        //   (pola ini mengisi grid 4 kolom dengan rapi tanpa lubang)
        const spanClasses = ['col-span-2', 'md:row-span-2'];

        const applyLayout = (visibleItems) => {
            galeriItems.forEach(el => el.classList.remove(...spanClasses));

            const n = visibleItems.length;
            if (n === 0) return;

            if (n < 5) {
                visibleItems.forEach(el => el.classList.add('md:row-span-2'));
                return;
            }

            const full = Math.floor(n / 8) * 8;   // jumlah foto dalam siklus penuh
            const tail = n - full;                // sisa foto di akhir

            visibleItems.forEach((el, k) => {
                if (k < full) {
                    const p = k % 8;
                    if (p === 0) el.classList.add('col-span-2', 'md:row-span-2'); // besar
                    else if (p === 5) el.classList.add('col-span-2');             // lebar
                } else if (tail >= 5 && k - full === 0) {
                    el.classList.add('col-span-2', 'md:row-span-2');              // besar untuk sisa
                }
            });
        };

        const getVisibleItems = () => galeriItems.filter(el => el.style.display !== 'none');

        const setActive = (btn) => {
            filterButtons.forEach(b => {
                const on = b === btn;
                b.classList.remove(...(on ? inactiveBtn : activeBtn));
                b.classList.add(...(on ? activeBtn : inactiveBtn));

                const icon = b.querySelector('.filter-icon');
                icon.classList.remove(...(on ? inactiveIcon : activeIcon));
                icon.classList.add(...(on ? activeIcon : inactiveIcon));

                const sub = b.querySelector('.filter-sub');
                sub.classList.toggle('text-white/70', on);
                sub.classList.toggle('text-gray-500', !on);
            });
        };

        const applyFilter = (filter) => {
            galeriItems.forEach(item => {
                const match = filter === 'Semua' || item.dataset.kategori === filter;
                item.style.display = match ? '' : 'none';
            });
            const visible = getVisibleItems();
            applyLayout(visible);
            emptyStateGaleri.classList.toggle('hidden', visible.length > 0);
            galeriGrid.classList.toggle('hidden', visible.length === 0);
            resultCount.textContent = 'Menampilkan ' + visible.length + ' foto';
        };

        filterButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                setActive(btn);
                applyFilter(btn.dataset.filter);
            });
        });

        applyFilter('Semua');

        // ===== Lightbox dengan navigasi =====
        const lightbox = document.getElementById('lightbox');
        const lightboxImg = document.getElementById('lightbox-img');
        const lightboxJudul = document.getElementById('lightbox-judul');
        const lightboxKategori = document.getElementById('lightbox-kategori');
        const lightboxCounter = document.getElementById('lightbox-counter');

        let currentList = [];
        let currentIndex = 0;

        const showPhoto = (i) => {
            currentIndex = (i + currentList.length) % currentList.length;
            const item = currentList[currentIndex];
            lightboxImg.src = item.dataset.img;
            lightboxImg.alt = item.dataset.judul;
            lightboxJudul.textContent = item.dataset.judul;
            lightboxKategori.textContent = item.dataset.kategori;
            lightboxCounter.textContent = (currentIndex + 1) + ' / ' + currentList.length;
        };

        const openLightbox = (item) => {
            currentList = getVisibleItems();
            showPhoto(currentList.indexOf(item));
            lightbox.classList.remove('hidden');
            lightbox.classList.add('flex');
        };

        const closeLightbox = () => {
            lightbox.classList.add('hidden');
            lightbox.classList.remove('flex');
        };

        galeriItems.forEach(item => item.addEventListener('click', () => openLightbox(item)));

        document.getElementById('lightbox-close').addEventListener('click', closeLightbox);
        document.getElementById('lightbox-prev').addEventListener('click', (e) => { e.stopPropagation(); showPhoto(currentIndex - 1); });
        document.getElementById('lightbox-next').addEventListener('click', (e) => { e.stopPropagation(); showPhoto(currentIndex + 1); });

        lightbox.addEventListener('click', (e) => {
            if (e.target === lightbox) closeLightbox();
        });

        document.addEventListener('keydown', (e) => {
            if (lightbox.classList.contains('hidden')) return;
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowLeft') showPhoto(currentIndex - 1);
            if (e.key === 'ArrowRight') showPhoto(currentIndex + 1);
        });
    </script>

</body>
</html>