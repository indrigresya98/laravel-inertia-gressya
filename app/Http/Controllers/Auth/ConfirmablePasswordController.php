<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

// Class untuk menangani konfirmasi password pengguna
class ConfirmablePasswordController extends Controller
{
    /**
     * Menampilkan halaman konfirmasi password.
     */
    public function show(): Response
    {
        return Inertia::render('Auth/ConfirmPassword');
    }

    /**
     * Memeriksa password yang dimasukkan pengguna.
     */
    public function store(Request $request): RedirectResponse
    {
        // Memeriksa kecocokan email dan password pengguna
        if (! Auth::guard('web')->validate([
            'email' => $request->user()->email,
            'password' => $request->password,
        ])) {
            // Menampilkan pesan error jika password salah
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        // Menyimpan waktu ketika password berhasil dikonfirmasi
        $request->session()->put('auth.password_confirmed_at', time());

        // Mengarahkan pengguna ke halaman dashboard
        return redirect()->intended(route('dashboard', absolute: false));
    }
}
