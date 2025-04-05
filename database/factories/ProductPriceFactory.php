<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Currency;
use App\Models\Product;
use App\Models\ProductPrice;

class ProductPriceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductPrice::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'currency_id' => Currency::factory(),
            'price' => fake()->randomFloat(2, 0, 99999999.99),
            'tax_cost' => fake()->randomFloat(2, 0, 99999999.99),
        ];
    }
}
