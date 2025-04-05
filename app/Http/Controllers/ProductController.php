<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;

class ProductController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $products = Product::with('prices.currency')->paginate(20);
        return ProductResource::collection($products); 
    }
    public function store(ProductStoreRequest $request): JsonResponse
    {
        $data = $request->validated();

        $product = Product::create(
            Arr::only($data, ['name', 'description', 'manufacturing_cost'])
        );

        if (!empty($data['prices'])) {
            foreach ($data['prices'] as $price) {
                $product->prices()->create($price);
            }
        }

        return response()->json(
            new ProductResource($product->load('prices.currency')),
            201
        );
    }

    public function show(Request $request, Product $product): JsonResponse
    {
        return response()->json(new ProductResource($product->load('prices.currency')));
    }

    public function update(ProductUpdateRequest $request, Product $product): JsonResponse
    {
        $data = $request->validated();

        // Actualizar solo los campos del producto
        $product->update(
            Arr::only($data, ['name', 'description', 'manufacturing_cost'])
        );

        // Si se envían nuevos precios, eliminamos los anteriores y los reinsertamos
        if (!empty($data['prices'])) {
            $product->prices()->delete();

            foreach ($data['prices'] as $price) {
                $product->prices()->create($price);
            }
        }

        return response()->json(
            new ProductResource($product->load('prices.currency'))
        );
    }


    public function destroy(Request $request, Product $product): JsonResponse
    {
        $product->delete();
        return response()->json(null, 204);
    }
}
