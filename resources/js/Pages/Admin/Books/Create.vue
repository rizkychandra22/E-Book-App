<script setup>
import { Head, useForm } from '@inertiajs/vue3'
const props = defineProps({ categories: Array })

const form = useForm({
    title: '',
    author: '',
    category_id: '',
    stock: 0,
})

const submit = () => {
    form.post(route('admin.books.store'), {
        onSuccess: () => form.reset(),
    })
}
</script>

<template>
  <Head title="Tambah Buku" />
  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom py-3">
      <h5 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Tambah Buku</h5>
    </div>
    <div class="card-body">
      <form @submit.prevent="submit">
        <div class="mb-3">
          <label class="form-label">Judul<span class="text-danger">*</span></label>
          <input v-model="form.title" class="form-control" :class="{ 'is-invalid': form.errors.title }" placeholder="Masukkan judul buku" />
          <div class="invalid-feedback d-block" v-if="form.errors.title">{{ form.errors.title }}</div>
        </div>
        <div class="mb-3">
          <label class="form-label">Author</label>
          <input v-model="form.author" class="form-control" placeholder="Nama penulis" />
        </div>
        <div class="mb-3">
          <label class="form-label">Kategori<span class="text-danger">*</span></label>
          <select v-model="form.category_id" class="form-select" :class="{ 'is-invalid': form.errors.category_id }">
            <option value="">-- Pilih Kategori --</option>
            <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name }}</option>
          </select>
          <div class="invalid-feedback d-block" v-if="form.errors.category_id">{{ form.errors.category_id }}</div>
        </div>
        <div class="mb-3">
          <label class="form-label">Stok</label>
          <input v-model.number="form.stock" type="number" class="form-control" min="0" placeholder="0" />
        </div>
        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-primary" :disabled="form.processing">
            <i class="bi bi-check-circle me-1" v-if="!form.processing"></i>
            <span v-if="form.processing" class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
            {{ form.processing ? 'Menyimpan...' : 'Simpan' }}
          </button>
          <a href="/dashboard" class="btn btn-secondary">Batal</a>
        </div>
      </form>
    </div>
  </div>
</template>
