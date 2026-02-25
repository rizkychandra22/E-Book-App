<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import App from '../../../Layouts/App.vue'

defineOptions({ layout: App })

const props = defineProps({ book: Object })

const form = useForm({
  book_id: props.book.id,
  loan_date: '',
  due_date: '',
})

const submit = () => {
  form.post(route('member.loans.store'))
}
</script>

<template>
  <Head :title="`Detail Buku - ${book.title}`" />

  <div class="row g-4">
    <div class="col-lg-7">
      <div class="card border-0 shadow-sm detail-card h-100">
        <div class="card-body p-4 p-md-5">
          <div class="d-flex justify-content-between align-items-start mb-3">
            <span class="badge rounded-pill book-category px-3 py-2">{{ book.category?.name || 'Tanpa Kategori' }}</span>
            <Link :href="route('dashboard')" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
              <i class="bi bi-arrow-left me-1"></i>Kembali
            </Link>
          </div>

          <h3 class="fw-bold mb-2">{{ book.title }}</h3>
          <p class="text-muted mb-4">oleh <strong>{{ book.author || '-' }}</strong></p>

          <div class="row g-3 mb-4">
            <div class="col-sm-6">
              <div class="meta-box">
                <small>Penerbit</small>
                <div class="fw-semibold">{{ book.publisher || '-' }}</div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="meta-box">
                <small>Tahun</small>
                <div class="fw-semibold">{{ book.year || '-' }}</div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="meta-box">
                <small>Stok</small>
                <div class="fw-semibold">{{ book.stock ?? 0 }}</div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="meta-box">
                <small>Kode Buku</small>
                <div class="fw-semibold">{{ book.code_book || '-' }}</div>
              </div>
            </div>
          </div>

          <h6 class="fw-bold mb-2">Deskripsi</h6>
          <p class="text-muted mb-0">{{ book.description || 'Belum ada deskripsi untuk buku ini.' }}</p>
        </div>
      </div>
    </div>

    <div class="col-lg-5">
      <div class="card border-0 shadow-sm detail-card">
        <div class="card-body p-4 p-md-5">
          <h5 class="fw-bold mb-1">Form Peminjaman</h5>
          <p class="text-muted mb-4">Isi tanggal pinjam dan tanggal kembali.</p>

          <form @submit.prevent="submit">
            <div class="mb-3">
              <label class="form-label fw-semibold">Tanggal Pinjam</label>
              <input
                v-model="form.loan_date"
                type="date"
                class="form-control form-control-modern"
                :class="{ 'is-invalid': form.errors.loan_date }"
              />
              <div v-if="form.errors.loan_date" class="invalid-feedback d-block">{{ form.errors.loan_date }}</div>
            </div>
            <div class="mb-4">
              <label class="form-label fw-semibold">Tanggal Kembali</label>
              <input
                v-model="form.due_date"
                type="date"
                class="form-control form-control-modern"
                :class="{ 'is-invalid': form.errors.due_date }"
              />
              <div v-if="form.errors.due_date" class="invalid-feedback d-block">{{ form.errors.due_date }}</div>
            </div>
            <button class="btn btn-modern-primary w-100 fw-semibold py-2 rounded-3" :disabled="form.processing">
              <span v-if="form.processing" class="spinner-border spinner-border-sm me-2"></span>
              Pinjam Buku
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.detail-card {
  border-radius: 16px;
}

.meta-box {
  border: 1px solid #e2e8f0;
  background: #f8fafc;
  border-radius: 12px;
  padding: 0.7rem 0.85rem;
}

.meta-box small {
  display: block;
  color: #64748b;
  margin-bottom: 0.2rem;
}

.book-category {
  background: #ccfbf1 !important;
  color: #0f766e !important;
  border: 1px solid #99f6e4;
}

.form-control-modern {
  min-height: 44px;
  border-radius: 10px;
  border-color: #dbe4ed;
}

.form-control-modern:focus {
  border-color: #0f766e;
  box-shadow: 0 0 0 0.2rem rgba(15, 118, 110, 0.15);
}

.btn-modern-primary {
  background: #0f766e;
  border-color: #0f766e;
  color: #fff;
}

.btn-modern-primary:hover {
  background: #0b5b55;
  border-color: #0b5b55;
  color: #fff;
}
</style>
