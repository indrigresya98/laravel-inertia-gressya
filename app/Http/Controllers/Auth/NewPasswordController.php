<?php

// Menentukan namespace controller autentikasi
namespace App\Http\Controllers\Auth;

// Mengimpor Controller utama Laravel
use App\Http\Controllers\Controller;

// Mengimpor event PasswordReset untuk menandai password berhasil diubah
use Illuminate\Auth\Events\PasswordReset;

// Mengimpor RedirectResponse untuk mengatur pengalihan halaman
use Illuminate\Http\RedirectResponse;

// Mengimpor Request untuk menerima permintaan dari pengguna
use Illuminate\Http\Request;

// Mengimpor Hash untuk mengenkripsi password
use Illuminate\Support\Facades\Hash;

// Mengimpor Password untuk mengelola proses reset password
use Illuminate\Support\Facades\Password;

// Mengimpor Str untuk membuat karakter secara acak
use Illuminate\Support\Str;

// Mengimpor Rules untuk aturan validasi password
use Illuminate\Validation\Rules;

// Mengimpor ValidationException untuk menangani kesalahan validasi
use Illuminate\Validation\ValidationException;

// Mengimpor Inertia untuk menampilkan halaman menggunakan Inertia.js
use Inertia\Inertia;

// Mengimpor Response sebagai tipe data hasil tampilan halaman
use Inertia\Response;

// Membuat class NewPasswordController
class NewPasswordController extends Controller
{
    /**
     * Menampilkan halaman untuk mengatur ulang password.
     */
    public function create(Request $request): Response
    {
        // Menampilkan halaman ResetPassword menggunakan Inertia
        return Inertia::render('Auth/ResetPassword', [
            // Mengirimkan email pengguna ke halaman reset password
            'email' => $request->email,

            // Mengambil token reset password dari URL
            'token' => $request->route('token'),
        ]);
    }

    /**
     * Menangani permintaan untuk membuat password baru.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Melakukan validasi data yang dimasukkan pengguna
        $request->validate([
            // Token wajib diisi
            'token' => 'required',

            // Email wajib diisi dan harus menggunakan format email yang benar
            'email' => 'required|email',

            // Password wajib diisi, harus sesuai dengan konfirmasi,
            // dan mengikuti aturan password bawaan Laravel
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Melakukan proses reset password menggunakan token dan email
        $status = Password::reset(
            // Mengambil data email, password, konfirmasi password, dan token
            $request->only('email', 'password', 'password_confirmation', 'token'),

            // Menjalankan proses berikut jika reset password berhasil
            function ($user) use ($request) {

                // Mengisi data password baru dan token pengingat secara paksa
                $user->forceFill([
                    // Mengenkripsi password baru sebelum disimpan ke database
                    'password' => Hash::make($request->password),

                    // Membuat remember token baru secara acak
                    'remember_token' => Str::random(60),

                // Menyimpan perubahan data pengguna ke database
                ])->save();

                // Mengirimkan event bahwa password pengguna berhasil direset
                event(new PasswordReset($user));
            }
        );

        // Memeriksa apakah proses reset password berhasil
        if ($status == Password::PASSWORD_RESET) {

            // Jika berhasil, arahkan pengguna ke halaman login
            // dan tampilkan pesan bahwa password berhasil diubah
            return redirect()->route('login')->with('status', __($status));
        }

        // Jika gagal, tampilkan pesan kesalahan pada bagian email
        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
    }
}
