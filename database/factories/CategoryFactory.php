<?php

namespace Database\Factories;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' =>$this->faker->word,
            'parent_id' =>44,
            'category_id' =>33,




   "slug"	=> $this->faker->word,
"photo"	=> 'public/might like/man (1).png',
"description"=> $this->faker->word,
"small_descripe"=> $this->faker->word,
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'user_id' => 1,

            "special_name"=>$this->faker->word
        ];
    }
}
