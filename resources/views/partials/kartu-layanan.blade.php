@php
    $ikon = [
        'M8.288 15.038a5.25 5.25 0 017.424 0M5.106 11.856c3.807-3.808 9.98-3.808 13.788 0M1.924 8.674c5.565-5.565 14.587-5.565 20.152 0M12.53 18.22l-.53.53-.53-.53a.75.75 0 011.06 0z',
        'M7.217 10.907a2.25 2.25 0 100 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186l9.566-5.314m-9.566 7.5l9.566 5.314m0 0a2.25 2.25 0 103.935 2.186 2.25 2.25 0 00-3.935-2.186zm0-12.814a2.25 2.25 0 103.933-2.185 2.25 2.25 0 00-3.933 2.185z',
        'M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25',
        'M2.25 15a4.5 4.5 0 004.5 4.5H18a3.75 3.75 0 001.332-7.257 3 3 0 00-3.758-3.848 5.25 5.25 0 00-10.233 2.33A4.502 4.502 0 002.25 15z',
        'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z',
        'M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z',
    ];
    $jalur   = $ikon[$l->id % count($ikon)];
    $produk  = ($l->jenis ?? 'Layanan') === 'Produk';
    $baris   = array_values(array_filter(array_map('trim', explode("\n", (string) $l->deskripsi))));
    $pembuka = $baris[0] ?? '';
    $fitur   = array_slice($baris, 1);
    $tampil  = array_slice($fitur, 0, 3);
    $sisa    = count($fitur) - count($tampil);
@endphp

<article class="group relative flex flex-col overflow-hidden rounded-3xl transition duration-300 hover:-translate-y-1.5
    {{ $produk ? 'bg-gradient-to-br from-navy-900 to-navy-700 text-white shadow-xl shadow-navy-900/25' : 'bg-white shadow-md ring-1 ring-slate-200 hover:shadow-xl hover:ring-navy-700/40' }}">

    @if ($produk)
        <div class="absolute -right-12 -top-12 h-40 w-40 rounded-full bg-white/10"></div>
    @else
        <div class="h-1.5 bg-gradient-to-r from-navy-700 via-sky-400 to-amber-400"></div>
    @endif

    @if ($l->urlGambar())
        <img src="{{ $l->urlGambar() }}" alt="{{ $l->nama }}" class="relative h-44 w-full object-cover">
    @endif

    <div class="relative flex flex-1 flex-col p-7">
        <div class="mb-5 flex items-center justify-between">
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl transition group-hover:scale-105 {{ $produk ? 'bg-amber-400 text-navy-950' : 'bg-gradient-to-br from-navy-700 to-navy-900 text-white shadow-lg shadow-navy-700/30' }}">
                <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $jalur }}"/></svg>
            </div>
            <span class="rounded-full px-3.5 py-1 text-xs font-bold tracking-wide {{ $produk ? 'bg-amber-400 text-navy-950' : 'bg-blue-50 text-navy-700 ring-1 ring-blue-100' }}">{{ $produk ? 'PRODUK' : 'LAYANAN' }}</span>
        </div>

        <h3 class="font-display text-xl font-bold leading-snug {{ $produk ? 'text-white' : 'text-navy-950' }}">
            <a href="{{ route('layanan.show', $l->id) }}" class="after:absolute after:inset-0">{{ $l->nama }}</a>
        </h3>

        @if ($pembuka)
            <p class="mt-3 text-sm leading-relaxed {{ $produk ? 'text-blue-100' : 'text-slate-600' }}">{{ $pembuka }}</p>
        @endif

        @if (count($tampil))
            <ul class="mt-5 space-y-2.5">
                @foreach ($tampil as $p)
                    <li class="flex items-start gap-2.5 text-sm leading-relaxed {{ $produk ? 'text-blue-50' : 'text-slate-600' }}">
                        <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full {{ $produk ? 'bg-amber-400 text-navy-950' : 'bg-sky-100 text-navy-700' }}">
                            <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="3.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </span>
                        <span>{{ $p }}</span>
                    </li>
                @endforeach
            </ul>
            @if ($sisa > 0)
                <p class="mt-3 text-xs font-semibold {{ $produk ? 'text-amber-300' : 'text-navy-700' }}">+ {{ $sisa }} fitur lainnya</p>
            @endif
        @endif

        <span class="mt-auto inline-flex items-center gap-2 pt-6 text-sm font-semibold {{ $produk ? 'text-amber-300' : 'text-navy-700 group-hover:text-navy-950' }}">
            {{ $produk ? 'Lihat detail produk' : 'Lihat detail layanan' }}
            <svg class="h-4 w-4 transition group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </span>
    </div>
</article>