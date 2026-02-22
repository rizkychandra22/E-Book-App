<script setup>
import { Head } from '@inertiajs/vue3'
import { ref } from 'vue'

const showPassword = ref(false)
// Script untuk login 
</script>

<template>
    <Head title="Login - E-Book App" />
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <i class="bi bi-book display-1 text-primary"></i>
                            <h2 class="mt-3">E-Book App</h2>
                            <p class="text-muted">Login to your account</p>
                        </div>
                        <form>
                            <div class="mb-3">
                                <label for="email" class="form-label">Username or Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control" id="email" placeholder="Enter username or email" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input :type="showPassword ? 'text' : 'password'" class="form-control" id="password" placeholder="Enter your password" required>
                                    <button type="button" class="btn btn-outline-secondary" @click="showPassword = !showPassword">
                                        <i :class="showPassword ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>