<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\ProductPriceController;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

/**
 * Endpoint para iniciar sesión y obtener token
 */
Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = \App\Models\User::where('email', $request->email)->first();

    if (! $user || ! \Hash::check($request->password, $user->password)) {
        return response()->json([
            'success' => false,
            'message' => 'Credenciales incorrectas.'
        ], 401);
    }

    return response()->json([
        'success' => true,
        'token' => $user->createToken('api-token')->plainTextToken,
        'user' => $user,
    ]);
});


/**
 * Rutas protegidas con Sanctum (token en Authorization: Bearer ...)
 */
Route::middleware(['auth:sanctum'])->group(function () {

    Route::apiResource('products', ProductController::class);
    Route::apiResource('currencies', CurrencyController::class);

    Route::get('/products/{product}/prices', [ProductPriceController::class, 'index']);
    Route::post('/products/{product}/prices', [ProductPriceController::class, 'store']);

    // Logout
    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Sesión cerrada correctamente.'
        ]);
    });

});
