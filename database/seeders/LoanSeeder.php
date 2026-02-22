<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('loans')->insert([
            [
                'user_id' => 2, // John Doe
                'book_id' => 1, // The Great Gatsby
                'loan_date' => now()->subDays(10),
                'due_date' => now()->addDays(10),
                'return_date' => null,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3, // Jane Smith
                'book_id' => 2, // To Kill a Mockingbird
                'loan_date' => now()->subDays(5),
                'due_date' => now()->addDays(15),
                'return_date' => now()->subDays(1),
                'status' => 'returned',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2, // John Doe
                'book_id' => 3, // Sapiens
                'loan_date' => now()->subDays(20),
                'due_date' => now()->subDays(10),
                'return_date' => null,
                'status' => 'overdue',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}