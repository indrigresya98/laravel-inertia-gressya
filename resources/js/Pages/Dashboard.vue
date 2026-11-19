
<script setup>
// Import layout khusus untuk pengguna yang sudah login
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

// Import Head dari Inertia untuk mengatur judul halaman pada browser
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <!-- Mengatur judul halaman menjadi Dashboard -->
    <Head title="Dashboard" />

    <!-- Menggunakan layout untuk pengguna yang sudah login -->
    <AuthenticatedLayout>
        <!-- Mengisi bagian header pada layout -->
        <template #header>
            <!-- Menampilkan judul Dashboard -->
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Dashboard
            </h2>
        </template>

        <!-- Bagian utama halaman Dashboard dengan jarak vertikal -->
        <div class="py-12">
            <!-- Mengatur lebar konten dan posisi agar berada di tengah -->
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Card sebagai wadah informasi dashboard -->
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <!-- Menampilkan pesan bahwa pengguna berhasil login -->
                    <div class="p-6 text-gray-900">
                        You're logged in!
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
