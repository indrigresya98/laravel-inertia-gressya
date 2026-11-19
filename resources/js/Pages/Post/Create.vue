
<script setup>
// Import layout utama aplikasi
import Layout from '../../Layouts/App.vue'

// Import reactive untuk membuat data yang dapat berubah secara otomatis
import { reactive } from 'vue'

// Import Link untuk navigasi dan router untuk mengirim data ke server melalui Inertia
import { Link, router } from '@inertiajs/vue3'

// Mengambil props errors dari controller untuk menampilkan pesan validasi
defineProps({
    errors: Object
})

// Membuat state post untuk menyimpan data judul dan isi postingan
const post = reactive({
    title: '',
    content: ''
})

// Function storePost digunakan untuk menyimpan postingan
function storePost() {
    // Mengirim data postingan ke server menggunakan method POST
    router.post('/posts', post)
}

// Function resetForm digunakan untuk mengosongkan seluruh input
function resetForm() {
    post.title = ''
    post.content = ''
}
</script>

<template>
    <!-- Menggunakan Layout utama aplikasi -->
    <Layout>
        <div class="mt-4">
            <!-- Bagian header dan tombol untuk kembali ke halaman postingan -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0 text-dark">TAMBAH POSTINGAN</h4>
                <!-- Link untuk kembali ke halaman daftar postingan -->
                <Link href="/posts" class="btn btn-sm btn-light border px-3 rounded-3 text-secondary">
                    ← Kembali
                </Link>
            </div>

            <!-- Card sebagai wadah form tambah postingan -->
            <div class="card border-0 rounded-4 shadow-sm" style="background-color: #FFF5F7;">
                <div class="card-body p-4">
                    <!-- Form akan menjalankan storePost saat dikirim tanpa melakukan reload halaman -->
                    <form @submit.prevent="storePost">
                        
                        <!-- Bagian input untuk judul postingan -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">TITLE POST</label>
                            <input 
                                type="text" 
                                class="form-control border-0 rounded-3 shadow-sm px-3 py-2" 
                                v-model="post.title" 
                                placeholder="Masukkan Title Post"
                                :class="{ 'is-invalid': errors?.title }"
                            >
                            <!-- Menampilkan pesan error jika judul tidak memenuhi validasi -->
                            <div v-if="errors?.title" class="text-danger text-sm mt-1">
                                {{ errors.title }}
                            </div>
                        </div>

                        <!-- Bagian input untuk isi postingan -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary">CONTENT</label>
                            <textarea 
                                class="form-control border-0 rounded-3 shadow-sm px-3 py-2" 
                                rows="5" 
                                v-model="post.content"
                                placeholder="Masukkan Content Post"
                                :class="{ 'is-invalid': errors?.content }"
                            ></textarea>
                            <!-- Menampilkan pesan error jika isi postingan tidak memenuhi validasi -->
                            <div v-if="errors?.content" class="text-danger text-sm mt-1">
                                {{ errors.content }}
                            </div>
                        </div>

                        <!-- Bagian tombol untuk menyimpan dan mereset form -->
                        <div class="d-flex gap-2">
                            <!-- Tombol SIMPAN untuk mengirim data postingan ke server -->
                            <button 
                                type="submit" 
                                class="btn text-white fw-bold px-4 rounded-3 border-0 shadow-sm" 
                                style="background-color: #F472B6;"
                            >
                                SIMPAN
                            </button>

                            <!-- Tombol RESET untuk mengosongkan kembali seluruh input -->
                            <button 
                                type="button" 
                                @click="resetForm" 
                                class="btn fw-semibold px-4 rounded-3 border-0 shadow-sm" 
                                style="background-color: #E0F2FE; color: #0284C7;"
                            >
                                RESET
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </Layout>
</template>
