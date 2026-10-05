@if ($errors->any())
    <div class="mb-4 rounded-lg bg-red-100 text-red-700 px-4 py-3 text-sm">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="space-y-4 text-sm">
    <div>
        <label class="block font-semibold mb-1">Judul</label>
        <input type="text" name="judul" value="{{ old('judul', $berita->judul ?? '') }}"
               class="w-full border rounded-lg px-3 py-2">
    </div>
    <div>
        <label class="block font-semibold mb-1">Tanggal</label>
        <input type="date" name="tanggal" value="{{ old('tanggal', $berita->tanggal ?? '') }}"
               class="w-full border rounded-lg px-3 py-2">
    </div>
    <div>
        <label class="block font-semibold mb-1">Isi Berita</label>
        <textarea name="isi" rows="6" class="w-full border rounded-lg px-3 py-2">{{ old('isi', $berita->isi ?? '') }}</textarea>
    </div>
    <div>
        <label class="block font-semibold mb-1">Gambar (maks 2 MB)</label>
        @if (!empty($berita->gambar))
            <img src="{{ asset('storage/' . $berita->gambar) }}" class="w-32 rounded mb-2" alt="">
        @endif
        <input type="file" name="gambar" accept="image/*">
    </div>
    <div class="flex gap-3 pt-2">
        <button class="bg-blue-600 text-white font-semibold px-5 py-2 rounded-lg hover:bg-blue-700">Simpan</button>
        <a href="{{ route('admin.berita') }}" class="px-5 py-2 rounded-lg border">Batal</a>
    </div>
</div>