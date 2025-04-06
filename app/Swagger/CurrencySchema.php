<?php

/**
 * @OA\Schema(
 *     schema="Currency",
 *     type="object",
 *     title="Moneda",
 *     required={"id", "name", "symbol", "exchange_rate"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         example=1,
 *         description="ID único de la moneda"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         example="Dólar estadounidense",
 *         description="Nombre de la moneda"
 *     ),
 *     @OA\Property(
 *         property="symbol",
 *         type="string",
 *         example="$",
 *         description="Símbolo de la moneda"
 *     ),
 *     @OA\Property(
 *         property="exchange_rate",
 *         type="number",
 *         format="float",
 *         example=1.0000,
 *         description="Tasa de cambio respecto a la moneda base"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         example="2024-01-01T12:00:00Z"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         example="2024-01-02T15:30:00Z"
 *     )
 * )
 */
