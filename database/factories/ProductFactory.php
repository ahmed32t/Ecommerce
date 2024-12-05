<?php

namespace Database\Factories;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{/*
    protected $model = Category::class;*/
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [/*
            'name' => $this->faker->word,



   "slug"	=> $this->faker->word,
"photo"	=> $this->faker->word,
"description"=> $this->faker->word,
"small_descripe"=> $this->faker->word,
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'user_id' => 1,
        */ ];
    }
}
