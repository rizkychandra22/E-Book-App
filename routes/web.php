<?php

use App\Http\Controllers\Admin\DashboardAdmin;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Member\DashboardMember;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::redirect('/', '/login');

// Route untuk Guest (Hanya bisa diakses jika BELUM login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);
});

// Route Logout (Hanya bisa diakses jika SUDAH login)
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Route Dashboard Khusus ADMIN
Route::middleware(['role:admin'])->prefix('admin')->group(function () {
   Route::get('/index', [DashboardAdmin::class, 'index'])->name('admin.index');
});

// Route Dashboard Khusus MEMBER
Route::middleware(['role:member'])->prefix('member')->group(function () {
    Route::get('/index', [DashboardMember::class, 'index'])->name('member.index');
});