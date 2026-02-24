<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    public function index()
    {
        return redirect()->route('dashboard');
    }

    public function create()
    {
        return redirect()->route('dashboard');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'year' => 'nullable|integer|min:0|max:' . date('Y'),
            'code_book' => 'required|string|max:255|unique:books,code_book',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
        ]);

        Book::create($data);

        return redirect()->route('dashboard')->with('message', 'Buku berhasil ditambahkan.');
    }

    public function edit(Book $book)
    {
        return redirect()->route('dashboard');
    }

    public function update(Request $request, Book $book)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'year' => 'nullable|integer|min:0|max:' . date('Y'),
            'code_book' => ['required', 'string', 'max:255', Rule::unique('books', 'code_book')->ignore($book->id)],
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
        ]);

        $book->update($data);

        return redirect()->route('dashboard')->with('message', 'Buku berhasil diperbarui.');
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('dashboard')->with('message', 'Buku berhasil dihapus.');
    }
}
