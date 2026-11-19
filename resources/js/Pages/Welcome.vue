
<script setup>
// Import Head untuk mengatur judul halaman dan Link untuk navigasi dari Inertia
import { Head, Link } from '@inertiajs/vue3';

// Mengambil props canLogin dan canRegister dari controller
defineProps({
    canLogin: Boolean, // Menentukan apakah fitur login tersedia
    canRegister: Boolean, // Menentukan apakah fitur register tersedia
});
</script>

<template>
    <!-- Mengatur judul halaman pada tab browser -->
    <Head title="Selamat Datang" />

    <!-- Container utama halaman dengan warna latar dan warna teks -->
    <div class="min-h-screen bg-slate-50 text-slate-800">
        <!-- Bagian navigasi atau header halaman -->
        <nav class="flex items-center justify-between px-8 py-5 bg-white border-b border-slate-100 shadow-sm">
            <!-- Menampilkan nama atau logo aplikasi -->
            <div class="flex items-center gap-2">
                <span class="text-2xl font-black text-indigo-600 tracking-tight">MyApp</span>
            </div>

            <!-- Menampilkan menu navigasi jika fitur login tersedia -->
            <div v-if="canLogin" class="flex items-center space-x-3">
                <!-- Jika pengguna sudah login, tampilkan link menuju halaman postingan -->
                <Link
                    v-if="$page.props.auth.user"
                    :href="route('posts.index')"
                    class="px-4 py-2 font-semibold text-slate-700 hover:text-indigo-600 transition"
                >
                    Ke Posts
                </Link>

                <!-- Jika pengguna belum login, tampilkan pilihan masuk dan daftar -->
                <template v-else>
                    <!-- Link untuk menuju halaman login -->
                    <Link
                        :href="route('login')"
                        class="px-4 py-2 font-semibold text-slate-600 hover:text-indigo-600 transition"
                    >
                        Masuk
                    </Link>

                    <!-- Menampilkan tombol daftar jika fitur register tersedia -->
                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="px-5 py-2.5 text-sm font-semibold text-white bg-indigo-600 rounded-xl hover:bg-indigo-500 transition shadow-sm"
                    >
                        Daftar
                    </Link>
                </template>
            </div>
        </nav>

        <!-- Bagian utama atau Hero Section yang berisi pengenalan aplikasi -->
        <section class="max-w-4xl mx-auto px-6 pt-24 pb-16 text-center">
            <!-- Menampilkan judul utama halaman -->
            <h1 class="text-4xl md:text-6xl font-black text-slate-900 tracking-tight leading-tight">
                Bagikan Postingan & Ceritamu di Sini
            </h1>

            <!-- Menampilkan deskripsi singkat mengenai fungsi aplikasi -->
            <p class="mt-6 text-lg text-slate-600 leading-relaxed max-w-2xl mx-auto">
                Platform sederhana untuk membuat, mengelola, dan menemukan berbagai postingan menarik secara cepat dan mudah.
            </p>
            
            <!-- Bagian tombol aksi untuk memulai atau masuk ke aplikasi -->
            <div class="mt-10 flex justify-center gap-4">
                <!-- Jika pengguna belum login, tampilkan tombol daftar dan masuk -->
                <template v-if="!$page.props.auth.user">
                    <!-- Tombol untuk menuju halaman register jika fitur daftar tersedia -->
                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="px-8 py-3.5 font-medium text-white bg-indigo-600 rounded-xl shadow-lg hover:bg-indigo-500 transition"
                    >
                        Mulai Sekarang
                    </Link>

                    <!-- Tombol untuk menuju halaman login -->
                    <Link
                        :href="route('login')"
                        class="px-8 py-3.5 font-medium text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition"
                    >
                        Masuk Akun
                    </Link>
                </template>

                <!-- Jika pengguna sudah login, tampilkan tombol menuju daftar postingan -->
                <template v-else>
                    <Link
                        :href="route('posts.index')"
                        class="px-8 py-3.5 font-medium text-white bg-indigo-600 rounded-xl shadow-lg hover:bg-indigo-500 transition"
                    >
                        Lihat Postingan
                    </Link>
                </template>
            </div>
        </section>
    </div>
</template>
