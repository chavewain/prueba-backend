<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Currency;
use App\Models\ProductPrice;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $symbols = ['$', '€', '£', '¥', '₹', '₽'];

        // Crear monedas
        $currencies = [];
        for ($i = 0; $i < 5; $i++) {
            $currencies[] = Currency::create([
                'name' => $faker->currencyCode,
                'symbol' => $faker->randomElement($symbols),
                'exchange_rate' => $faker->randomFloat(4, 0.5, 2.0),
            ]);
        }

        // Crear productos y registrar al menos dos precios con diferentes divisas
        for ($i = 0; $i < 100; $i++) {
            $product = Product::create([
                'name' => $faker->words(3, true),
                'description' => $faker->paragraph,
                'manufacturing_cost' => $faker->randomFloat(2, 100, 1000),
            ]);

            // Escoge al menos 2 monedas distintas
            $selectedCurrencies = $faker->randomElements($currencies, 2);

            foreach ($selectedCurrencies as $currency) {
                ProductPrice::create([
                    'product_id' => $product->id,
                    'currency_id' => $currency->id,
                    'price' => $faker->randomFloat(2, 10, 2000),
                    'tax_cost' => $faker->randomFloat(2, 1, 200),
                ]);
            }
        }
    }
}