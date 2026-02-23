<script setup>
import { Head, usePage } from '@inertiajs/vue3'
const props = defineProps({ loan: Object })
const page = usePage()
</script>

<template>
  <Head :title="`Peminjaman - ${loan.id}`" />
  <div class="card">
    <div class="card-header"><h5 class="mb-0">Detail Peminjaman</h5></div>
    <div class="card-body">
      <p><strong>User:</strong> {{ loan.user?.name }}</p>
      <p><strong>Book:</strong> {{ loan.book?.title }}</p>
      <p><strong>Loan Date:</strong> {{ loan.loan_date }}</p>
      <p><strong>Due Date:</strong> {{ loan.due_date }}</p>
      <p><strong>Return Date:</strong> {{ loan.return_date || '-' }}</p>
      <p><strong>Status:</strong> {{ loan.status }}</p>

      <form :action="route('admin.loans.update', loan.id)" method="post" class="mt-3">
        <input type="hidden" name="_method" value="put" />
        <input type="hidden" name="_token" :value="page.props.csrf_token" />
        <div class="mb-3">
          <label class="form-label">Status</label>
          <select name="status" class="form-select">
            <option value="borrowed" :selected="loan.status === 'borrowed'">borrowed</option>
            <option value="returned" :selected="loan.status === 'returned'">returned</option>
            <option value="late" :selected="loan.status === 'late'">late</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Return Date</label>
          <input type="date" name="return_date" class="form-control" :value="loan.return_date" />
        </div>
        <button class="btn btn-primary">Update</button>
      </form>
    </div>
  </div>
</template>
