<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with(['user', 'book'])->paginate(20);
        return Inertia::render('Admin/Loans/Index', compact('loans'));
    }

    public function show(Loan $loan)
    {
        return Inertia::render('Admin/Loans/Show', compact('loan'));
    }

    public function update(Request $request, Loan $loan)
    {
        $data = $request->validate([
            'status' => 'required|string',
            'return_date' => 'nullable|date',
        ]);

        $loan->update($data);

        return redirect()->route('admin.loans.index');
    }
}
