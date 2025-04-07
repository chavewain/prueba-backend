<?php

namespace App\Swagger;

/**
 * @OA\Post(
 *     path="/api/login",
 *     summary="Iniciar sesión y obtener token de acceso",
 *     tags={"Autenticación"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 required={"email", "password"},
 *                 @OA\Property(property="email", type="string", format="email", example="test@example.com"),
 *                 @OA\Property(property="password", type="string", format="password", example="password")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Login exitoso. Retorna el token de acceso",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="token", type="string", example="1|abcDEF123456..."),
 *             @OA\Property(
 *                 property="user",
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="John Doe"),
 *                 @OA\Property(property="email", type="string", example="admin@demo.com")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Credenciales incorrectas",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Credenciales incorrectas.")
 *         )
 *     )
 * )
 */
class AuthDocumentation {}