<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

abstract class AdminCrudController extends Controller
{
    abstract protected function cfg(): array;

    protected function beforeSave(array $data, $item): array
    {
        return $data;
    }

    // Nilai awal form tambah, contoh: ['jurusan' => 'TO']
    protected function defaults(): array
    {
        return [];
    }

    // Tujuan tombol Batal
    protected function urlBatal($item): string
    {
        return route($this->cfg()['route']);
    }

    // Tujuan setelah tambah / ubah / hapus
    protected function kembali(string $pesan, $item = null)
    {
        return redirect()->route($this->cfg()['route'])->with('success', $pesan);
    }

    public function index()
    {
        $c = $this->cfg();
        $items = $c['model']::orderBy($c['order'][0], $c['order'][1])->get();
        return view('admin.crud.index', compact('c', 'items'));
    }

    public function create()
    {
        return view('admin.crud.form', [
            'c' => $this->cfg(),
            'item' => null,
            'defaults' => $this->defaults(),
            'batal' => $this->urlBatal(null),
        ]);
    }

    public function store(Request $request)
    {
        $c = $this->cfg();
        $data = $request->validate($this->rules());
        $data = $this->simpanGambar($request, $data, null);
        $data = $this->beforeSave($data, null);

        $item = $c['model']::create($data);

        return $this->kembali($c['title'] . ' berhasil ditambahkan.', $item);
    }

    public function edit($id)
    {
        $c = $this->cfg();
        $item = $c['model']::findOrFail($id);
        $defaults = [];
        $batal = $this->urlBatal($item);
        return view('admin.crud.form', compact('c', 'item', 'defaults', 'batal'));
    }

    public function update(Request $request, $id)
    {
        $c = $this->cfg();
        $item = $c['model']::findOrFail($id);
        $data = $request->validate($this->rules());
        $data = $this->simpanGambar($request, $data, $item);
        $data = $this->beforeSave($data, $item);

        $item->update($data);

        return $this->kembali($c['title'] . ' berhasil diperbarui.', $item);
    }

    public function destroy($id)
    {
        $c = $this->cfg();
        $item = $c['model']::findOrFail($id);

        foreach ($c['fields'] as $f) {
            if ($f['type'] === 'image') {
                $this->hapusFile($item->{$f['name']});
            }
        }
        $item->delete();

        return $this->kembali($c['title'] . ' berhasil dihapus.', $item);
    }

    private function rules(): array
    {
        $rules = [];
        foreach ($this->cfg()['fields'] as $f) {
            $rules[$f['name']] = $f['rules'];
        }
        return $rules;
    }

    private function simpanGambar(Request $request, array $data, $item): array
    {
        $c = $this->cfg();
        foreach ($c['fields'] as $f) {
            if ($f['type'] !== 'image') {
                continue;
            }
            $n = $f['name'];
            if ($request->hasFile($n)) {
                if ($item) {
                    $this->hapusFile($item->$n);
                }
                $data[$n] = $request->file($n)->store($c['folder'], 'public');
            } else {
                unset($data[$n]); // tidak upload baru = gambar lama dipertahankan
            }
        }
        return $data;
    }

    // Gambar bawaan di public/images tidak pernah dihapus
    private function hapusFile(?string $path): void
    {
        if ($path && ! str_starts_with($path, 'images/')) {
            Storage::disk('public')->delete($path);
        }
    }
}