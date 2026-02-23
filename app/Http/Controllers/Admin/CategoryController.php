<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
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
            'name' => 'required|string|max:255',
            'code_name' => 'required|string|max:255|unique:categories,code_name',
        ]);

        Category::create($data);

        return redirect()->route('dashboard')->with('message', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        return redirect()->route('dashboard');
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code_name' => ['required', 'string', 'max:255', Rule::unique('categories', 'code_name')->ignore($category->id)],
        ]);

        $category->update($data);

        return redirect()->route('dashboard')->with('message', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('dashboard')->with('message', 'Kategori berhasil dihapus.');
    }
}
