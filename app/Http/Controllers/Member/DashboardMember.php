<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardMember extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return Inertia::render('Dashboard', [
            'stats' => [
                'my_borrowed'  => 3, // Ganti dengan query database sesungguhnya
                'my_wishlist'  => 12,
                'late_returns' => 0,
            ]
        ]);
    }
}
