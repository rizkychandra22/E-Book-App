<script setup>
import { Link, Head, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const props = defineProps({ loans: Object })
const page = usePage()

const getStatusBadge = (status) => {
  const badges = {
    'borrowed': 'warning',
    'returned': 'success',
    'late': 'danger'
  }
  return badges[status] || 'secondary'
}

const getStatusLabel = (status) => {
  const labels = {
    'borrowed': '📖 Dipinjam',
    'returned': '✓ Dikembalikan',
    'late': '⏰ Terlambat'
  }
  return labels[status] || status
}
</script>

<template>
  <Head title="Loans - Admin" />
  
  <div class="mb-4">
    <h2 class="h4 fw-bold text-dark mb-1">📋 Rekap Peminjaman</h2>
    <p class="text-muted">Kelola semua catatan peminjaman buku member</p>
  </div>

  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom-1 py-3">
      <h5 class="mb-0 fw-bold">Daftar Peminjaman</h5>
    </div>
    <div class="card-body p-0">
      <div v-if="loans && loans.data && loans.data.length" class="table-responsive">
        <table class="table table-hover mb-0">
          <thead class="table-light">
            <tr>
              <th class="fw-bold">Member</th>
              <th class="fw-bold">📚 Judul Buku</th>
              <th class="fw-bold">Tgl Pinjam</th>
              <th class="fw-bold">Tgl Kembali</th>
              <th class="fw-bold text-center">Status</th>
              <th class="fw-bold text-center w-15">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="loan in loans.data" :key="loan.id" class="align-middle">
              <td>
                <div class="fw-semibold">{{ loan.user?.name }}</div>
                <small class="text-muted">{{ loan.user?.email }}</small>
              </td>
              <td>
                <div class="fw-semibold">{{ loan.book?.title }}</div>
                <small class="text-muted">{{ loan.book?.author }}</small>
              </td>
              <td>
                <small class="text-muted">{{ new Date(loan.loan_date).toLocaleDateString('id-ID') }}</small>
              </td>
              <td>
                <small class="text-muted">{{ new Date(loan.due_date).toLocaleDateString('id-ID') }}</small>
              </td>
              <td class="text-center">
                <span class="badge" :class="`bg-${getStatusBadge(loan.status)}`">
                  {{ getStatusLabel(loan.status) }}
                </span>
              </td>
              <td class="text-center">
                <Link :href="route('admin.loans.show', loan.id)" class="btn btn-sm btn-outline-primary rounded-2">
                  <i class="bi bi-eye"></i> Lihat
                </Link>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div v-else class="text-center py-5 text-muted">
        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
        <p class="mb-0">Belum ada data peminjaman</p>
      </div>
    </div>
  </div>
</template>

<style scoped>
.card {
  border-radius: 12px;
  transition: box-shadow 0.3s ease;
}

.table-hover tbody tr:hover {
  background-color: #f8f9fa;
  transition: background-color 0.2s ease;
}

.badge {
  font-weight: 600;
  padding: 0.5rem 1rem;
  border-radius: 8px;
}

.btn-sm {
  padding: 0.35rem 0.75rem;
}
</style>
