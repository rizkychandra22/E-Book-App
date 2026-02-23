<script setup>
import { Head, useForm } from '@inertiajs/vue3'

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
  <Head :title="`Buku - ${book.title}`" />
  <div class="card">
    <div class="card-body">
      <h5>{{ book.title }}</h5>
      <p class="small text-muted">{{ book.author }} — {{ book.category?.name }}</p>
      <p>{{ book.description }}</p>
      <form class="mt-3" @submit.prevent="submit">
        <div class="mb-3">
          <label class="form-label">Tanggal Pinjam</label>
          <input v-model="form.loan_date" type="date" class="form-control" :class="{ 'is-invalid': form.errors.loan_date }" />
          <div v-if="form.errors.loan_date" class="invalid-feedback d-block">{{ form.errors.loan_date }}</div>
        </div>
        <div class="mb-3">
          <label class="form-label">Tanggal Kembali</label>
          <input v-model="form.due_date" type="date" class="form-control" :class="{ 'is-invalid': form.errors.due_date }" />
          <div v-if="form.errors.due_date" class="invalid-feedback d-block">{{ form.errors.due_date }}</div>
        </div>
        <button class="btn btn-primary" :disabled="form.processing">Pinjam</button>
      </form>
    </div>
  </div>
</template>
