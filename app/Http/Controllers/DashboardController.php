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
            $users = User::where('role', 'member')->latest()->get();
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
            $books = Book::with('category')->latest()->limit(12)->get();
            $categories = Category::latest()->get();
            $wishlistBookIds = $user->wishlists()->pluck('books.id')->all();

            $books = $books->map(function ($book) use ($wishlistBookIds) {
                $book->is_wishlisted = in_array($book->id, $wishlistBookIds, true);
                return $book;
            });

            $stats = [
                'my_borrowed' => Loan::where('user_id', $user->id)->where('status', 'active')->count(),
                'my_wishlist' => $user->wishlists()->count(),
                'late_returns' => Loan::where('user_id', $user->id)->where('status', 'overdue')->count(),
            ];

           return Inertia::render('Dashboard', [
                'stats' => $stats,
                'books' => $books,
                'myLoans' => $myLoans,
                'bookCategories' => $categories, 
            ]);
        }
    }
}
