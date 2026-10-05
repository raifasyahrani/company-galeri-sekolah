@php $isEdit = isset($jurusan); @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $isEdit ? 'Edit' : 'Tambah' }} Jurusan - SMKN 4 Bogor</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-800 bg-gray-100">

    <div class="flex min-h-screen">

        @include('partials.sidebar')

        <main class="flex-1">
            <header class="bg-white shadow-sm px-8 py-4">
                <h1 class="font-bold text-navy-900 text-lg">{{ $isEdit ? 'Edit Jurusan' : 'Tambah Jurusan' }}</h1>
                <p class="text-xs text-gray-400">Isi data jurusan dengan lengkap</p>
            </header>

            <div class="p-8">
                <form action="{{ $isEdit ? route('admin.jurusan.update', $jurusan) : route('admin.jurusan.store') }}"
                      method="POST" enctype="multipart/form-data"
                      class="bg-white rounded-2xl shadow-sm p-6 max-w-2xl space-y-5">
                    @csrf
                    @if ($isEdit)
                        @method('PUT')
                    @endif

                    <div>
                        <label class="block text-sm font-semibold mb-1">Nama Jurusan</label>
                        <input type="text" name="nama" value="{{ old('nama', $jurusan->nama ?? '') }}"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-500">
                        @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Singkatan</label>
                        <input type="text" name="singkatan" value="{{ old('singkatan', $jurusan->singkatan ?? '') }}"
                               placeholder="Contoh: PPLG"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-500">
                        @error('singkatan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Deskripsi</label>
                        <textarea name="deskripsi" rows="5"
                                  class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-500">{{ old('deskripsi', $jurusan->deskripsi ?? '') }}</textarea>
                        @error('deskripsi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Foto</label>
                        <input type="file" name="gambar" accept="image/*"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
                        @error('gambar') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        @if ($isEdit && $jurusan->gambar)
                            <img src="{{ asset('storage/' . $jurusan->gambar) }}" alt="Foto saat ini"
                                 class="w-28 mt-3 rounded-lg">
                            <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengganti foto.</p>
                        @endif
                    </div>

                    <div class="flex gap-2 pt-2">
                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition">Simpan</button>
                        <a href="{{ route('admin.jurusan') }}"
                           class="px-5 py-2 border border-gray-200 rounded-lg text-sm hover:bg-gray-50">Batal</a>
                    </div>
                </form>
            </div>
        </main>
    </div>

</body>
</html>