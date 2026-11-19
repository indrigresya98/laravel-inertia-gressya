<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

// Class untuk menangani proses login dan logout
class AuthenticatedSessionController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Menangani proses login pengguna.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Memeriksa email dan password pengguna
        $request->authenticate();

        // Memperbarui session setelah login berhasil
        $request->session()->regenerate();

        // Mengarahkan pengguna ke halaman postingan
        return redirect()->intended('/posts');
    }

    /**
     * Mengakhiri sesi login pengguna.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Melakukan logout menggunakan guard web
        Auth::guard('web')->logout();

        // Menghapus session pengguna
        $request->session()->invalidate();

        // Membuat token CSRF baru
        $request->session()->regenerateToken();

        // Mengarahkan pengguna ke halaman utama
        return redirect('/');
    }
}
