<?php

namespace App\Swagger\Schemas;

/**
 * @OA\Schema(
 *     schema="ProductPrice",
 *     type="object",
 *     title="Precio de Producto",
 *     required={"price", "tax_cost", "currency"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="price", type="number", format="float", example=150.00),
 *     @OA\Property(property="tax_cost", type="number", format="float", example=20.00),
 *     @OA\Property(property="currency_id", type="integer", example=1),
 *     @OA\Property(
 *         property="currency",
 *         type="object",
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="name", type="string", example="USD"),
 *         @OA\Property(property="symbol", type="string", example="$"),
 *         @OA\Property(property="exchange_rate", type="number", format="float", example=1.0000)
 *     ),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-04-05T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-04-05T12:30:00Z")
 * )
 */
class ProductPriceSchema {}