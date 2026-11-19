
<script setup>
// Import layout utama aplikasi
import Layout from '../../Layouts/App.vue'

// Import Link untuk navigasi dan router untuk menjalankan aksi melalui Inertia
import { Link, router } from '@inertiajs/vue3';

// Mengambil props posts dari controller yang berisi daftar data postingan
defineProps({
    posts: Array
});

// Function deletePost digunakan untuk menghapus data postingan berdasarkan ID
const deletePost = (id) => {
    // Menampilkan konfirmasi sebelum menghapus data postingan
    if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
        // Mengirim permintaan DELETE ke server berdasarkan ID postingan
        router.delete(`/posts/${id}`);
    }
};
</script>

<template>
    <!-- Menggunakan Layout utama aplikasi -->
    <Layout>
        <div class="mt-4">
            <!-- Menampilkan pesan pemberitahuan jika terdapat flash message dari server -->
            <div v-if="$page.props.flash?.message" class="alert border-0 shadow-sm text-white mb-4" style="background-color: #38BDF8;" role="alert">
                ✨ {{ $page.props.flash.message }}
            </div>

            <!-- Bagian tombol aksi untuk menambah data dan logout -->
            <div class="mb-4 d-flex justify-content-between align-items-center">
                <!-- Link menuju halaman tambah postingan -->
                <Link href="/posts/create" class="btn text-white fw-bold px-4 rounded-3 border-0 shadow-sm" style="background-color: #F472B6;">
                    + TAMBAH DATA
                </Link>
                
                <!-- Tombol Logout untuk keluar dari akun menggunakan method POST -->
                <Link href="/logout" method="post" as="button" class="btn btn-outline-danger fw-semibold rounded-3 px-3">
                    LOGOUT
                </Link>
            </div>

            <!-- Card sebagai wadah tabel daftar postingan -->
            <div class="card border-0 rounded-4 shadow-sm" style="background-color: #FFF5F7;">
                <div class="card-body p-4">
                    <!-- Membuat tabel responsif agar dapat menyesuaikan ukuran layar -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <!-- Bagian kepala tabel yang berisi nama setiap kolom -->
                            <thead>
                                <tr style="background-color: #FCE7F3; color: #DB2777;">
                                    <th scope="col" class="py-3 px-3 rounded-start-3">TITLE</th>
                                    <th scope="col" class="py-3 px-3">CONTENT</th>
                                    <th scope="col" class="py-3 px-3 text-center rounded-end-3" style="width: 200px;">ACTIONS</th>
                                </tr>
                            </thead>

                            <!-- Bagian isi tabel untuk menampilkan data postingan -->
                            <tbody>
                                <!-- Mengulang setiap data postingan yang diterima dari controller -->
                                <tr v-for="post in posts" :key="post.id">
                                    <!-- Menampilkan judul postingan -->
                                    <td class="px-3 fw-bold text-dark">{{ post.title }}</td>

                                    <!-- Menampilkan isi postingan -->
                                    <td class="px-3 text-secondary">{{ post.content }}</td>

                                    <!-- Kolom tombol aksi untuk mengedit dan menghapus postingan -->
                                    <td class="px-3 text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <!-- Tombol Edit untuk menuju halaman edit berdasarkan ID postingan -->
                                            <Link :href="`/posts/${post.id}/edit`" class="btn btn-sm text-white fw-semibold px-3 rounded-2 border-0" style="background-color: #38BDF8;">
                                                EDIT
                                            </Link>
                                            
                                            <!-- Tombol Hapus untuk menjalankan function deletePost -->
                                            <button @click="deletePost(post.id)" class="btn btn-sm fw-semibold px-3 rounded-2 border-0" style="background-color: #FCE7F3; color: #DB2777;">
                                                HAPUS
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Menampilkan pesan jika data postingan kosong atau belum tersedia -->
                                <tr v-if="!posts || posts.length === 0">
                                    <td colspan="3" class="text-center py-4 text-muted">
                                        Belum ada data postingan.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
