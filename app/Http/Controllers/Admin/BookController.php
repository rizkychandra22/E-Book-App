<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('category')->paginate(12);
        $categories = Category::all();
        return Inertia::render('Admin/Books/Index', compact('books', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return Inertia::render('Admin/Books/Create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'nullable|integer|min:0',
        ]);

        Book::create($data);

        return redirect()->route('admin.books.index');
    }

    public function edit(Book $book)
    {
        $categories = Category::all();
        return Inertia::render('Admin/Books/Edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'nullable|integer|min:0',
        ]);

        $book->update($data);

        return redirect()->route('admin.books.index');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('admin.books.index');
    }
}
