
<script setup>
// Import layout utama aplikasi
import Layout from '../../Layouts/App.vue'

// Import reactive untuk membuat data yang dapat berubah secara otomatis
import { reactive } from 'vue'

// Import Link untuk navigasi dan router untuk mengirim data melalui Inertia
import { Link, router } from '@inertiajs/vue3'

// Mengambil props post dan errors dari controller
const props = defineProps({
    post: Object,
    errors: Object
})

// Membuat state form yang diisi dengan data postingan dari props
const form = reactive({
    title: props.post.title,
    content: props.post.content
})

// Function updatePost digunakan untuk memperbarui data postingan
function updatePost() {
    // Mengirim data yang telah diedit ke server menggunakan method PUT
    router.put(`/posts/${props.post.id}`, form)
}
</script>

<template>
    <!-- Menggunakan Layout utama aplikasi -->
    <Layout>
        <div class="mt-4">
            <!-- Bagian header dan tombol untuk kembali ke halaman postingan -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0 text-dark">EDIT POSTINGAN</h4>
                <!-- Link untuk kembali ke halaman daftar postingan -->
                <Link href="/posts" class="btn btn-sm btn-light border px-3 rounded-3 text-secondary">
                    ← Kembali
                </Link>
            </div>

            <!-- Card sebagai wadah form edit postingan -->
            <div class="card border-0 rounded-4 shadow-sm" style="background-color: #FFF5F7;">
                <div class="card-body p-4">
                    <!-- Form menjalankan updatePost ketika dikirim tanpa reload halaman -->
                    <form @submit.prevent="updatePost">
                        
                        <!-- Bagian input untuk mengedit judul postingan -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">TITLE POST</label>
                            <input 
                                type="text" 
                                class="form-control border-0 rounded-3 shadow-sm px-3 py-2" 
                                v-model="form.title" 
                                placeholder="Masukkan Title Post"
                                :class="{ 'is-invalid': errors?.title }"
                            >
                            <!-- Menampilkan pesan error jika judul tidak memenuhi validasi -->
                            <div v-if="errors?.title" class="text-danger text-sm mt-1">
                                {{ errors.title }}
                            </div>
                        </div>

                        <!-- Bagian input untuk mengedit isi postingan -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary">CONTENT</label>
                            <textarea 
                                class="form-control border-0 rounded-3 shadow-sm px-3 py-2" 
                                rows="5" 
                                v-model="form.content"
                                placeholder="Masukkan Content Post"
                                :class="{ 'is-invalid': errors?.content }"
                            ></textarea>
                            <!-- Menampilkan pesan error jika isi postingan tidak memenuhi validasi -->
                            <div v-if="errors?.content" class="text-danger text-sm mt-1">
                                {{ errors.content }}
                            </div>
                        </div>

                        <!-- Bagian tombol untuk menyimpan perubahan postingan -->
                        <div class="d-flex gap-2">
                            <!-- Tombol UPDATE untuk mengirim perubahan data ke server -->
                            <button 
                                type="submit" 
                                class="btn text-white fw-bold px-4 rounded-3 border-0 shadow-sm" 
                                style="background-color: #38BDF8;"
                            >
                                UPDATE
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </Layout>
</template>
