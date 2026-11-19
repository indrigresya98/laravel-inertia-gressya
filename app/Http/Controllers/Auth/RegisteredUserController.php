<?php

// Menentukan namespace controller autentikasi
namespace App\Http\Controllers\Auth;

// Mengimpor Controller utama Laravel
use App\Http\Controllers\Controller;

// Mengimpor RedirectResponse untuk mengatur pengalihan halaman
use Illuminate\Http\RedirectResponse;

// Mengimpor Request untuk menerima permintaan dari pengguna
use Illuminate\Http\Request;

// Mengimpor Password untuk mengelola proses reset password
use Illuminate\Support\Facades\Password;

// Mengimpor ValidationException untuk menangani kesalahan validasi
use Illuminate\Validation\ValidationException;

// Mengimpor Inertia untuk menampilkan halaman menggunakan Inertia.js
use Inertia\Inertia;

// Mengimpor Response sebagai tipe data hasil tampilan halaman
use Inertia\Response;

// Membuat class PasswordResetLinkController
class PasswordResetLinkController extends Controller
{
    /**
     * Menampilkan halaman permintaan tautan reset password.
     */
    public function create(): Response
    {
        // Menampilkan halaman ForgotPassword menggunakan Inertia
        return Inertia::render('Auth/ForgotPassword', [
            // Mengambil pesan status dari session
            'status' => session('status'),
        ]);
    }

    /**
     * Menangani permintaan pengiriman tautan reset password.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Melakukan validasi email yang dimasukkan pengguna
        $request->validate([
            // Email wajib diisi dan harus menggunakan format email yang benar
            'email' => 'required|email',
        ]);

        // Mengirimkan tautan reset password ke email pengguna
        $status = Password::sendResetLink(
            // Mengambil alamat email dari data yang dikirimkan pengguna
            $request->only('email')
        );

        // Memeriksa apakah tautan reset password berhasil dikirim
        if ($status == Password::RESET_LINK_SENT) {

            // Jika berhasil, kembali ke halaman sebelumnya
            // dan menampilkan pesan bahwa tautan reset password telah dikirim
            return back()->with('status', __($status));
        }

        // Jika pengiriman gagal, tampilkan pesan kesalahan pada bagian email
        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
    }
}
