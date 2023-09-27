<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'brand' => $this->faker->name(),
            'weight' => $this->faker->numberBetween(0, 100),
            'cost' => $this->faker->randomFloat(2 ,1 , 20),
            'sale' => $this->faker->randomFloat(2, 21 , 50),
            'amount' => $this->faker->numberBetween(0, 100),
            'category_id' => $this->faker->numberBetween(1, 18),
        ];
    }
}
