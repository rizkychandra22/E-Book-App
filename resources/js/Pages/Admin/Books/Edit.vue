<script setup>
import { Head, usePage } from '@inertiajs/vue3'
const props = defineProps({ book: Object, categories: Array })
const page = usePage()
</script>

<template>
  <Head :title="`Edit Buku - ${book.title}`" />
  <div class="card">
    <div class="card-header"><h5 class="mb-0">Edit Buku</h5></div>
    <div class="card-body">
      <form :action="route('admin.books.update', book.id)" method="post">
        <input type="hidden" name="_method" value="put" />
        <input type="hidden" name="_token" :value="page.props.csrf_token" />
        <div class="mb-3">
          <label class="form-label">Title</label>
          <input name="title" class="form-control" :value="book.title" />
        </div>
        <div class="mb-3">
          <label class="form-label">Category</label>
          <select name="category_id" class="form-select">
            <option v-for="c in categories" :value="c.id" :key="c.id" :selected="c.id === book.category_id">{{ c.name }}</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Author</label>
          <input name="author" class="form-control" :value="book.author" />
        </div>
        <div class="mb-3">
          <label class="form-label">Stock</label>
          <input type="number" name="stock" class="form-control" :value="book.stock" />
        </div>
        <button class="btn btn-primary">Perbarui</button>
      </form>
    </div>
  </div>
</template>
