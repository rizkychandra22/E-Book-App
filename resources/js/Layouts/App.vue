<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'
import { route } from 'ziggy-js'

const page = usePage()
const user = computed(() => page.props.auth.user)
const role = computed(() => user.value?.role)
</script>

<template>
    <div class="app-shell">
        <nav class="navbar navbar-expand-lg app-navbar fixed-top">
            <div class="container py-2">
                <Link class="navbar-brand fw-bold app-brand" :href="route('dashboard')">
                    <span class="brand-icon"><i class="bi bi-book-half"></i></span>
                    <span>E-Book App</span>
                </Link>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-3 mb-lg-0 ms-lg-4">
                        <li class="nav-item">
                            <Link class="nav-link app-link" :href="route('dashboard')">
                                <i class="bi bi-grid-1x2-fill me-1"></i> Dashboard
                            </Link>
                        </li>
                    </ul>

                    <div class="d-flex align-items-center gap-2">
                        <span class="user-chip d-none d-md-inline-flex">
                            <i class="bi bi-person-circle me-2"></i>
                            <strong>{{ user?.name }}</strong>
                            <small class="ms-2 text-uppercase">{{ role }}</small>
                        </span>
                        <Link :href="route('logout')" method="post" as="button" class="btn btn-sm app-logout-btn">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                        </Link>
                    </div>
                </div>
            </div>
        </nav>

        <main class="container app-main">
            <slot />
        </main>
    </div>
</template>

<style scoped>
.app-shell {
    min-height: 100vh;
}

.app-navbar {
    background: rgba(9, 20, 34, 0.86);
    backdrop-filter: blur(14px);
    border-bottom: 1px solid rgba(148, 163, 184, 0.22);
}

.app-brand {
    color: #fff;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    letter-spacing: -0.02em;
}

.brand-icon {
    width: 36px;
    height: 36px;
    border-radius: 11px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #0f766e, #0b5b55);
    color: #fff;
}

.app-link {
    color: rgba(241, 245, 249, 0.86);
    font-weight: 600;
}

.app-link:hover,
.app-link.router-link-active {
    color: #fff;
}

.user-chip {
    align-items: center;
    border: 1px solid rgba(148, 163, 184, 0.4);
    background: rgba(15, 23, 42, 0.5);
    color: #e2e8f0;
    border-radius: 999px;
    padding: 0.4rem 0.8rem;
    font-size: 0.85rem;
}

.app-logout-btn {
    border-radius: 999px;
    border: 1px solid rgba(148, 163, 184, 0.45);
    color: #e2e8f0;
    background: rgba(15, 23, 42, 0.5);
}

.app-logout-btn:hover {
    background: #fff;
    color: #0f172a;
}

.app-main {
    padding-top: 100px;
    padding-bottom: 26px;
}
</style>
