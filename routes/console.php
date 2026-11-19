<?php

// Mengimpor class Inspiring untuk mengambil kutipan motivasi bawaan Laravel
use Illuminate\Foundation\Inspiring;

// Mengimpor Artisan untuk membuat perintah atau command pada Laravel
use Illuminate\Support\Facades\Artisan;

// Membuat perintah Artisan dengan nama 'inspire'
Artisan::command('inspire', function () {
    // Menampilkan kutipan motivasi dari Inspiring melalui terminal
    $this->comment(Inspiring::quote());

// Memberikan deskripsi fungsi perintah 'inspire'
})->purpose('Display an inspiring quote');
