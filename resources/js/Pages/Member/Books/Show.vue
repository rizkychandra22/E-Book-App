<script setup>
import { Head, usePage } from '@inertiajs/vue3'
const props = defineProps({ book: Object })
const page = usePage()
</script>

<template>
  <Head :title="`Buku - ${book.title}`" />
  <div class="card">
    <div class="card-body">
      <h5>{{ book.title }}</h5>
      <p class="small text-muted">{{ book.author }} — {{ book.category?.name }}</p>
      <p>{{ book.description }}</p>
      <form :action="route('member.loans.store')" method="post" class="mt-3">
        <input type="hidden" name="_token" :value="page.props.csrf_token" />
        <input type="hidden" name="book_id" :value="book.id" />
        <div class="mb-3">
          <label class="form-label">Tanggal Pinjam</label>
          <input type="date" name="loan_date" class="form-control" />
        </div>
        <div class="mb-3">
          <label class="form-label">Tanggal Kembali</label>
          <input type="date" name="due_date" class="form-control" />
        </div>
        <button class="btn btn-primary">Pinjam</button>
      </form>
    </div>
  </div>
</template>
