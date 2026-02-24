<script setup>
import { Link, Head, usePage } from '@inertiajs/vue3'
const props = defineProps({ users: Object })
const page = usePage()

const getRoleBadge = (role) => {
  return role === 'admin' ? 'danger' : 'primary'
}

const getRoleLabel = (role) => {
  const labels = {
    'admin': '👑 Administrator',
    'member': '👤 Member'
  }
  return labels[role] || role
}
</script>

<template>
  <Head title="Users - Admin" />
  
  <div class="mb-4">
    <h2 class="h4 fw-bold text-dark mb-1">👥 Manajemen User</h2>
    <p class="text-muted">Kelola pengguna dan izin akses sistem</p>
  </div>

  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom-1 py-3">
      <h5 class="mb-0 fw-bold">Daftar User</h5>
    </div>
    <div class="card-body p-0">
      <div v-if="users && users.data && users.data.length" class="table-responsive">
        <table class="table table-hover mb-0">
          <thead class="table-light">
            <tr>
              <th class="fw-bold">Nama</th>
              <th class="fw-bold">Email</th>
              <th class="fw-bold text-center">Role</th>
              <th class="fw-bold text-center w-20">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in users.data" :key="user.id" class="align-middle">
              <td>
                <div class="fw-semibold">{{ user.name }}</div>
                <small class="text-muted">ID: {{ user.id }}</small>
              </td>
              <td>
                <small>{{ user.email }}</small>
              </td>
              <td class="text-center">
                <span class="badge" :class="`bg-${getRoleBadge(user.role)}`">
                  {{ getRoleLabel(user.role) }}
                </span>
              </td>
              <td class="text-center">
                <div class="btn-group btn-group-sm" role="group">
                  <Link :href="route('admin.users.edit', user.id)" class="btn btn-outline-primary" title="Edit">
                    <i class="bi bi-pencil"></i>
                  </Link>
                  <form :action="route('admin.users.destroy', user.id)" method="post" class="d-inline" @submit.prevent="(e) => confirm('Hapus user ini?') && e.target.submit()">
                    <input type="hidden" name="_method" value="delete" />
                    <input type="hidden" name="_token" :value="page.props.csrf_token" />
                    <button type="submit" class="btn btn-outline-danger" title="Hapus">
                      <i class="bi bi-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div v-else class="text-center py-5 text-muted">
        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
        <p class="mb-0">Belum ada user terdaftar</p>
      </div>
    </div>
  </div>
</template>

<style scoped>
.card {
  border-radius: 12px;
  transition: box-shadow 0.3s ease;
}

.table-hover tbody tr:hover {
  background-color: #f8f9fa;
  transition: background-color 0.2s ease;
}

.badge {
  font-weight: 600;
  padding: 0.5rem 1rem;
  border-radius: 8px;
}

.btn-group-sm .btn {
  padding: 0.25rem 0.5rem;
  font-size: 0.75rem;
}
</style>
