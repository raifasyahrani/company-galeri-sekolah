<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SMKN 4 Bogor</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-800 bg-gray-100">

    <div class="flex min-h-screen">

        {{-- SIDEBAR (dari partial, menu aktif otomatis) --}}
        @include('partials.sidebar')

        {{-- MAIN CONTENT --}}
        <main class="flex-1 min-w-0">
            {{-- TOPBAR --}}
            <header class="bg-white shadow-sm px-8 py-4 flex items-center justify-between" style="position:relative;z-index:30;">
                <div>
                    <h1 class="font-bold text-navy-900 text-xl">Dashboard</h1>
                    <p class="text-sm text-gray-400">Selamat datang kembali, Admin.</p>
                </div>

                {{-- AVATAR ADMIN (klik untuk membuka kartu akun) --}}
                <div id="akunWrap" style="position:relative;">
                    <button type="button" id="akunBtn" title="Akun Admin" aria-label="Akun Admin"
                            class="w-11 h-11 rounded-full bg-gradient-to-br from-blue-600 to-blue-700 text-white flex items-center justify-center font-bold text-base shadow-md shadow-blue-200 hover:scale-105 hover:shadow-lg transition-all duration-200"
                            style="outline:none;">
                        A
                    </button>

                    <div id="akunMenu"
                         style="display:none;position:absolute;right:0;top:calc(100% + 12px);width:300px;background:#fff;border-radius:20px;box-shadow:0 20px 50px rgba(15,23,42,.18);border:1px solid #f1f5f9;overflow:hidden;">
                        <div style="background:linear-gradient(120deg,#0b1b3f,#1d4ed8);padding:20px;color:#fff;">
                            <div class="flex items-center gap-3">
                                <span class="w-12 h-12 rounded-full bg-white text-blue-700 flex items-center justify-center font-extrabold text-lg">A</span>
                                <div class="min-w-0">
                                    <p class="font-bold leading-tight">Admin SMKN 4</p>
                                    <p class="text-xs text-blue-100 truncate">{{ session('admin_email') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-5 space-y-3.5 text-sm">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">Email</span>
                                <span class="font-semibold text-navy-900 truncate" style="max-width:170px;">{{ session('admin_email') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">Role</span>
                                <span class="font-semibold text-navy-900">Administrator</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">Status</span>
                                <span class="inline-flex items-center gap-1.5 font-semibold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full text-xs">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Aktif
                                </span>
                            </div>
                        </div>

                        <form action="{{ route('admin.logout') }}" method="POST" class="px-5 pb-5">
                            @csrf
                            <button class="w-full flex items-center justify-center gap-2 bg-red-50 text-red-600 font-semibold text-sm py-2.5 rounded-xl hover:bg-red-600 hover:text-white transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <div class="p-8">

                @php
                    /*
                     * Semua kartu & tombol didaftarkan di sini, lalu difilter dengan Route::has().
                     * Kalau route-nya belum dibuat (misalnya admin.produk), item itu otomatis
                     * TIDAK ditampilkan dan tidak menimbulkan error "Route not defined".
                     */
                    $ada = fn ($nama) => \Illuminate\Support\Facades\Route::has($nama);

                    $stats = collect([
                        ['label' => 'Total Berita', 'value' => $totalBerita ?? 0, 'route' => 'admin.berita', 'color' => 'blue',
                         'icon' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l6 6v10a2 2 0 01-2 2z'],
                        ['label' => 'Total Produk', 'value' => $totalProduk ?? 0, 'route' => 'admin.produk', 'color' => 'orange',
                         'icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z'],
                        ['label' => 'Total Jurusan', 'value' => $totalJurusan ?? 0, 'route' => 'admin.jurusan', 'color' => 'green',
                         'icon' => 'M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.42A12.083 12.083 0 0121 19a12.083 12.083 0 01-9 5 12.083 12.083 0 01-9-5 12.083 12.083 0 012.84-8.42L12 14z'],
                        ['label' => 'Total Ekstrakurikuler', 'value' => $totalEkskul ?? 0, 'route' => 'admin.ekskul', 'color' => 'yellow',
                         'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                        ['label' => 'Foto Galeri', 'value' => $totalGaleri ?? 0, 'route' => 'admin.galeri', 'color' => 'purple',
                         'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 8h16M4 8a2 2 0 00-2 2v8a2 2 0 002 2h16a2 2 0 002-2v-8a2 2 0 00-2-2M4 8V6a2 2 0 012-2h12a2 2 0 012 2v2'],
                    ])->filter(fn ($stat) => $ada($stat['route']));

                    $colorMap = [
                        'blue'   => 'bg-blue-100 text-blue-600',
                        'orange' => 'bg-orange-100 text-orange-600',
                        'green'  => 'bg-emerald-100 text-emerald-600',
                        'yellow' => 'bg-yellow-100 text-yellow-600',
                        'purple' => 'bg-purple-100 text-purple-600',
                    ];

                    $borderMap = [
                        'blue'   => 'border-blue-500',
                        'orange' => 'border-orange-400',
                        'green'  => 'border-emerald-500',
                        'yellow' => 'border-yellow-400',
                        'purple' => 'border-purple-400',
                    ];

                    $plus   = 'M12 4v16m8-8H4';
                    $pensil = 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z';

                    $quickActions = collect([
                        ['label' => 'Tambah Berita',  'route' => 'admin.berita.create',  'icon' => $plus],
                        ['label' => 'Tambah Jurusan', 'route' => 'admin.jurusan.create', 'icon' => $plus],
                        ['label' => 'Tambah Produk',  'route' => 'admin.produk.create',  'icon' => $plus],
                        ['label' => 'Tambah Foto',    'route' => 'admin.galeri.create',  'icon' => $plus],
                        ['label' => 'Tambah Ekskul',  'route' => 'admin.ekskul.create',  'icon' => $plus],
                        ['label' => 'Edit Jurusan',   'route' => 'admin.jurusan',        'icon' => $pensil],
                        ['label' => 'Edit Profil',    'route' => 'admin.profil',         'icon' => $pensil],
                    ])->filter(fn ($action) => $ada($action['route']));

                    $hariIni = \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y');
                    $totalData = $stats->sum('value');
                @endphp

                {{-- BANNER SAMBUTAN --}}
                <div class="relative overflow-hidden rounded-3xl p-7 mb-8 text-white shadow-lg"
                     style="background: linear-gradient(120deg, #0b1b3f 0%, #1d4ed8 70%, #3b82f6 100%);">
                    <div class="absolute rounded-full" style="right:-60px;top:-60px;width:220px;height:220px;background:rgba(255,255,255,.08);"></div>
                    <div class="absolute rounded-full" style="right:120px;bottom:-90px;width:180px;height:180px;background:rgba(250,204,21,.15);"></div>
                    <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-widest text-blue-200">{{ $hariIni }}</p>
                            <h2 class="text-2xl md:text-3xl font-extrabold mt-1">Halo, Admin SMKN 4 Bogor</h2>
                            <p class="text-sm text-blue-100 mt-1">Kelola seluruh konten website sekolah dari satu tempat.</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="rounded-2xl px-5 py-3 text-center" style="background:rgba(255,255,255,.12);">
                                <p class="text-2xl font-extrabold leading-none">{{ $totalData }}</p>
                                <p class="text-[11px] text-blue-100 mt-1">Total Data</p>
                            </div>
                            @if ($ada('welcome'))
                                <a href="{{ route('welcome') }}" target="_blank"
                                   class="inline-flex items-center gap-2 bg-yellow-400 text-navy-900 font-bold text-sm px-5 py-3 rounded-2xl shadow-md hover:bg-yellow-300 hover:-translate-y-0.5 transition-all">
                                    Lihat Website
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- STAT CARDS --}}
                <div class="grid grid-cols-[repeat(auto-fit,minmax(13rem,1fr))] gap-5 mb-8">
                    @foreach ($stats as $stat)
                        <a href="{{ route($stat['route']) }}"
                           class="group bg-white rounded-2xl shadow-sm p-5 flex items-center gap-4 border-b-4 {{ $borderMap[$stat['color']] }} hover:shadow-lg hover:-translate-y-1 transition-all duration-200">
                            <span class="w-14 h-14 rounded-2xl flex items-center justify-center shrink-0 {{ $colorMap[$stat['color']] }} group-hover:scale-110 transition-transform duration-200">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"/></svg>
                            </span>
                            <div class="min-w-0">
                                <p class="text-3xl font-extrabold text-navy-900 leading-none">{{ $stat['value'] }}</p>
                                <p class="text-xs text-gray-500 mt-1.5">{{ $stat['label'] }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>

                {{-- AKSI CEPAT + AKTIVITAS TERKINI --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm p-6">
                        <div class="flex items-center justify-between mb-5">
                            <div>
                                <h2 class="font-bold text-navy-900 text-lg">Aksi Cepat</h2>
                                <p class="text-xs text-gray-400">Pintasan untuk tugas yang sering dipakai</p>
                            </div>
                            <span class="text-[11px] font-bold px-2.5 py-1 rounded-full bg-gray-100 text-gray-500 uppercase tracking-wide">{{ $quickActions->count() }} Menu</span>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            @foreach ($quickActions as $action)
                                @php $isTambah = $action['icon'] === $plus; @endphp
                                <a href="{{ route($action['route']) }}"
                                   class="group flex flex-col items-center gap-3 p-5 rounded-2xl border border-gray-100 hover:-translate-y-1 hover:shadow-md transition-all duration-200 text-center
                                          {{ $isTambah ? 'hover:border-blue-300 hover:bg-blue-50' : 'hover:border-amber-300 hover:bg-amber-50' }}">
                                    <span class="w-12 h-12 rounded-2xl flex items-center justify-center transition-colors
                                                 {{ $isTambah ? 'bg-blue-100 text-blue-600 group-hover:bg-blue-600 group-hover:text-white' : 'bg-amber-100 text-amber-600 group-hover:bg-amber-500 group-hover:text-white' }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $action['icon'] }}"/></svg>
                                    </span>
                                    <span class="text-xs font-semibold text-navy-900">{{ $action['label'] }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    {{-- AKTIVITAS TERKINI --}}
                    @include('admin.partials.aktivitas')
                </div>

            </div>
        </main>
    </div>

    <script>
        // kartu akun admin: buka/tutup saat avatar diklik
        (function () {
            const wrap = document.getElementById('akunWrap');
            const btn  = document.getElementById('akunBtn');
            const menu = document.getElementById('akunMenu');
            if (!wrap || !btn || !menu) return;

            const tutup = () => { menu.style.display = 'none'; };

            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                menu.style.display = (menu.style.display === 'none') ? 'block' : 'none';
            });
            document.addEventListener('click', (e) => { if (!wrap.contains(e.target)) tutup(); });
            document.addEventListener('keydown', (e) => { if (e.key === 'Escape') tutup(); });
        })();
    </script>

</body>
</html>