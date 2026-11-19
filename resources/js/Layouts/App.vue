
<script setup>
// Mengimpor ref untuk membuat variabel reaktif di Vue
import { ref } from 'vue'

// Mengimpor Link dan router dari Inertia.js
// Link digunakan untuk navigasi halaman
// router digunakan untuk menjalankan perpindahan halaman melalui kode
import { Link, router } from '@inertiajs/vue3'

// Membuat state pencarian dengan nilai awal kosong
const search = ref('')

// Membuat fungsi untuk menangani proses pencarian
const handleSearch = () => {
    // Mengirim permintaan GET ke halaman /posts
    // Mengirimkan nilai pencarian melalui parameter search
    // preserveState digunakan agar state halaman tetap dipertahankan
    router.get('/posts', { search: search.value }, { preserveState: true })
}
</script>

<template>
    <!-- Membuat tampilan utama dengan tinggi minimal satu layar
         dan memberikan warna latar belakang pink muda -->
    <div class="min-vh-100" style="background-color: #FFF5F7;">

        <!-- Navbar Header: bagian navigasi utama aplikasi -->
        <nav class="navbar navbar-expand-md fixed-top shadow-sm border-bottom border-pink-100" style="background-color: #FFFFFF;">
            <div class="container">

                <!-- Menampilkan nama aplikasi dan mengarahkan ke halaman utama -->
                <Link class="navbar-brand fw-bold" href="/" style="color: #DB2777;">
                    🌸 LARAVEL + VUE + INERTIA.JS
                </Link>
                
                <!-- Tombol untuk membuka dan menutup navbar pada perangkat kecil -->
                <button 
                    class="navbar-toggler border-0" 
                    type="button" 
                    data-bs-toggle="collapse" 
                    data-bs-target="#navbarCollapse" 
                    aria-controls="navbarCollapse" 
                    aria-expanded="false" 
                    aria-label="Toggle navigation"
                >
                    <!-- Ikon tombol menu navbar -->
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <!-- Bagian menu navigasi navbar -->
                <div class="collapse navbar-collapse" id="navbarCollapse">

                    <!-- Membuat daftar menu navigasi -->
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">

                        <!-- Menu untuk menuju halaman Posts -->
                        <li class="nav-item">
                            <Link class="nav-link fw-semibold text-secondary" href="/posts">POSTS</Link>
                        </li>

                        <!-- Menu untuk membuka halaman Ebook -->
                        <li class="nav-item">
                            <a class="nav-link fw-semibold text-secondary" href="https://santrikoding.com/ebook" target="_blank">EBOOK</a>
                        </li>

                        <!-- Menu untuk membuka halaman Tutorial Set -->
                        <li class="nav-item">
                            <a class="nav-link fw-semibold text-secondary" href="https://santrikoding.com/tutorial-set" target="_blank">TUTORIAL SET</a>
                        </li>
                    </ul>

                    <!-- Form Pencarian & Logout -->
                    <div class="d-flex align-items-center gap-2">

                        <!-- Form pencarian yang menjalankan handleSearch
                             ketika tombol Cari ditekan -->
                        <form @submit.prevent="handleSearch" class="d-flex">

                            <!-- Input untuk memasukkan kata kunci pencarian
                                 v-model menghubungkan input dengan variabel search -->
                            <input 
                                v-model="search" 
                                class="form-control me-2 border-0 shadow-sm rounded-3 px-3" 
                                type="search" 
                                placeholder="Cari postingan..." 
                                aria-label="Search"
                                style="background-color: #FCE7F3;"
                            >

                            <!-- Tombol untuk menjalankan proses pencarian -->
                            <button 
                                class="btn text-white fw-bold px-3 rounded-3 border-0 shadow-sm" 
                                type="submit" 
                                style="background-color: #38BDF8;"
                            >
                                Cari
                            </button>
                        </form>

                        <!-- Tombol Logout untuk mengakhiri sesi login pengguna
                             menggunakan metode POST -->
                        <Link 
                            href="/logout" 
                            method="post" 
                            as="button" 
                            class="btn text-white fw-bold px-3 rounded-3 border-0 shadow-sm ms-2"
                            style="background-color: #F472B6;"
                        >
                            LOGOUT
                        </Link>
                    </div>
                </div>
            </div>
        </nav>
        
        <!-- Main Content Area: tempat menampilkan isi halaman -->
        <main class="container">

            <!-- Slot digunakan untuk menampilkan konten
                 dari halaman yang menggunakan layout ini -->
            <slot />
        </main>
    </div>
</template>

<!-- CSS khusus untuk mengatur tampilan layout ini -->
<style scoped>

/* Memberikan jarak bagian atas agar konten tidak tertutup navbar */
.container main, main.container {
    padding-top: 90px;
}

/* Mengubah warna teks menu ketika kursor diarahkan ke menu navigasi */
.nav-link:hover {
    color: #DB2777 !important;
}
</style>
