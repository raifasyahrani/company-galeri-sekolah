<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - SMKN 4 Bogor</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif; }
        .admin-bg {
            background-color: #f1f5f9;
            background-image:
                radial-gradient(at 0% 0%, rgba(37, 99, 235, 0.07) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(99, 102, 241, 0.06) 0px, transparent 50%);
            background-attachment: fixed;
        }
        .flash-enter { animation: flashIn .35s ease-out; }
        @keyframes flashIn {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="text-slate-800 admin-bg antialiased">
<div class="flex min-h-screen">
    @include('partials.sidebar')

    <main class="flex-1 min-w-0">
        <header class="sticky top-0 z-30 bg-white/80 backdrop-blur-md border-b border-slate-200/70 px-8 py-4 flex items-center justify-between gap-4">
            @yield('header')
        </header>

        <div class="p-8 max-w-[1500px]">
            @if (session('success'))
                <div id="flashSuccess" class="flash-enter mb-6 flex items-start gap-3 rounded-2xl bg-emerald-50 ring-1 ring-emerald-200 text-emerald-800 px-5 py-4 text-sm shadow-sm">
                    <span class="mt-0.5 inline-flex items-center justify-center w-6 h-6 rounded-full bg-emerald-500 text-white shrink-0">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    </span>
                    <p class="flex-1 font-medium">{{ session('success') }}</p>
                    <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 text-lg leading-none">&times;</button>
                </div>
            @endif

            @if ($errors->any())
                <div class="flash-enter mb-6 flex items-start gap-3 rounded-2xl bg-red-50 ring-1 ring-red-200 text-red-800 px-5 py-4 text-sm shadow-sm">
                    <span class="mt-0.5 inline-flex items-center justify-center w-6 h-6 rounded-full bg-red-500 text-white shrink-0 font-bold text-xs">!</span>
                    <div class="flex-1">
                        <p class="font-semibold mb-1">Periksa kembali isian berikut:</p>
                        <ul class="list-disc pl-5 space-y-0.5">
                            @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-600 text-lg leading-none">&times;</button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>
</div>

<script>
    // Pesan sukses hilang otomatis setelah 5 detik
    (function () {
        var el = document.getElementById('flashSuccess');
        if (!el) return;
        setTimeout(function () {
            el.style.transition = 'opacity .4s, transform .4s';
            el.style.opacity = '0';
            el.style.transform = 'translateY(-8px)';
            setTimeout(function () { el.remove(); }, 400);
        }, 5000);
    })();
</script>
@stack('scripts')
</body>
</html>