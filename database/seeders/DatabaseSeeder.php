<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        \App\Models\Book::factory(10)->create();
        \App\Models\User::factory(10)->create();

        // Get all the category attaching up to 3 random category to each author
        $category = Category::all();
        // Populate the pivot table
        Author::all()->each(function ($author) use ($category) { 
            $author->categories()->attach(
                $category->random(rand(1, 3))->pluck('id')->toArray()
            ); 
        });

        // Get all the category attaching up to 3 random category to each author
        $book = Book::all();
        // Populate the pivot table
        User::all()->each(function ($user) use ($book) { 
            $user->books()->attach(
                $book->random(rand(1, 3))->pluck('id')->toArray()
            ); 
        });
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
