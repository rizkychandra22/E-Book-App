<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('category')->paginate(12);
        $wishlistBookIds = Auth::user()->wishlists()->pluck('books.id')->all();

        $books->getCollection()->transform(function ($book) use ($wishlistBookIds) {
            $book->is_wishlisted = in_array($book->id, $wishlistBookIds, true);
            return $book;
        });

        return Inertia::render('Member/Books/Index', compact('books'));
    }

    public function show(Book $book)
    {
        $book->load('category');
        $book->is_wishlisted = Auth::user()->wishlists()->where('books.id', $book->id)->exists();

        return Inertia::render('Member/Books/Show', compact('book'));
    }
}
