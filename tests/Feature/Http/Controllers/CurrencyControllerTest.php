<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Currency;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CurrencyController
 */
final class CurrencyControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $currencies = Currency::factory()->count(3)->create();

        $response = $this->get(route('currencies.index'));

        $response->assertOk();
        $response->assertViewIs('currency.index');
        $response->assertViewHas('currencies');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('currencies.create'));

        $response->assertOk();
        $response->assertViewIs('currency.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CurrencyController::class,
            'store',
            \App\Http\Requests\CurrencyStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $name = fake()->name();
        $symbol = fake()->word();
        $exchange_rate = fake()->randomFloat(/** decimal_attributes **/);

        $response = $this->post(route('currencies.store'), [
            'name' => $name,
            'symbol' => $symbol,
            'exchange_rate' => $exchange_rate,
        ]);

        $currencies = Currency::query()
            ->where('name', $name)
            ->where('symbol', $symbol)
            ->where('exchange_rate', $exchange_rate)
            ->get();
        $this->assertCount(1, $currencies);
        $currency = $currencies->first();

        $response->assertRedirect(route('currencies.index'));
        $response->assertSessionHas('currency.id', $currency->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $currency = Currency::factory()->create();

        $response = $this->get(route('currencies.show', $currency));

        $response->assertOk();
        $response->assertViewIs('currency.show');
        $response->assertViewHas('currency');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $currency = Currency::factory()->create();

        $response = $this->get(route('currencies.edit', $currency));

        $response->assertOk();
        $response->assertViewIs('currency.edit');
        $response->assertViewHas('currency');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CurrencyController::class,
            'update',
            \App\Http\Requests\CurrencyUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $currency = Currency::factory()->create();
        $name = fake()->name();
        $symbol = fake()->word();
        $exchange_rate = fake()->randomFloat(/** decimal_attributes **/);

        $response = $this->put(route('currencies.update', $currency), [
            'name' => $name,
            'symbol' => $symbol,
            'exchange_rate' => $exchange_rate,
        ]);

        $currency->refresh();

        $response->assertRedirect(route('currencies.index'));
        $response->assertSessionHas('currency.id', $currency->id);

        $this->assertEquals($name, $currency->name);
        $this->assertEquals($symbol, $currency->symbol);
        $this->assertEquals($exchange_rate, $currency->exchange_rate);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $currency = Currency::factory()->create();

        $response = $this->delete(route('currencies.destroy', $currency));

        $response->assertRedirect(route('currencies.index'));

        $this->assertModelMissing($currency);
    }
}
