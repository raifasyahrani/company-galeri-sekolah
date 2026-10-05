<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Berita - SMKN 4 Bogor</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-800 bg-gray-100">
<div class="flex min-h-screen">
    @include('partials.sidebar')
    <main class="flex-1">
        <header class="bg-white shadow-sm px-8 py-4">
            <h1 class="font-bold text-navy-900 text-lg">Tambah Berita</h1>
        </header>
        <div class="p-8">
            <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data"
                  class="bg-white rounded-2xl shadow-sm p-6 max-w-2xl">
                @csrf
                @include('admin.berita._form')
            </form>
        </div>
    </main>
</div>
</body>
</html>