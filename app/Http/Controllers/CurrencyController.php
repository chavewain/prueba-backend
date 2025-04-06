<?php

namespace App\Http\Controllers;

use App\Http\Requests\CurrencyStoreRequest;
use App\Http\Requests\CurrencyUpdateRequest;
use App\Models\Currency;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Schema(
 *     schema="Currency",
 *     type="object",
 *     title="Moneda",
 *     required={"id", "name", "symbol", "exchange_rate"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Dólar estadounidense"),
 *     @OA\Property(property="symbol", type="string", example="$"),
 *     @OA\Property(property="exchange_rate", type="number", format="float", example=1.0000),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-01T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-01-02T15:30:00Z")
 * )
 */

class CurrencyController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/currencies",
     *     summary="Listar todas las monedas",
     *     tags={"Monedas"},
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
        $currencies = Currency::all();
    
        return response()->json([
            'success' => true,
            'data' => $currencies
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/currencies",
     *     summary="Crear una nueva moneda",
     *     tags={"Monedas"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "symbol", "exchange_rate"},
     *             @OA\Property(property="name", type="string", example="USD"),
     *             @OA\Property(property="symbol", type="string", example="$"),
     *             @OA\Property(property="exchange_rate", type="number", format="float", example=1.0)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Moneda creada exitosamente"
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
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la moneda",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles de la moneda",
     *         @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="data", ref="#/components/schemas/Currency")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Moneda no encontrada"
     *     ),
     *     @OA\Response(
     *          response=422,
     *          description="Errores de validación",
     *              @OA\JsonContent(
     *                  @OA\Property(property="success", type="boolean", example=false),
     *                  @OA\Property(property="message", type="string", example="Errores de validación"),
     *                  @OA\Property(property="errors", type="object")
     *              )
     *   )
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
     *     summary="Actualizar una moneda existente",
     *     tags={"Monedas"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la moneda",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Dólar actualizado"),
     *             @OA\Property(property="symbol", type="string", example="$"),
     *             @OA\Property(property="exchange_rate", type="number", format="float", example=1.05)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Moneda actualizada correctamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Moneda no encontrada"
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
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la moneda a eliminar",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Moneda eliminada correctamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Moneda no encontrada"
     *     )
     * )
     */
    public function destroy(Request $request, Currency $currency): JsonResponse
    {
        $currency->delete();

        return response()->json([
            'success' => true,
            'message' => 'Moneda eliminada correctamente.'
        ], 200);
    }
}
