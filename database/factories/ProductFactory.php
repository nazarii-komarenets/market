<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\ProductType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Random\RandomException;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws RandomException
     */
    public function definition(): array
    {
        $title = $this->faker->unique()->text(10);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'price' => random_int(200, 4500),
            'description' => $this->faker->text,
            'quantity' => random_int(1, 20),
            'game_id' => Game::inRandomOrder()->first()->id,
            'product_type_id' => ProductType::inRandomOrder()->first()->id,
            'author_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
