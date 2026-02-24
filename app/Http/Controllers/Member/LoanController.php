<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'book_id' => 'required|exists:books,id',
            'loan_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:loan_date',
        ]);

        $data['user_id'] = Auth::id();
        $data['status'] = 'active';

        Loan::create($data);

        return redirect()->route('dashboard')->with('message', 'Peminjaman berhasil dibuat.');
    }
}
