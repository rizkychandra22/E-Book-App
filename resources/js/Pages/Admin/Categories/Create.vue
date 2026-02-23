<script setup>
import { Head, usePage } from '@inertiajs/vue3'
const page = usePage()
</script>

<template>
  <Head title="Tambah Kategori" />
  <div class="card">
    <div class="card-header"><h5 class="mb-0">Tambah Kategori</h5></div>
    <div class="card-body">
      <form :action="route('admin.categories.store')" method="post">
        <input type="hidden" name="_token" :value="page.props.csrf_token" />
        <div class="mb-3">
          <label class="form-label">Nama</label>
          <input name="name" class="form-control" />
        </div>
        <button class="btn btn-primary">Simpan</button>
      </form>
    </div>
  </div>
</template>
