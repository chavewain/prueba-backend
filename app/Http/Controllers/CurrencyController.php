<?php

namespace App\Http\Controllers;

use App\Http\Requests\CurrencyStoreRequest;
use App\Http\Requests\CurrencyUpdateRequest;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Monedas",
 *     description="Operaciones relacionadas con monedas"
 * )
 */
class CurrencyController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/currencies",
     *     summary="Listar todas las monedas",
     *     tags={"Monedas"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Listado de monedas",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Currency")
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => Currency::all()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/currencies",
     *     summary="Crear una nueva moneda",
     *     tags={"Monedas"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/Currency")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Moneda creada correctamente",
     *         @OA\JsonContent(ref="#/components/schemas/Currency")
     *     )
     * )
     */
    public function store(CurrencyStoreRequest $request): JsonResponse
    {
        $currency = Currency::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Moneda creada correctamente.',
            'data' => $currency
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/currencies/{id}",
     *     summary="Mostrar detalles de una moneda",
     *     tags={"Monedas"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la moneda",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles de la moneda",
     *         @OA\JsonContent(ref="#/components/schemas/Currency")
     *     ),
     *     @OA\Response(response=404, description="Moneda no encontrada")
     * )
     */
    public function show(Request $request, Currency $currency): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $currency
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/currencies/{id}",
     *     summary="Actualizar una moneda",
     *     tags={"Monedas"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/Currency")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Moneda actualizada correctamente",
     *         @OA\JsonContent(ref="#/components/schemas/Currency")
     *     )
     * )
     */
    public function update(CurrencyUpdateRequest $request, Currency $currency): JsonResponse
    {
        $currency->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Moneda actualizada correctamente.',
            'data' => $currency
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/currencies/{id}",
     *     summary="Eliminar una moneda",
     *     tags={"Monedas"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Moneda eliminada correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Moneda eliminada correctamente.")
     *         )
     *     )
     * )
     */
    public function destroy(Request $request, Currency $currency): JsonResponse
    {
        $currency->delete();

        return response()->json([
            'success' => true,
            'message' => 'Moneda eliminada correctamente.'
        ]);
    }
}
