<?php

// Menentukan namespace controller autentikasi
namespace App\Http\Controllers\Auth;

// Mengimpor Controller utama Laravel
use App\Http\Controllers\Controller;

// Mengimpor RedirectResponse untuk mengatur pengalihan halaman
use Illuminate\Http\RedirectResponse;

// Mengimpor Request untuk menerima permintaan dari pengguna
use Illuminate\Http\Request;

// Mengimpor Hash untuk mengenkripsi password
use Illuminate\Support\Facades\Hash;

// Mengimpor Password untuk menerapkan aturan validasi password
use Illuminate\Validation\Rules\Password;

// Membuat class PasswordController
class PasswordController extends Controller
{
    /**
     * Memperbarui password pengguna.
     */
    public function update(Request $request): RedirectResponse
    {
        // Melakukan validasi data password yang dimasukkan pengguna
        $validated = $request->validate([
            // Password lama wajib diisi dan harus sesuai dengan password akun saat ini
            'current_password' => ['required', 'current_password'],

            // Password baru wajib diisi, mengikuti aturan password Laravel,
            // dan harus sesuai dengan password konfirmasi
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        // Memperbarui password pengguna yang sedang login
        $request->user()->update([
            // Mengenkripsi password baru sebelum disimpan ke database
            'password' => Hash::make($validated['password']),
        ]);

        // Kembali ke halaman sebelumnya setelah password berhasil diperbarui
        return back();
    }
}
