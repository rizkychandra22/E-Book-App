<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// Route untuk Guest (Hanya bisa diakses jika BELUM login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);
});

// Route Logout (Hanya bisa diakses jika SUDAH login)
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Route Dashboard Unified (All-in-One) - untuk semua user yang sudah login
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Route Dashboard Khusus ADMIN
Route::middleware(['role:admin'])->prefix('admin')->group(function () {
    Route::get('/index', function () {
        return redirect()->route('dashboard');
    })->name('admin.index');
    // Admin resource routes
    Route::resource('books', \App\Http\Controllers\Admin\BookController::class)->names('admin.books');
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->names('admin.categories');
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->names('admin.users');
    Route::resource('loans', \App\Http\Controllers\Admin\LoanController::class)->names('admin.loans');
});

// Route Dashboard Khusus MEMBER
Route::middleware(['role:member'])->prefix('member')->group(function () {
    Route::get('/index', function () {
        return redirect()->route('dashboard');
    })->name('member.index');
    // Member routes: browse books and create loans
    Route::get('books', [\App\Http\Controllers\Member\BookController::class, 'index'])->name('member.books.index');
    Route::get('books/{book}', [\App\Http\Controllers\Member\BookController::class, 'show'])->name('member.books.show');
    Route::post('loans', [\App\Http\Controllers\Member\LoanController::class, 'store'])->name('member.loans.store');
});