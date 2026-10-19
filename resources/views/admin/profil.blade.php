@extends('admin.layout')
@section('title', 'Profil Perusahaan')

@section('header')
    <div>
        <h1 class="font-bold text-navy-900 text-lg">Profil Perusahaan</h1>
        <p class="text-xs text-gray-400">Halaman statis: hanya bisa diperbarui. Akun admin: {{ session('admin_email') }}</p>
    </div>
@endsection

@section('content')
    <form action="{{ route('admin.profil.update') }}" method="POST"
          class="bg-white rounded-2xl shadow-sm p-6 max-w-3xl space-y-4 text-sm">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="block font-semibold mb-1">Direktur</label>
                <input type="text" name="direktur" value="{{ old('direktur', $profil->direktur) }}" class="w-full border rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block font-semibold mb-1">Legalitas (NIB/SIUP)</label>
                <input type="text" name="legalitas" value="{{ old('legalitas', $profil->legalitas) }}" class="w-full border rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block font-semibold mb-1">Tahun berdiri</label>
                <input type="text" name="tahun_berdiri" value="{{ old('tahun_berdiri', $profil->tahun_berdiri) }}" class="w-full border rounded-lg px-3 py-2">
            </div>
        </div>
        <div>
            <label class="block font-semibold mb-1">Sejarah</label>
            <textarea name="sejarah" rows="5" class="w-full border rounded-lg px-3 py-2">{{ old('sejarah', $profil->sejarah) }}</textarea>
        </div>
        <div>
            <label class="block font-semibold mb-1">Visi</label>
            <textarea name="visi" rows="3" class="w-full border rounded-lg px-3 py-2">{{ old('visi', $profil->visi) }}</textarea>
        </div>
        <div>
            <label class="block font-semibold mb-1">Misi (satu poin per baris)</label>
            <textarea name="misi" rows="5" class="w-full border rounded-lg px-3 py-2">{{ old('misi', $profil->misi) }}</textarea>
        </div>

        <button class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-blue-700">Simpan Perubahan</button>
    </form>
@endsection
