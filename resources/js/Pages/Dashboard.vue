<script setup>
import { Head, usePage } from '@inertiajs/vue3'
import App from '../Layouts/App.vue'
import { computed } from 'vue'

defineOptions({ layout: App })

defineProps({
    stats: {
        type: Object,
        default: () => ({})
    }
})

const page = usePage()
const user = computed(() => page.props.auth.user)
const role = computed(() => user.value?.role)
</script>

<template>
    <Head :title="`Dashboard ${role === 'admin' ? 'Admin' : 'Member'} - E-Book App`" />
    
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <h3 class="mb-0">Dashboard {{ role === 'admin' ? 'Administrator' : 'Member' }}</h3>
        </div>
        <div class="card-body">
            <p class="lead">Welcome back, <strong>{{ user.name }}</strong>!</p>
            <hr>

            <div v-if="role === 'admin'" class="row">
                <div class="col-md-4">
                    <div class="card text-white bg-primary mb-3 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-bookshelf"></i> Total Books</h5>
                            <h2 class="fw-bold">{{ stats.total_books || 0 }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-success mb-3 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-people"></i> Total Users</h5>
                            <h2 class="fw-bold">{{ stats.total_users || 0 }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-warning mb-3 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-tags"></i> Categories</h5>
                            <h2 class="fw-bold">{{ stats.total_categories || 0 }}</h2>
                        </div>
                    </div>
                </div>
            </div>

            <div v-else class="row">
                <div class="col-md-4">
                    <div class="card text-white bg-info mb-3 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-book"></i> My Borrowed Books</h5>
                            <h2 class="fw-bold">{{ stats.my_borrowed || 0 }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-secondary mb-3 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-bookmark-star"></i> My Wishlist</h5>
                            <h2 class="fw-bold">{{ stats.my_wishlist || 0 }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-danger mb-3 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-clock-history"></i> Late Returns</h5>
                            <h2 class="fw-bold">{{ stats.late_returns || 0 }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</template>

<style scoped>
.card {
    border-radius: 12px;
}
.card-header {
    border-top-left-radius: 12px !important;
    border-top-right-radius: 12px !important;
}
</style>