<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Fiction',
                'code_name' => 'fiction',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Non-Fiction',
                'code_name' => 'non-fiction',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Science',
                'code_name' => 'science',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'History',
                'code_name' => 'history',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Biography',
                'code_name' => 'biography',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}