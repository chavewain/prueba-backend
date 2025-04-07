<?php

namespace App\Swagger;

/**
 * @OA\Info(
 *     title="API de Autenticación",
 *     version="1.0.0",
 *     description="Documentación para la API con autenticación mediante Sanctum y Swagger"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
class OpenApiInfo {}
