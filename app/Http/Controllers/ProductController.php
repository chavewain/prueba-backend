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

/**
 * @OA\Tag(
 *     name="Productos",
 *     description="Operaciones relacionadas con productos"
 * )
 */
class ProductController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/products",
     *     summary="Obtener todos los productos",
     *     tags={"Productos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de productos paginada",
     *         @OA\JsonContent(
     *             @OA\Property(property="current_page", type="integer", example=1),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Product")
     *             ),
     *             @OA\Property(property="total", type="integer", example=100),
     *             @OA\Property(property="per_page", type="integer", example=20)
     *         )
     *     )
     * )
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $products = Product::with('prices.currency')->paginate(20);
        return ProductResource::collection($products); 
    }

    /**
     * @OA\Post(
     *     path="/api/products",
     *     summary="Crear nuevo producto",
     *     tags={"Productos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/Product")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Producto creado correctamente",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     )
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/api/products/{id}",
     *     summary="Obtener los detalles de un producto",
     *     tags={"Productos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del producto",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles del producto",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Producto no encontrado"
     *     )
     * )
     */
    public function show(Request $request, Product $product): JsonResponse
    {
        return response()->json(new ProductResource($product->load('prices.currency')));
    }

    /**
     * @OA\Put(
     *     path="/api/products/{id}",
     *     summary="Actualizar un producto existente",
     *     tags={"Productos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del producto",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/Product")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Producto actualizado correctamente",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     )
     * )
     */
    public function update(ProductUpdateRequest $request, Product $product): JsonResponse
    {
        $data = $request->validated();

        $product->update(
            Arr::only($data, ['name', 'description', 'manufacturing_cost'])
        );

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

    /**
     * @OA\Delete(
     *     path="/api/products/{id}",
     *     summary="Eliminar un producto",
     *     tags={"Productos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del producto",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Producto eliminado correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Producto eliminado correctamente.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Producto no encontrado"
     *     )
     * )
     */
    public function destroy(Request $request, Product $product): JsonResponse
    {
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado correctamente.'
        ], 200);
    }
}