<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\library\Author;
use App\Models\library\Book;
use App\Models\library\Category;
use App\Models\admin\Permission;
use App\Models\admin\Role;
use App\Models\user\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Book::factory(10)->create();

        User::factory()->create([
            'name' => 'AdminUser',
            'email' => 'admin@example.com',
            'password' => 'password'
        ]);

        User::factory(10)->create();
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);


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

    }
}
