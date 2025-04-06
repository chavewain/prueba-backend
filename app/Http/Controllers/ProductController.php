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
 *     name="Products",
 *     description="Operations related to products"
 * )
 */

/**
 * @OA\Schema(
 *     schema="Product",
 *     type="object",
 *     required={"name", "description", "manufacturing_cost", "prices"},
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="description", type="string"),
 *     @OA\Property(property="manufacturing_cost", type="number", format="float"),
 *     @OA\Property(
 *         property="prices",
 *         type="array",
 *         @OA\Items(
 *             type="object",
 *             required={"price", "tax_cost", "currency_id"},
 *             @OA\Property(property="price", type="number", format="float", example=150.00),
 *             @OA\Property(property="tax_cost", type="number", format="float", example=20.00),
 *             @OA\Property(property="currency_id", type="integer", example=1)
 *         )
 *     )
 * )
 */

class ProductController extends Controller
{
    
    /**
     * @OA\Get(
     *     path="/api/products",
     *     summary="Obtener todos los productos",
     *     tags={"Productos"},
     *     @OA\Response(response="200", description="Lista de productos")
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
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Product created successfully",
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
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del producto",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles del producto",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Producto no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Producto no encontrado.")
     *         )
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
     *     summary="Actualizar un producto existente y sus precios",
     *     tags={"Productos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del producto",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Nuevo nombre del producto"),
     *             @OA\Property(property="description", type="string", example="Descripción actualizada"),
     *             @OA\Property(property="manufacturing_cost", type="number", format="float", example=200.00),
     *             @OA\Property(
     *                 property="prices",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="price", type="number", format="float", example=250.00),
     *                     @OA\Property(property="tax_cost", type="number", format="float", example=25.00),
     *                     @OA\Property(property="currency_id", type="integer", example=1)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Producto actualizado correctamente",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Producto no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Producto no encontrado.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Errores de validación",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Errores de validación detectados."),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */

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

    /**
     * @OA\Delete(
     *     path="/api/products/{id}",
     *     summary="Eliminar un producto por su ID",
     *     tags={"Productos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del producto a eliminar",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
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
     *         description="Producto no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Producto no encontrado.")
     *         )
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
