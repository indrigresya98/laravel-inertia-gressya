
<?php

// Mengimpor controller yang digunakan untuk menangani proses autentikasi
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;

// Mengimpor Route untuk mendefinisikan alamat halaman aplikasi
use Illuminate\Support\Facades\Route;

// Mengelompokkan route yang hanya dapat diakses oleh pengguna yang belum login
Route::middleware('guest')->group(function () {
    // Menampilkan halaman registrasi akun
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    // Memproses data registrasi akun baru
    Route::post('register', [RegisteredUserController::class, 'store']);

    // Menampilkan halaman login
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    // Memproses data login pengguna
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // Menampilkan halaman permintaan link reset password
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    // Mengirim link reset password ke email pengguna
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    // Menampilkan halaman untuk membuat password baru berdasarkan token
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    // Memproses dan menyimpan password baru
    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

// Mengelompokkan route yang hanya dapat diakses oleh pengguna yang sudah login
Route::middleware('auth')->group(function () {
    // Menampilkan halaman pemberitahuan verifikasi email
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    // Memproses verifikasi email berdasarkan ID dan hash pengguna
    // Middleware signed memeriksa keaslian URL, sedangkan throttle membatasi permintaan
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    // Mengirim ulang email verifikasi kepada pengguna
    // Throttle membatasi jumlah permintaan pengiriman
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    // Menampilkan halaman konfirmasi password
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    // Memproses konfirmasi password pengguna
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    // Memproses perubahan password pengguna
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    // Memproses logout atau mengeluarkan pengguna dari akun
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
