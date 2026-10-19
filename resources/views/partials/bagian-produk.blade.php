{{-- PRODUK --}}
<section class="bg-slate-50">
    <div class="mx-auto max-w-6xl px-6 py-24">
        <div class="mb-12 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div class="max-w-2xl">
                <span class="inline-block rounded-full bg-amber-400 px-4 py-1 text-xs font-bold tracking-wide text-navy-950">PRODUK</span>
                <h2 class="mt-4 font-display text-3xl font-semibold leading-tight text-navy-950 md:text-4xl">Paket dan perangkat untuk bisnis Anda</h2>
                <p class="mt-3 text-slate-600">Produk yang bisa Anda langgani atau miliki: paket internet, jaringan antar kantor, dan perangkat jaringan.</p>
            </div>
            <a href="{{ route('layanan') }}" class="text-sm font-semibold text-navy-700 hover:text-navy-950">Semua produk &rarr;</a>
        </div>
        <div class="grid gap-7 md:grid-cols-2 lg:grid-cols-4">
            @forelse ($produks as $l)
                @include('partials.kartu-layanan', ['l' => $l])
            @empty
                <p class="col-span-full text-center text-slate-500">Belum ada produk.</p>
            @endforelse
        </div>
    </div>
</section>

{{-- LAYANAN --}}
<section class="bg-white">
    <div class="mx-auto max-w-6xl px-6 py-24">
        <div class="mb-12 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div class="max-w-2xl">
                <span class="inline-block rounded-full bg-blue-50 px-4 py-1 text-xs font-bold tracking-wide text-navy-700 ring-1 ring-blue-100">LAYANAN</span>
                <h2 class="mt-4 font-display text-3xl font-semibold leading-tight text-navy-950 md:text-4xl">Jasa yang menjaga jaringan Anda tetap andal</h2>
                <p class="mt-3 text-slate-600">Layanan yang dikerjakan tim kami: pengelolaan jaringan, cloud, keamanan, dan dukungan teknis.</p>
            </div>
            <a href="{{ route('layanan') }}" class="text-sm font-semibold text-navy-700 hover:text-navy-950">Semua layanan &rarr;</a>
        </div>
        <div class="grid gap-7 md:grid-cols-2 lg:grid-cols-4">
            @forelse ($jasas as $l)
                @include('partials.kartu-layanan', ['l' => $l])
            @empty
                <p class="col-span-full text-center text-slate-500">Belum ada layanan.</p>
            @endforelse
        </div>
    </div>
</section>