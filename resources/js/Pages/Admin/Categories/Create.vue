<script setup>
import { Head, useForm } from '@inertiajs/vue3'

const form = useForm({
    name: '',
})

const submit = () => {
    form.post(route('admin.categories.store'), {
        onSuccess: () => form.reset(),
    })
}
</script>

<template>
  <Head title="Tambah Kategori" />
  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom py-3">
      <h5 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Tambah Kategori</h5>
    </div>
    <div class="card-body">
      <form @submit.prevent="submit">
        <div class="mb-3">
          <label class="form-label">Nama Kategori<span class="text-danger">*</span></label>
          <input v-model="form.name" class="form-control" :class="{ 'is-invalid': form.errors.name }" placeholder="Masukkan nama kategori" />
          <div class="invalid-feedback d-block" v-if="form.errors.name">{{ form.errors.name }}</div>
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
