@extends('admin.layout')
@section('title', ($item ? 'Edit ' : 'Tambah ') . $c['title'])

@section('header')
    <div>
        <h1 class="font-bold text-navy-900 text-lg">{{ $item ? 'Edit' : 'Tambah' }} {{ $c['title'] }}</h1>
    </div>
@endsection

@section('content')
    <form action="{{ $item ? route($c['route'] . '.update', $item->id) : route($c['route'] . '.store') }}"
          method="POST" enctype="multipart/form-data"
          class="bg-white rounded-2xl shadow-sm p-6 max-w-2xl space-y-4 text-sm">
        @csrf
        @if ($item) @method('PUT') @endif

        @foreach ($c['fields'] as $f)
            @php $val = old($f['name'], $item?->{$f['name']} ?? (($defaults ?? [])[$f['name']] ?? '')); @endphp
            <div>
                <label class="block font-semibold mb-1">{{ $f['label'] }}</label>

                @if ($f['type'] === 'textarea')
                    <textarea name="{{ $f['name'] }}" rows="{{ $f['rows'] ?? 4 }}" class="w-full border rounded-lg px-3 py-2">{{ $val }}</textarea>

                @elseif ($f['type'] === 'select')
                    <select name="{{ $f['name'] }}" class="w-full border rounded-lg px-3 py-2">
                        @foreach ($f['options'] as $opt)
                            <option value="{{ $opt }}" @selected($val === $opt)>{{ $opt }}</option>
                        @endforeach
                    </select>

                @elseif ($f['type'] === 'image')
                    @if ($item && $item->urlGambar($f['name']))
                        <img src="{{ $item->urlGambar($f['name']) }}" class="w-40 rounded mb-2" alt="">
                        <p class="text-xs text-gray-400 mb-1">Pilih file baru hanya jika ingin mengganti gambar.</p>
                    @endif
                    <input type="file" name="{{ $f['name'] }}" accept="image/*">

                @else
                    <input type="{{ $f['type'] }}" name="{{ $f['name'] }}" value="{{ $val }}"
                           placeholder="{{ $f['placeholder'] ?? '' }}" class="w-full border rounded-lg px-3 py-2">
                @endif
            </div>
        @endforeach

        <div class="flex gap-3 pt-2">
            <button class="bg-blue-600 text-white font-semibold px-5 py-2 rounded-lg hover:bg-blue-700">Simpan</button>
            <a href="{{ $batal ?? route($c['route']) }}" class="px-5 py-2 rounded-lg border">Batal</a>
        </div>
    </form>
@endsection