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
        .clamp-1 { display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }
        .pop-in  { animation: popIn .22s ease-out; }
        @keyframes popIn {
            from { opacity: 0; transform: translateY(10px) scale(.96); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
    </style>

    @php $total = count($items); @endphp

    <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/60 ring-1 ring-slate-100 overflow-hidden">

        {{-- Toolbar --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-6 py-5 bg-gradient-to-r from-slate-50 to-white">
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-blue-600/10 text-blue-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="3"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                </span>
                <div>
                    <p class="text-sm font-semibold text-slate-800">Koleksi Foto</p>
                    <p class="text-xs text-slate-400">{{ $total }} foto tersimpan</p>
                </div>
            </div>
            <div class="relative w-full sm:w-72">
                <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="M21 21l-4.3-4.3"/></svg>
                <input id="searchInput" type="text" placeholder="Cari judul foto..."
                       class="w-full pl-10 pr-4 py-2.5 text-sm rounded-xl border border-slate-200 bg-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 transition">
            </div>
        </div>

        {{-- Grid foto --}}
        <div class="p-6 border-t border-slate-100 bg-slate-50/50">
            <div id="galeriGrid" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-5">

                {{-- Kartu tambah foto --}}
                <a href="{{ route($c['route'] . '.create') }}"
                   class="group flex flex-col items-center justify-center gap-3 rounded-2xl border-2 border-dashed border-slate-300 bg-white text-slate-400 hover:border-blue-500 hover:bg-blue-50/50 hover:text-blue-600 transition-all duration-200 min-h-[240px]">
                    <span class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-slate-100 group-hover:bg-blue-100 transition-colors">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14"/></svg>
                    </span>
                    <span class="text-sm font-bold">Tambah Foto</span>
                </a>

                @foreach ($items as $item)
                    @php
                        $url = $item->urlGambar('gambar');
                        $tgl = $item->created_at instanceof \Carbon\Carbon ? $item->created_at->translatedFormat('d M Y') : null;
                    @endphp
                    <div data-card data-judul="{{ strtolower($item->judul) }}"
                         class="group bg-white rounded-2xl ring-1 ring-slate-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col">

                        {{-- Foto --}}
                        <div class="relative overflow-hidden bg-slate-100" style="aspect-ratio: 4 / 3;">
                            @if ($url)
                                <button type="button" data-preview="{{ $url }}" class="absolute inset-0 w-full h-full cursor-zoom-in" title="Klik untuk memperbesar">
                                    <img src="{{ $url }}" alt="{{ $item->judul }}"
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    <span class="absolute inset-0 bg-gradient-to-t from-slate-900/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                                    <span class="absolute left-3 bottom-3 inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/90 text-slate-700 text-[11px] font-bold opacity-0 translate-y-2 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="M21 21l-4.3-4.3M11 8v6M8 11h6"/></svg>
                                        Perbesar
                                    </span>
                                </button>
                            @else
                                <span class="absolute inset-0 flex items-center justify-center text-slate-300">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="3"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                                </span>
                            @endif

                            @if ($tgl)
                                <span class="absolute right-3 top-3 px-2.5 py-1 rounded-full bg-slate-900/60 backdrop-blur text-white text-[10px] font-semibold">{{ $tgl }}</span>
                            @endif
                        </div>

                        {{-- Judul + aksi --}}
                        <div class="flex items-center justify-between gap-3 px-4 py-3.5">
                            <p class="clamp-1 font-semibold text-slate-800 text-sm min-w-0" title="{{ $item->judul }}">{{ $item->judul ?: '-' }}</p>

                            <div class="inline-flex items-center gap-1.5 shrink-0">
                                <a href="{{ route($c['route'] . '.edit', $item->id) }}" title="Edit"
                                   class="inline-flex items-center justify-center w-9 h-9 rounded-xl text-blue-600 bg-blue-50 hover:bg-blue-600 hover:text-white transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 4H4v16h16v-7M18.5 2.5a2.1 2.1 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </a>

                                <button type="button" title="Hapus"
                                        data-hapus="hapus-{{ $item->id }}"
                                        data-nama="{{ \Illuminate\Support\Str::limit($item->judul, 60) }}"
                                        class="inline-flex items-center justify-center w-9 h-9 rounded-xl text-red-600 bg-red-50 hover:bg-red-600 hover:text-white transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6M10 11v6M14 11v6"/></svg>
                                </button>

                                <form id="hapus-{{ $item->id }}" action="{{ route($c['route'] . '.destroy', $item->id) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($total === 0)
                <p class="text-center text-sm text-slate-400 mt-8">Belum ada foto. Klik “Tambah Foto” untuk mulai mengisi galeri.</p>
            @endif

            <p id="noResult" class="hidden text-center text-sm text-slate-400 mt-8">Tidak ada foto yang cocok dengan pencarian.</p>
        </div>

        {{-- Footer --}}
        @if ($total > 0)
            <div class="flex items-center justify-between px-6 py-3.5 border-t border-slate-100 bg-white text-xs text-slate-500">
                <p>Menampilkan <span id="shownCount" class="font-bold text-slate-700">{{ $total }}</span> dari {{ $total }} foto</p>
                <p class="hidden sm:block text-slate-400">Klik foto untuk memperbesar</p>
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
            <h3 class="text-xl font-extrabold text-navy-900 mb-2">Hapus foto ini?</h3>
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

    {{-- MODAL: pratinjau foto --}}
    <div id="modalFoto" class="hidden fixed inset-0 z-50 flex items-center justify-center p-6 bg-slate-900/80 backdrop-blur-sm cursor-zoom-out">
        <img id="fotoBesar" src="" alt="" class="pop-in max-h-[85vh] max-w-[90vw] rounded-2xl shadow-2xl ring-1 ring-white/20 object-contain">
    </div>

    <script>
        (function () {
            // ===== Pencarian =====
            var input = document.getElementById('searchInput');
            var cards = Array.prototype.slice.call(document.querySelectorAll('[data-card]'));
            var noResult = document.getElementById('noResult');
            var shown = document.getElementById('shownCount');

            if (input) {
                input.addEventListener('input', function () {
                    var q = input.value.toLowerCase().trim();
                    var n = 0;
                    cards.forEach(function (card) {
                        var cocok = card.getAttribute('data-judul').indexOf(q) !== -1;
                        card.classList.toggle('hidden', !cocok);
                        if (cocok) n++;
                    });
                    if (shown) shown.textContent = n;
                    if (noResult) noResult.classList.toggle('hidden', cards.length === 0 || n !== 0);
                });
            }

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
                    namaHapus.textContent = btn.getAttribute('data-nama') || 'Foto ini';
                    modalHapus.classList.remove('hidden');
                });
            });
            document.getElementById('btnBatalHapus').addEventListener('click', tutupHapus);
            document.getElementById('overlayHapus').addEventListener('click', tutupHapus);
            document.getElementById('btnYaHapus').addEventListener('click', function () {
                if (formTerpilih) formTerpilih.submit();
            });

            // ===== Pratinjau foto =====
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