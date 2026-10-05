{{-- NAVBAR PUBLIK --}}
<header class="sticky top-0 z-50 bg-white shadow-sm">
    <div class="flex items-center justify-between px-8 py-3">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/LOGO.png') }}" alt="Logo SMKN 4 Bogor" class="w-12 h-12 object-contain">
            <div class="leading-tight">
                <p class="font-extrabold text-navy-900 text-lg">SMKN 4 BOGOR</p>
                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest">Unggul, Kompeten, Berkarakter</p>
            </div>
        </div>
        <nav class="hidden md:flex items-center gap-6 text-sm font-semibold text-gray-500">
            <a href="{{ route('welcome') }}"
               class="pb-1 border-b-2 transition {{ request()->routeIs('welcome') ? 'text-blue-600 border-blue-600' : 'border-transparent hover:text-blue-600' }}">
                Beranda
            </a>
            <a href="{{ route('profil') }}"
               class="pb-1 border-b-2 transition {{ request()->routeIs('profil') ? 'text-blue-600 border-blue-600' : 'border-transparent hover:text-blue-600' }}">
                Profil
            </a>
            <a href="{{ route('berita') }}"
               class="pb-1 border-b-2 transition {{ request()->routeIs('berita') ? 'text-blue-600 border-blue-600' : 'border-transparent hover:text-blue-600' }}">
                Berita
            </a>
            <a href="{{ route('jurusan') }}"
               class="pb-1 border-b-2 transition {{ request()->routeIs('jurusan') ? 'text-blue-600 border-blue-600' : 'border-transparent hover:text-blue-600' }}">
                Jurusan
            </a>
            <a href="{{ route('galeri') }}"
               class="pb-1 border-b-2 transition {{ request()->routeIs('galeri') ? 'text-blue-600 border-blue-600' : 'border-transparent hover:text-blue-600' }}">
                Galeri
            </a>
            <a href="{{ route('ekstrakulikuler') }}"
               class="pb-1 border-b-2 transition {{ request()->routeIs('ekstrakulikuler') ? 'text-blue-600 border-blue-600' : 'border-transparent hover:text-blue-600' }}">
                Ekstrakulikuler
            </a>
            <a href="{{ route('admin.login') }}" class="flex items-center gap-2 bg-blue-600 text-white font-semibold px-4 py-2 rounded-full hover:bg-blue-700 transition">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                Login Sebagai Admin
            </a>
        </nav>
    </div>
</header>