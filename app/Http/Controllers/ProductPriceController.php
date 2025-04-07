<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductPriceStoreRequest;
use App\Http\Resources\ProductPriceResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Precios",
 *     description="Gestión de precios para productos"
 * )
 */
class ProductPriceController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/products/{productId}/prices",
     *     summary="Obtener todos los precios de un producto",
     *     tags={"Precios"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="productId",
     *         in="path",
     *         required=true,
     *         description="ID del producto",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de precios",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/ProductPrice")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Producto no encontrado"
     *     )
     * )
     */
    public function index($productId): JsonResponse
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

    /**
     * @OA\Post(
     *     path="/api/products/{productId}/prices",
     *     summary="Registrar un nuevo precio para un producto",
     *     tags={"Precios"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="productId",
     *         in="path",
     *         required=true,
     *         description="ID del producto",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"price", "tax_cost", "currency_id"},
     *                 @OA\Property(property="price", type="number", format="float", example=150.00),
     *                 @OA\Property(property="tax_cost", type="number", format="float", example=20.00),
     *                 @OA\Property(property="currency_id", type="integer", example=1)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Precio creado exitosamente",
     *         @OA\JsonContent(ref="#/components/schemas/ProductPrice")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Producto no encontrado"
     *     )
     * )
     */
    public function store(ProductPriceStoreRequest $request, $productId): JsonResponse
    {
        $product = Product::find($productId);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado.'
            ], 404);
        }

        $price = $product->prices()->create($request->validated());

        return response()->json(new ProductPriceResource($price->load('currency')), 201);
    }
}