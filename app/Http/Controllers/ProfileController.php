<?php

// Menentukan namespace controller utama
namespace App\Http\Controllers;

// Mengimpor ProfileUpdateRequest untuk memvalidasi perubahan data profil
use App\Http\Requests\ProfileUpdateRequest;

// Mengimpor MustVerifyEmail untuk memeriksa kewajiban verifikasi email
use Illuminate\Contracts\Auth\MustVerifyEmail;

// Mengimpor RedirectResponse untuk mengatur pengalihan halaman
use Illuminate\Http\RedirectResponse;

// Mengimpor Request untuk menerima permintaan dari pengguna
use Illuminate\Http\Request;

// Mengimpor Auth untuk mengelola autentikasi pengguna
use Illuminate\Support\Facades\Auth;

// Mengimpor Redirect untuk melakukan pengalihan halaman
use Illuminate\Support\Facades\Redirect;

// Mengimpor Inertia untuk menampilkan halaman menggunakan Inertia.js
use Inertia\Inertia;

// Mengimpor Response sebagai tipe data hasil tampilan halaman
use Inertia\Response;

// Membuat class ProfileController
class ProfileController extends Controller
{
    /**
     * Menampilkan formulir profil pengguna.
     */
    public function edit(Request $request): Response
    {
        // Menampilkan halaman Edit pada bagian Profile menggunakan Inertia
        return Inertia::render('Profile/Edit', [
            // Memeriksa apakah pengguna wajib melakukan verifikasi email
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,

            // Mengambil pesan status dari session
            'status' => session('status'),
        ]);
    }

    /**
     * Memperbarui informasi profil pengguna.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Mengisi data pengguna berdasarkan data yang sudah divalidasi
        $request->user()->fill($request->validated());

        // Memeriksa apakah terdapat perubahan pada alamat email pengguna
        if ($request->user()->isDirty('email')) {

            // Mengatur ulang status verifikasi email menjadi null
            // karena alamat email pengguna telah berubah
            $request->user()->email_verified_at = null;
        }

        // Menyimpan perubahan data profil ke database
        $request->user()->save();

        // Mengarahkan pengguna kembali ke halaman edit profil
        return Redirect::route('profile.edit');
    }

    /**
     * Menghapus akun pengguna.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Melakukan validasi password sebelum akun dihapus
        $request->validate([
            // Password wajib diisi dan harus sesuai dengan password akun saat ini
            'password' => ['required', 'current_password'],
        ]);

        // Mengambil data pengguna yang sedang login
        $user = $request->user();

        // Mengeluarkan pengguna dari akun atau melakukan logout
        Auth::logout();

        // Menghapus akun pengguna dari database
        $user->delete();

        // Menghapus session pengguna yang sedang aktif
        $request->session()->invalidate();

        // Membuat token CSRF baru untuk keamanan
        $request->session()->regenerateToken();

        // Mengarahkan pengguna ke halaman utama setelah akun dihapus
        return Redirect::to('/');
    }
}
