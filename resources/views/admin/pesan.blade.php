@extends('admin.layout')
@section('title', 'Pesan Masuk')

@section('header')
    <div>
        <h1 class="font-bold text-navy-900 text-xl tracking-tight">Pesan Masuk</h1>
        <p class="text-xs text-gray-400 mt-0.5">Pesan dari formulir Kontak Kami</p>
    </div>
@endsection

@section('content')
    <div class="bg-white rounded-2xl shadow-sm p-6 text-sm">
        @forelse ($pesans as $p)
            <div style="border-bottom:1px solid #e2e8f0;padding:14px 0;display:flex;gap:16px;justify-content:space-between;">
                <div>
                    <p class="font-semibold">{{ $p->nama }}
                        <span style="color:#64748b;font-weight:400;">&lt;{{ $p->email }}&gt;</span>
                    </p>
                    <p style="margin-top:6px;white-space:pre-line;">{{ $p->pesan }}</p>
                    <p class="text-xs text-gray-400" style="margin-top:6px;">{{ $p->created_at->format('d-m-Y H:i') }}</p>
                </div>
                <form method="POST" action="{{ route('admin.pesan.destroy', $p->id) }}"
                      onsubmit="return confirm('Hapus pesan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="color:#dc2626;font-weight:600;">Hapus</button>
                </form>
            </div>
        @empty
            <p class="text-gray-400">Belum ada pesan.</p>
        @endforelse
    </div>
@endsection
