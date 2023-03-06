<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        //'name' => fake()->name(),
        return [
            'title' => $this->faker->title,
            'description' => $this->faker->text,
            'path_image' => fake()->imageUrl($width=400 ,$height=400),
            'user_id' => User::all()->random()->id,
        ];
    }
}
