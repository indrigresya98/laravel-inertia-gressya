
<!DOCTYPE html>
<!-- Menentukan jenis dokumen HTML dan bahasa halaman sesuai pengaturan aplikasi -->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- Mengatur karakter agar mendukung berbagai jenis teks -->
        <meta charset="utf-8">

        <!-- Mengatur tampilan agar responsif pada berbagai ukuran layar -->
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Mengatur judul halaman sesuai nama aplikasi Laravel -->
        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Menghubungkan koneksi awal ke penyedia font -->
        <!-- Mengambil jenis font Figtree dengan beberapa variasi ketebalan -->
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Menghubungkan Bootstrap 5 CSS untuk mengatur tampilan dan desain halaman -->
        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Menyediakan route Laravel agar dapat digunakan oleh JavaScript -->
        <!-- Memuat file JavaScript utama aplikasi menggunakan Vite -->
        <!-- Mengatur bagian head yang dikelola oleh Inertia -->
        <!-- Scripts & Inertia -->
        @routes
        @vite(['resources/js/app.js'])
        @inertiaHead
    </head>

    <!-- Mengatur jenis font, tampilan teks, dan warna latar belakang halaman -->
    <body class="font-sans antialiased bg-light">
        <!-- Menjadi tempat untuk menampilkan halaman Vue melalui Inertia -->
        @inertia

        <!-- Memuat Bootstrap 5 JavaScript untuk menjalankan komponen interaktif -->
        <!-- Bootstrap 5 JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
