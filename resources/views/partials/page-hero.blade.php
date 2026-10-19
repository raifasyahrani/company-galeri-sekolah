<section class="relative overflow-hidden bg-gradient-to-br from-navy-950 via-navy-900 to-navy-700 text-white">
    <div class="absolute -right-24 -top-32 h-96 w-96 rounded-full bg-white/10"></div>
    <div class="absolute right-40 -bottom-24 h-64 w-64 rounded-full bg-amber-400/20"></div>
    <div class="relative mx-auto max-w-6xl px-6 py-16 md:py-24">
        <p class="mb-4 text-sm text-blue-100"><a href="{{ route('welcome') }}" class="hover:text-white">Beranda</a> / {{ $badge ?? $judul }}</p>
        <h1 class="max-w-3xl font-display text-3xl font-bold leading-tight md:text-5xl">{{ $judul }}</h1>
        @if (!empty($sub))
            <p class="mt-5 max-w-2xl text-lg leading-relaxed text-blue-50">{{ $sub }}</p>
        @endif
    </div>
</section>