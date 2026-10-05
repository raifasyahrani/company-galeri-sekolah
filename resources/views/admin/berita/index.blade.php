<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita - SMKN 4 Bogor</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-800 bg-gray-100">
<div class="flex min-h-screen">
    @include('partials.sidebar')

    <main class="flex-1">
        <header class="bg-white shadow-sm px-8 py-4 flex items-center justify-between">
            <div>
                <h1 class="font-bold text-navy-900 text-lg">Berita</h1>
                <p class="text-xs text-gray-400">Kelola berita sekolah</p>
            </div>
            <a href="{{ route('admin.berita.create') }}"
               class="bg-blue-600 text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-blue-700">
                + Tambah Berita
            </a>
        </header>

        <div class="p-8">
            @if (session('success'))
                <div class="mb-4 rounded-lg bg-green-100 text-green-700 px-4 py-3 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-500 text-left">
                        <tr>
                            <th class="px-6 py-3">Gambar</th>
                            <th class="px-6 py-3">Judul</th>
                            <th class="px-6 py-3">Tanggal</th>
                            <th class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($beritas as $berita)
                            <tr class="border-t">
                                <td class="px-6 py-3">
                                    @if ($berita->gambar)
                                        <img src="{{ asset('storage/' . $berita->gambar) }}"
                                             class="w-16 h-12 object-cover rounded" alt="">
                                    @else
                                        <span class="text-gray-300">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3 font-semibold">{{ $berita->judul }}</td>
                                <td class="px-6 py-3">{{ $berita->tanggal ?? '-' }}</td>
                                <td class="px-6 py-3 text-right">
                                    <a href="{{ route('admin.berita.edit', $berita) }}"
                                       class="text-blue-600 font-semibold mr-3">Edit</a>
                                    <form action="{{ route('admin.berita.destroy', $berita) }}" method="POST"
                                          class="inline" onsubmit="return confirm('Hapus berita ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 font-semibold">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-400">Belum ada berita.</td>
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