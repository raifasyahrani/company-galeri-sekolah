@php
    $isEdit = isset($galeri);
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $isEdit ? 'Edit' : 'Tambah' }} Foto Galeri - SMKN 4 Bogor</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-800 bg-gray-100">

    <div class="flex min-h-screen">

        @include('partials.sidebar')

        <main class="flex-1">
            <header class="bg-white shadow-sm px-8 py-4 flex items-center justify-between">
                <div>
                    <h1 class="font-bold text-navy-900 text-lg">{{ $isEdit ? 'Edit Foto Galeri' : 'Tambah Foto Galeri' }}</h1>
                    <p class="text-xs text-gray-400">
                        {{ $isEdit ? 'Perbarui data foto kegiatan sekolah' : 'Unggah foto kegiatan sekolah' }}
                    </p>
                </div>
                <a href="{{ route('admin.galeri') }}"
                   class="border border-gray-200 hover:bg-gray-50 px-4 py-2 rounded-lg text-sm font-semibold transition">
                    ← Kembali
                </a>
            </header>

            <div class="p-8">
                <form action="{{ $isEdit ? route('admin.galeri.update', $galeri) : route('admin.galeri.store') }}"
                      method="POST" enctype="multipart/form-data"
                      class="bg-white rounded-2xl shadow-sm p-6 max-w-2xl space-y-5">
                    @csrf
                    @if ($isEdit)
                        @method('PUT')
                    @endif

                    {{-- JUDUL --}}
                    <div>
                        <label for="judul" class="block text-sm font-semibold text-navy-900 mb-1">Judul Foto</label>
                        <input type="text" id="judul" name="judul"
                               value="{{ old('judul', $isEdit ? $galeri->judul : '') }}"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('judul')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- TANGGAL --}}
                    <div>
                        <label for="tanggal" class="block text-sm font-semibold text-navy-900 mb-1">Tanggal (opsional)</label>
                        <input type="date" id="tanggal" name="tanggal"
                               value="{{ old('tanggal', $isEdit ? optional($galeri->tanggal)->format('Y-m-d') : '') }}"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('tanggal')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- KETERANGAN --}}
                    <div>
                        <label for="keterangan" class="block text-sm font-semibold text-navy-900 mb-1">Keterangan (opsional)</label>
                        <textarea id="keterangan" name="keterangan" rows="3"
                                  class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('keterangan', $isEdit ? $galeri->keterangan : '') }}</textarea>
                        @error('keterangan')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- FOTO --}}
                    <div>
                        <label for="gambar" class="block text-sm font-semibold text-navy-900 mb-1">
                            Foto {{ $isEdit ? '(kosongkan jika tidak diganti)' : '' }}
                        </label>

                        <div class="mb-3">
                            @if ($isEdit && $galeri->gambar)
                                <img id="preview" src="{{ asset('storage/' . $galeri->gambar) }}" alt="{{ $galeri->judul }}"
                                     class="w-full max-w-sm h-48 object-cover rounded-xl border border-gray-100">
                            @else
                                <img id="preview" src="" alt="Pratinjau"
                                     class="hidden w-full max-w-sm h-48 object-cover rounded-xl border border-gray-100">
                            @endif
                        </div>

                        <input type="file" id="gambar" name="gambar" accept=".jpg,.jpeg,.png,.webp"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100">
                        <p class="text-[11px] text-gray-400 mt-1">Format jpg, jpeg, png, atau webp. Maksimal 2 MB.</p>
                        @error('gambar')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition">
                            {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Foto' }}
                        </button>
                        <a href="{{ route('admin.galeri') }}"
                           class="border border-gray-200 hover:bg-gray-50 px-5 py-2 rounded-lg text-sm font-semibold transition">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        // Pratinjau foto sebelum diunggah
        document.getElementById('gambar').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (!file) return;
            const img = document.getElementById('preview');
            img.src = URL.createObjectURL(file);
            img.classList.remove('hidden');
        });
    </script>

</body>
</html>