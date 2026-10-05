@php
    $isEdit = isset($ekskul);
    $hariTerpilih = old('hari_latihan', $isEdit ? $ekskul->hari_list : []);
    $logoAwal = $isEdit ? $ekskul->logo_url : null;
    $sampulAwal = $isEdit ? $ekskul->sampul_url : null;
    $inputClass = 'w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500';
    $fileClass = 'block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100';
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $isEdit ? 'Edit' : 'Tambah' }} Ekstrakurikuler - SMKN 4 Bogor</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-800 bg-gray-100">

    <div class="flex min-h-screen">

        @include('partials.sidebar')

        <main class="flex-1 min-w-0">
            <header class="bg-white shadow-sm px-8 py-4 flex items-center justify-between">
                <div>
                    <h1 class="font-bold text-navy-900 text-lg">{{ $isEdit ? 'Edit Ekstrakurikuler' : 'Tambah Ekstrakurikuler' }}</h1>
                    <p class="text-xs text-gray-400">Perubahan langsung tampil di halaman Ekstrakurikuler website</p>
                </div>
                <a href="{{ route('admin.ekskul') }}"
                   class="border border-gray-200 hover:bg-gray-50 px-4 py-2 rounded-lg text-sm font-semibold transition">
                    ← Kembali
                </a>
            </header>

            <div class="p-8 grid grid-cols-1 xl:grid-cols-5 gap-8 items-start">

                {{-- ================= FORM ================= --}}
                <form action="{{ $isEdit ? route('admin.ekskul.update', $ekskul) : route('admin.ekskul.store') }}"
                      method="POST" enctype="multipart/form-data"
                      class="xl:col-span-3 bg-white rounded-2xl shadow-sm p-6 space-y-6">
                    @csrf
                    @if ($isEdit)
                        @method('PUT')
                    @endif

                    @if ($errors->any())
                        <div class="bg-red-50 text-red-700 border border-red-100 rounded-lg px-4 py-3 text-sm">
                            Ada isian yang belum sesuai. Periksa pesan merah di bawah kolom.
                        </div>
                    @endif

                    {{-- INFO UTAMA --}}
                    <div class="space-y-4">
                        <h2 class="text-xs font-bold tracking-widest uppercase text-blue-600">Info Utama</h2>

                        <div>
                            <label for="nama" class="block text-sm font-semibold text-navy-900 mb-1">Nama Ekstrakurikuler</label>
                            <input type="text" id="nama" name="nama" value="{{ old('nama', $isEdit ? $ekskul->nama : '') }}" class="{{ $inputClass }}">
                            @error('nama') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="deskripsi" class="block text-sm font-semibold text-navy-900 mb-1">Deskripsi / Caption</label>
                            <textarea id="deskripsi" name="deskripsi" rows="4" class="{{ $inputClass }}">{{ old('deskripsi', $isEdit ? $ekskul->deskripsi : '') }}</textarea>
                            @error('deskripsi') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- KEPENGURUSAN --}}
                    <div class="space-y-4">
                        <h2 class="text-xs font-bold tracking-widest uppercase text-blue-600">Kepengurusan</h2>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label for="ketua" class="block text-sm font-semibold text-navy-900 mb-1">Ketua Ekskul</label>
                                <input type="text" id="ketua" name="ketua" value="{{ old('ketua', $isEdit ? $ekskul->ketua : '') }}" class="{{ $inputClass }}">
                                @error('ketua') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="pembina" class="block text-sm font-semibold text-navy-900 mb-1">Pembina</label>
                                <input type="text" id="pembina" name="pembina" value="{{ old('pembina', $isEdit ? $ekskul->pembina : '') }}" class="{{ $inputClass }}">
                                @error('pembina') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="jumlah_anggota" class="block text-sm font-semibold text-navy-900 mb-1">Jumlah Anggota</label>
                                <input type="number" min="0" id="jumlah_anggota" name="jumlah_anggota" value="{{ old('jumlah_anggota', $isEdit ? $ekskul->jumlah_anggota : '') }}" class="{{ $inputClass }}">
                                @error('jumlah_anggota') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- JADWAL --}}
                    <div class="space-y-4">
                        <h2 class="text-xs font-bold tracking-widest uppercase text-blue-600">Jadwal Latihan</h2>

                        <div>
                            <p class="block text-sm font-semibold text-navy-900 mb-2">Hari Latihan</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach (\App\Models\Ekskul::HARI as $hari)
                                    <label class="cursor-pointer">
                                        <input type="checkbox" name="hari_latihan[]" value="{{ $hari }}" class="peer sr-only"
                                               @checked(in_array($hari, (array) $hariTerpilih, true))>
                                        <span class="inline-block px-3.5 py-1.5 rounded-full border border-gray-200 text-xs font-semibold text-gray-500 transition
                                                     peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600 hover:border-blue-300">
                                            {{ $hari }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                            @error('hari_latihan.*') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                            <p class="text-[11px] text-gray-400 mt-2">Badge "Latihan Hari Ini" di website muncul otomatis pada hari yang dipilih.</p>
                        </div>

                        <div class="max-w-xs">
                            <label for="jam_latihan" class="block text-sm font-semibold text-navy-900 mb-1">Jam Latihan</label>
                            <input type="text" id="jam_latihan" name="jam_latihan" placeholder="15.00 - 17.00 WIB"
                                   value="{{ old('jam_latihan', $isEdit ? $ekskul->jam_latihan : '') }}" class="{{ $inputClass }}">
                            @error('jam_latihan') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- FOTO --}}
                    <div class="space-y-4">
                        <h2 class="text-xs font-bold tracking-widest uppercase text-blue-600">Foto</h2>

                        <div>
                            <label for="foto_sampul" class="block text-sm font-semibold text-navy-900 mb-1">
                                Foto Sampul {{ $isEdit ? '(kosongkan jika tidak diganti)' : '' }}
                            </label>
                            <input type="file" id="foto_sampul" name="foto_sampul" accept=".jpg,.jpeg,.png,.webp" class="{{ $fileClass }}">
                            <p class="text-[11px] text-gray-400 mt-1">Foto besar di bagian atas kartu. Disarankan landscape. Maksimal 4 MB.</p>
                            @error('foto_sampul') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="gambar" class="block text-sm font-semibold text-navy-900 mb-1">
                                Logo {{ $isEdit ? '(kosongkan jika tidak diganti)' : '' }}
                            </label>
                            <input type="file" id="gambar" name="gambar" accept=".jpg,.jpeg,.png,.webp" class="{{ $fileClass }}">
                            <p class="text-[11px] text-gray-400 mt-1">Logo bulat di kartu. Disarankan persegi. Maksimal 2 MB.</p>
                            @error('gambar') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- URUTAN --}}
                    <div class="max-w-xs">
                        <label for="urutan" class="block text-sm font-semibold text-navy-900 mb-1">Urutan Tampil</label>
                        <input type="number" min="0" id="urutan" name="urutan" value="{{ old('urutan', $isEdit ? $ekskul->urutan : 0) }}" class="{{ $inputClass }}">
                        <p class="text-[11px] text-gray-400 mt-1">Angka kecil tampil lebih dulu di website (0 = otomatis urut abjad).</p>
                        @error('urutan') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex gap-3 pt-2 border-t border-gray-100">
                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition mt-4">
                            {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Ekskul' }}
                        </button>
                        <a href="{{ route('admin.ekskul') }}"
                           class="border border-gray-200 hover:bg-gray-50 px-5 py-2 rounded-lg text-sm font-semibold transition mt-4">
                            Batal
                        </a>
                    </div>
                </form>

                {{-- ================= PRATINJAU ================= --}}
                <aside class="xl:col-span-2 xl:sticky xl:top-6">
                    <p class="text-xs font-bold tracking-widest uppercase text-gray-400 mb-3">Pratinjau di Website</p>

                    <div class="bg-white rounded-3xl shadow-lg overflow-hidden">
                        <div class="relative h-52 bg-gradient-to-br from-navy-900 to-blue-600 overflow-hidden">
                            <img id="pvSampul" src="{{ $sampulAwal }}" alt="" class="{{ $sampulAwal ? '' : 'hidden' }} absolute inset-0 w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-navy-900/90 via-navy-900/40 to-navy-900/10"></div>

                            <span id="pvAnggota" class="absolute top-3 right-3 bg-white/90 text-navy-900 text-xs font-bold px-3 py-1.5 rounded-full"></span>

                            <div class="absolute bottom-4 left-4 right-4 flex items-center gap-3">
                                <span class="w-16 h-16 rounded-full bg-white ring-4 ring-yellow-400 overflow-hidden flex items-center justify-center shrink-0 shadow-xl">
                                    <img id="pvLogo" src="{{ $logoAwal }}" alt="" class="{{ $logoAwal ? '' : 'hidden' }} w-full h-full object-contain p-2">
                                    <span id="pvHuruf" class="{{ $logoAwal ? 'hidden' : '' }} font-extrabold text-2xl text-blue-600">?</span>
                                </span>
                                <div>
                                    <h3 id="pvNama" class="text-2xl font-extrabold text-white leading-tight"></h3>
                                    <span class="block mt-1.5 h-1 w-10 rounded-full bg-gradient-to-r from-blue-500 to-yellow-400"></span>
                                </div>
                            </div>
                        </div>

                        <div class="p-5">
                            <p id="pvDeskripsi" class="text-sm text-gray-600 leading-relaxed"></p>
                            <div class="grid grid-cols-3 gap-2 mt-4 text-[11px]">
                                <div class="bg-blue-50 rounded-xl p-2.5">
                                    <p class="text-gray-400 uppercase tracking-wide">Ketua</p>
                                    <p id="pvKetua" class="font-bold text-navy-900 mt-0.5"></p>
                                </div>
                                <div class="bg-blue-50 rounded-xl p-2.5">
                                    <p class="text-gray-400 uppercase tracking-wide">Pembina</p>
                                    <p id="pvPembina" class="font-bold text-navy-900 mt-0.5"></p>
                                </div>
                                <div class="bg-blue-50 rounded-xl p-2.5">
                                    <p class="text-gray-400 uppercase tracking-wide">Jadwal</p>
                                    <p id="pvHari" class="font-bold text-navy-900 mt-0.5"></p>
                                    <p id="pvJam" class="text-gray-400"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>

            </div>
        </main>
    </div>

    <script>
        const $ = (id) => document.getElementById(id);

        function gabungHari(list) {
            if (list.length === 0) return '-';
            if (list.length === 1) return list[0];
            return list.slice(0, -1).join(', ') + ' & ' + list[list.length - 1];
        }

        function perbarui() {
            const nama = $('nama').value.trim();
            $('pvNama').textContent = nama || 'Nama Ekskul';
            $('pvHuruf').textContent = (nama[0] || '?').toUpperCase();
            $('pvDeskripsi').textContent = $('deskripsi').value.trim() || 'Deskripsi ekskul akan tampil di sini.';
            $('pvKetua').textContent = $('ketua').value.trim() || '-';
            $('pvPembina').textContent = $('pembina').value.trim() || '-';
            $('pvJam').textContent = $('jam_latihan').value.trim();

            const jml = $('jumlah_anggota').value.trim();
            $('pvAnggota').textContent = jml !== '' ? jml + ' Anggota' : 'Anggota -';

            const hari = [...document.querySelectorAll('input[name="hari_latihan[]"]:checked')].map((c) => c.value);
            $('pvHari').textContent = gabungHari(hari);
        }

        function pratinjauFile(inputId, imgId, hurufId) {
            $(inputId).addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (!file) return;
                const img = $(imgId);
                img.src = URL.createObjectURL(file);
                img.classList.remove('hidden');
                if (hurufId) $(hurufId).classList.add('hidden');
            });
        }

        ['nama', 'deskripsi', 'ketua', 'pembina', 'jumlah_anggota', 'jam_latihan'].forEach((id) => {
            $(id).addEventListener('input', perbarui);
        });
        document.querySelectorAll('input[name="hari_latihan[]"]').forEach((c) => c.addEventListener('change', perbarui));

        pratinjauFile('foto_sampul', 'pvSampul');
        pratinjauFile('gambar', 'pvLogo', 'pvHuruf');
        perbarui();
    </script>

</body>
</html>