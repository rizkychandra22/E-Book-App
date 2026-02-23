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
            // Get all data for admin dashboard
            $books = Book::with('category')->limit(10)->get();
            $loans = Loan::with('user', 'book')->limit(10)->get();
            $users = User::limit(10)->get();
            $categories = Category::all();

            // Calculate stats
            $stats = [
                'total_books' => Book::count(),
                'total_users' => User::count(),
                'total_categories' => Category::count(),
                'total_loans' => Loan::count(),
                'borrowed_count' => Loan::where('status', 'borrowed')->count(),
                'returned_count' => Loan::where('status', 'returned')->count(),
            ];

            return Inertia::render('Dashboard', compact('stats', 'books', 'loans', 'users', 'categories'));
        } else {
            // Member dashboard
            $myLoans = Loan::where('user_id', $user->id)->with('book')->limit(10)->get();
            $books = Book::with('category')->limit(10)->get();

            $stats = [
                'my_borrowed' => Loan::where('user_id', $user->id)->where('status', 'borrowed')->count(),
                'my_wishlist' => 0, // Can be implemented later
                'late_returns' => Loan::where('user_id', $user->id)->where('status', 'late')->count(),
            ];

            return Inertia::render('Dashboard', compact('stats', 'books', 'myLoans'));
        }
    }
}
