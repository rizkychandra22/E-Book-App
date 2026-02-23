<script setup>
import { Head, usePage } from '@inertiajs/vue3'
const props = defineProps({ user: Object })
const page = usePage()
</script>

<template>
  <Head :title="`Edit User - ${user.name}`" />
  <div class="card">
    <div class="card-header"><h5 class="mb-0">Edit User</h5></div>
    <div class="card-body">
      <form :action="route('admin.users.update', user.id)" method="post">
        <input type="hidden" name="_method" value="put" />
        <input type="hidden" name="_token" :value="page.props.csrf_token" />
        <div class="mb-3">
          <label class="form-label">Name</label>
          <input name="name" class="form-control" :value="user.name" />
        </div>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input name="email" class="form-control" :value="user.email" />
        </div>
        <div class="mb-3">
          <label class="form-label">Role</label>
          <select name="role" class="form-select">
            <option value="admin" :selected="user.role === 'admin'">admin</option>
            <option value="member" :selected="user.role === 'member'">member</option>
          </select>
        </div>
        <button class="btn btn-primary">Perbarui</button>
      </form>
    </div>
  </div>
</template>
