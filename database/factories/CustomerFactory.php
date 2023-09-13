<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->word(),
            'gender' => $this->faker->word(),
            'zipcode' => $this->faker->word(),
            'street' => $this->faker->word(),
            'number' => $this->faker->word(),
            'district' => $this->faker->word(),
        ];
    }
}
