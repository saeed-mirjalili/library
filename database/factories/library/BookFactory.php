<?php

namespace Database\Factories\library;

use App\Models\library\Author;
use App\Models\library\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\library\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'summary' => fake()->sentence(5),
            'edition' => fake()->numberBetween(1900, 2023),
            'author_id' => Author::factory()->create()->id,
            'category_id' => Category::factory()->create()->id,
            'book_url' => fake()->numberBetween(1, 5) . '.pdf'
        ];
    }
}
//->unique()->image('public/storage/books/',340,280, null, false)
