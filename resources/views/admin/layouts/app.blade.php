<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - SMKN 4 Bogor')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-800 bg-gray-100">

    @php
        $menuItems = [
            ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
            ['route' => 'admin.profil', 'label' => 'Profil', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
            ['route' => 'admin.berita', 'label' => 'Berita', 'icon' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l6 6v10a2 2 0 01-2 2zM9 12h6M9 16h6M9 8h2'],
            ['route' => 'admin.jurusan', 'label' => 'Jurusan', 'icon' => 'M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.42A12.083 12.083 0 0121 19a12.083 12.083 0 01-9 5 12.083 12.083 0 01-9-5 12.083 12.083 0 012.84-8.42L12 14z'],
            ['route' => 'admin.galeri', 'label' => 'Galeri', 'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 8h16M4 8a2 2 0 00-2 2v8a2 2 0 002 2h16a2 2 0 002-2v-8a2 2 0 00-2-2M4 8V6a2 2 0 012-2h12a2 2 0 012 2v2'],
            ['route' => 'admin.ekskul', 'label' => 'Ekskul', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
        ];
    @endphp

    <div class="flex min-h-screen">

        {{-- SIDEBAR --}}
        <aside class="w-64 bg-navy-900 text-white flex flex-col shrink-0 sticky top-0 h-screen self-start">
            {{-- Logo: klik untuk kembali ke Dashboard --}}
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-6 py-5 border-b border-white/10">
                <span class="w-10 h-10 rounded-lg bg-white flex items-center justify-center p-1.5 shrink-0">
                    <img src="{{ asset('images/LOGO.png') }}" alt="Logo" class="w-full h-full object-contain">
                </span>
                <div class="leading-tight">
                    <p class="font-bold text-sm">SMKN 4 BOGOR</p>
                    <p class="text-[10px] text-blue-300 uppercase tracking-wide">Admin Panel</p>
                </div>
            </a>

            <nav class="flex-1 px-3 py-5 space-y-1 overflow-y-auto">
                @foreach ($menuItems as $item)
                    {{-- Aktif di halaman itu sendiri DAN turunannya (mis. admin.berita.create, admin.berita.edit) --}}
                    @php $active = request()->routeIs($item['route'], $item['route'].'.*'); @endphp
                    <a href="{{ route($item['route']) }}"
                       @if ($active) aria-current="page" @endif
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition {{ $active ? 'bg-blue-600 text-white font-semibold shadow-md' : 'text-white/70 hover:bg-white/5 hover:text-white font-medium' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/></svg>
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>

            <div class="px-3 py-5 border-t border-white/10">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-red-300 hover:bg-red-500/10 hover:text-red-200 text-sm font-semibold transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- MAIN CONTENT --}}
        <main class="flex-1 min-w-0">
            {{-- TOPBAR --}}
            <header class="bg-white shadow-sm px-8 py-4 flex items-center justify-between">
                <div>
                    <h1 class="font-bold text-navy-900 text-lg">@yield('heading', 'Dashboard')</h1>
                    <p class="text-xs text-gray-400">@yield('subtitle')</p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="w-9 h-9 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-sm">A</span>
                    <div class="text-right">
                        <p class="text-sm font-semibold text-navy-900">Admin SMKN 4</p>
                        <p class="text-xs text-gray-400">{{ session('admin_email') }}</p>
                    </div>
                </div>
            </header>

            @section('content')
        </main>
    </div>

</body>
</html>