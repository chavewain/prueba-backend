<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Currency;
use App\Models\Product;
use App\Models\ProductPrice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ProductPriceController
 */
final class ProductPriceControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $productPrices = ProductPrice::factory()->count(3)->create();

        $response = $this->get(route('product-prices.index'));

        $response->assertOk();
        $response->assertViewIs('productPrice.index');
        $response->assertViewHas('productPrices');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('product-prices.create'));

        $response->assertOk();
        $response->assertViewIs('productPrice.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ProductPriceController::class,
            'store',
            \App\Http\Requests\ProductPriceStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $product = Product::factory()->create();
        $currency = Currency::factory()->create();
        $price = fake()->randomFloat(/** decimal_attributes **/);
        $tax_cost = fake()->randomFloat(/** decimal_attributes **/);

        $response = $this->post(route('product-prices.store'), [
            'product_id' => $product->id,
            'currency_id' => $currency->id,
            'price' => $price,
            'tax_cost' => $tax_cost,
        ]);

        $productPrices = ProductPrice::query()
            ->where('product_id', $product->id)
            ->where('currency_id', $currency->id)
            ->where('price', $price)
            ->where('tax_cost', $tax_cost)
            ->get();
        $this->assertCount(1, $productPrices);
        $productPrice = $productPrices->first();

        $response->assertRedirect(route('productPrices.index'));
        $response->assertSessionHas('productPrice.id', $productPrice->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $productPrice = ProductPrice::factory()->create();

        $response = $this->get(route('product-prices.show', $productPrice));

        $response->assertOk();
        $response->assertViewIs('productPrice.show');
        $response->assertViewHas('productPrice');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $productPrice = ProductPrice::factory()->create();

        $response = $this->get(route('product-prices.edit', $productPrice));

        $response->assertOk();
        $response->assertViewIs('productPrice.edit');
        $response->assertViewHas('productPrice');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ProductPriceController::class,
            'update',
            \App\Http\Requests\ProductPriceUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $productPrice = ProductPrice::factory()->create();
        $product = Product::factory()->create();
        $currency = Currency::factory()->create();
        $price = fake()->randomFloat(/** decimal_attributes **/);
        $tax_cost = fake()->randomFloat(/** decimal_attributes **/);

        $response = $this->put(route('product-prices.update', $productPrice), [
            'product_id' => $product->id,
            'currency_id' => $currency->id,
            'price' => $price,
            'tax_cost' => $tax_cost,
        ]);

        $productPrice->refresh();

        $response->assertRedirect(route('productPrices.index'));
        $response->assertSessionHas('productPrice.id', $productPrice->id);

        $this->assertEquals($product->id, $productPrice->product_id);
        $this->assertEquals($currency->id, $productPrice->currency_id);
        $this->assertEquals($price, $productPrice->price);
        $this->assertEquals($tax_cost, $productPrice->tax_cost);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $productPrice = ProductPrice::factory()->create();

        $response = $this->delete(route('product-prices.destroy', $productPrice));

        $response->assertRedirect(route('productPrices.index'));

        $this->assertModelMissing($productPrice);
    }
}
