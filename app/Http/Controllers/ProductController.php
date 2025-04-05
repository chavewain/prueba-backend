<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $products = Product::with('prices.currency')->paginate(10);
        return response()->json(ProductResource::collection($products));
    }

    public function store(ProductStoreRequest $request): JsonResponse
    {
        $product = Product::create($request->validated());
        return response()->json(new ProductResource($product->load('prices.currency')), 201);
    }

    public function show(Request $request, Product $product): JsonResponse
    {
        return response()->json(new ProductResource($product->load('prices.currency')));
    }

    public function update(ProductUpdateRequest $request, Product $product): JsonResponse
    {
        $product->update($request->validated());
        return response()->json(new ProductResource($product->load('prices.currency')));
    }

    public function destroy(Request $request, Product $product): JsonResponse
    {
        $product->delete();
        return response()->json(null, 204);
    }
}
