<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Loan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'book_id',
        'loan_date',
        'due_date',
        'return_date',
        'status'
    ];

    /**
     * Get the user that owns the loan.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the book that owns the loan.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
