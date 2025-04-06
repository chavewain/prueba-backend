<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductPriceStoreRequest;
use App\Http\Requests\ProductPriceUpdateRequest;
use App\Models\ProductPrice;
use App\Models\Product;
use App\Http\Resources\ProductPriceResource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductPriceController extends Controller
{
    public function index($productId)
    {
        $product = Product::with('prices.currency')->find($productId);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => ProductPriceResource::collection($product->prices)
        ]);
    }

    public function create(Request $request): View
    {
        return view('productPrice.create');
    }

    public function store(ProductPriceStoreRequest $request): RedirectResponse
    {
        $productPrice = ProductPrice::create($request->validated());

        $request->session()->flash('productPrice.id', $productPrice->id);

        return redirect()->route('productPrices.index');
    }

    public function show(Request $request, ProductPrice $productPrice): View
    {
        return view('productPrice.show', [
            'productPrice' => $productPrice,
        ]);
    }

    public function edit(Request $request, ProductPrice $productPrice): View
    {
        return view('productPrice.edit', [
            'productPrice' => $productPrice,
        ]);
    }

    public function update(ProductPriceUpdateRequest $request, ProductPrice $productPrice): RedirectResponse
    {
        $productPrice->update($request->validated());

        $request->session()->flash('productPrice.id', $productPrice->id);

        return redirect()->route('productPrices.index');
    }

    public function destroy(Request $request, ProductPrice $productPrice): RedirectResponse
    {
        $productPrice->delete();

        return redirect()->route('productPrices.index');
    }
}
