<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Jurusan - SMKN 4 Bogor</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-800 bg-gray-100">

    <div class="flex min-h-screen">

        @include('partials.sidebar')

        <main class="flex-1">
            <header class="bg-white shadow-sm px-8 py-4 flex items-center justify-between">
                <div>
                    <h1 class="font-bold text-navy-900 text-lg">Kelola Jurusan</h1>
                    <p class="text-xs text-gray-400">Kelola daftar jurusan sekolah</p>
                </div>
                <a href="{{ route('admin.jurusan.create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                    + Tambah Jurusan
                </a>
            </header>

            <div class="p-8">

                @if (session('success'))
                    <div class="bg-emerald-100 text-emerald-700 px-4 py-3 rounded-lg mb-5 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="bg-white rounded-2xl shadow-sm overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-[11px] uppercase text-gray-500">
                            <tr>
                                <th class="px-5 py-3">Foto</th>
                                <th class="px-5 py-3">Nama Jurusan</th>
                                <th class="px-5 py-3">Singkatan</th>
                                <th class="px-5 py-3">Deskripsi</th>
                                <th class="px-5 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jurusans as $j)
                                <tr class="border-t border-gray-100">
                                    <td class="px-5 py-3">
                                        @if ($j->gambar)
                                            <img src="{{ asset('storage/' . $j->gambar) }}" alt="{{ $j->nama }}"
                                                 class="w-12 h-12 object-cover rounded-lg">
                                        @else
                                            <span class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center text-gray-300 text-xs">-</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3 font-semibold text-navy-900">{{ $j->nama }}</td>
                                    <td class="px-5 py-3">
                                        <span class="px-2 py-1 rounded-full bg-blue-50 text-blue-600 text-xs font-semibold">{{ $j->singkatan }}</span>
                                    </td>
                                    <td class="px-5 py-3 text-gray-500 max-w-xs">{{ \Illuminate\Support\Str::limit($j->deskripsi, 80) }}</td>
                                    <td class="px-5 py-3">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('admin.jurusan.edit', $j) }}"
                                               class="px-3 py-1.5 border border-gray-200 rounded-lg text-xs hover:bg-gray-50">Edit</a>
                                            <form action="{{ route('admin.jurusan.destroy', $j) }}" method="POST"
                                                  onsubmit="return confirm('Hapus jurusan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="px-3 py-1.5 border border-red-200 text-red-600 rounded-lg text-xs hover:bg-red-50">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-10 text-center text-gray-400">Belum ada jurusan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </main>
    </div>

</body>
</html>