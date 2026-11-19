
<script setup>
// Mengimpor komponen ApplicationLogo untuk menampilkan logo aplikasi
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

// Mengimpor Link dari Inertia.js untuk navigasi antarhalaman
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <!-- Membuat tampilan utama dengan posisi elemen tersusun secara vertikal,
         berada di tengah halaman, dan memiliki latar belakang abu-abu -->
    <div
        class="flex min-h-screen flex-col items-center bg-gray-100 pt-6 sm:justify-center sm:pt-0"
    >

        <!-- Bagian untuk menampilkan logo aplikasi -->
        <div>

            <!-- Mengarahkan pengguna ke halaman utama ketika logo diklik -->
            <Link href="/">

                <!-- Menampilkan logo aplikasi dengan ukuran dan warna yang ditentukan -->
                <ApplicationLogo class="h-20 w-20 fill-current text-gray-500" />
            </Link>
        </div>

        <!-- Membuat kotak utama untuk menampilkan konten halaman
             dengan latar belakang putih, bayangan, dan sudut membulat -->
        <div
            class="mt-6 w-full overflow-hidden bg-white px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg"
        >

            <!-- Slot digunakan untuk menampilkan isi halaman
                 seperti form login, register, atau lupa password -->
            <slot />
        </div>
    </div>
</template>
