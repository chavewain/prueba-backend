<?php

/**
 * @OA\Schema(
 *     schema="Product",
 *     type="object",
 *     title="Producto",
 *     required={"id", "name", "manufacturing_cost"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Laptop Gamer"),
 *     @OA\Property(property="description", type="string", example="Una laptop potente"),
 *     @OA\Property(property="manufacturing_cost", type="number", format="float", example=1200.00),
 *     @OA\Property(
 *         property="prices",
 *         type="array",
 *         @OA\Items(
 *             @OA\Property(property="price", type="number", format="float", example=1500.00),
 *             @OA\Property(property="tax_cost", type="number", format="float", example=120.00),
 *             @OA\Property(property="currency", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="USD"),
 *                 @OA\Property(property="symbol", type="string", example="$"),
 *                 @OA\Property(property="exchange_rate", type="number", format="float", example=1.0)
 *             )
 *         )
 *     )
 * )
 */
