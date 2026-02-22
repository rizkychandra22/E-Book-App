<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('books')->insert([
            [
                'category_id' => 1, // Fiction
                'title' => 'The Great Gatsby',
                'author' => 'F. Scott Fitzgerald',
                'publisher' => 'Scribner',
                'year' => 1925,
                'code_book' => 'TG001',
                'description' => 'A classic American novel about the Jazz Age.',
                'cover_image' => null,
                'file_path' => null,
                'view_count' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1, // Fiction
                'title' => 'To Kill a Mockingbird',
                'author' => 'Harper Lee',
                'publisher' => 'J. B. Lippincott & Co.',
                'year' => 1960,
                'code_book' => 'TKM002',
                'description' => 'A novel about racial injustice in the American South.',
                'cover_image' => null,
                'file_path' => null,
                'view_count' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2, // Non-Fiction
                'title' => 'Sapiens: A Brief History of Humankind',
                'author' => 'Yuval Noah Harari',
                'publisher' => 'Harper',
                'year' => 2011,
                'code_book' => 'SAP003',
                'description' => 'An exploration of the history of humankind.',
                'cover_image' => null,
                'file_path' => null,
                'view_count' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 3, // Science
                'title' => 'A Brief History of Time',
                'author' => 'Stephen Hawking',
                'publisher' => 'Bantam Books',
                'year' => 1988,
                'code_book' => 'BHT004',
                'description' => 'A popular science book on cosmology.',
                'cover_image' => null,
                'file_path' => null,
                'view_count' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 4, // History
                'title' => 'Guns, Germs, and Steel',
                'author' => 'Jared Diamond',
                'publisher' => 'W. W. Norton & Company',
                'year' => 1997,
                'code_book' => 'GGS005',
                'description' => 'A book on the rise of civilizations.',
                'cover_image' => null,
                'file_path' => null,
                'view_count' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 5, // Biography
                'title' => 'Steve Jobs',
                'author' => 'Walter Isaacson',
                'publisher' => 'Simon & Schuster',
                'year' => 2011,
                'code_book' => 'SJ006',
                'description' => 'A biography of Steve Jobs.',
                'cover_image' => null,
                'file_path' => null,
                'view_count' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}