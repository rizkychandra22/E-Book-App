<script setup>
import { Link, Head, usePage } from '@inertiajs/vue3'
const props = defineProps({ books: Object, categories: Object })
const page = usePage()
</script>

<template>
  <Head title="Books - Admin" />
  
  <div class="mb-4">
    <h2 class="h4 fw-bold text-dark mb-1">📚 Manajemen Buku</h2>
    <p class="text-muted">Kelola seluruh koleksi buku di sistem</p>
  </div>

  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom-1 py-3">
      <div class="d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">Daftar Buku</h5>
        <Link class="btn btn-primary btn-sm rounded-2" :href="route('admin.books.create')">
          <i class="bi bi-plus-circle me-1"></i> Tambah Buku
        </Link>
      </div>
    </div>
    <div class="card-body p-0">
      <div v-if="books && books.data && books.data.length" class="table-responsive">
        <table class="table table-hover mb-0">
          <thead class="table-light">
            <tr>
              <th class="fw-bold">📖 Judul</th>
              <th class="fw-bold">Kategori</th>
              <th class="fw-bold">Penulis</th>
              <th class="fw-bold text-center">Stok</th>
              <th class="fw-bold text-center w-25">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="book in books.data" :key="book.id" class="align-middle">
              <td>
                <div class="fw-semibold">{{ book.title }}</div>
                <small class="text-muted">ID: {{ book.id }}</small>
              </td>
              <td>
                <span class="badge bg-info">{{ book.category?.name || 'Tanpa Kategori' }}</span>
              </td>
              <td>{{ book.author }}</td>
              <td class="text-center">
                <span class="badge" :class="book.stock > 0 ? 'bg-success' : 'bg-danger'">
                  {{ book.stock }}
                </span>
              </td>
              <td class="text-center">
                <div class="btn-group btn-group-sm" role="group">
                  <Link :href="route('admin.books.edit', book.id)" class="btn btn-outline-primary" title="Edit">
                    <i class="bi bi-pencil"></i>
                  </Link>
                  <form :action="route('admin.books.destroy', book.id)" method="post" class="d-inline" @submit.prevent="(e) => confirm('Hapus buku ini?') && e.target.submit()">
                    <input type="hidden" name="_method" value="delete" />
                    <input type="hidden" name="_token" :value="page.props.csrf_token" />
                    <button type="submit" class="btn btn-outline-danger" title="Hapus">
                      <i class="bi bi-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div v-else class="text-center py-5 text-muted">
        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
        <p class="mb-0">Belum ada buku. <Link :href="route('admin.books.create')" class="text-primary fw-bold">Tambah sekarang</Link></p>
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

.btn-group-sm .btn {
  padding: 0.25rem 0.5rem;
  font-size: 0.75rem;
}

.badge {
  font-weight: 600;
  padding: 0.5rem 1rem;
  border-radius: 8px;
}
</style>
