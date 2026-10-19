@php
    // ====== PENGATURAN HUBUNGI IT ======
    // Ganti dengan nomor WhatsApp IT (boleh format 0812..., +62812..., atau 62812...)
    $nomorIT = '0812 3456 7890';
    $pesanWA = 'Halo IT PT Solusi Koneksi Anda, saya lupa email/kata sandi akun admin. Mohon bantuannya untuk pemulihan akun. Terima kasih.';

    // Rapikan nomor ke format internasional untuk wa.me
    $nomorWA = preg_replace('/\D+/', '', $nomorIT);
    if (str_starts_with($nomorWA, '0')) {
        $nomorWA = '62' . substr($nomorWA, 1);
    }
    $linkWA = 'https://wa.me/' . $nomorWA . '?text=' . rawurlencode($pesanWA);

    // Pesan error: pakai pesan dari controller bila ada, kalau tidak pakai pesan umum
    $pesanError = null;
    if ($errors->any()) {
        $pesanError = $errors->first('login')
            ?: 'Email atau kata sandi yang Anda masukkan tidak sesuai. Periksa kembali lalu coba lagi.';
    }
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - PT Solusi Koneksi Anda</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif; }
        .modal-fade-in { animation: modalFade .2s ease-out; }
        .modal-pop-in  { animation: modalPop .25s ease-out; }
        .card-rise     { animation: cardRise .6s ease-out both; }
        .alert-shake   { animation: alertShake .5s ease-in-out; }
        @keyframes modalFade { from { opacity: 0; } to { opacity: 1; } }
        @keyframes modalPop {
            from { opacity: 0; transform: translateY(12px) scale(.96); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
        @keyframes cardRise {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes alertShake {
            0%, 100% { transform: translateX(0); }
            20% { transform: translateX(-6px); }
            40% { transform: translateX(6px); }
            60% { transform: translateX(-4px); }
            80% { transform: translateX(4px); }
        }
    </style>
</head>
<body class="text-slate-800 antialiased">

    <div class="min-h-screen grid grid-cols-1 md:grid-cols-2">

        {{-- PANEL KIRI: FOTO + INFO PERUSAHAAN --}}
        <div class="relative hidden md:block bg-navy-900">
            @if (file_exists(public_path('images/hero.jpg')))
                <img src="{{ asset('images/hero.jpg') }}" alt="" class="absolute inset-0 w-full h-full object-cover">
            @endif
            <div class="absolute inset-0 bg-gradient-to-br from-navy-900/90 via-navy-900/70 to-blue-800/60"></div>

            <div class="relative z-10 h-full flex flex-col justify-between p-12 text-white">
                {{-- LOGO --}}
                <div class="flex items-center gap-4">
                    <span class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-white shadow-xl shadow-black/20 p-2">
                        <svg viewBox="0 0 40 40" class="w-full h-full rounded-xl" role="img" aria-label="Logo PT Solusi Koneksi Anda">
                            <rect width="40" height="40" fill="#2159e0"/>
                            <path d="M7 27c6-10 14-14 26-14" stroke="#fff" stroke-width="3.2" fill="none" stroke-linecap="round"/>
                            <path d="M7 20c6-7 14-10 26-10" stroke="#fff" stroke-width="3.2" fill="none" stroke-linecap="round" opacity=".5"/>
                            <circle cx="31" cy="30" r="3.5" fill="#fbbf24"/>
                        </svg>
                    </span>
                    <div class="leading-tight">
                        <p class="font-extrabold tracking-wide">SOLUSI KONEKSI</p>
                        <p class="text-[11px] font-semibold tracking-[0.2em] text-blue-200">ADMIN PANEL</p>
                    </div>
                </div>

                {{-- JUDUL --}}
                <div>
                    <span class="block w-14 h-1.5 rounded-full bg-gradient-to-r from-blue-400 to-blue-200 mb-6"></span>
                    <h1 class="text-4xl lg:text-5xl font-extrabold leading-tight mb-5">
                        Sistem Informasi<br>PT Solusi Koneksi Anda
                    </h1>
                    <p class="text-white/80 text-base max-w-md leading-relaxed">
                        Kelola konten website perusahaan dengan mudah dan cepat.
                    </p>
                </div>

                {{-- KONTAK --}}
                <div class="space-y-3 text-xs text-white/85 max-w-md">
                    <div class="flex items-start gap-3 bg-white/10 backdrop-blur-md ring-1 ring-white/15 rounded-2xl px-4 py-3">
                        <svg class="w-4 h-4 mt-0.5 shrink-0 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="leading-relaxed">{{ config('perusahaan.alamat') }}</span>
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
                        <div class="flex items-center gap-3 bg-white/10 backdrop-blur-md ring-1 ring-white/15 rounded-2xl px-4 py-3">
                            <svg class="w-4 h-4 shrink-0 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span>{{ config('perusahaan.telepon') }}</span>
                        </div>
                        <div class="flex items-center gap-3 bg-white/10 backdrop-blur-md ring-1 ring-white/15 rounded-2xl px-4 py-3">
                            <svg class="w-4 h-4 shrink-0 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span class="break-all">{{ config('perusahaan.email') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- PANEL KANAN: FORM LOGIN --}}
        <div class="relative flex items-center justify-center bg-gradient-to-br from-slate-50 via-white to-blue-50 px-6 py-12 overflow-hidden">
            <div class="pointer-events-none absolute -top-24 -right-24 w-72 h-72 rounded-full bg-blue-200/40 blur-3xl"></div>
            <div class="pointer-events-none absolute -bottom-28 -left-20 w-72 h-72 rounded-full bg-indigo-200/30 blur-3xl"></div>

            <div class="relative w-full max-w-md card-rise">

                {{-- Logo mobile (muncul saat layar kecil, panel kiri disembunyikan) --}}
                <div class="text-center mb-8 md:hidden">
                    <span class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-navy-900 shadow-lg mb-3 p-2">
                        <svg viewBox="0 0 40 40" class="w-full h-full rounded-xl" role="img" aria-label="Logo PT Solusi Koneksi Anda">
                            <rect width="40" height="40" fill="#2159e0"/>
                            <path d="M7 27c6-10 14-14 26-14" stroke="#fff" stroke-width="3.2" fill="none" stroke-linecap="round"/>
                            <path d="M7 20c6-7 14-10 26-10" stroke="#fff" stroke-width="3.2" fill="none" stroke-linecap="round" opacity=".5"/>
                            <circle cx="31" cy="30" r="3.5" fill="#fbbf24"/>
                        </svg>
                    </span>
                    <h1 class="text-navy-900 font-extrabold text-lg">SOLUSI KONEKSI</h1>
                </div>

                <div class="bg-white rounded-3xl shadow-2xl shadow-blue-900/10 ring-1 ring-slate-100 p-8 sm:p-10">

                    <div class="flex items-center gap-4 mb-7">
                        <span class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-600 to-blue-500 text-white shadow-lg shadow-blue-600/30 shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </span>
                        <div>
                            <h2 class="text-2xl font-extrabold text-navy-900 leading-tight">Selamat Datang</h2>
                            <p class="text-sm text-slate-500 mt-0.5">Silakan masuk untuk mengakses sistem.</p>
                        </div>
                    </div>

                    {{-- PEMBERITAHUAN ERROR --}}
                    @if ($pesanError)
                        <div class="alert-shake mb-6 rounded-2xl bg-red-50 ring-1 ring-red-200 px-4 py-4" role="alert">
                            <div class="flex items-start gap-3">
                                <span class="mt-0.5 inline-flex items-center justify-center w-7 h-7 rounded-full bg-red-500 text-white shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01"/></svg>
                                </span>
                                <div class="flex-1">
                                    <p class="text-sm font-bold text-red-700">Gagal masuk</p>
                                    <p class="text-sm text-red-600 mt-0.5 leading-relaxed">{{ $pesanError }}</p>
                                    <p class="text-xs text-red-500 mt-2">
                                        Lupa email atau kata sandi?
                                        <button type="button" data-buka-lupa class="font-bold underline hover:text-red-700">Hubungi IT</button>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-5" autocomplete="off" id="formLogin">
                        @csrf
                        {{-- Trik anti-autofill: input dummy tersembunyi agar Chrome tidak mengisi otomatis field asli di bawah --}}
                        <input type="text" name="fake_username" autocomplete="username" class="hidden" tabindex="-1" aria-hidden="true">
                        <input type="password" name="fake_password" autocomplete="new-password" class="hidden" tabindex="-1" aria-hidden="true">

                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-2">Email</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </span>
                                <input
                                    type="email"
                                    name="email"
                                    value=""
                                    placeholder="Masukkan email"
                                    required
                                    autofocus
                                    autocomplete="off"
                                    autocapitalize="off"
                                    spellcheck="false"
                                    class="w-full pl-11 pr-4 py-3 text-sm bg-slate-50 border {{ $pesanError ? 'border-red-300' : 'border-slate-200' }} rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 transition">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-2">Kata Sandi</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                </span>
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    value=""
                                    placeholder="••••••••"
                                    required
                                    autocomplete="new-password"
                                    class="w-full pl-11 pr-11 py-3 text-sm bg-slate-50 border {{ $pesanError ? 'border-red-300' : 'border-slate-200' }} rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 transition">
                                <button
                                    type="button"
                                    id="togglePassword"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition"
                                    aria-label="Tampilkan/sembunyikan kata sandi">
                                    <svg id="eyeIconOpen" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg id="eyeIconClosed" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a10.025 10.025 0 012.132-3.411m3.087-2.386A9.955 9.955 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.965 9.965 0 01-4.132 5.411M15 12a3 3 0 11-6 0 3 3 0 016 0zM3 3l18 18"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="button" data-buka-lupa class="text-xs font-bold text-blue-600 hover:text-blue-700 hover:underline">Lupa email atau kata sandi?</button>
                        </div>

                        <button type="submit" id="btnLogin"
                                class="w-full bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-bold text-sm py-3.5 rounded-xl shadow-lg shadow-blue-600/30 hover:shadow-blue-600/40 hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                            <span id="teksLogin">Login</span>
                        </button>
                    </form>

                    <p class="text-center text-xs text-slate-400 mt-7">&copy; {{ date('Y') }} PT Solusi Koneksi Anda. All rights reserved.</p>
                </div>

                <div class="text-center mt-6">
                    <a href="{{ route('welcome') }}" class="text-slate-400 hover:text-navy-900 text-sm font-medium transition inline-flex items-center gap-1">
                        ← Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>

    </div>

    {{-- MODAL: LUPA EMAIL / KATA SANDI -> HUBUNGI IT --}}
    <div id="modalLupa" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4" role="dialog" aria-modal="true" aria-labelledby="judulLupa">
        <div id="modalOverlay" class="modal-fade-in absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

        <div class="modal-pop-in relative w-full max-w-sm bg-white rounded-3xl shadow-2xl p-8 text-center">
            <span class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-blue-50 text-blue-600 ring-1 ring-blue-100 mb-5">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </span>

            <h3 id="judulLupa" class="text-xl font-extrabold text-navy-900 mb-2">Hubungi IT</h3>
            <p class="text-sm text-slate-500 leading-relaxed mb-7">
                Lupa email atau kata sandi? Silakan hubungi tim IT PT Solusi Koneksi Anda melalui WhatsApp untuk pemulihan akun.
            </p>

            <div class="grid grid-cols-2 gap-3">
                <button type="button" id="btnBatal"
                        class="py-3 rounded-xl text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 transition">
                    Batal
                </button>
                <a href="{{ $linkWA }}" target="_blank" rel="noopener" id="btnHubungi"
                   class="py-3 rounded-xl text-sm font-semibold text-white bg-green-600 hover:bg-green-700 shadow-lg shadow-green-600/25 transition inline-flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h8M8 14h5M21 12c0 4.418-4.03 8-9 8a9.9 9.9 0 01-3.6-.67L3 21l1.4-4.2A7.6 7.6 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    Hubungi
                </a>
            </div>
        </div>
    </div>

    <script>
        // ===== Tampilkan / sembunyikan kata sandi =====
        const passwordInput = document.getElementById('password');
        const toggleBtn = document.getElementById('togglePassword');
        const eyeOpen = document.getElementById('eyeIconOpen');
        const eyeClosed = document.getElementById('eyeIconClosed');

        toggleBtn.addEventListener('click', () => {
            const isHidden = passwordInput.type === 'password';
            passwordInput.type = isHidden ? 'text' : 'password';
            eyeOpen.classList.toggle('hidden', isHidden);
            eyeClosed.classList.toggle('hidden', !isHidden);
        });

        // ===== Tombol Login: tampilkan "Memproses..." saat dikirim =====
        const formLogin = document.getElementById('formLogin');
        const btnLogin = document.getElementById('btnLogin');
        const teksLogin = document.getElementById('teksLogin');

        formLogin.addEventListener('submit', () => {
            teksLogin.textContent = 'Memproses...';
            btnLogin.classList.add('opacity-80', 'pointer-events-none');
        });
        // Kembalikan tampilan tombol jika pengguna menekan tombol "kembali" di browser
        window.addEventListener('pageshow', () => {
            teksLogin.textContent = 'Login';
            btnLogin.classList.remove('opacity-80', 'pointer-events-none');
        });

        // ===== Modal Lupa Email / Kata Sandi =====
        const modalLupa = document.getElementById('modalLupa');
        const btnBatal = document.getElementById('btnBatal');
        const btnHubungi = document.getElementById('btnHubungi');
        const modalOverlay = document.getElementById('modalOverlay');
        let pembuka = null;

        function bukaModal(e) {
            pembuka = e.currentTarget;
            modalLupa.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            btnBatal.focus();
        }

        function tutupModal() {
            modalLupa.classList.add('hidden');
            document.body.style.overflow = '';
            if (pembuka) pembuka.focus();
        }

        document.querySelectorAll('[data-buka-lupa]').forEach((el) => el.addEventListener('click', bukaModal));
        btnBatal.addEventListener('click', tutupModal);
        modalOverlay.addEventListener('click', tutupModal);
        btnHubungi.addEventListener('click', () => setTimeout(tutupModal, 150));
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !modalLupa.classList.contains('hidden')) tutupModal();
        });
    </script>

</body>
</html>