<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::redirect('/', '/login');

Route::get('/login', function () {
    return Inertia::render('Auth/Login', [
        'title' => 'Login - E-Book App'
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard', [
        'title' => 'Dashboard - E-Book App'
    ]);
});
