<?php

// Menentukan namespace controller autentikasi
namespace App\Http\Controllers\Auth;

// Mengimpor Controller utama Laravel
use App\Http\Controllers\Controller;

// Mengimpor RedirectResponse untuk mengatur pengalihan halaman
use Illuminate\Http\RedirectResponse;

// Mengimpor Request untuk menerima permintaan dari pengguna
use Illuminate\Http\Request;

// Membuat class EmailVerificationNotificationController
class EmailVerificationNotificationController extends Controller
{
    /**
     * Mengirimkan notifikasi verifikasi email baru.
     */
    public function store(Request $request): RedirectResponse
    {
        // Memeriksa apakah email pengguna sudah terverifikasi
        if ($request->user()->hasVerifiedEmail()) {

            // Jika sudah terverifikasi, arahkan pengguna ke halaman dashboard
            return redirect()->intended(route('dashboard', absolute: false));
        }

        // Mengirimkan tautan verifikasi email kepada pengguna
        $request->user()->sendEmailVerificationNotification();

        // Kembali ke halaman sebelumnya dengan status bahwa
        // tautan verifikasi email berhasil dikirim
        return back()->with('status', 'verification-link-sent');
    }
}
