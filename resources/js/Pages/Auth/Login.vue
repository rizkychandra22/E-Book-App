<script setup>
import { Head, useForm } from '@inertiajs/vue3'
import { ref, watch } from 'vue'

const showPassword = ref(false)

const form = useForm({
    login: '',    
    password: '',
    remember: false,
});

const submit = () => {
    form.clearErrors();

    // 1. Validasi Manual Client-side untuk Login & Password
    if (!form.login) {
        form.setError('login', 'Username atau Email wajib diisi!');
    }
    if (!form.password) {
        form.setError('password', 'Password wajib diisi!');
    }
    
    // 2. Kirim jika semua input terisi
    if (form.login && form.password) {
        form.post('/login', {
            onFinish: () => form.reset('password'),
        });
    }
};

watch(() => form.login, () => {
    if (form.errors.loginError) form.clearErrors('loginError');
    if (form.errors.loginAkses) form.clearErrors('loginAkses');
});
</script>

<template>
    <Head title="Login - E-Book App" />
    
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">

                <!-- Card Login -->
                <div class="card shadow border-0">
                    <div class="card-body p-4">
                        <div class="text-center mb-3">
                            <i class="bi bi-book display-3 text-primary"></i>
                            <h3 class="fw-bold">E-Book App</h3>
                            <p class="text-muted small">Login to your account</p>
                        </div>

                        <!-- Alert Error Login Middleware -->
                        <div v-if="$page.props.errors.loginAkses" class="alert alert-danger alert-dismissible fade show shadow-sm py-2 px-3 mb-3" role="alert" style="font-size: 0.8rem;">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-shield-lock-fill me-2"></i>
                                <span>{{ $page.props.errors.loginAkses }}</span>
                            </div>
                            <button type="button" class="btn-close btn-close-sm p-1" @click="$page.props.errors.loginAkses = null" style="top: 0.4rem; right: 0.5rem;"></button>
                        </div>

                        <!-- Alert Error Login Form -->
                        <div v-if="form.errors.loginError" class="alert alert-danger alert-dismissible fade show shadow-sm py-2 px-3 mb-3" role="alert" style="font-size: 0.8rem;">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-exclamation-circle-fill me-2"></i>
                                <span>{{ form.errors.loginError }}</span>
                            </div>
                            <button type="button" class="btn-close btn-close-sm p-1" @click="form.clearErrors('loginError')" style="top: 0.4rem; right: 0.5rem;"></button>
                        </div>

                        <!-- From Login -->
                        <form @submit.prevent="submit">

                            <!-- Input Username or Email -->
                            <div class="mb-3">
                                <label for="login" class="form-label small fw-bold text-secondary">Username or Email</label>
                                <div class="input-group input-group-sm has-validation">
                                    <span class="input-group-text bg-light border-end-0" :class="{ 'border-danger': form.errors.login }">
                                        <i class="bi bi-person text-secondary"></i>
                                    </span>
                                    <input 
                                        type="text" 
                                        v-model="form.login" 
                                        class="form-control border-start-0 ps-0" 
                                        :class="{ 'is-invalid': form.errors.login }"
                                        id="login" 
                                        placeholder="Username or email"
                                    >
                                    <div class="invalid-feedback small">{{ form.errors.login }}</div>
                                </div>
                            </div>

                            <!-- Input Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label small fw-bold text-secondary">Password</label>
                                <div class="input-group input-group-sm has-validation">
                                    <span class="input-group-text bg-light border-end-0" :class="{ 'border-danger': form.errors.password }">
                                        <i class="bi bi-lock text-secondary"></i>
                                    </span>
                                    <input 
                                        :type="showPassword ? 'text' : 'password'" 
                                        v-model="form.password" 
                                        class="form-control border-start-0 ps-0" 
                                        :class="{ 'is-invalid': form.errors.password }" 
                                        id="password" 
                                        placeholder="Your password"
                                    >
                                    <button type="button" class="btn btn-outline-secondary border-start-0" :class="{ 'border-danger': form.errors.password }" @click="showPassword = !showPassword">
                                        <i :class="showPassword ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                                    </button>
                                    <div v-if="form.errors.password" class="invalid-feedback small">{{ form.errors.password }}</div>
                                </div>
                            </div>

                            <!-- Check Box Remember Me -->
                            <div class="mb-3 form-check">
                                <input type="checkbox" v-model="form.remember" class="form-check-input" id="remember">
                                <label class="form-check-label small text-secondary" for="remember">Remember Me</label>
                            </div>

                            <!-- Button Login -->
                            <div class="d-grid mt-2">
                                <button 
                                    type="submit" 
                                    class="btn btn-primary btn-sm fw-bold shadow-sm" 
                                    :disabled="form.processing"
                                >
                                    <span v-if="form.processing" class="spinner-border spinner-border-sm me-2"></span>
                                    LOGIN
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <p class="text-center mt-4 text-muted small" style="opacity: 0.7;">
                    &copy; {{ new Date().getFullYear() }} E-Book Library System
                </p>
            </div>
        </div>
    </div>
</template>

<style scoped>
.card { border-radius: 12px; }
.btn-primary { border-radius: 8px; letter-spacing: 0.5px; }
.input-group-text { border-radius: 8px 0 0 8px; }
.form-control { border-radius: 0 8px 8px 0; }
.input-group .btn { border-top-right-radius: 8px; border-bottom-right-radius: 8px; }
.form-control:focus, .btn:focus { box-shadow: none !important; border-color: #dee2e6 !important; }
.form-control.is-invalid:focus { border-color: #dc3545 !important; }
</style>