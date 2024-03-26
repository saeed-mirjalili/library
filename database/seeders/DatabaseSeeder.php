<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Book::factory(10)->create();
        User::factory(10)->create();
        Role::factory(10)->create();
        Permission::factory()->state([
            'name'=>'exhibit',
            'display_name'=>'exhibitor'
        ])->create();
        Permission::factory()->state([
            'name'=>'change',
            'display_name'=>'changer'
        ])->create();
        Permission::factory()->state([
            'name'=>'create',
            'display_name'=>'creator'
        ])->create();
        Permission::factory()->state([
            'name'=>'delete',
            'display_name'=>'Detergent'
        ])->create();

        // Get all the category attaching up to 3 random category to each author
        $category = Category::all();
        // Populate the pivot table
        Author::all()->each(function ($author) use ($category) { 
            $author->categories()->attach(
                $category->random(rand(1, 3))->pluck('id')->toArray()
            ); 
        });

        $book = Book::all();
        // Populate the pivot table
        User::all()->each(function ($user) use ($book) { 
            $user->books()->attach(
                $book->random(rand(1, 3))->pluck('id')->toArray()
            ); 
        });
        
        $user = User::all();
        // Populate the pivot table
        Role::all()->each(function ($role) use ($user) { 
            $role->users()->attach(
                $user->random(rand(1, 3))->pluck('id')->toArray()
            ); 
        });

        $role = Role::all();
        // Populate the pivot table
        Permission::all()->each(function ($permission) use ($role) { 
            $permission->roles()->attach(
                $role->random(rand(1, 3))->pluck('id')->toArray()
            ); 
        });
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
