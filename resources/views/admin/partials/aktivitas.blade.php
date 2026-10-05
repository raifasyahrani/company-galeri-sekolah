@php
    $logs = \App\Models\ActivityLog::latest()->take(8)->get();

    $gaya = [
        'tambah' => ['bg' => '#dcfce7', 'fg' => '#16a34a', 'kata' => 'menambah',  'icon' => 'M12 4v16m8-8H4'],
        'ubah'   => ['bg' => '#dbeafe', 'fg' => '#2563eb', 'kata' => 'mengubah',  'icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'],
        'hapus'  => ['bg' => '#fee2e2', 'fg' => '#dc2626', 'kata' => 'menghapus', 'icon' => 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16'],
    ];
@endphp

<div class="bg-white rounded-3xl shadow-sm p-6 h-full flex flex-col">
    <div class="flex items-center justify-between mb-5">
        <div class="flex items-center gap-3">
            <span class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:#eff6ff;color:#2563eb;">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </span>
            <div>
                <h3 class="font-bold text-navy-900 text-lg leading-tight">Aktivitas Terkini</h3>
                <p class="text-xs text-gray-400">Perubahan terbaru di admin</p>
            </div>
        </div>
        @if ($logs->count())
            <span class="text-[11px] font-bold px-2.5 py-1 rounded-full" style="background:#eff6ff;color:#2563eb;">{{ $logs->count() }} terbaru</span>
        @endif
    </div>

    @if ($logs->isEmpty())
        <div class="flex-1 flex flex-col items-center justify-center text-center py-8">
            <span class="w-14 h-14 rounded-2xl flex items-center justify-center mb-3" style="background:#f3f4f6;color:#9ca3af;">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </span>
            <p class="text-sm font-semibold text-gray-500">Belum ada aktivitas</p>
            <p class="text-xs text-gray-400 mt-1">Tambah atau edit data, riwayatnya muncul di sini.</p>
        </div>
    @else
        <ol class="relative flex-1 space-y-4" style="max-height:340px;overflow-y:auto;padding-right:4px;">
            <span class="absolute" style="left:19px;top:8px;bottom:8px;width:2px;background:#f1f5f9;"></span>
            @foreach ($logs as $log)
                @php $g = $gaya[$log->aksi] ?? $gaya['ubah']; @endphp
                <li class="relative flex items-start gap-3">
                    <span class="relative z-10 w-10 h-10 shrink-0 rounded-full flex items-center justify-center"
                          style="background:{{ $g['bg'] }};color:{{ $g['fg'] }};box-shadow:0 0 0 4px #fff;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $g['icon'] }}"/></svg>
                    </span>
                    <div class="min-w-0 flex-1 pt-0.5">
                        <p class="text-sm text-gray-700 leading-snug">
                            Admin {{ $g['kata'] }}
                            <span class="font-bold text-navy-900">{{ $log->modul }}</span>
                        </p>
                        @if ($log->judul)
                            <p class="text-xs text-gray-500 truncate">{{ $log->judul }}</p>
                        @endif
                        <p class="text-[11px] text-gray-400 mt-0.5">{{ $log->created_at->locale('id')->diffForHumans() }}</p>
                    </div>
                </li>
            @endforeach
        </ol>
    @endif
</div>