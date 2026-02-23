<script setup>
import { Head, useForm } from '@inertiajs/vue3'
const props = defineProps({ user: Object })

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    role: props.user.role,
})

const submit = () => {
    form.put(route('admin.users.update', props.user.id), {
        onSuccess: () => form.reset(),
    })
}
</script>

<template>
  <Head :title="`Edit User - ${user.name}`" />
  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom py-3">
      <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Edit User</h5>
    </div>
    <div class="card-body">
      <form @submit.prevent="submit">
        <div class="mb-3">
          <label class="form-label">Nama<span class="text-danger">*</span></label>
          <input v-model="form.name" class="form-control" :class="{ 'is-invalid': form.errors.name }" placeholder="Nama user" />
          <div class="invalid-feedback d-block" v-if="form.errors.name">{{ form.errors.name }}</div>
        </div>
        <div class="mb-3">
          <label class="form-label">Email<span class="text-danger">*</span></label>
          <input v-model="form.email" type="email" class="form-control" :class="{ 'is-invalid': form.errors.email }" placeholder="Email user" />
          <div class="invalid-feedback d-block" v-if="form.errors.email">{{ form.errors.email }}</div>
        </div>
        <div class="mb-3">
          <label class="form-label">Role<span class="text-danger">*</span></label>
          <select v-model="form.role" class="form-select" :class="{ 'is-invalid': form.errors.role }">
            <option value="">-- Pilih Role --</option>
            <option value="admin">Administrator</option>
            <option value="member">Member</option>
          </select>
          <div class="invalid-feedback d-block" v-if="form.errors.role">{{ form.errors.role }}</div>
        </div>
        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-primary" :disabled="form.processing">
            <i class="bi bi-check-circle me-1" v-if="!form.processing"></i>
            <span v-if="form.processing" class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
            {{ form.processing ? 'Menyimpan...' : 'Perbarui' }}
          </button>
          <a href="/dashboard" class="btn btn-secondary">Batal</a>
        </div>
      </form>
    </div>
  </div>
</template>
