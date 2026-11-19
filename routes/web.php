<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Public Routes (Bisa diakses tanpa login)
|--------------------------------------------------------------------------
*/

// OPSI 1: Menampilkan Landing Page (Welcome.vue) dengan data Auth
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
});

// OPSI 2: Jika tetap ingin redirect langsung ke login, hapus OPSI 1 dan hapus comment garis di bawah:
// Route::redirect('/', '/login');


/*
|--------------------------------------------------------------------------
| Protected Routes (Wajib Login & Terverifikasi)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // Redirect /dashboard langsung ke halaman posts
    Route::get('/dashboard', function () {
        return redirect()->route('posts.index');
    })->name('dashboard');

    // URUTAN PENTING: Route khusus ditaruh SEBELUM Route::resource
    Route::get('/posts/search', [PostController::class, 'search'])->name('posts.search');

    // Route CRUD Posts (index, create, store, show, edit, update, destroy)
    Route::resource('posts', PostController::class);

    // Profile Management
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });
});

/*
|--------------------------------------------------------------------------
| Fallback & Auth Routes
|--------------------------------------------------------------------------
*/
// Penanganan URL yang tidak ditemukan (404) -> kembalikan ke /posts
Route::fallback(function () {
    return redirect()->route('posts.index');
});

require __DIR__.'/auth.php';