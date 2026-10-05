<?php

namespace App\Models\Concerns;

trait UrlGambar
{
    // Gambar bawaan (public/images/...) dan hasil upload (storage) sama-sama didukung.
    public function urlGambar(string $field = 'gambar'): ?string
    {
        $v = $this->{$field};
        if (! $v) {
            return null;
        }

        $path = str_starts_with($v, 'images/') ? $v : 'storage/' . $v;

        // Encode tiap segmen supaya nama file ber-spasi tetap terbaca
        return asset(implode('/', array_map('rawurlencode', explode('/', $path))));
    }
}