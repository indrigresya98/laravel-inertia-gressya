<?php

// Menentukan namespace controller autentikasi
namespace App\Http\Controllers\Auth;

// Mengimpor Controller utama Laravel
use App\Http\Controllers\Controller;

// Mengimpor RedirectResponse untuk mengatur pengalihan halaman
use Illuminate\Http\RedirectResponse;

// Mengimpor Request untuk menerima permintaan dari pengguna
use Illuminate\Http\Request;

// Mengimpor Inertia untuk menampilkan halaman menggunakan Inertia.js
use Inertia\Inertia;

// Mengimpor Response sebagai tipe data hasil tampilan halaman
use Inertia\Response;

// Membuat class EmailVerificationPromptController
class EmailVerificationPromptController extends Controller
{
    /**
     * Menampilkan halaman pemberitahuan verifikasi email.
     */
    public function __invoke(Request $request): RedirectResponse|Response
    {
        // Memeriksa apakah email pengguna sudah berhasil diverifikasi
        return $request->user()->hasVerifiedEmail()

                    // Jika sudah terverifikasi, arahkan pengguna ke dashboard
                    ? redirect()->intended(route('dashboard', absolute: false))

                    // Jika belum terverifikasi, tampilkan halaman VerifyEmail
                    // serta mengambil status pemberitahuan dari session
                    : Inertia::render('Auth/VerifyEmail', ['status' => session('status')]);
    }
}
