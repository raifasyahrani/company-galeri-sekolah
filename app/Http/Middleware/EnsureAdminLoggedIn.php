<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminLoggedIn
{
    /**
     * Cek apakah admin sudah login (lewat session 'admin_email').
     * Kalau belum, tendang ke halaman login.
     * Kalau sudah, lanjutkan request seperti biasa.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->session()->has('admin_email')) {
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}