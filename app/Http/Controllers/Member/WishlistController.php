<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function store(Book $book)
    {
        $user = Auth::user();
        $user->wishlists()->syncWithoutDetaching([$book->id]);

        return redirect()->route('dashboard')->with('message', 'Buku ditambahkan ke wishlist.');
    }

    public function destroy(Book $book)
    {
        $user = Auth::user();
        $user->wishlists()->detach($book->id);

        return redirect()->route('dashboard')->with('message', 'Buku dihapus dari wishlist.');
    }
}
