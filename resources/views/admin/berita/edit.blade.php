<title>Edit Berita - SMKN 4 Bogor</title>
...
<h1 class="font-bold text-navy-900 text-lg">Edit Berita</h1>
...
<form action="{{ route('admin.berita.update', $berita) }}" method="POST" enctype="multipart/form-data"
      class="bg-white rounded-2xl shadow-sm p-6 max-w-2xl">
    @csrf
    @method('PUT')
    @include('admin.berita._form')
</form>