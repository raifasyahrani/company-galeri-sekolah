@extends('admin.layout')
@section('title', 'Prestasi')

@section('header')
    <div>
        <h1 class="font-bold text-navy-900 text-lg">Prestasi</h1>
        <p class="text-xs text-gray-400">{{ $c['subtitle'] }}</p>
    </div>
    <a href="{{ route('admin.prestasi.create') }}"
       class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow-md shadow-blue-200 hover:-translate-y-0.5 hover:shadow-lg transition-all">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Tambah Prestasi
    </a>
@endsection

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-2xl shadow-sm p-5 flex items-center gap-4">
            <span class="w-12 h-12 rounded-xl bg-yellow-100 text-yellow-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21 12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2Z"/></svg>
            </span>
            <div>
                <p class="text-2xl font-extrabold text-navy-900 leading-none">{{ $items->count() }}</p>
                <p class="text-xs text-gray-500 mt-1">Total Prestasi</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-sm p-5 flex items-center gap-4">
            <span class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 011 1v14a1 1 0 01-1 1H5a1 1 0 01-1-1V6a1 1 0 011-1z"/></svg>
            </span>
            <div>
                <p class="text-2xl font-extrabold text-navy-900 leading-none">{{ $items->pluck('tahun')->unique()->count() }}</p>
                <p class="text-xs text-gray-500 mt-1">Tahun Berbeda</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-sm p-5 flex items-center">
            <div class="relative w-full">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="M21 21l-4.3-4.3"/></svg>
                <input id="cari" type="text" placeholder="Cari judul atau tahun..."
                       class="w-full border border-gray-200 rounded-xl pl-9 pr-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
            </div>
        </div>
    </div>

    <p class="text-xs text-gray-400 mb-4">Tiga prestasi terbaru (berlabel <span class="font-semibold text-yellow-600">Tampil di beranda</span>) ditampilkan di halaman depan.</p>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse ($items as $i => $p)
            <div data-cari="{{ strtolower($p->judul . ' ' . $p->tahun) }}"
                 class="kartu group bg-white rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col">
                <div class="relative h-52 bg-gray-100 overflow-hidden">
                    @if ($p->urlGambar())
                        <img src="{{ $p->urlGambar() }}" alt="{{ $p->judul }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300 text-sm">Belum ada foto</div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-navy-900/60 via-transparent to-transparent"></div>
                    <span class="absolute top-3 left-3 inline-flex items-center gap-1.5 bg-yellow-400 text-navy-900 text-[11px] font-extrabold px-3 py-1 rounded-full shadow">
                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21 12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2Z"/></svg>
                        {{ $p->tahun }}
                    </span>
                    @if ($i < 3)
                        <span class="absolute top-3 right-3 bg-white/90 text-emerald-600 text-[10px] font-bold px-2.5 py-1 rounded-full shadow">Tampil di beranda</span>
                    @endif
                </div>

                <div class="p-5 flex-1">
                    <h3 class="font-bold text-navy-900 leading-snug">{{ $p->judul }}</h3>
                    <span class="block mt-3 h-1 w-10 rounded-full bg-yellow-400"></span>
                </div>

                <div class="px-5 pb-5 flex gap-3">
                    <a href="{{ route('admin.prestasi.edit', $p->id) }}"
                       class="flex-1 text-center bg-blue-50 text-blue-700 font-semibold text-sm py-2 rounded-xl hover:bg-blue-600 hover:text-white transition">Edit</a>
                    <form action="{{ route('admin.prestasi.destroy', $p->id) }}" method="POST" class="flex-1"
                          onsubmit="return confirm('Hapus prestasi ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="w-full bg-red-50 text-red-600 font-semibold text-sm py-2 rounded-xl hover:bg-red-600 hover:text-white transition">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-2xl shadow-sm p-12 text-center text-gray-400">
                Belum ada prestasi. Klik "Tambah Prestasi" untuk memulai.
            </div>
        @endforelse
    </div>

    <p id="kosong" class="hidden text-center text-gray-400 mt-8">Tidak ada prestasi yang cocok.</p>

    <script>
        const cari = document.getElementById('cari');
        const kartu = document.querySelectorAll('.kartu');
        const kosong = document.getElementById('kosong');
        cari?.addEventListener('input', () => {
            const q = cari.value.toLowerCase().trim();
            let tampil = 0;
            kartu.forEach(k => {
                const cocok = k.dataset.cari.includes(q);
                k.classList.toggle('hidden', !cocok);
                if (cocok) tampil++;
            });
            kosong.classList.toggle('hidden', tampil > 0);
        });
    </script>
@endsection