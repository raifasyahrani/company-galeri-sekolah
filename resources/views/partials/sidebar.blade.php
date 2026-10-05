@php
    $menuAdmin = [
        ['route' => 'admin.dashboard', 'aktif' => 'admin.dashboard',  'label' => 'Dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
        ['route' => 'admin.berita',    'aktif' => 'admin.berita*',    'label' => 'Berita',    'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
        ['route' => 'admin.jurusan',   'aktif' => 'admin.jurusan*',   'label' => 'Jurusan',   'icon' => 'M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z'],
        ['route' => 'admin.prestasi',  'aktif' => 'admin.prestasi*',  'label' => 'Prestasi',  'icon' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z'],
        ['route' => 'admin.galeri',    'aktif' => 'admin.galeri*',    'label' => 'Galeri',    'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'],
        ['route' => 'admin.ekskul',    'aktif' => 'admin.ekskul*',    'label' => 'Ekskul',    'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
    ];
@endphp

<style>
    /* Sembunyikan batang scroll sidebar (tetap bisa digulung dengan mouse/touchpad jika layar sangat pendek) */
    .sidebar-scroll { scrollbar-width: none; -ms-overflow-style: none; overscroll-behavior: contain; }
    .sidebar-scroll::-webkit-scrollbar { display: none; width: 0; height: 0; }
</style>

<aside class="w-64 shrink-0 bg-navy-900 text-white flex flex-col relative"
       style="position: sticky; top: 0; height: 100vh; align-self: flex-start; overflow: hidden;">

    {{-- Hiasan cahaya latar --}}
    <div class="pointer-events-none absolute -top-24 -left-24 w-64 h-64 rounded-full bg-blue-500/20 blur-3xl"></div>
    <div class="pointer-events-none absolute -bottom-32 -right-24 w-72 h-72 rounded-full bg-indigo-500/10 blur-3xl"></div>

    {{-- Logo --}}
    <div class="relative shrink-0 flex items-center gap-3 px-5 py-4 border-b border-white/10">
        <div class="relative">
            <div class="absolute inset-0 rounded-2xl bg-blue-400/40 blur-md"></div>
            <img src="{{ asset('images/LOGO.png') }}" alt="Logo"
                 class="relative w-11 h-11 object-contain bg-white rounded-2xl p-1.5 ring-2 ring-white/20 shadow-lg">
        </div>
        <div class="leading-tight">
            <p class="font-extrabold tracking-wide text-sm">SMKN 4 BOGOR</p>
            <p class="text-[10px] font-semibold tracking-[0.2em] text-blue-300 mt-0.5">ADMIN PANEL</p>
        </div>
    </div>

    {{-- Menu --}}
    <nav class="sidebar-scroll relative flex-1 min-h-0 overflow-y-auto px-3 py-3">
        <p class="px-4 mb-2 text-[10px] font-bold uppercase tracking-[0.2em] text-blue-200/50">Menu Utama</p>

        <div class="space-y-0.5">
            @foreach ($menuAdmin as $m)
                @php $aktif = request()->routeIs($m['aktif']); @endphp
                <a href="{{ route($m['route']) }}"
                   class="group relative flex items-center gap-3 px-3 py-2 rounded-2xl text-sm font-semibold transition-all duration-200
                          {{ $aktif
                              ? 'bg-gradient-to-r from-blue-600 to-blue-500 text-white shadow-lg shadow-blue-900/40'
                              : 'text-slate-300 hover:bg-white/10 hover:text-white hover:translate-x-1' }}">

                    @if ($aktif)
                        <span class="absolute -left-3 top-1/2 -translate-y-1/2 w-1.5 h-6 rounded-r-full bg-white"></span>
                    @endif

                    <span class="inline-flex items-center justify-center w-7 h-7 rounded-xl transition-colors
                                 {{ $aktif ? 'bg-white/20' : 'bg-white/5 group-hover:bg-white/10' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $m['icon'] }}"/>
                        </svg>
                    </span>

                    <span class="flex-1">{{ $m['label'] }}</span>

                    @if ($aktif)
                        <span class="w-2 h-2 rounded-full bg-white shadow shadow-white/50"></span>
                    @endif
                </a>
            @endforeach
        </div>
    </nav>

    {{-- Bagian bawah (selalu terlihat) --}}
    <div class="relative shrink-0 px-3 pb-2 pt-2 border-t border-white/10 space-y-0.5">
        <a href="{{ url('/') }}" target="_blank"
           class="group flex items-center gap-3 px-3 py-2 rounded-2xl text-sm font-semibold text-slate-300 hover:bg-white/10 hover:text-white transition">
            <span class="inline-flex items-center justify-center w-7 h-7 rounded-xl bg-white/5 group-hover:bg-white/10 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </span>
            Lihat Website
        </a>

        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit"
                    class="group w-full flex items-center gap-3 px-3 py-2 rounded-2xl text-sm font-semibold text-red-300 hover:bg-red-500/15 hover:text-red-200 transition">
                <span class="inline-flex items-center justify-center w-7 h-7 rounded-xl bg-red-500/10 group-hover:bg-red-500/20 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                </span>
                Logout
            </button>
        </form>
    </div>
</aside>