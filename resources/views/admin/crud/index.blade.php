@extends('admin.layout')
@section('title', $c['title'])

@section('header')
    <div>
        <h1 class="font-bold text-navy-900 text-xl tracking-tight">{{ $c['title'] }}</h1>
        <p class="text-xs text-gray-400 mt-0.5">{{ $c['subtitle'] }}</p>
    </div>
    <a href="{{ route($c['route'] . '.create') }}"
       class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow-lg shadow-blue-600/25 hover:shadow-blue-600/40 hover:-translate-y-0.5 transition-all duration-200">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14"/></svg>
        Tambah {{ $c['title'] }}
    </a>
@endsection

@section('content')
    <style>
        .clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .pop-in  { animation: popIn .22s ease-out; }
        @keyframes popIn {
            from { opacity: 0; transform: translateY(10px) scale(.96); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
    </style>

    @php
        // Kolom yang ditampilkan sebagai badge berwarna
        $badgeCols = ['kategori', 'jurusan', 'category'];
        // Kolom teks pendukung yang digabung di bawah judul
        $subNames = ['ringkasan', 'deskripsi', 'keterangan'];
        // Pilihan warna badge (class ditulis lengkap agar terbaca Tailwind)
        $badgeColors = [
            'bg-blue-50 text-blue-700 ring-blue-200',
            'bg-emerald-50 text-emerald-700 ring-emerald-200',
            'bg-amber-50 text-amber-700 ring-amber-200',
            'bg-violet-50 text-violet-700 ring-violet-200',
            'bg-rose-50 text-rose-700 ring-rose-200',
            'bg-cyan-50 text-cyan-700 ring-cyan-200',
        ];

        // Kolom teks pertama = judul utama
        $titleCol = null;
        foreach ($c['columns'] as $col) {
            if (($col['type'] ?? '') !== 'image' && !in_array($col['name'], $badgeCols)) {
                $titleCol = $col['name'];
                break;
            }
        }

        // Kolom pendukung pertama setelah judul (mis. ringkasan) digabung ke sel judul
        $subCol = null;
        if ($titleCol) {
            $setelah = false;
            foreach ($c['columns'] as $col) {
                if ($col['name'] === $titleCol) { $setelah = true; continue; }
                if ($setelah && in_array($col['name'], $subNames)) { $subCol = $col['name']; break; }
            }
        }

        $kolom = collect($c['columns'])->reject(fn ($col) => $col['name'] === $subCol)->values();

        // Kolom badge pertama dipakai untuk tombol filter
        $kolomKat = collect($c['columns'])->first(fn ($col) => in_array($col['name'], $badgeCols));
        $katName = $kolomKat['name'] ?? null;
        $katList = $katName
            ? collect($items)->pluck($katName)->filter()->countBy()->sortKeys()
            : collect();

        $adaGambar = collect($c['columns'])->contains(fn ($col) => ($col['type'] ?? '') === 'image');
        $total = method_exists($items, 'total') ? $items->total() : count($items);
    @endphp

    <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/60 ring-1 ring-slate-100 overflow-hidden">

        {{-- Toolbar: judul + pencarian --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-6 py-5 bg-gradient-to-r from-slate-50 to-white">
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-blue-600/10 text-blue-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h10"/></svg>
                </span>
                <div>
                    <p class="text-sm font-semibold text-slate-800">Daftar {{ $c['title'] }}</p>
                    <p class="text-xs text-slate-400">{{ $total }} data tersimpan</p>
                </div>
            </div>
            <div class="relative w-full sm:w-72">
                <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="M21 21l-4.3-4.3"/></svg>
                <input id="searchInput" type="text" placeholder="Cari data..."
                       class="w-full pl-10 pr-4 py-2.5 text-sm rounded-xl border border-slate-200 bg-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 transition">
            </div>
        </div>

        {{-- Tombol filter kategori --}}
        @if ($katName && $katList->count() > 0)
            <div class="flex flex-wrap items-center gap-2 px-6 pb-4">
                <button type="button" data-filter=""
                        class="px-4 py-1.5 rounded-full text-xs font-bold transition bg-blue-600 text-white shadow-md shadow-blue-600/30">
                    Semua <span class="ml-1 opacity-70">{{ $total }}</span>
                </button>
                @foreach ($katList as $nama => $jml)
                    <button type="button" data-filter="{{ $nama }}"
                            class="px-4 py-1.5 rounded-full text-xs font-bold transition bg-slate-100 text-slate-600 hover:bg-slate-200">
                        {{ $nama }} <span class="ml-1 opacity-70">{{ $jml }}</span>
                    </button>
                @endforeach
            </div>
        @endif

        <div class="overflow-x-auto border-t border-slate-100">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-[11px] uppercase tracking-wider text-slate-500 bg-slate-50/80">
                        @foreach ($kolom as $col)
                            <th class="px-4 py-3.5 font-semibold {{ $loop->first ? 'pl-6' : '' }}">{{ $col['label'] }}</th>
                        @endforeach
                        <th class="px-4 pr-6 py-3.5 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100" id="dataBody">
                    @forelse ($items as $item)
                        <tr data-row data-kat="{{ $katName ? ($item->{$katName} ?? '') : '' }}"
                            class="group hover:bg-blue-50/40 transition-colors duration-150">
                            @foreach ($kolom as $ci => $col)
                                @php
                                    $isImage = ($col['type'] ?? '') === 'image';
                                    $name = $col['name'];
                                    $isBadge = in_array($name, $badgeCols);
                                    $isTitle = $name === $titleCol;
                                    $isDate = str_contains(strtolower($name), 'tanggal') || str_contains(strtolower($name), 'tgl');
                                @endphp
                                <td class="px-4 py-4 align-middle border-l-4 {{ $ci === 0 ? 'pl-5 border-transparent group-hover:border-blue-500' : 'border-transparent' }} {{ $isTitle ? 'min-w-[240px]' : '' }}">
                                    @if ($isImage)
                                        @if ($item->urlGambar($name))
                                            <button type="button" data-preview="{{ $item->urlGambar($name) }}" class="block" title="Klik untuk memperbesar">
                                                <img src="{{ $item->urlGambar($name) }}" alt=""
                                                     class="w-16 h-12 object-cover rounded-xl ring-1 ring-slate-200 shadow-sm group-hover:scale-105 group-hover:shadow-md transition duration-200">
                                            </button>
                                        @else
                                            <span class="inline-flex items-center justify-center w-16 h-12 rounded-xl bg-slate-100 text-slate-300">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="3"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                                            </span>
                                        @endif

                                    @elseif ($isBadge)
                                        @php $val = $item->{$name}; @endphp
                                        @if ($val)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold whitespace-nowrap ring-1 {{ $badgeColors[crc32((string) $val) % count($badgeColors)] }}">
                                                {{ $val }}
                                            </span>
                                        @else
                                            <span class="text-slate-300">-</span>
                                        @endif

                                    @elseif ($isTitle)
                                        <p class="clamp-2 font-semibold text-slate-800 leading-snug">
                                            {{ \Illuminate\Support\Str::limit($item->{$name}, 120) ?: '-' }}
                                        </p>
                                        @if ($subCol)
                                            <p class="clamp-2 mt-1 text-xs text-slate-500 leading-relaxed">
                                                {{ \Illuminate\Support\Str::limit($item->{$subCol}, 160) ?: '' }}
                                            </p>
                                        @endif

                                    @else
                                        @php $val = $item->{$name}; @endphp
                                        @if ($isDate)
                                            <span class="inline-flex items-center gap-1.5 whitespace-nowrap text-slate-600 font-medium">
                                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                                                @if ($val instanceof \Carbon\Carbon)
                                                    {{ $val->translatedFormat('d M Y') }}
                                                @else
                                                    {{ $val ?: '-' }}
                                                @endif
                                            </span>
                                        @else
                                            <span class="text-slate-500">
                                                {{ \Illuminate\Support\Str::limit($val instanceof \Carbon\Carbon ? $val->translatedFormat('d M Y') : $val, 70) ?: '-' }}
                                            </span>
                                        @endif
                                    @endif
                                </td>
                            @endforeach

                            <td class="px-4 pr-6 py-4 text-right whitespace-nowrap align-middle">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route($c['route'] . '.edit', $item->id) }}" title="Edit"
                                       class="inline-flex items-center justify-center w-9 h-9 rounded-xl text-blue-600 bg-blue-50 hover:bg-blue-600 hover:text-white hover:-translate-y-0.5 transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 4H4v16h16v-7M18.5 2.5a2.1 2.1 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </a>

                                    <button type="button" title="Hapus"
                                            data-hapus="hapus-{{ $item->id }}"
                                            data-nama="{{ $titleCol ? \Illuminate\Support\Str::limit($item->{$titleCol}, 60) : '' }}"
                                            class="inline-flex items-center justify-center w-9 h-9 rounded-xl text-red-600 bg-red-50 hover:bg-red-600 hover:text-white hover:-translate-y-0.5 transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6M10 11v6M14 11v6"/></svg>
                                    </button>

                                    <form id="hapus-{{ $item->id }}" action="{{ route($c['route'] . '.destroy', $item->id) }}" method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $kolom->count() + 1 }}" class="px-6 py-16 text-center">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-slate-100 text-slate-300 mb-4">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6m16 0v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4m16 0h-5l-1 2h-4l-1-2H4"/></svg>
                                </div>
                                <p class="font-semibold text-slate-600">Belum ada data</p>
                                <p class="text-xs text-slate-400 mt-1">Klik tombol “Tambah {{ $c['title'] }}” untuk mulai mengisi.</p>
                            </td>
                        </tr>
                    @endforelse

                    {{-- Pesan jika hasil pencarian/filter kosong --}}
                    <tr id="noResult" class="hidden">
                        <td colspan="{{ $kolom->count() + 1 }}" class="px-6 py-12 text-center text-slate-400 text-sm">
                            Tidak ada data yang cocok dengan pencarian atau filter.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Footer tabel --}}
        @if ($total > 0)
            <div class="flex items-center justify-between px-6 py-3.5 border-t border-slate-100 bg-slate-50/60 text-xs text-slate-500">
                <p>Menampilkan <span id="shownCount" class="font-bold text-slate-700">{{ $total }}</span> dari {{ $total }} data</p>
                @if ($adaGambar)
                    <p class="hidden sm:block text-slate-400">Klik gambar untuk memperbesar</p>
                @endif
            </div>
        @endif

        {{-- Pagination (hanya tampil jika $items memakai paginate) --}}
        @if (method_exists($items, 'links') && method_exists($items, 'hasPages') && $items->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                {{ $items->links() }}
            </div>
        @endif
    </div>

    {{-- MODAL: konfirmasi hapus --}}
    <div id="modalHapus" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4" role="dialog" aria-modal="true">
        <div id="overlayHapus" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        <div class="pop-in relative w-full max-w-sm bg-white rounded-3xl shadow-2xl p-8 text-center">
            <span class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-red-50 text-red-500 ring-1 ring-red-100 mb-5">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6M10 11v6M14 11v6"/></svg>
            </span>
            <h3 class="text-xl font-extrabold text-navy-900 mb-2">Hapus data ini?</h3>
            <p class="text-sm text-slate-500 leading-relaxed mb-7">
                <span id="namaHapus" class="font-semibold text-slate-700"></span><br>
                akan dihapus permanen dan tidak bisa dikembalikan.
            </p>
            <div class="grid grid-cols-2 gap-3">
                <button type="button" id="btnBatalHapus" class="py-3 rounded-xl text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 transition">Batal</button>
                <button type="button" id="btnYaHapus" class="py-3 rounded-xl text-sm font-semibold text-white bg-red-600 hover:bg-red-700 shadow-lg shadow-red-600/25 transition">Ya, Hapus</button>
            </div>
        </div>
    </div>

    {{-- MODAL: pratinjau gambar --}}
    <div id="modalFoto" class="hidden fixed inset-0 z-50 flex items-center justify-center p-6 bg-slate-900/80 backdrop-blur-sm cursor-zoom-out">
        <img id="fotoBesar" src="" alt="" class="pop-in max-h-[85vh] max-w-[90vw] rounded-2xl shadow-2xl ring-1 ring-white/20 object-contain">
    </div>

    <script>
        (function () {
            // ===== Pencarian + filter kategori =====
            var input = document.getElementById('searchInput');
            var rows = Array.prototype.slice.call(document.querySelectorAll('#dataBody tr[data-row]'));
            var noResult = document.getElementById('noResult');
            var shown = document.getElementById('shownCount');
            var chips = Array.prototype.slice.call(document.querySelectorAll('[data-filter]'));
            var kat = '';
            var aktif = ['bg-blue-600', 'text-white', 'shadow-md', 'shadow-blue-600/30'];
            var pasif = ['bg-slate-100', 'text-slate-600', 'hover:bg-slate-200'];

            function terapkan() {
                var q = input ? input.value.toLowerCase().trim() : '';
                var n = 0;
                rows.forEach(function (row) {
                    var cocokTeks = row.textContent.toLowerCase().indexOf(q) !== -1;
                    var cocokKat = kat === '' || row.getAttribute('data-kat') === kat;
                    var tampil = cocokTeks && cocokKat;
                    row.classList.toggle('hidden', !tampil);
                    if (tampil) n++;
                });
                if (shown) shown.textContent = n;
                if (noResult) noResult.classList.toggle('hidden', rows.length === 0 || n !== 0);
            }

            if (input) input.addEventListener('input', terapkan);

            chips.forEach(function (chip) {
                chip.addEventListener('click', function () {
                    kat = chip.getAttribute('data-filter');
                    chips.forEach(function (c) {
                        c.classList.remove.apply(c.classList, aktif.concat(pasif));
                        c.classList.add.apply(c.classList, c === chip ? aktif : pasif);
                    });
                    terapkan();
                });
            });

            // ===== Konfirmasi hapus =====
            var modalHapus = document.getElementById('modalHapus');
            var namaHapus = document.getElementById('namaHapus');
            var formTerpilih = null;

            function tutupHapus() {
                modalHapus.classList.add('hidden');
                formTerpilih = null;
            }

            document.querySelectorAll('[data-hapus]').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    formTerpilih = document.getElementById(btn.getAttribute('data-hapus'));
                    namaHapus.textContent = btn.getAttribute('data-nama') || 'Data ini';
                    modalHapus.classList.remove('hidden');
                });
            });
            document.getElementById('btnBatalHapus').addEventListener('click', tutupHapus);
            document.getElementById('overlayHapus').addEventListener('click', tutupHapus);
            document.getElementById('btnYaHapus').addEventListener('click', function () {
                if (formTerpilih) formTerpilih.submit();
            });

            // ===== Pratinjau gambar =====
            var modalFoto = document.getElementById('modalFoto');
            var fotoBesar = document.getElementById('fotoBesar');

            function tutupFoto() {
                modalFoto.classList.add('hidden');
                fotoBesar.src = '';
            }

            document.querySelectorAll('[data-preview]').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    fotoBesar.src = btn.getAttribute('data-preview');
                    modalFoto.classList.remove('hidden');
                });
            });
            modalFoto.addEventListener('click', tutupFoto);

            document.addEventListener('keydown', function (e) {
                if (e.key !== 'Escape') return;
                if (!modalHapus.classList.contains('hidden')) tutupHapus();
                if (!modalFoto.classList.contains('hidden')) tutupFoto();
            });
        })();
    </script>
@endsection