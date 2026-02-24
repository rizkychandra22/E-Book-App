<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('category')->paginate(12);
        return Inertia::render('Member/Books/Index', compact('books'));
    }

    public function show(Book $book)
    {
        $book->load('category');
        return Inertia::render('Member/Books/Show', compact('book'));
    }
}
