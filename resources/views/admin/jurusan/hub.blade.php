@extends('admin.layout')
@section('title', 'Jurusan')

@section('header')
    <div>
        <h1 class="font-bold text-navy-900 text-xl tracking-tight">Jurusan</h1>
        <p class="text-xs text-gray-400 mt-0.5">Kelola isi halaman Jurusan: seragam, kegiatan, produk, dan dokumentasi</p>
    </div>
    <a href="{{ route('admin.jurusan.daftar') }}"
       class="inline-flex items-center gap-2 bg-white text-blue-700 text-sm font-semibold px-5 py-2.5 rounded-xl ring-1 ring-blue-200 shadow-sm hover:bg-blue-600 hover:text-white hover:ring-blue-600 hover:-translate-y-0.5 transition-all duration-200">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><circle cx="12" cy="12" r="3"/></svg>
        Kelola data jurusan
    </a>
@endsection

@section('content')
    @php
        // Tema tiap bagian (class ditulis lengkap agar terbaca Tailwind)
        $tema = [
            'admin.jurusan.seragam' => [
                'icon'  => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
                'box'   => 'bg-blue-50 text-blue-600 ring-blue-100',
                'bar'   => 'from-blue-500 to-blue-400',
                'badge' => 'bg-blue-50 text-blue-700 ring-blue-200',
            ],
            'admin.jurusan.kegiatan' => [
                'icon'  => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
                'box'   => 'bg-emerald-50 text-emerald-600 ring-emerald-100',
                'bar'   => 'from-emerald-500 to-emerald-400',
                'badge' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
            ],
            'admin.jurusan.produk' => [
                'icon'  => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
                'box'   => 'bg-amber-50 text-amber-600 ring-amber-100',
                'bar'   => 'from-amber-500 to-amber-400',
                'badge' => 'bg-amber-50 text-amber-700 ring-amber-200',
            ],
            'admin.jurusan.dokumentasi' => [
                'icon'  => 'M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9zM15 13a3 3 0 11-6 0 3 3 0 016 0z',
                'box'   => 'bg-violet-50 text-violet-600 ring-violet-100',
                'bar'   => 'from-violet-500 to-violet-400',
                'badge' => 'bg-violet-50 text-violet-700 ring-violet-200',
            ],
        ];
        $temaDefault = [
            'icon'  => 'M4 6h16M4 12h16M4 18h10',
            'box'   => 'bg-slate-50 text-slate-600 ring-slate-100',
            'bar'   => 'from-slate-500 to-slate-400',
            'badge' => 'bg-slate-50 text-slate-700 ring-slate-200',
        ];
        $totalData = collect($bagian)->sum(fn ($b) => $b['items']->count());
    @endphp

    {{-- Pilihan jurusan --}}
    <div class="flex flex-wrap gap-2.5 mb-6">
        @foreach ($daftar as $k => $nama)
            <a href="{{ route('admin.jurusan', ['jurusan' => $k]) }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl text-sm font-bold tracking-wide transition-all duration-200
                      {{ $k === $kode
                          ? 'bg-gradient-to-r from-blue-600 to-blue-500 text-white shadow-lg shadow-blue-600/30 -translate-y-0.5'
                          : 'bg-white text-slate-500 ring-1 ring-slate-200 hover:ring-blue-300 hover:text-blue-600 hover:-translate-y-0.5 hover:shadow-md' }}">
                @if ($k === $kode)
                    <span class="w-2 h-2 rounded-full bg-white"></span>
                @endif
                {{ $k }}
            </a>
        @endforeach
    </div>

    {{-- Banner jurusan terpilih --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-navy-900 via-navy-900 to-blue-700 text-white px-8 py-7 shadow-xl shadow-slate-300/50 mb-6">
        <div class="pointer-events-none absolute -top-20 -right-16 w-64 h-64 rounded-full bg-blue-400/20 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-24 left-1/3 w-64 h-64 rounded-full bg-indigo-400/10 blur-3xl"></div>
        <div class="relative flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-5">
                <div class="w-16 h-16 rounded-2xl bg-white/10 ring-1 ring-white/20 backdrop-blur flex items-center justify-center text-xl font-extrabold tracking-wide">
                    {{ $kode }}
                </div>
                <div>
                    <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-blue-200">Jurusan terpilih</p>
                    <h2 class="text-xl sm:text-2xl font-extrabold leading-snug mt-0.5">{{ $daftar[$kode] }}</h2>
                </div>
            </div>
            <div class="text-left sm:text-right">
                <p class="text-3xl font-extrabold leading-none">{{ $totalData }}</p>
                <p class="text-xs text-blue-200 mt-1">total data konten</p>
            </div>
        </div>
    </div>

    {{-- Ringkasan per bagian (klik untuk melompat) --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @foreach ($bagian as $i => $b)
            @php $t = $tema[$b['route']] ?? $temaDefault; @endphp
            <a href="#bagian-{{ $i }}"
               class="group bg-white rounded-2xl p-4 ring-1 ring-slate-100 shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-3">
                <span class="inline-flex items-center justify-center w-11 h-11 rounded-xl ring-1 {{ $t['box'] }} shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $t['icon'] }}"/></svg>
                </span>
                <div class="min-w-0">
                    <p class="text-2xl font-extrabold text-slate-800 leading-none">{{ $b['items']->count() }}</p>
                    <p class="text-xs text-slate-500 mt-1 truncate group-hover:text-blue-600 transition-colors">{{ $b['judul'] }}</p>
                </div>
            </a>
        @endforeach
    </div>

    {{-- Daftar bagian --}}
    <div class="space-y-8">
        @foreach ($bagian as $i => $b)
            @php $t = $tema[$b['route']] ?? $temaDefault; @endphp
            <section id="bagian-{{ $i }}" class="scroll-mt-24 bg-white rounded-3xl shadow-xl shadow-slate-200/60 ring-1 ring-slate-100 overflow-hidden">
                <div class="h-1.5 bg-gradient-to-r {{ $t['bar'] }}"></div>

                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 px-6 py-5 border-b border-slate-100">
                    <div class="flex items-center gap-4">
                        <span class="inline-flex items-center justify-center w-12 h-12 rounded-2xl ring-1 {{ $t['box'] }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $t['icon'] }}"/></svg>
                        </span>
                        <div>
                            <h2 class="font-bold text-slate-800 text-lg flex items-center gap-2.5">
                                {{ $b['judul'] }}
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold ring-1 {{ $t['badge'] }}">{{ $b['items']->count() }}</span>
                            </h2>
                            <p class="text-xs text-slate-400 mt-0.5">{{ $b['info'] }}</p>
                        </div>
                    </div>
                    <a href="{{ route($b['route'] . '.create', ['jurusan' => $kode]) }}"
                       class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow-lg shadow-blue-600/25 hover:shadow-blue-600/40 hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14"/></svg>
                        Tambah
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-[11px] uppercase tracking-wider text-slate-500 bg-slate-50/80">
                                <th class="px-6 py-3.5 font-semibold">Gambar</th>
                                <th class="px-6 py-3.5 font-semibold">{{ $b['deskripsi'] ? 'Judul' : 'Keterangan' }}</th>
                                @if ($b['deskripsi'])
                                    <th class="px-6 py-3.5 font-semibold">Deskripsi</th>
                                @endif
                                <th class="px-6 py-3.5 font-semibold">Urutan</th>
                                <th class="px-6 py-3.5 font-semibold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($b['items'] as $item)
                                <tr class="group hover:bg-blue-50/40 transition-colors duration-150">
                                    <td class="px-6 py-4 align-middle">
                                        @if ($item->urlGambar('gambar'))
                                            <img src="{{ $item->urlGambar('gambar') }}" alt=""
                                                 class="w-20 h-14 object-cover rounded-xl ring-1 ring-slate-200 shadow-sm group-hover:scale-105 group-hover:shadow-md transition duration-200">
                                        @else
                                            <span class="inline-flex items-center justify-center w-20 h-14 rounded-xl bg-slate-100 text-slate-300">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="3"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 align-middle min-w-[200px]">
                                        <p class="font-semibold text-slate-800 leading-snug">{{ \Illuminate\Support\Str::limit($item->{$b['teks']}, 60) ?: '-' }}</p>
                                    </td>
                                    @if ($b['deskripsi'])
                                        <td class="px-6 py-4 align-middle text-slate-500 leading-relaxed">
                                            {{ \Illuminate\Support\Str::limit($item->{$b['deskripsi']}, 70) ?: '-' }}
                                        </td>
                                    @endif
                                    <td class="px-6 py-4 align-middle">
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-100 text-slate-600 text-xs font-bold">{{ $item->urutan }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-right whitespace-nowrap align-middle">
                                        <div class="inline-flex items-center gap-2">
                                            <a href="{{ route($b['route'] . '.edit', $item->id) }}"
                                               class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg text-xs font-semibold text-blue-700 bg-blue-50 hover:bg-blue-600 hover:text-white transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 4H4v16h16v-7M18.5 2.5a2.1 2.1 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                                Edit
                                            </a>
                                            <form action="{{ route($b['route'] . '.destroy', $item->id) }}" method="POST" class="inline"
                                                  onsubmit="return confirm('Hapus data ini? Tindakan ini tidak bisa dibatalkan.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-600 hover:text-white transition-colors">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6M10 11v6M14 11v6"/></svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ $b['deskripsi'] ? 5 : 4 }}" class="px-6 py-12 text-center">
                                        <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-slate-100 text-slate-300 mb-3">
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6m16 0v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4m16 0h-5l-1 2h-4l-1-2H4"/></svg>
                                        </div>
                                        <p class="font-semibold text-slate-600">Belum ada data untuk {{ $kode }}</p>
                                        <p class="text-xs text-slate-400 mt-1">Klik tombol “Tambah” untuk mengisi bagian {{ $b['judul'] }}.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        @endforeach
    </div>
@endsection