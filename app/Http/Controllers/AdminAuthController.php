<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminAuthController extends Controller
{
    /**
     * Kredensial admin (hardcoded sesuai permintaan).
     * Untuk produksi sebaiknya dipindah ke tabel users + Hash::make().
     */
    protected string $adminEmail = 'admin@gmail.com';
    protected string $adminPassword = '4dm1n1108!';

    public function showLogin(): View|RedirectResponse
    {
        // Sudah login -> langsung ke Dashboard
        if (session('is_admin')) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        if (
            $credentials['email'] === $this->adminEmail &&
            $credentials['password'] === $this->adminPassword
        ) {
            $request->session()->regenerate();
            $request->session()->put('is_admin', true);
            $request->session()->put('admin_email', $this->adminEmail);

            // Login berhasil -> Dashboard (bukan halaman depan)
            return redirect()->route('admin.dashboard');
        }

        return back()
            ->withErrors(['email' => 'Email atau kata sandi yang Anda masukkan salah.'])
            ->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        // Hapus seluruh sesi, lalu buat token CSRF baru
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}