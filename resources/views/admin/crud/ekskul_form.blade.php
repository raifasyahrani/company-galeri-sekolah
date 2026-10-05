@extends('admin.layout')
@section('title', ($item ? 'Edit ' : 'Tambah ') . 'Ekskul')

@section('header')
    <div>
        <h1 class="font-bold text-navy-900 text-lg">{{ $item ? 'Edit Ekskul' : 'Tambah Ekskul' }}</h1>
        <p class="text-xs text-gray-400">{{ $item ? 'Perbarui data ' . $item->nama : 'Isi data ekstrakurikuler baru' }}</p>
    </div>
    <a href="{{ route('admin.ekskul') }}" class="text-sm font-semibold text-gray-500 hover:text-blue-600 transition">&larr; Kembali</a>
@endsection

@section('content')
    @php
        $val = fn ($f) => old($f, $item?->{$f} ?? '');
        $hariTerpilih = array_filter(array_map('trim', explode(',', $val('hari_latihan'))));
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $inp = 'w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-300 transition';
    @endphp

    <form action="{{ $item ? route('admin.ekskul.update', $item->id) : route('admin.ekskul.store') }}"
          method="POST" enctype="multipart/form-data" class="text-sm">
        @csrf
        @if ($item) @method('PUT') @endif

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

            {{-- KIRI: INFORMASI --}}
            <div class="xl:col-span-2 space-y-6">

                <div class="bg-white rounded-2xl shadow-sm p-6 space-y-5">
                    <div class="flex items-center gap-3 pb-3 border-b border-gray-100">
                        <span class="w-9 h-9 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </span>
                        <h2 class="font-bold text-navy-900">Informasi Ekskul</h2>
                    </div>

                    <div>
                        <label class="block font-semibold text-gray-700 mb-1.5">Nama Ekskul <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" value="{{ $val('nama') }}" placeholder="contoh: Paduan Suara" class="{{ $inp }}">
                    </div>

                    <div>
                        <label class="block font-semibold text-gray-700 mb-1.5">Deskripsi <span class="text-red-500">*</span></label>
                        <textarea name="deskripsi" rows="5" placeholder="Jelaskan kegiatan ekskul ini..." class="{{ $inp }}">{{ $val('deskripsi') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block font-semibold text-gray-700 mb-1.5">Ketua Ekskul</label>
                            <input type="text" name="ketua" value="{{ $val('ketua') }}" placeholder="contoh: Keisha (XII PPLG 1)" class="{{ $inp }}">
                        </div>
                        <div>
                            <label class="block font-semibold text-gray-700 mb-1.5">Pembina</label>
                            <input type="text" name="pembina" value="{{ $val('pembina') }}" placeholder="contoh: Ibu Tresna, S.Pd." class="{{ $inp }}">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <label class="block font-semibold text-gray-700 mb-1.5">Jumlah Anggota</label>
                            <input type="number" min="0" name="jumlah_anggota" value="{{ $val('jumlah_anggota') }}" class="{{ $inp }}">
                        </div>
                        <div>
                            <label class="block font-semibold text-gray-700 mb-1.5">Urutan Tampil</label>
                            <input type="number" min="0" name="urutan" value="{{ $val('urutan') }}" placeholder="angka kecil tampil lebih dulu" class="{{ $inp }}">
                        </div>
                    </div>
                </div>

                {{-- JADWAL --}}
                <div class="bg-white rounded-2xl shadow-sm p-6 space-y-5">
                    <div class="flex items-center gap-3 pb-3 border-b border-gray-100">
                        <span class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </span>
                        <h2 class="font-bold text-navy-900">Jadwal Latihan</h2>
                    </div>

                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">Hari Latihan <span class="text-xs font-normal text-gray-400">(klik untuk memilih)</span></label>
                        <input type="hidden" name="hari_latihan" id="hariLatihan" value="{{ implode(',', $hariTerpilih) }}">
                        <div class="flex flex-wrap gap-2" id="hariWrap">
                            @foreach ($hariList as $h)
                                <button type="button" data-hari="{{ $h }}"
                                        class="hari-btn px-4 py-2 rounded-full border text-sm font-semibold transition
                                               {{ in_array($h, $hariTerpilih) ? 'bg-blue-600 text-white border-blue-600 shadow-md shadow-blue-200' : 'bg-white text-gray-500 border-gray-200 hover:border-blue-300 hover:text-blue-600' }}">
                                    {{ $h }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="block font-semibold text-gray-700 mb-1.5">Jam Latihan</label>
                        <input type="text" name="jam_latihan" value="{{ $val('jam_latihan') }}" placeholder="contoh: 15.00 - 17.00 WIB" class="{{ $inp }}">
                    </div>
                </div>
            </div>

            {{-- KANAN: GAMBAR --}}
            <div class="space-y-6">
                @foreach ([
                    ['name' => 'foto_sampul', 'label' => 'Foto Sampul', 'hint' => 'Tampil sebagai gambar besar di kartu ekskul', 'tinggi' => 'h-44'],
                    ['name' => 'gambar',      'label' => 'Logo',        'hint' => 'Tampil di beranda dan daftar ekskul',        'tinggi' => 'h-44'],
                ] as $g)
                    @php $url = $item?->urlGambar($g['name']); @endphp
                    <div class="bg-white rounded-2xl shadow-sm p-6">
                        <div class="flex items-center gap-3 pb-3 border-b border-gray-100 mb-4">
                            <span class="w-9 h-9 rounded-xl bg-yellow-100 text-yellow-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </span>
                            <div>
                                <h2 class="font-bold text-navy-900 leading-tight">{{ $g['label'] }}</h2>
                                <p class="text-[11px] text-gray-400">{{ $g['hint'] }}</p>
                            </div>
                        </div>

                        <label for="in_{{ $g['name'] }}"
                               class="block relative {{ $g['tinggi'] }} rounded-xl overflow-hidden border-2 border-dashed border-gray-200 hover:border-blue-400 bg-gray-50 cursor-pointer transition group">
                            <img id="pv_{{ $g['name'] }}" src="{{ $url }}" alt=""
                                 class="w-full h-full object-cover {{ $url ? '' : 'hidden' }}">
                            <div id="ph_{{ $g['name'] }}" class="absolute inset-0 flex flex-col items-center justify-center text-gray-400 {{ $url ? 'hidden' : '' }}">
                                <svg class="w-8 h-8 mb-1" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                <span class="text-xs">Klik untuk pilih gambar</span>
                            </div>
                            @if ($url)
                                <span class="absolute inset-x-0 bottom-0 bg-navy-900/70 text-white text-xs text-center py-1.5 opacity-0 group-hover:opacity-100 transition">Klik untuk ganti</span>
                            @endif
                        </label>
                        <input type="file" id="in_{{ $g['name'] }}" name="{{ $g['name'] }}" accept="image/*" class="hidden" data-pv="{{ $g['name'] }}">
                        <p class="text-[11px] text-gray-400 mt-2">Maks 2 MB. Kosongkan jika tidak ingin mengganti.</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- TOMBOL SIMPAN --}}
        <div class="sticky bottom-0 -mx-8 mt-8 px-8 py-4 bg-white/90 backdrop-blur border-t border-gray-100 flex items-center justify-end gap-3">
            <a href="{{ route('admin.ekskul') }}" class="px-6 py-2.5 rounded-xl border border-gray-200 text-gray-600 font-semibold hover:bg-gray-50 transition">Batal</a>
            <button class="px-8 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 text-white font-semibold shadow-md shadow-blue-200 hover:-translate-y-0.5 hover:shadow-lg transition-all">
                {{ $item ? 'Simpan Perubahan' : 'Simpan Ekskul' }}
            </button>
        </div>
    </form>

    <script>
        // pilih hari latihan
        const hiddenHari = document.getElementById('hariLatihan');
        const tombolHari = document.querySelectorAll('.hari-btn');
        const aktif = ['bg-blue-600', 'text-white', 'border-blue-600', 'shadow-md', 'shadow-blue-200'];
        const mati = ['bg-white', 'text-gray-500', 'border-gray-200'];

        tombolHari.forEach(btn => {
            btn.addEventListener('click', () => {
                const nyala = btn.classList.contains('bg-blue-600');
                aktif.forEach(c => btn.classList.toggle(c, !nyala));
                mati.forEach(c => btn.classList.toggle(c, nyala));
                hiddenHari.value = [...tombolHari]
                    .filter(b => b.classList.contains('bg-blue-600'))
                    .map(b => b.dataset.hari).join(',');
            });
        });

        // pratinjau gambar
        document.querySelectorAll('input[type=file][data-pv]').forEach(input => {
            input.addEventListener('change', () => {
                const file = input.files[0];
                if (!file) return;
                const img = document.getElementById('pv_' + input.dataset.pv);
                const ph = document.getElementById('ph_' + input.dataset.pv);
                img.src = URL.createObjectURL(file);
                img.classList.remove('hidden');
                ph.classList.add('hidden');
            });
        });
    </script>
@endsection