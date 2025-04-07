<?php

namespace App\Swagger\Schemas;

/**
 * @OA\Schema(
 *     schema="ProductRequest",
 *     type="object",
 *     required={"name", "description", "manufacturing_cost", "prices"},
 *     @OA\Property(property="name", type="string", example="Producto nuevo"),
 *     @OA\Property(property="description", type="string", example="Una descripción del producto"),
 *     @OA\Property(property="manufacturing_cost", type="number", format="float", example=200.50),
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
class ProductRequestSchema {}
