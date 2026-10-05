@extends('admin.layouts.app')

@section('content')
@php $isEdit = isset($berita); @endphp

<div class="p-6 max-w-2xl">
    <h1 class="text-xl font-bold mb-4">{{ $isEdit ? 'Edit Berita' : 'Tambah Berita' }}</h1>

    <form action="{{ $isEdit ? route('admin.berita.update', $berita) : route('admin.berita.store') }}"
          method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @if($isEdit) @method('PUT') @endif

        <div>
            <label class="block text-sm mb-1">Judul</label>
            <input type="text" name="judul"
                   value="{{ old('judul', $berita->judul ?? '') }}"
                   class="w-full border rounded p-2">
            @error('judul')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm mb-1">Kategori</label>
            <input type="text" name="kategori"
                   value="{{ old('kategori', $berita->kategori ?? '') }}"
                   class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block text-sm mb-1">Tanggal</label>
            <input type="date" name="tanggal"
                   value="{{ old('tanggal', $berita->tanggal ?? '') }}"
                   class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block text-sm mb-1">Isi</label>
            <textarea name="isi" rows="6"
                      class="w-full border rounded p-2">{{ old('isi', $berita->isi ?? '') }}</textarea>
            @error('isi')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm mb-1">Gambar</label>
            <input type="file" name="gambar" class="w-full border rounded p-2">
            @error('gambar')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
            @if($isEdit && $berita->gambar)
                <img src="{{ asset('storage/'.$berita->gambar) }}" class="w-24 mt-2 rounded">
            @endif
        </div>

        <div class="flex gap-2">
            <button class="bg-blue-700 text-white px-4 py-2 rounded text-sm">Simpan</button>
            <a href="{{ route('admin.berita') }}" class="px-4 py-2 border rounded text-sm">Batal</a>
        </div>
    </form>
</div>
@endsection