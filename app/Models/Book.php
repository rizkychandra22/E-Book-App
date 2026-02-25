<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'title',
        'author',
        'publisher',
        'year',
        'code_book',
        'description',
        'cover_image',
        'file_path',
        'view_count',
        'stock'
    ];

    /**
     * Get the category that owns the book.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the loans that belong to the book.
     */
    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }

    /**
     * Users who have this book in their wishlist.
     */
    public function wishlistedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'wishlists')->withTimestamps();
    }
}
