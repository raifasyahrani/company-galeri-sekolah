{{-- resources/views/partials/peta.blade.php --}}
{{-- Pemakaian: @include('partials.peta', ['tinggi' => 'h-96', 'tombol' => true]) --}}
@php
    $tinggi = $tinggi ?? 'h-80';
    $tombol = $tombol ?? true;

    $alamatPeta = config('perusahaan.alamat');
    if (! is_string($alamatPeta) || $alamatPeta === '') {
        $alamatPeta = 'Jl. Raya Pajajaran No. 88F, Kota Bogor 16153';
    }

    // Jika punya link embed khusus dari Google Maps, isi kunci 'peta_embed'
    // di config/perusahaan.php. Jika kosong, peta dicari dari alamat.
    $srcPeta = config('perusahaan.peta_embed')
        ?: 'https://www.google.com/maps?q=' . urlencode($alamatPeta) . '&hl=id&z=17&output=embed';

    $linkBuka = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($alamatPeta);
@endphp

<div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-slate-100 shadow-lg {{ $tinggi }}">
    <iframe
        src="{{ $srcPeta }}"
        class="h-full w-full border-0"
        style="border:0;"
        allowfullscreen
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
        title="Lokasi kantor {{ config('perusahaan.nama') }}">
    </iframe>

    @if ($tombol)
        <a href="{{ $linkBuka }}" target="_blank" rel="noopener"
           class="absolute bottom-3 right-3 inline-flex items-center gap-2 rounded-full bg-amber-400 px-4 py-2 text-sm font-semibold text-navy-950 shadow-md transition hover:bg-amber-300">
            Buka di Google Maps
        </a>
    @endif
</div>