<script setup>
import { Head, usePage, Link } from '@inertiajs/vue3'
import App from '../Layouts/App.vue'
import { computed, ref } from 'vue'

defineOptions({ layout: App })

defineProps({
    stats: Object,
    books: Object,
    loans: Object,
    users: Object,
    myLoans: Object,
    categories: Object,
})

const page = usePage()
const user = computed(() => page.props.auth.user)
const role = computed(() => user.value?.role)
const activeTab = ref('overview')

const getStatusBadge = (status) => {
    const badges = {
        'borrowed': 'warning',
        'returned': 'success',
        'late': 'danger'
    }
    return badges[status] || 'secondary'
}

const getStatusLabel = (status) => {
    const labels = {
        'borrowed': '📖 Dipinjam',
        'returned': '✓ Dikembalikan',
        'late': '⏰ Terlambat'
    }
    return labels[status] || status
}

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
    <Head :title="`Dashboard - E-Book App`" />
    
    <!-- Welcome Section -->
    <div class="mb-4">
        <h1 class="h3 fw-bold text-dark mb-2">Selamat datang kembali, <span class="text-primary">{{ user.name }}</span>! 👋</h1>
        <p class="text-muted">{{ role === 'admin' ? 'Panel Administratur E-Book' : 'Dashboard Anggota E-Book' }}</p>
    </div>

    <!-- Stats Cards Grid -->
    <div class="row g-4 mb-4">
        <!-- Admin Stats -->
        <template v-if="role === 'admin'">
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 stat-card bg-gradient-primary">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="stat-label text-white-50 mb-1">Total Buku</p>
                            <h2 class="stat-value text-white mb-0">{{ stats.total_books || 0 }}</h2>
                        </div>
                        <div class="stat-icon bg-white bg-opacity-25 text-white">
                            <i class="bi bi-book fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 stat-card bg-gradient-success">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="stat-label text-white-50 mb-1">Total Users</p>
                            <h2 class="stat-value text-white mb-0">{{ stats.total_users || 0 }}</h2>
                        </div>
                        <div class="stat-icon bg-white bg-opacity-25 text-white">
                            <i class="bi bi-people fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 stat-card bg-gradient-warning">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="stat-label text-white-50 mb-1">Kategori</p>
                            <h2 class="stat-value text-white mb-0">{{ stats.total_categories || 0 }}</h2>
                        </div>
                        <div class="stat-icon bg-white bg-opacity-25 text-white">
                            <i class="bi bi-tags fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 stat-card bg-gradient-info">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="stat-label text-white-50 mb-1">Peminjaman</p>
                            <h2 class="stat-value text-white mb-0">{{ stats.total_loans || 0 }}</h2>
                        </div>
                        <div class="stat-icon bg-white bg-opacity-25 text-white">
                            <i class="bi bi-clock-history fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <!-- Member Stats -->
        <template v-else>
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 stat-card bg-gradient-info">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="stat-label text-white-50 mb-1">Buku Dipinjam</p>
                            <h2 class="stat-value text-white mb-0">{{ stats.my_borrowed || 0 }}</h2>
                        </div>
                        <div class="stat-icon bg-white bg-opacity-25 text-white">
                            <i class="bi bi-book fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 stat-card bg-gradient-secondary">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="stat-label text-white-50 mb-1">Wishlist</p>
                            <h2 class="stat-value text-white mb-0">{{ stats.my_wishlist || 0 }}</h2>
                        </div>
                        <div class="stat-icon bg-white bg-opacity-25 text-white">
                            <i class="bi bi-star fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 stat-card bg-gradient-danger">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="stat-label text-white-50 mb-1">Keterlambatan</p>
                            <h2 class="stat-value text-white mb-0">{{ stats.late_returns || 0 }}</h2>
                        </div>
                        <div class="stat-icon bg-white bg-opacity-25 text-white">
                            <i class="bi bi-exclamation-triangle fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <!-- Tabs Navigation -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom-1 p-0">
            <ul class="nav nav-tabs border-0" role="tablist">
                <li class="nav-item" role="presentation">
                    <button 
                        class="nav-link" 
                        :class="{ active: activeTab === 'overview' }"
                        @click="activeTab = 'overview'"
                        type="button"
                    >
                        <i class="bi bi-bar-chart me-2"></i> Overview
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button 
                        class="nav-link"
                        :class="{ active: activeTab === 'books' }"
                        @click="activeTab = 'books'"
                        type="button"
                    >
                        <i class="bi bi-book me-2"></i> Buku
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button 
                        class="nav-link"
                        :class="{ active: activeTab === 'loans' }"
                        @click="activeTab = 'loans'"
                        type="button"
                    >
                        <i class="bi bi-clock-history me-2"></i> Peminjaman
                    </button>
                </li>
                <li v-if="role === 'admin'" class="nav-item" role="presentation">
                    <button 
                        class="nav-link"
                        :class="{ active: activeTab === 'users' }"
                        @click="activeTab = 'users'"
                        type="button"
                    >
                        <i class="bi bi-people me-2"></i> User
                    </button>
                </li>
                <li v-if="role === 'admin'" class="nav-item" role="presentation">
                    <button 
                        class="nav-link"
                        :class="{ active: activeTab === 'categories' }"
                        @click="activeTab = 'categories'"
                        type="button"
                    >
                        <i class="bi bi-tags me-2"></i> Kategori
                    </button>
                </li>
            </ul>
        </div>
        
        <!-- Tab Content -->
        <div class="card-body">
            <!-- Overview Tab -->
            <div v-if="activeTab === 'overview'" class="tab-pane active">
                <div class="alert alert-info border-0">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Dashboard Overview:</strong> Semua data penting ditampilkan dalam tab-tab di atas untuk navigasi yang lebih mudah.
                </div>
            </div>

            <!-- Books Tab -->
            <div v-if="activeTab === 'books'" class="tab-pane active">
                <h5 class="mb-3"><i class="bi bi-book me-2"></i>Daftar Buku</h5>
                <div v-if="books && books.length" class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="fw-bold">📖 Judul</th>
                                <th class="fw-bold">Kategori</th>
                                <th class="fw-bold">Penulis</th>
                                <th class="fw-bold text-center">Stok</th>
                                <th v-if="role === 'admin'" class="fw-bold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="book in books" :key="book.id" class="align-middle">
                                <td>
                                    <div class="fw-semibold">{{ book.title }}</div>
                                    <small class="text-muted">ID: {{ book.id }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ book.category?.name || 'Tanpa Kategori' }}</span>
                                </td>
                                <td>{{ book.author }}</td>
                                <td class="text-center">
                                    <span class="badge" :class="book.stock > 0 ? 'bg-success' : 'bg-danger'">
                                        {{ book.stock }}
                                    </span>
                                </td>
                                <td v-if="role === 'admin'" class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <Link :href="route('admin.books.edit', book.id)" class="btn btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </Link>
                                        <form :action="route('admin.books.destroy', book.id)" method="post" class="d-inline" @submit.prevent="(e) => confirm('Hapus buku ini?') && e.target.submit()">
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
                <div v-else class="text-center py-4 text-muted">
                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                    Belum ada buku
                </div>
            </div>

            <!-- Loans Tab -->
            <div v-if="activeTab === 'loans'" class="tab-pane active">
                <h5 class="mb-3"><i class="bi bi-clock-history me-2"></i>Rekap Peminjaman</h5>
                <div v-if="(role === 'admin' ? loans : myLoans) && (role === 'admin' ? loans.length : myLoans.length)" class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="fw-bold" v-if="role === 'admin'">Member</th>
                                <th class="fw-bold">📚 Judul Buku</th>
                                <th class="fw-bold">Tgl Pinjam</th>
                                <th class="fw-bold">Tgl Kembali</th>
                                <th class="fw-bold text-center">Status</th>
                                <th v-if="role === 'admin'" class="fw-bold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="loan in (role === 'admin' ? loans : myLoans)" :key="loan.id" class="align-middle">
                                <td v-if="role === 'admin'">
                                    <div class="fw-semibold">{{ loan.user?.name }}</div>
                                    <small class="text-muted">{{ loan.user?.email }}</small>
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ loan.book?.title }}</div>
                                    <small class="text-muted">{{ loan.book?.author }}</small>
                                </td>
                                <td>
                                    <small class="text-muted">{{ new Date(loan.loan_date).toLocaleDateString('id-ID') }}</small>
                                </td>
                                <td>
                                    <small class="text-muted">{{ new Date(loan.due_date).toLocaleDateString('id-ID') }}</small>
                                </td>
                                <td class="text-center">
                                    <span class="badge" :class="`bg-${getStatusBadge(loan.status)}`">
                                        {{ getStatusLabel(loan.status) }}
                                    </span>
                                </td>
                                <td v-if="role === 'admin'" class="text-center">
                                    <Link :href="route('admin.loans.show', loan.id)" class="btn btn-sm btn-outline-primary rounded-2">
                                        <i class="bi bi-eye"></i> Lihat
                                    </Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div v-else class="text-center py-4 text-muted">
                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                    Belum ada peminjaman
                </div>
            </div>

            <!-- Users Tab (Admin Only) -->
            <div v-if="role === 'admin' && activeTab === 'users'" class="tab-pane active">
                <h5 class="mb-3"><i class="bi bi-people me-2"></i>Daftar User</h5>
                <div v-if="users && users.length" class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="fw-bold">Nama</th>
                                <th class="fw-bold">Email</th>
                                <th class="fw-bold text-center">Role</th>
                                <th class="fw-bold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="u in users" :key="u.id" class="align-middle">
                                <td>
                                    <div class="fw-semibold">{{ u.name }}</div>
                                    <small class="text-muted">ID: {{ u.id }}</small>
                                </td>
                                <td>
                                    <small>{{ u.email }}</small>
                                </td>
                                <td class="text-center">
                                    <span class="badge" :class="`bg-${getRoleBadge(u.role)}`">
                                        {{ getRoleLabel(u.role) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <Link :href="route('admin.users.edit', u.id)" class="btn btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </Link>
                                        <form :action="route('admin.users.destroy', u.id)" method="post" class="d-inline" @submit.prevent="(e) => confirm('Hapus user ini?') && e.target.submit()">
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
                <div v-else class="text-center py-4 text-muted">
                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                    Belum ada user
                </div>
            </div>

            <!-- Categories Tab (Admin Only) -->
            <div v-if="role === 'admin' && activeTab === 'categories'" class="tab-pane active">
                <h5 class="mb-3"><i class="bi bi-tags me-2"></i>Daftar Kategori</h5>
                <div v-if="categories && categories.length">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3 px-4 border-bottom" v-for="category in categories" :key="category.id">
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
                <div v-else class="text-center py-4 text-muted">
                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                    Belum ada kategori
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.stat-card {
    border-radius: 12px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12) !important;
}

.stat-label {
    font-size: 0.85rem;
    font-weight: 600;
    letter-spacing: 0.5px;
}

.stat-value {
    font-size: 2rem;
    font-weight: 700;
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #0d6efd 0%, #0d5be8 100%);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #198754 0%, #157347 100%);
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #0dcaf0 0%, #0bb5e0 100%);
}

.bg-gradient-secondary {
    background: linear-gradient(135deg, #6c757d 0%, #5c636a 100%);
}

.bg-gradient-danger {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
}

.nav-tabs .nav-link {
    color: #6c757d;
    border: none;
    border-bottom: 3px solid transparent;
    padding: 1rem;
    transition: all 0.3s ease;
    font-weight: 500;
}

.nav-tabs .nav-link:hover {
    color: #0d6efd;
    border-bottom-color: #0d6efd;
}

.nav-tabs .nav-link.active {
    color: #0d6efd;
    background-color: transparent;
    border-bottom-color: #0d6efd;
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

.card {
    border-radius: 12px;
}

.tab-pane {
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}
</style>