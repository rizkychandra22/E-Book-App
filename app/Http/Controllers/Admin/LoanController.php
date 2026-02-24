<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index()
    {
        return redirect()->route('dashboard');
    }

    public function show(Loan $loan)
    {
        return redirect()->route('dashboard');
    }

    public function update(Request $request, Loan $loan)
    {
        $data = $request->validate([
            'status' => 'required|in:active,returned,overdue',
            'return_date' => 'nullable|date',
        ]);

        $loan->update($data);

        return redirect()->route('dashboard')->with('message', 'Status peminjaman berhasil diperbarui.');
    }
}
