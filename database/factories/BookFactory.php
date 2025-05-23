<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'author' => $this->faker->name,
            'summary' => $this->faker->paragraph(3),
            'pages' => $this->faker->numberBetween(50, 1000),
            'published_at' => $this->faker->date(),
            'cover' => 'covers/default.jpg',
            'category_id' => Category::factory(),
            'status' => $this->faker->randomElement(['available', 'borrowed']),
        ];
    }
}