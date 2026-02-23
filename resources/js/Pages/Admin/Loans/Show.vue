<script setup>
import { Head, useForm } from '@inertiajs/vue3'
const props = defineProps({ loan: Object })

const form = useForm({
    status: props.loan.status,
    return_date: props.loan.return_date,
})

const submit = () => {
    form.put(route('admin.loans.update', props.loan.id), {
        onSuccess: () => form.reset(),
    })
}
</script>

<template>
  <Head :title="`Peminjaman - ${loan.id}`" />
  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom py-3">
      <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Detail Peminjaman #{{ loan.id }}</h5>
    </div>
    <div class="card-body">
      <div class="row mb-4">
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label text-muted small">Member</label>
            <h6 class="fw-bold">{{ loan.user?.name }}</h6>
            <small class="text-muted">{{ loan.user?.email }}</small>
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label text-muted small">Buku</label>
            <h6 class="fw-bold">{{ loan.book?.title }}</h6>
            <small class="text-muted">{{ loan.book?.author }}</small>
          </div>
        </div>
      </div>

      <div class="row mb-4">
        <div class="col-md-4">
          <div class="mb-3">
            <label class="form-label text-muted small">Tanggal Pinjam</label>
            <p class="mb-0">{{ new Date(loan.loan_date).toLocaleDateString('id-ID') }}</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="mb-3">
            <label class="form-label text-muted small">Tanggal Kembali</label>
            <p class="mb-0">{{ new Date(loan.due_date).toLocaleDateString('id-ID') }}</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="mb-3">
            <label class="form-label text-muted small">Status</label>
            <span class="badge bg-warning">{{ loan.status }}</span>
          </div>
        </div>
      </div>

      <hr class="my-4" />

      <h5 class="mb-3">Update Status Peminjaman</h5>
      <form @submit.prevent="submit">
        <div class="mb-3">
          <label class="form-label">Status<span class="text-danger">*</span></label>
          <select v-model="form.status" class="form-select" :class="{ 'is-invalid': form.errors.status }">
            <option value="">-- Pilih Status --</option>
            <option value="borrowed">📖 Dipinjam</option>
            <option value="returned">✓ Dikembalikan</option>
            <option value="late">⏰ Terlambat</option>
          </select>
          <div class="invalid-feedback d-block" v-if="form.errors.status">{{ form.errors.status }}</div>
        </div>
        <div class="mb-3">
          <label class="form-label">Tanggal Pengembalian</label>
          <input v-model="form.return_date" type="date" class="form-control" />
        </div>
        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-primary" :disabled="form.processing">
            <i class="bi bi-check-circle me-1" v-if="!form.processing"></i>
            <span v-if="form.processing" class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
            {{ form.processing ? 'Memperbarui...' : 'Perbarui Status' }}
          </button>
          <a href="/dashboard" class="btn btn-secondary">Kembali</a>
        </div>
      </form>
    </div>
  </div>
</template>
