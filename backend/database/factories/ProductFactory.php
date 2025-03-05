<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'barcode' => strtoupper($this->faker->unique()->bothify('#####-#####')),
            'sku' => strtoupper($this->faker->unique()->bothify('???-#####')),
            'price' => $this->faker->randomFloat(2, 10, 1000), // Giá từ 10 đến 1000
            'stock_quantity' => $this->faker->numberBetween(1, 100),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
