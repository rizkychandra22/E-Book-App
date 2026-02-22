<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Inertia\Inertia;

class DashboardAdmin extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard', [
            'stats' => [
                'total_books'      => Book::count(),
                'total_users'      => User::count(),
                'total_categories' => Category::count(),
            ]
        ]);
    }
}
