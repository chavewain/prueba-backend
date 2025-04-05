<?php

namespace App\Http\Controllers;

use App\Http\Requests\CurrencyStoreRequest;
use App\Http\Requests\CurrencyUpdateRequest;
use App\Models\Currency;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CurrencyController extends Controller
{
    public function index(Request $request): View
    {
        $currencies = Currency::all();

        return view('currency.index', [
            'currencies' => $currencies,
        ]);
    }

    public function create(Request $request): View
    {
        return view('currency.create');
    }

    public function store(CurrencyStoreRequest $request): RedirectResponse
    {
        $currency = Currency::create($request->validated());

        $request->session()->flash('currency.id', $currency->id);

        return redirect()->route('currencies.index');
    }

    public function show(Request $request, Currency $currency): View
    {
        return view('currency.show', [
            'currency' => $currency,
        ]);
    }

    public function edit(Request $request, Currency $currency): View
    {
        return view('currency.edit', [
            'currency' => $currency,
        ]);
    }

    public function update(CurrencyUpdateRequest $request, Currency $currency): RedirectResponse
    {
        $currency->update($request->validated());

        $request->session()->flash('currency.id', $currency->id);

        return redirect()->route('currencies.index');
    }

    public function destroy(Request $request, Currency $currency): RedirectResponse
    {
        $currency->delete();

        return redirect()->route('currencies.index');
    }
}
