@extends('admin.layout')
@section('title', ($item ? 'Edit ' : 'Tambah ') . 'Prestasi')

@section('header')
    <div>
        <h1 class="font-bold text-navy-900 text-lg">{{ $item ? 'Edit Prestasi' : 'Tambah Prestasi' }}</h1>
        <p class="text-xs text-gray-400">Prestasi akan tampil di bagian "Kebanggaan Kami" pada beranda</p>
    </div>
    <a href="{{ route('admin.prestasi') }}" class="text-sm font-semibold text-gray-500 hover:text-blue-600 transition">&larr; Kembali</a>
@endsection

@section('content')
    @php
        $inp = 'w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-300 transition';
        $url = $item?->urlGambar();
    @endphp

    <form action="{{ $item ? route('admin.prestasi.update', $item->id) : route('admin.prestasi.store') }}"
          method="POST" enctype="multipart/form-data" class="text-sm">
        @csrf
        @if ($item) @method('PUT') @endif

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <div class="xl:col-span-2 bg-white rounded-2xl shadow-sm p-6 space-y-5">
                <div class="flex items-center gap-3 pb-3 border-b border-gray-100">
                    <span class="w-9 h-9 rounded-xl bg-yellow-100 text-yellow-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21 12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2Z"/></svg>
                    </span>
                    <h2 class="font-bold text-navy-900">Informasi Prestasi</h2>
                </div>

                <div>
                    <label class="block font-semibold text-gray-700 mb-1.5">Judul prestasi <span class="text-red-500">*</span></label>
                    <input type="text" name="judul" value="{{ old('judul', $item->judul ?? '') }}" placeholder="contoh: Juara 1 LKS Tingkat Kota" class="{{ $inp }}">
                </div>
                <div>
                    <label class="block font-semibold text-gray-700 mb-1.5">Tahun <span class="text-red-500">*</span></label>
                    <input type="text" name="tahun" value="{{ old('tahun', $item->tahun ?? date('Y')) }}" maxlength="10" placeholder="contoh: 2026" class="{{ $inp }}">
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-6">
                <div class="flex items-center gap-3 pb-3 border-b border-gray-100 mb-4">
                    <span class="w-9 h-9 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </span>
                    <h2 class="font-bold text-navy-900">Foto</h2>
                </div>

                <label for="in_gambar" class="block relative h-52 rounded-xl overflow-hidden border-2 border-dashed border-gray-200 hover:border-blue-400 bg-gray-50 cursor-pointer transition">
                    <img id="pv" src="{{ $url }}" alt="" class="w-full h-full object-cover {{ $url ? '' : 'hidden' }}">
                    <div id="ph" class="absolute inset-0 flex flex-col items-center justify-center text-gray-400 {{ $url ? 'hidden' : '' }}">
                        <svg class="w-8 h-8 mb-1" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        <span class="text-xs">Klik untuk pilih foto</span>
                    </div>
                </label>
                <input type="file" id="in_gambar" name="gambar" accept="image/*" class="hidden">
                <p class="text-[11px] text-gray-400 mt-2">Maks 2 MB. Kosongkan jika tidak ingin mengganti.</p>
            </div>
        </div>

        <div class="sticky bottom-0 -mx-8 mt-8 px-8 py-4 bg-white/90 backdrop-blur border-t border-gray-100 flex items-center justify-end gap-3">
            <a href="{{ route('admin.prestasi') }}" class="px-6 py-2.5 rounded-xl border border-gray-200 text-gray-600 font-semibold hover:bg-gray-50 transition">Batal</a>
            <button class="px-8 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 text-white font-semibold shadow-md shadow-blue-200 hover:-translate-y-0.5 hover:shadow-lg transition-all">
                {{ $item ? 'Simpan Perubahan' : 'Simpan Prestasi' }}
            </button>
        </div>
    </form>

    <script>
        document.getElementById('in_gambar').addEventListener('change', e => {
            const f = e.target.files[0];
            if (!f) return;
            const img = document.getElementById('pv');
            img.src = URL.createObjectURL(f);
            img.classList.remove('hidden');
            document.getElementById('ph').classList.add('hidden');
        });
    </script>
@endsection