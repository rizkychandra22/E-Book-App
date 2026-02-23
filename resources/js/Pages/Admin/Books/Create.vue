<script setup>
import { Head, usePage } from '@inertiajs/vue3'
const props = defineProps({ categories: Array })
const page = usePage()
</script>

<template>
  <Head title="Tambah Buku" />
  <div class="card">
    <div class="card-header"><h5 class="mb-0">Tambah Buku</h5></div>
    <div class="card-body">
      <form :action="route('admin.books.store')" method="post">
        <input type="hidden" name="_token" :value="page.props.csrf_token" />
        <div class="mb-3">
          <label class="form-label">Title</label>
          <input name="title" class="form-control" />
        </div>
        <div class="mb-3">
          <label class="form-label">Category</label>
          <select name="category_id" class="form-select">
            <option v-for="c in categories" :value="c.id" :key="c.id">{{ c.name }}</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Author</label>
          <input name="author" class="form-control" />
        </div>
        <div class="mb-3">
          <label class="form-label">Stock</label>
          <input type="number" name="stock" class="form-control" />
        </div>
        <button class="btn btn-primary">Simpan</button>
      </form>
    </div>
  </div>
</template>
