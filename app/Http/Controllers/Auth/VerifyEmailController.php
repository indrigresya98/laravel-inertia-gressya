<?php

// Menentukan namespace controller autentikasi
namespace App\Http\Controllers\Auth;

// Mengimpor Controller utama Laravel
use App\Http\Controllers\Controller;

// Mengimpor event Verified untuk menandai email berhasil diverifikasi
use Illuminate\Auth\Events\Verified;

// Mengimpor EmailVerificationRequest untuk memvalidasi permintaan verifikasi email
use Illuminate\Foundation\Auth\EmailVerificationRequest;

// Mengimpor RedirectResponse untuk mengatur pengalihan halaman
use Illuminate\Http\RedirectResponse;

// Membuat class VerifyEmailController
class VerifyEmailController extends Controller
{
    /**
     * Menandai alamat email pengguna yang sedang login sebagai terverifikasi.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        // Memeriksa apakah email pengguna sudah berhasil diverifikasi
        if ($request->user()->hasVerifiedEmail()) {

            // Jika sudah terverifikasi, arahkan pengguna ke dashboard
            // dengan menambahkan parameter verified=1 pada URL
            return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
        }

        // Memeriksa dan mengubah status email pengguna menjadi terverifikasi
        if ($request->user()->markEmailAsVerified()) {

            // Mengirimkan event Verified jika proses verifikasi berhasil
            event(new Verified($request->user()));
        }

        // Mengarahkan pengguna ke halaman dashboard setelah verifikasi selesai
        // dengan menambahkan parameter verified=1 pada URL
        return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
    }
}
