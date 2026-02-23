<script setup>
import { Head, usePage } from '@inertiajs/vue3'
const props = defineProps({ category: Object })
const page = usePage()
</script>

<template>
  <Head :title="`Edit Kategori - ${category.name}`" />
  <div class="card">
    <div class="card-header"><h5 class="mb-0">Edit Kategori</h5></div>
    <div class="card-body">
      <form :action="route('admin.categories.update', category.id)" method="post">
        <input type="hidden" name="_method" value="put" />
        <input type="hidden" name="_token" :value="page.props.csrf_token" />
        <div class="mb-3">
          <label class="form-label">Nama</label>
          <input name="name" class="form-control" :value="category.name" />
        </div>
        <button class="btn btn-primary">Perbarui</button>
      </form>
    </div>
  </div>
</template>
