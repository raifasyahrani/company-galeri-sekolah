<article class="group flex flex-col bg-white border border-slate-200 rounded-lg overflow-hidden hover:border-slate-300 hover:shadow-md transition">
    @if ($a->urlGambar())
        <img src="{{ $a->urlGambar() }}" alt="{{ $a->judul }}" class="h-48 w-full object-cover">
    @else
        <div class="h-48 bg-slate-100 flex items-center justify-center font-display text-5xl text-slate-300">{{ mb_substr($a->judul, 0, 1) }}</div>
    @endif
    <div class="flex flex-1 flex-col p-6">
        <p class="text-xs text-slate-500 mb-2"><span class="font-semibold text-blue-700">{{ $a->kategori }}</span> &middot; {{ $a->tanggalIndo() }}</p>
        <h3 class="font-display text-lg font-semibold text-navy-900 leading-snug mb-2">{{ $a->judul }}</h3>
        <p class="text-sm leading-relaxed text-slate-600 flex-1">{{ \Illuminate\Support\Str::limit($a->deskripsi, 120) }}</p>
        <a href="{{ route('artikel.show', $a->slug) }}" class="mt-4 text-sm font-semibold text-blue-700 hover:text-blue-900">Baca selengkapnya</a>
    </div>
</article>