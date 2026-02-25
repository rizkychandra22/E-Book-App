<script setup>
import { Head, usePage, useForm, router } from '@inertiajs/vue3'
import App from '../Layouts/App.vue'
import { computed, ref } from 'vue'

defineOptions({ layout: App })

const props = defineProps({
    stats: Object,
    books: Array,
    loans: Array,
    users: Array,
    myLoans: Array,
    categories: Array,
    bookCategories: Array,
})

const page = usePage()
const user = computed(() => page.props.auth.user)
const role = computed(() => user.value?.role)
const activeTab = ref('overview')

const searchQuery = ref('')
const selectedCategory = ref('')

const filteredBooks = computed(() => {
  const allBooks = Array.isArray(props.books) ? props.books : []

  if (!searchQuery.value && !selectedCategory.value) {
    return allBooks
  }

  const query = searchQuery.value.toLowerCase()

  const matched = allBooks.filter(book => {
    const matchesSearch =
      !searchQuery.value ||
      book.title?.toLowerCase().includes(query) ||
      book.author?.toLowerCase().includes(query) ||
      book.publisher?.toLowerCase().includes(query) ||
      book.description?.toLowerCase().includes(query) ||
      book.year?.toString().includes(query) ||
      book.category?.name?.toLowerCase().includes(query)

    const matchesCategory =
      !selectedCategory.value ||
      book.category?.name === selectedCategory.value

    return matchesSearch && matchesCategory
  })

  const notMatched = allBooks.filter(book => !matched.includes(book))

  // Menampilkan data search dan filter paling atas dari list card book
  return [...matched, ...notMatched]
})

const getStatusBadge = (status) => {
    const badges = { active: 'warning', returned: 'success', overdue: 'danger' }
    return badges[status] || 'secondary'
}

const getStatusLabel = (status) => {
    const labels = { active: 'Dipinjam', returned: 'Dikembalikan', overdue: 'Terlambat' }
    return labels[status] || status
}

const bookForm = useForm({
    title: '',
    author: '',
    publisher: '',
    year: '',
    code_book: '',
    description: '',
    category_id: '',
    stock: 0,
})
const editingBookId = ref(null)
const editBook = (book) => {
    editingBookId.value = book.id
    bookForm.title = book.title || ''
    bookForm.author = book.author || ''
    bookForm.publisher = book.publisher || ''
    bookForm.year = book.year || ''
    bookForm.code_book = book.code_book || ''
    bookForm.description = book.description || ''
    bookForm.category_id = book.category_id || ''
    bookForm.stock = book.stock ?? 0
}
const resetBookForm = () => {
    editingBookId.value = null
    bookForm.reset()
    bookForm.clearErrors()
}
const submitBook = () => {
    if (editingBookId.value) {
        bookForm.put(route('admin.books.update', editingBookId.value), { preserveScroll: true, onSuccess: resetBookForm })
        return
    }
    bookForm.post(route('admin.books.store'), { preserveScroll: true, onSuccess: resetBookForm })
}
const destroyBook = (bookId) => {
    if (!confirm('Hapus buku ini?')) return
    router.delete(route('admin.books.destroy', bookId), { preserveScroll: true })
}

const categoryForm = useForm({ name: '', code_name: '' })
const editingCategoryId = ref(null)
const editCategory = (category) => {
    editingCategoryId.value = category.id
    categoryForm.name = category.name || ''
    categoryForm.code_name = category.code_name || ''
}
const resetCategoryForm = () => {
    editingCategoryId.value = null
    categoryForm.reset()
    categoryForm.clearErrors()
}
const submitCategory = () => {
    if (editingCategoryId.value) {
        categoryForm.put(route('admin.categories.update', editingCategoryId.value), { preserveScroll: true, onSuccess: resetCategoryForm })
        return
    }
    categoryForm.post(route('admin.categories.store'), { preserveScroll: true, onSuccess: resetCategoryForm })
}
const destroyCategory = (categoryId) => {
    if (!confirm('Hapus kategori ini?')) return
    router.delete(route('admin.categories.destroy', categoryId), { preserveScroll: true })
}

const userForm = useForm({ name: '', email: '', role: '' })
const editingUserId = ref(null)
const editUser = (u) => {
    editingUserId.value = u.id
    userForm.name = u.name || ''
    userForm.email = u.email || ''
    userForm.role = u.role || ''
}
const resetUserForm = () => {
    editingUserId.value = null
    userForm.reset()
    userForm.clearErrors()
}
const submitUser = () => {
    if (!editingUserId.value) return
    userForm.put(route('admin.users.update', editingUserId.value), { preserveScroll: true, onSuccess: resetUserForm })
}
const destroyUser = (userId) => {
    if (!confirm('Hapus user ini?')) return
    router.delete(route('admin.users.destroy', userId), { preserveScroll: true })
}

const loanForm = useForm({ status: '', return_date: '' })
const editingLoanId = ref(null)
const editLoan = (loan) => {
    editingLoanId.value = loan.id
    loanForm.status = loan.status || 'active'
    loanForm.return_date = loan.return_date || ''
}
const resetLoanForm = () => {
    editingLoanId.value = null
    loanForm.reset()
    loanForm.clearErrors()
}
const submitLoan = () => {
    if (!editingLoanId.value) return
    loanForm.put(route('admin.loans.update', editingLoanId.value), { preserveScroll: true, onSuccess: resetLoanForm })
}
</script>

<template>
    <Head title="Dashboard - E-Book App" />

    <section class="mb-4">
        <div class="hero-banner modern-surface p-4 p-lg-5">
            <div class="d-flex flex-column flex-lg-row justify-content-between gap-3 align-items-lg-center">
                <div>
                    <p class="hero-kicker mb-2">Dashboard Terpadu</p>
                    <h1 class="modern-title h3 mb-2">Halo, {{ user?.name }}.</h1>
                    <p class="modern-subtitle mb-0">
                        {{ role === 'admin' ? 'Kelola seluruh data aplikasi dari satu halaman.' : 'Pantau koleksi dan status peminjaman Anda.' }}
                    </p>
                </div>
                <span class="role-pill">{{ role }}</span>
            </div>
        </div>
    </section>

    <section class="row g-3 mb-4">
        <template v-if="role === 'admin'">
            <div class="col-sm-6 col-xl-3">
                <div class="stats-card stats-1">
                    <small>Total Buku</small>
                    <h3>{{ stats?.total_books || 0 }}</h3>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="stats-card stats-2">
                    <small>Total Kategori</small>
                    <h3>{{ stats?.total_categories || 0 }}</h3>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="stats-card stats-3">
                    <small>Total User</small>
                    <h3>{{ stats?.total_users || 0 }}</h3>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="stats-card stats-4">
                    <small>Total Peminjaman</small>
                    <h3>{{ stats?.total_loans || 0 }}</h3>
                </div>
            </div>
        </template>
        <template v-else>
            <div class="col-md-4">
                <div class="stats-card stats-1"><small>Sedang Dipinjam</small><h3>{{ stats?.my_borrowed || 0 }}</h3></div>
            </div>
            <div class="col-md-4">
                <div class="stats-card stats-3"><small>Terlambat</small><h3>{{ stats?.late_returns || 0 }}</h3></div>
            </div>
            <div class="col-md-4">
                <div class="stats-card stats-2"><small>Wishlist</small><h3>{{ stats?.my_wishlist || 0 }}</h3></div>
            </div>
        </template>
    </section>

    <section class="modern-surface dashboard-panel">
        <div class="panel-head px-3 px-md-4 pt-3 pb-2">
            <ul class="nav app-tabs flex-wrap gap-2">
                <li><button class="tab-btn" :class="{ active: activeTab === 'overview' }" @click="activeTab = 'overview'">Overview</button></li>
                <li><button class="tab-btn" :class="{ active: activeTab === 'books' }" @click="activeTab = 'books'" v-if="role === 'admin'">Buku</button></li>
                <li><button class="tab-btn" :class="{ active: activeTab === 'loans' }" @click="activeTab = 'loans'">Peminjaman</button></li>
                <li v-if="role === 'admin'">
                    <button class="tab-btn" :class="{ active: activeTab === 'categories' }" @click="activeTab = 'categories'">Kategori</button>
                </li>
                <li v-if="role === 'admin'">
                    <button class="tab-btn" :class="{ active: activeTab === 'users' }" @click="activeTab = 'users'">User</button>
                </li>
            </ul>
        </div>

        <div class="p-3 p-md-4">
            <div v-if="activeTab === 'overview'">
                <div v-if="role === 'admin'" class="overview-box">
                    Semua fitur manajemen sudah dipusatkan dalam dashboard ini.
                </div>
                <div v-else class="row g-3">
                    <!-- SEARCH & FILTER -->
                    <div class="row mb-4 g-2 align-items-end">
                        <!-- Search -->
                        <div class="col-md-6">
                            <label class="form-label small text-muted">
                                Cari Buku
                            </label>
                            <input 
                                v-model="searchQuery"
                                type="text"
                                class="form-control form-control-modern"
                                placeholder="Cari buku berdasarkan judul, penulis, penerbit, deskripsi, tahun..."
                            >
                        </div>

                        <!-- Filter Category -->
                        <div class="col-md-4">
                            <label class="form-label small text-muted">
                                Filter Kategori
                            </label>
                            <select 
                                v-model="selectedCategory"
                                class="form-select form-control-modern"
                            >
                                <option value="">Semua Kategori</option>
                                <option 
                                    v-for="category in bookCategories"
                                    :key="category.id"
                                    :value="category.name"
                                >
                                    {{ category.name }}
                                </option>
                            </select>
                        </div>

                        <!-- Reset -->
                        <div class="col-md-2">
                            <button 
                                class="btn btn-modern-soft w-100"
                                @click="() => { searchQuery = ''; selectedCategory = '' }"
                            >
                                Reset
                            </button>
                        </div>
                    </div>
                    <div v-for="book in filteredBooks" :key="book.id" class="col-md-3">
                        <div class="card book-card h-100">
                            <div v-if="book.cover_image" class="card-img-placeholder position-relative" style="height: 200px; border-radius: 12px 12px 0 0; overflow: hidden;">
                                <img :src="book.cover_image" :alt="book.title" class="w-100 h-100 object-fit-cover">
                            </div>
                            <div v-else class="card-img-placeholder bg-light d-flex align-items-center justify-content-center position-relative" style="height: 200px; border-radius: 12px 12px 0 0; overflow: hidden;">
                                <div class="text-center w-100">
                                    <i class="bi bi-book fs-1 text-primary opacity-25 d-block mb-2"></i>
                                    <small class="text-muted">Sampul Buku</small>
                                </div>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title">{{ book.title }}</h6>
                                <p class="card-text text-muted">{{ book.category?.name || 'Tanpa Kategori' }}</p>
                                <a :href="route('member.books.show', book.id)" class="btn btn-modern-primary mt-auto">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="activeTab === 'books'">
                <div v-if="role === 'admin'" class="editor-card mb-3">
                    <h6 class="mb-3 modern-title h6">{{ editingBookId ? 'Edit Buku' : 'Tambah Buku' }}</h6>
                    <form @submit.prevent="submitBook">
                        <div class="row g-2">
                            <div class="col-md-6"><input v-model="bookForm.title" class="form-control form-control-modern" placeholder="Judul"></div>
                            <div class="col-md-6"><input v-model="bookForm.author" class="form-control form-control-modern" placeholder="Penulis"></div>
                            <div class="col-md-6"><input v-model="bookForm.publisher" class="form-control form-control-modern" placeholder="Penerbit"></div>
                            <div class="col-md-3"><input v-model="bookForm.year" type="number" class="form-control form-control-modern" placeholder="Tahun"></div>
                            <div class="col-md-3"><input v-model="bookForm.stock" type="number" class="form-control form-control-modern" placeholder="Stok"></div>
                            <div class="col-md-6"><input v-model="bookForm.code_book" class="form-control form-control-modern" placeholder="Kode Buku"></div>
                            <div class="col-md-6">
                                <select v-model="bookForm.category_id" class="form-select form-control-modern">
                                    <option value="">Pilih kategori</option>
                                    <option v-for="c in bookCategories" :key="c.id" :value="c.id">{{ c.name }}</option>
                                </select>
                            </div>
                            <div class="col-12"><textarea v-model="bookForm.description" class="form-control form-control-modern" rows="2" placeholder="Deskripsi"></textarea></div>
                        </div>
                        <div class="mt-3 d-flex gap-2">
                            <button class="btn btn-modern-primary" :disabled="bookForm.processing">{{ editingBookId ? 'Update Buku' : 'Tambah Buku' }}</button>
                            <button v-if="editingBookId" type="button" class="btn btn-modern-soft" @click="resetBookForm">Batal</button>
                        </div>
                    </form>
                </div>

                <div class="table-wrap table-responsive">
                    <table class="table table-modern table-sm mb-0">
                        <thead><tr><th>Judul</th><th>Kategori</th><th>Penulis</th><th>Stok</th><th v-if="role === 'admin'">Aksi</th></tr></thead>
                        <tbody>
                            <tr v-for="book in books" :key="book.id">
                                <td>{{ book.title }}</td>
                                <td>{{ book.category?.name || '-' }}</td>
                                <td>{{ book.author }}</td>
                                <td>{{ book.stock }}</td>
                                <td v-if="role === 'admin'" class="d-flex gap-2">
                                    <button class="btn btn-sm btn-modern-soft" @click="editBook(book)">Edit</button>
                                    <button class="btn btn-sm btn-modern-danger" @click="destroyBook(book.id)">Hapus</button>
                                </td>
                            </tr>
                            <tr v-if="!books?.length"><td colspan="5" class="text-center text-muted py-4">Belum ada buku</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div v-if="activeTab === 'categories' && role === 'admin'">
                <div class="editor-card mb-3">
                    <h6 class="mb-3 modern-title h6">{{ editingCategoryId ? 'Edit Kategori' : 'Tambah Kategori' }}</h6>
                    <form @submit.prevent="submitCategory">
                        <div class="row g-2">
                            <div class="col-md-6"><input v-model="categoryForm.name" class="form-control form-control-modern" placeholder="Nama kategori"></div>
                            <div class="col-md-6"><input v-model="categoryForm.code_name" class="form-control form-control-modern" placeholder="Kode kategori"></div>
                        </div>
                        <div class="mt-3 d-flex gap-2">
                            <button class="btn btn-modern-primary" :disabled="categoryForm.processing">{{ editingCategoryId ? 'Update Kategori' : 'Tambah Kategori' }}</button>
                            <button v-if="editingCategoryId" type="button" class="btn btn-modern-soft" @click="resetCategoryForm">Batal</button>
                        </div>
                    </form>
                </div>

                <ul class="list-group list-modern">
                    <li v-for="category in categories" :key="category.id" class="list-group-item d-flex justify-content-between align-items-center">
                        <div><div class="fw-semibold">{{ category.name }}</div><small class="text-muted">{{ category.code_name }}</small></div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-modern-soft" @click="editCategory(category)">Edit</button>
                            <button class="btn btn-sm btn-modern-danger" @click="destroyCategory(category.id)">Hapus</button>
                        </div>
                    </li>
                    <li v-if="!categories?.length" class="list-group-item text-center text-muted">Belum ada kategori</li>
                </ul>
            </div>

            <div v-if="activeTab === 'users' && role === 'admin'">
                <div v-if="editingUserId" class="editor-card mb-3">
                    <h6 class="mb-3 modern-title h6">Edit User</h6>
                    <form @submit.prevent="submitUser">
                        <div class="row g-2">
                            <div class="col-md-4"><input v-model="userForm.name" class="form-control form-control-modern" placeholder="Nama"></div>
                            <div class="col-md-4"><input v-model="userForm.email" type="email" class="form-control form-control-modern" placeholder="Email"></div>
                            <div class="col-md-4">
                                <select v-model="userForm.role" class="form-select form-control-modern">
                                    <option value="">Pilih role</option>
                                    <option value="member">Member</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-3 d-flex gap-2">
                            <button class="btn btn-modern-primary btn-sm" :disabled="userForm.processing">Simpan User</button>
                            <button type="button" class="btn btn-modern-soft btn-sm" @click="resetUserForm">Batal</button>
                        </div>
                    </form>
                </div>

                <div class="table-wrap table-responsive">
                    <table class="table table-modern table-sm mb-0">
                        <thead><tr><th>Nama</th><th>Email</th><th>Role</th><th>Aksi</th></tr></thead>
                        <tbody>
                            <tr v-for="u in users" :key="u.id">
                                <td>{{ u.name }}</td>
                                <td>{{ u.email }}</td>
                                <td><span class="role-pill-sm">{{ u.role }}</span></td>
                                <td class="d-flex gap-2">
                                    <button class="btn btn-sm btn-modern-soft" @click="editUser(u)">Edit</button>
                                    <button class="btn btn-sm btn-modern-danger" @click="destroyUser(u.id)">Hapus</button>
                                </td>
                            </tr>
                            <tr v-if="!users?.length"><td colspan="4" class="text-center text-muted py-4">Belum ada user</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div v-if="activeTab === 'loans'">
                <div v-if="role === 'admin' && editingLoanId" class="editor-card mb-3">
                    <h6 class="mb-3 modern-title h6">Update Peminjaman</h6>
                    <form @submit.prevent="submitLoan">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <select v-model="loanForm.status" class="form-select form-control-modern">
                                    <option value="active">Dipinjam</option>
                                    <option value="returned">Dikembalikan</option>
                                    <option value="overdue">Terlambat</option>
                                </select>
                            </div>
                            <div class="col-md-6"><input v-model="loanForm.return_date" type="date" class="form-control form-control-modern"></div>
                        </div>
                        <div class="mt-3 d-flex gap-2">
                            <button class="btn btn-modern-primary btn-sm" :disabled="loanForm.processing">Simpan Status</button>
                            <button type="button" class="btn btn-modern-soft btn-sm" @click="resetLoanForm">Batal</button>
                        </div>
                    </form>
                </div>

                <div class="table-wrap table-responsive">
                    <table class="table table-modern table-sm mb-0">
                        <thead>
                            <tr>
                                <th v-if="role === 'admin'">Member</th>
                                <th>Buku</th>
                                <th>Pinjam</th>
                                <th>Kembali</th>
                                <th>Status</th>
                                <th v-if="role === 'admin'">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="loan in (role === 'admin' ? loans : myLoans)" :key="loan.id">
                                <td v-if="role === 'admin'">{{ loan.user?.name }}</td>
                                <td>{{ loan.book?.title }}</td>
                                <td>{{ loan.loan_date }}</td>
                                <td>{{ loan.due_date }}</td>
                                <td><span class="badge rounded-pill" :class="`text-bg-${getStatusBadge(loan.status)}`">{{ getStatusLabel(loan.status) }}</span></td>
                                <td v-if="role === 'admin'"><button class="btn btn-sm btn-modern-soft" @click="editLoan(loan)">Update</button></td>
                            </tr>
                            <tr v-if="!(role === 'admin' ? loans : myLoans)?.length"><td :colspan="role === 'admin' ? 6 : 5" class="text-center text-muted py-4">Belum ada peminjaman</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
.hero-banner {
    border-radius: 24px;
    position: relative;
    overflow: hidden;
}

.hero-banner::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(120deg, rgba(15, 118, 110, 0.08), rgba(249, 115, 22, 0.05));
    pointer-events: none;
}

.hero-kicker {
    color: #0f766e;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    font-size: 0.75rem;
}

.role-pill {
    padding: 0.35rem 0.85rem;
    border-radius: 999px;
    background: #0f172a;
    color: #e2e8f0;
    text-transform: uppercase;
    font-weight: 700;
    font-size: 0.72rem;
}

.stats-card {
    border-radius: 16px;
    padding: 1rem 1.1rem;
    color: #fff;
    min-height: 104px;
}

.stats-card small {
    display: block;
    opacity: 0.86;
}

.stats-card h3 {
    font-weight: 800;
    margin: 0.2rem 0 0;
}

.stats-1 {
    background: linear-gradient(135deg, #0f766e, #0b5b55);
}

.stats-2 {
    background: linear-gradient(135deg, #334155, #1e293b);
}

.stats-3 {
    background: linear-gradient(135deg, #ea580c, #c2410c);
}

.stats-4 {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
}

.dashboard-panel {
    border-radius: 20px;
}

.app-tabs {
    list-style: none;
    margin: 0;
    padding: 0;
}

.tab-btn {
    border: 1px solid #d7e2ea;
    background: #f8fafc;
    color: #334155;
    padding: 0.4rem 0.85rem;
    border-radius: 999px;
    font-weight: 600;
}

.tab-btn.active {
    background: #0f766e;
    border-color: #0f766e;
    color: #fff;
}

.overview-box {
    border: 1px dashed #cbd5e1;
    border-radius: 14px;
    padding: 0.85rem 1rem;
    color: #475569;
    background: #f8fafc;
}

.editor-card {
    border: 1px solid #dde7ef;
    border-radius: 14px;
    padding: 1rem;
    background: #fbfdff;
}

.form-control-modern {
    border-radius: 10px;
    border-color: #dbe4ed;
    min-height: 42px;
}

.table-wrap {
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    overflow: hidden;
    overflow-x: auto;
}

.table-modern thead th {
    background: #f8fafc;
    color: #475569;
    border-bottom: 1px solid #e2e8f0;
    font-weight: 700;
}

.table-modern td,
.table-modern th {
    padding: 0.78rem 0.72rem;
    vertical-align: middle;
}

.list-modern .list-group-item {
    border-color: #e2e8f0;
}

.btn-modern-primary {
    background: #0f766e;
    color: #fff;
    border: 1px solid #0f766e;
}

.btn-modern-primary:hover {
    background: #0b5b55;
    border-color: #0b5b55;
    color: #fff;
}

.btn-modern-soft {
    background: #f8fafc;
    border: 1px solid #d1dbe5;
    color: #334155;
}

.btn-modern-danger {
    background: #fff7ed;
    border: 1px solid #fdba74;
    color: #c2410c;
}

.role-pill-sm {
    font-size: 0.74rem;
    text-transform: uppercase;
    background: #f1f5f9;
    padding: 0.16rem 0.52rem;
    border-radius: 999px;
    font-weight: 700;
}
</style>
