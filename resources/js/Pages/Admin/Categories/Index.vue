<script setup>
import { Link, Head, usePage } from '@inertiajs/vue3'
const props = defineProps({ categories: Object })
const page = usePage()
</script>

<template>
  <Head title="Categories - Admin" />
  
  <div class="mb-4">
    <h2 class="h4 fw-bold text-dark mb-1">🏷️ Manajemen Kategori</h2>
    <p class="text-muted">Kelola kategori buku dalam sistem</p>
  </div>

  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom-1 py-3">
      <div class="d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">Daftar Kategori</h5>
        <Link class="btn btn-primary btn-sm rounded-2" :href="route('admin.categories.create')">
          <i class="bi bi-plus-circle me-1"></i> Tambah Kategori
        </Link>
      </div>
    </div>
    <div class="card-body p-0">
      <div v-if="categories && categories.data && categories.data.length">
        <ul class="list-group list-group-flush">
          <li class="list-group-item d-flex justify-content-between align-items-center py-3 px-4 border-bottom" v-for="category in categories.data" :key="category.id">
            <div>
              <h6 class="mb-1 fw-semibold text-dark">{{ category.name }}</h6>
              <small class="text-muted">ID: {{ category.id }}</small>
            </div>
            <div class="btn-group btn-group-sm" role="group">
              <Link :href="route('admin.categories.edit', category.id)" class="btn btn-outline-primary" title="Edit">
                <i class="bi bi-pencil"></i>
              </Link>
              <form :action="route('admin.categories.destroy', category.id)" method="post" class="d-inline" @submit.prevent="(e) => confirm('Hapus kategori ini?') && e.target.submit()">
                <input type="hidden" name="_method" value="delete" />
                <input type="hidden" name="_token" :value="page.props.csrf_token" />
                <button type="submit" class="btn btn-outline-danger" title="Hapus">
                  <i class="bi bi-trash"></i>
                </button>
              </form>
            </div>
          </li>
        </ul>
      </div>
      <div v-else class="text-center py-5 text-muted">
        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
        <p class="mb-0">Belum ada kategori. <Link :href="route('admin.categories.create')" class="text-primary fw-bold">Buat sekarang</Link></p>
      </div>
    </div>
  </div>
</template>

<style scoped>
.card {
  border-radius: 12px;
  transition: box-shadow 0.3s ease;
}

.list-group-item {
  transition: background-color 0.2s ease;
}

.list-group-item:hover {
  background-color: #f8f9fa;
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
