@extends('admin.layout')
@section('title', 'Beranda')

@section('header')
    <div>
        <h1 class="font-bold text-navy-900 text-lg">Beranda</h1>
        <p class="text-xs text-gray-400">Atur isi halaman beranda website</p>
    </div>
@endsection

@section('content')
    <form action="{{ route('admin.beranda.update') }}" method="POST" enctype="multipart/form-data"
          class="max-w-3xl space-y-6 text-sm">
        @csrf
        @method('PUT')

        {{-- HERO --}}
        <div class="bg-white rounded-2xl shadow-sm p-6 space-y-4">
            <h2 class="font-bold text-base">Bagian Utama (Hero)</h2>
            <div>
                <label class="block font-semibold mb-1">Judul</label>
                <input type="text" name="hero_judul" value="{{ old('hero_judul', $beranda->hero_judul) }}" class="w-full border rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block font-semibold mb-1">Sub judul</label>
                <input type="text" name="hero_subjudul" value="{{ old('hero_subjudul', $beranda->hero_subjudul) }}" class="w-full border rounded-lg px-3 py-2">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold mb-1">Teks tombol</label>
                    <input type="text" name="tombol_teks" value="{{ old('tombol_teks', $beranda->tombol_teks) }}" class="w-full border rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block font-semibold mb-1">Link tombol</label>
                    <input type="text" name="tombol_link" value="{{ old('tombol_link', $beranda->tombol_link) }}" class="w-full border rounded-lg px-3 py-2">
                </div>
            </div>
            <div>
                <label class="block font-semibold mb-1">Gambar hero (maks 2 MB)</label>
                @if ($beranda->hero_gambar)
                    <img src="{{ asset('storage/' . $beranda->hero_gambar) }}" class="w-48 rounded mb-2" alt="">
                    <p class="text-xs text-gray-400 mb-1">Pilih file baru hanya jika ingin mengganti gambar.</p>
                @endif
                <input type="file" name="hero_gambar" accept="image/*">
            </div>
        </div>

        {{-- TENTANG --}}
        <div class="bg-white rounded-2xl shadow-sm