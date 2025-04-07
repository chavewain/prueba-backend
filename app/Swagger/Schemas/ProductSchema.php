<?php

namespace App\Swagger\Schemas;

/**
 * @OA\Schema(
 *     schema="Product",
 *     type="object",
 *     title="Producto",
 *     required={"name", "description", "manufacturing_cost", "prices"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Producto A"),
 *     @OA\Property(property="description", type="string", example="Descripción del producto A"),
 *     @OA\Property(property="manufacturing_cost", type="number", format="float", example=150.00),
 *     @OA\Property(
 *         property="prices",
 *         type="array",
 *         @OA\Items(
 *             type="object",
 *             required={"price", "tax_cost", "currency_id"},
 *             @OA\Property(property="price", type="number", format="float", example=200.00),
 *             @OA\Property(property="tax_cost", type="number", format="float", example=20.00),
 *             @OA\Property(property="currency_id", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-01T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-01-01T12:00:00Z")
 * )
 */
class ProductSchema
{
    // Swagger solo necesita esta clase vacía como contenedor de anotaciones
}