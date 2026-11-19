
<script setup>
// Mengimpor ref dari Vue untuk membuat variabel reaktif
import { ref } from 'vue';

// Mengimpor komponen logo aplikasi
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

// Mengimpor komponen dropdown untuk membuat menu pilihan
import Dropdown from '@/Components/Dropdown.vue';

// Mengimpor komponen link yang digunakan di dalam dropdown
import DropdownLink from '@/Components/DropdownLink.vue';

// Mengimpor komponen navigasi untuk menu utama
import NavLink from '@/Components/NavLink.vue';

// Mengimpor komponen navigasi untuk tampilan perangkat kecil
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

// Mengimpor Link dari Inertia.js untuk navigasi antarhalaman
import { Link } from '@inertiajs/vue3';

// Membuat variabel reaktif untuk mengatur tampilan menu navigasi
// Nilai awal false berarti menu dropdown belum terbuka
const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <!-- Membuat area utama dengan tinggi minimal satu layar
             dan memberikan warna latar belakang abu-abu -->
        <div class="min-h-screen bg-gray-100">

            <!-- Membuat navbar sebagai menu navigasi utama aplikasi -->
            <nav
                class="border-b border-gray-100 bg-white"
            >
                <!-- Primary Navigation Menu: menu navigasi utama -->
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <!-- Mengatur posisi logo dan menu agar berada di sisi berlawanan -->
                    <div class="flex h-16 justify-between">
                        <div class="flex">

                            <!-- Logo: menampilkan logo aplikasi -->
                            <div class="flex shrink-0 items-center">

                                <!-- Mengarahkan pengguna ke halaman dashboard ketika logo diklik -->
                                <Link :href="route('dashboard')">
                                    <ApplicationLogo
                                        class="block h-9 w-auto fill-current text-gray-800"
                                    />
                                </Link>
                            </div>

                            <!-- Navigation Links: menampilkan menu navigasi -->
                            <div
                                class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"
                            >
                                <!-- Menampilkan menu Dashboard
                                     dan memberikan tanda aktif jika sedang berada di halaman dashboard -->
                                <NavLink
                                    :href="route('dashboard')"
                                    :active="route().current('dashboard')"
                                >
                                    Dashboard
                                </NavLink>
                            </div>
                        </div>

                        <!-- Menampilkan menu pengaturan untuk perangkat berukuran besar -->
                        <div class="hidden sm:ms-6 sm:flex sm:items-center">

                            <!-- Settings Dropdown: menu dropdown pengaturan akun -->
                            <div class="relative ms-3">
                                <!-- Membuat dropdown dengan posisi kanan dan lebar 48 -->
                                <Dropdown align="right" width="48">

                                    <!-- Trigger: bagian yang diklik untuk membuka dropdown -->
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">

                                            <!-- Tombol menampilkan nama pengguna yang sedang login -->
                                            <button
                                                type="button"
                                                class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none"
                                            >
                                                <!-- Mengambil nama pengguna dari data autentikasi Inertia -->
                                                {{ $page.props.auth.user.name }}

                                                <!-- Ikon panah untuk menandakan menu dropdown -->
                                                <svg
                                                    class="-me-0.5 ms-2 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <!-- Content: isi menu dropdown pengaturan akun -->
                                    <template #content>

                                        <!-- Link untuk membuka halaman profil pengguna -->
                                        <DropdownLink
                                            :href="route('profile.edit')"
                                        >
                                            Profile
                                        </DropdownLink>

                                        <!-- Link untuk melakukan logout menggunakan metode POST -->
                                        <DropdownLink
                                            :href="route('logout')"
                                            method="post"
                                            as="button"
                                        >
                                            Log Out
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger: tombol menu untuk perangkat berukuran kecil -->
                        <div class="-me-2 flex items-center sm:hidden">

                            <!-- Ketika diklik, mengubah status menu
                                 dari terbuka menjadi tertutup atau sebaliknya -->
                            <button
                                @click="
                                    showingNavigationDropdown =
                                        !showingNavigationDropdown
                                "
                                class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none"
                            >

                                <!-- SVG digunakan untuk membuat ikon hamburger dan tanda silang -->
                                <svg
                                    class="h-6 w-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >

                                    <!-- Ikon garis tiga yang muncul ketika menu tertutup -->
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex':
                                                !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />

                                    <!-- Ikon silang yang muncul ketika menu terbuka -->
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex':
                                                showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu: menu navigasi untuk perangkat kecil -->
                <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="sm:hidden"
                >

                    <!-- Menampilkan menu Dashboard pada tampilan perangkat kecil -->
                    <div class="space-y-1 pb-3 pt-2">
                        <ResponsiveNavLink
                            :href="route('dashboard')"
                            :active="route().current('dashboard')"
                        >
                            Dashboard
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options: pengaturan akun pada perangkat kecil -->
                    <div
                        class="border-t border-gray-200 pb-1 pt-4"
                    >
                        <div class="px-4">

                            <!-- Menampilkan nama pengguna yang sedang login -->
                            <div
                                class="text-base font-medium text-gray-800"
                            >
                                {{ $page.props.auth.user.name }}
                            </div>

                            <!-- Menampilkan alamat email pengguna -->
                            <div class="text-sm font-medium text-gray-500">
                                {{ $page.props.auth.user.email }}
                            </div>
                        </div>

                        <!-- Menampilkan pilihan menu profil dan logout -->
                        <div class="mt-3 space-y-1">

                            <!-- Link untuk membuka halaman profil pengguna -->
                            <ResponsiveNavLink :href="route('profile.edit')">
                                Profile
                            </ResponsiveNavLink>

                            <!-- Link untuk mengakhiri sesi login pengguna -->
                            <ResponsiveNavLink
                                :href="route('logout')"
                                method="post"
                                as="button"
                            >
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading: bagian judul halaman -->
            <header
                class="bg-white shadow"
                v-if="$slots.header"
            >
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

                    <!-- Menampilkan judul halaman melalui named slot header -->
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content: bagian untuk menampilkan isi halaman -->
            <main>

                <!-- Slot digunakan untuk menampilkan konten
                     dari halaman yang menggunakan layout ini -->
                <slot />
            </main>
        </div>
    </div>
</template>
