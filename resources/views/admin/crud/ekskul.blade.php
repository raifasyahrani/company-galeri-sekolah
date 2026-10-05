@extends('admin.layout')
@section('title', 'Ekskul')

@section('header')
    <div>
        <h1 class="font-bold text-navy-900 text-lg">Ekskul</h1>
        <p class="text-xs text-gray-400">{{ $c['subtitle'] }}</p>
    </div>
    <a href="{{ route('admin.ekskul.create') }}"
       class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow-md shadow-blue-200 hover:-translate-y-0.5 hover:shadow-lg transition-all">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Tambah Ekskul
    </a>
@endsection

@section('content')
    {{-- RINGKASAN + PENCARIAN --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-2xl shadow-sm p-5 flex items-center gap-4">
            <span class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </span>
            <div>
                <p class="text-2xl font-extrabold text-navy-900 leading-none">{{ $items->count() }}</p>
                <p class="text-xs text-gray-500 mt-1">Total Ekskul</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-sm p-5 flex items-center gap-4">
            <span class="w-12 h-12 rounded-xl bg-yellow-100 text-yellow-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 100-8 4 4 0 000 8z"/></svg>
            </span>
            <div>
                <p class="text-2xl font-extrabold text-navy-900 leading-none">{{ $items->sum('jumlah_anggota') }}</p>
                <p class="text-xs text-gray-500 mt-1">Total Anggota</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-sm p-5 flex items-center">
            <div class="relative w-full">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="M21 21l-4.3-4.3"/></svg>
                <input id="cariEkskul" type="text" placeholder="Cari ekskul, ketua, pembina..."
                       class="w-full border border-gray-200 rounded-xl pl-9 pr-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
            </div>
        </div>
    </div>

    {{-- KARTU --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse ($items as $e)
            @php $foto = $e->urlGambar('foto_sampul') ?? $e->urlGambar('gambar'); @endphp
            <div data-cari="{{ strtolower($e->nama . ' ' . $e->ketua . ' ' . $e->pembina) }}"
                 class="kartu-ekskul group bg-white rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col">

                <div class="relative h-44 bg-gray-100 overflow-hidden">
                    @if ($foto)
                        <img src="{{ $foto }}" alt="{{ $e->nama }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300 text-sm">Belum ada sampul</div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-navy-900/70 via-transparent to-transparent"></div>
                    <h3 class="absolute bottom-3 left-4 right-4 text-white font-bold text-lg leading-tight">{{ $e->nama }}</h3>
                    <span class="absolute top-3 right-3 bg-yellow-400 text-navy-900 text-[11px] font-extrabold px-3 py-1 rounded-full shadow">
                        {{ $e->jumlah_anggota ?? 0 }} anggota
                    </span>
                </div>

                <div class="p-5 flex-1 space-y-3 text-sm">
                    <div>
                        <p class="text-[11px] uppercase tracking-wide text-gray-400">Ketua</p>
                        <p class="font-semibold text-navy-900">{{ $e->ketua ?: '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] uppercase tracking-wide text-gray-400">Pembina</p>
                        <p class="font-semibold text-navy-900">{{ $e->pembina ?: '-' }}</p>
                    </div>
                    @if ($e->hari_latihan || $e->jam_latihan)
                        <div class="flex flex-wrap gap-2 pt-1">
                            @if ($e->hari_latihan)
                                <span class="bg-blue-50 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full">{{ $e->hari_latihan }}</span>
                            @endif
                            @if ($e->jam_latihan)
                                <span class="bg-emerald-50 text-emerald-700 text-xs font-semibold px-3 py-1 rounded-full">{{ $e->jam_latihan }}</span>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="px-5 pb-5 flex gap-3">
                    <a href="{{ route('admin.ekskul.edit', $e->id) }}"
                       class="flex-1 text-center bg-blue-50 text-blue-700 font-semibold text-sm py-2 rounded-xl hover:bg-blue-600 hover:text-white transition">Edit</a>
                    <form action="{{ route('admin.ekskul.destroy', $e->id) }}" method="POST" class="flex-1"
                          onsubmit="return confirm('Hapus ekskul {{ $e->nama }}?')">
                        @csrf
                        @method('DELETE')
                        <button class="w-full bg-red-50 text-red-600 font-semibold text-sm py-2 rounded-xl hover:bg-red-600 hover:text-white transition">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-2xl shadow-sm p-12 text-center text-gray-400">
                Belum ada ekskul. Klik "Tambah Ekskul" untuk memulai.
            </div>
        @endforelse
    </div>

    <p id="kosongEkskul" class="hidden text-center text-gray-400 mt-8">Tidak ada ekskul yang cocok.</p>

    <script>
        const cari = document.getElementById('cariEkskul');
        const kartu = document.querySelectorAll('.kartu-ekskul');
        const kosong = document.getElementById('kosongEkskul');
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