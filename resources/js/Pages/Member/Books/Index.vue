<script setup>
import { Link, Head } from '@inertiajs/vue3'
const props = defineProps({ books: Object })
</script>

<template>
  <Head title="Katalog Buku" />
  
  <div class="mb-4">
    <h2 class="h4 fw-bold text-dark mb-1">📚 Katalog Buku</h2>
    <p class="text-muted">Jelajahi koleksi buku yang tersedia untuk dipinjam</p>
  </div>

  <div v-if="books && books.data && books.data.length" class="row g-4">
    <div class="col-md-6 col-lg-4 col-xxl-3" v-for="book in books.data" :key="book.id">
      <div class="card border-0 shadow-sm h-100 book-card">
        <div class="card-img-placeholder bg-light d-flex align-items-center justify-content-center position-relative" style="height: 220px; border-radius: 12px 12px 0 0; overflow: hidden;">
          <div class="text-center w-100">
            <i class="bi bi-book fs-1 text-primary opacity-25 d-block mb-2"></i>
            <small class="text-muted">Sampul Buku</small>
          </div>
        </div>
        <div class="card-body d-flex flex-column">
          <h6 class="card-title fw-bold mb-1 text-dark line-clamp-2">{{ book.title }}</h6>
          <small class="text-muted mb-2">oleh <strong>{{ book.author }}</strong></small>
          
          <div class="mb-3">
            <span class="badge bg-info">{{ book.category?.name || 'Lainnya' }}</span>
          </div>

          <div class="mt-auto">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <small class="text-muted">Stok: <strong>{{ book.stock }}</strong></small>
              <span class="badge" :class="book.stock > 0 ? 'bg-success' : 'bg-danger'">
                {{ book.stock > 0 ? 'Tersedia' : 'Habis' }}
              </span>
            </div>
            <Link :href="route('member.books.show', book.id)" class="btn btn-primary btn-sm w-100 rounded-2">
              <i class="bi bi-eye me-1"></i> Lihat Detail
            </Link>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div v-else class="text-center py-5">
    <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
    <p class="text-muted">Belum ada buku yang tersedia</p>
  </div>
</template>

<style scoped>
.book-card {
  border-radius: 12px;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.book-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15) !important;
}

.card-img-placeholder {
  background: linear-gradient(135deg, #f0f4ff 0%, #f8faff 100%);
}

.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.badge {
  font-weight: 600;
  padding: 0.5rem 0.75rem;
  border-radius: 6px;
}

.btn-sm {
  padding: 0.5rem 1rem;
  font-weight: 500;
}
</style>
