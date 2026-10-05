<?php

namespace App\Http\Controllers;

abstract class AdminJurusanBagianController extends AdminCrudController
{
    protected const KODE = ['TO', 'PPLG', 'TJKT', 'TPFL'];

    protected function fieldJurusan(): array
    {
        return ['name' => 'jurusan', 'label' => 'Jurusan', 'type' => 'select', 'options' => self::KODE, 'rules' => 'required|in:' . implode(',', self::KODE)];
    }

    protected function fieldUrutan(): array
    {
        return ['name' => 'urutan', 'label' => 'Urutan tampil (angka kecil tampil dulu)', 'type' => 'text', 'placeholder' => '1', 'rules' => 'nullable|integer|min:0'];
    }

    protected function beforeSave(array $data, $item): array
    {
        $data['urutan'] = (int) ($data['urutan'] ?? 0);
        return $data;
    }

    protected function defaults(): array
    {
        $j = strtoupper((string) request('jurusan'));
        return in_array($j, self::KODE, true) ? ['jurusan' => $j] : [];
    }

    protected function urlBatal($item): string
    {
        $j = $item->jurusan ?? request('jurusan');
        return route('admin.jurusan', $j ? ['jurusan' => $j] : []);
    }

    protected function kembali(string $pesan, $item = null)
    {
        return redirect($this->urlBatal($item))->with('success', $pesan);
    }
}