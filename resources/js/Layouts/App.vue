<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'
import { route } from 'ziggy-js'

const page = usePage()
const user = computed(() => page.props.auth.user)
const role = computed(() => user.value?.role)
</script>

<template>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm fixed-top">
            <div class="container">
                <Link class="navbar-brand fw-bold" :href="route('admin.index')">
                    <i class="bi bi-book-half me-2"></i>E-Book App
                </Link>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <Link class="nav-link" :href="role === 'admin' ? route('admin.index') : route('member.index')">
                                <i class="bi bi-speedometer2 me-1"></i> Dashboard
                            </Link>
                        </li>

                        <template v-if="role === 'admin'">
                            <li class="nav-item">
                                <Link class="nav-link" :href="route('admin.index')">
                                    <i class="bi bi-collection me-1"></i> Tabel Buku
                                </Link>
                            </li>
                            <li class="nav-item">
                                <Link class="nav-link" :href="route('admin.index')">
                                    <i class="bi bi-journal-check me-1"></i> Rekap Peminjaman
                                </Link>
                            </li>
                            <li class="nav-item">
                                <Link class="nav-link" :href="route('admin.index')">
                                    <i class="bi bi-people me-1"></i> Users
                                </Link>
                            </li>
                        </template>

                        <template v-if="role === 'member'">
                            <li class="nav-item">
                                <Link class="nav-link" :href="route('member.index')">
                                    <i class="bi bi-search me-1"></i> Katalog Buku
                                </Link>
                            </li>
                            <li class="nav-item">
                                <Link class="nav-link" :href="route('member.index')">
                                    <i class="bi bi-clock-history me-1"></i> Pinjaman Saya
                                </Link>
                            </li>
                        </template>
                    </ul>

                    <div class="d-flex align-items-center">
                        <span class="navbar-text me-3 small d-none d-md-inline">
                            Hi, <strong>{{ user?.name }}</strong> ({{ role }})
                        </span>
                        <Link :href="route('logout')" method="post" as="button" class="btn btn-outline-light btn-sm rounded-pill px-3">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                        </Link>
                    </div>
                </div>
            </div>
        </nav>

        <main class="container mt-5 pt-4">
            <div class="row">
                <div class="col-md-12">
                    <slot />
                </div>
            </div>
        </main>
    </div>
</template>

<style scoped>
.navbar {
    border-bottom: 3px solid #0d6efd;
}
.nav-link {
    font-size: 0.9rem;
    transition: color 0.3s ease;
}
.nav-link:hover {
    color: #0d6efd !important;
}
/* Style untuk memastikan tombol logout tidak terlihat seperti tombol default */
button.btn-outline-light {
    border: 1px solid rgba(255,255,255,0.5);
}
</style>