<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $books = Book::with('category')->latest()->get();
            $loans = Loan::with('user', 'book')->latest()->get();
            $users = User::latest()->get();
            $categories = Category::latest()->get();

            $stats = [
                'total_books' => Book::count(),
                'total_users' => User::count(),
                'total_categories' => Category::count(),
                'total_loans' => Loan::count(),
                'borrowed_count' => Loan::where('status', 'active')->count(),
                'returned_count' => Loan::where('status', 'returned')->count(),
                'overdue_count' => Loan::where('status', 'overdue')->count(),
            ];

            return Inertia::render('Dashboard', [
                'stats' => $stats,
                'books' => $books,
                'loans' => $loans,
                'users' => $users,
                'categories' => $categories,
                'bookCategories' => $categories,
            ]);
        } else {
            $myLoans = Loan::where('user_id', $user->id)->with('book')->limit(10)->get();
            $books = Book::with('category')->limit(10)->get();

            $stats = [
                'my_borrowed' => Loan::where('user_id', $user->id)->where('status', 'active')->count(),
                'my_wishlist' => 0, // Can be implemented later
                'late_returns' => Loan::where('user_id', $user->id)->where('status', 'overdue')->count(),
            ];

            return Inertia::render('Dashboard', compact('stats', 'books', 'myLoans'));
        }
    }
}
