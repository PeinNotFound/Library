<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
{

    User::create([
        'name' => 'Admin',
        'email' => 'admin@amin.com',
        'password' => bcrypt('123456'),
        'role' => 'admin',
    ]);


    User::factory(19)->create();

    // Create categories
    Category::factory(5)->create();

    // Create books
    Book::factory(50)->create();

    // Create reviews
    Review::factory(200)->create();

    }
}
