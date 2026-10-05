@extends('admin.layouts.app')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-xl font-bold">Kelola Berita</h1>
            <p class="text-sm text-gray-500">Kelola daftar berita sekolah</p>
        </div>
        <a href="{{ route('admin.berita.create') }}"
           class="bg-blue-700 text-white px-4 py-2 rounded text-sm">+ Tambah</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                <tr>
                    <th class="p-3">Foto</th>
                    <th class="p-3">Judul</th>
                    <th class="p-3">Kategori</th>
                    <th class="p-3">Tanggal</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($beritas as $b)
                <tr class="border-t">
                    <td class="p-3">
                        @if($b->gambar)
                            <img src="{{ asset('storage/'.$b->gambar) }}"
                                 class="w-12 h-12 object-cover rounded">
                        @endif
                    </td>
                    <td class="p-3 font-semibold">{{ $b->judul }}</td>
                    <td class="p-3">{{ $b->kategori }}</td>
                    <td class="p-3">{{ $b->tanggal }}</td>
                    <td class="p-3">
                        <div class="flex gap-2">
                            <a href="{{ route('admin.berita.edit', $b) }}"
                               class="px-2 py-1 border rounded">Edit</a>
                            <form action="{{ route('admin.berita.destroy', $b) }}" method="POST"
                                  onsubmit="return confirm('Hapus berita ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="px-2 py-1 border rounded text-red-600">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-6 text-center text-gray-400">Belum ada data</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $beritas->links() }}</div>
</div>
@endsection