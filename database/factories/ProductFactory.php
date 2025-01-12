<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'product_name' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 100, 1000),
            'sale_price' => $this->faker->optional()->randomFloat(2, 50, 900),
            'stock_quanity' => $this->faker->numberBetween(0, 100),
            'slug' => $this->faker->unique()->slug(),
            'sku' => $this->faker->unique()->bothify('SKU-#####'),
            'product_type' => $this->faker->randomElement(['new', 'used', 'complete_pc', 'laptop']),
            'status' => 'approved',
            'category_id' => rand(41, 60), // Assuming you have 10 categories
            'brand_id' => rand(63, 80),    // Assuming you have 10 brands
            'user_id' => 1,     // Assuming you have 10 users
            'warranty' => $this->faker->optional()->sentence(),
            'condition' => $this->faker->optional()->randomElement(['New', 'Used', 'Refurbished']),
            'year_of_make' => $this->faker->optional()->year(),
        ];
    }
}
