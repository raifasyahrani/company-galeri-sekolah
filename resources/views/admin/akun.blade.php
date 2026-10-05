<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Saya - SMKN 4 Bogor</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-800 bg-gray-100">

    <div class="flex min-h-screen">

        @include('partials.sidebar')

        <main class="flex-1">
            <header class="bg-white shadow-sm px-8 py-4 flex items-center justify-between">
                <div>
                    <h1 class="font-bold text-navy-900 text-xl">Akun Saya</h1>
                    <p class="text-sm text-gray-400">Informasi akun admin yang sedang login.</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="text-sm font-semibold text-gray-500 hover:text-navy-900 transition inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Dashboard
                </a>
            </header>

            <div class="p-8">
                <div class="max-w-2xl bg-white rounded-2xl shadow-sm overflow-hidden">

                    {{-- HEADER PROFIL --}}
                    <div class="bg-gradient-to-br from-navy-900 to-blue-900 px-8 py-10 flex items-center gap-5">
                        <span class="w-20 h-20 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 text-white flex items-center justify-center font-bold text-3xl shadow-lg shadow-black/20 ring-4 ring-white/10">
                            A
                        </span>
                        <div>
                            <p class="text-white font-bold text-xl">Admin SMKN 4</p>
                            <p class="text-blue-200 text-sm">{{ session('admin_email') }}</p>
                            <span class="inline-flex items-center gap-1.5 mt-2 bg-white/10 text-white text-[11px] font-semibold px-2.5 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                Sesi Aktif
                            </span>
                        </div>
                    </div>

                    {{-- DETAIL --}}
                    <div class="p-8 space-y-5">
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <span class="text-sm text-gray-400">Email</span>
                            <span class="text-sm font-semibold text-navy-900">{{ session('admin_email') }}</span>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <span class="text-sm text-gray-400">Role</span>
                            <span class="text-sm font-semibold text-navy-900">Administrator</span>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <span class="text-sm text-gray-400">Status</span>
                            <span class="inline-flex items-center gap-1.5 font-semibold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full text-xs">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Aktif
                            </span>
                        </div>

                        <form method="POST" action="{{ route('admin.logout') }}" class="pt-3">
                            @csrf
                            <button type="submit" class="w-full flex items-center justify-center gap-2 bg-red-50 hover:bg-red-100 text-red-600 font-semibold text-sm px-4 py-3 rounded-xl transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>
</html>