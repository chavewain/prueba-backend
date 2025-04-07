<?php

namespace App\Swagger\Schemas;

/**
 * @OA\Schema(
 *     schema="Currency",
 *     title="Moneda",
 *     type="object",
 *     required={"name", "symbol", "exchange_rate"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Dólar estadounidense"),
 *     @OA\Property(property="symbol", type="string", example="$"),
 *     @OA\Property(property="exchange_rate", type="number", format="float", example=1.0000),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-01T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-01-02T15:30:00Z")
 * )
 */
class CurrencySchema {}