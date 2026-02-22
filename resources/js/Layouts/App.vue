<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<template>
    <div id="app" class="d-flex">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">E-Book App</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <Link class="nav-link" href="/dashboard">Dashboard</Link>
                        </li>
                        <li class="nav-item">
                            <Link class="nav-link" href="/books">Table Buku</Link>
                        </li>
                        <li class="nav-item">
                            <Link class="nav-link" href="/loans">Rekap Peminjaman Buku</Link>
                        </li>
                        <li class="nav-item">
                            <Link class="nav-link" href="/users">Users</Link>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid mt-5 pt-3">
            <div class="row">
                <div class="col-md-12">
                    <slot />
                </div>
            </div>
        </div>
    </div>
</template>