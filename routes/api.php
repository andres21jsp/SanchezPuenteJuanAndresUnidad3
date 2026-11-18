<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MovimientoController;

Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:5,1');

Route::middleware('auth:sanctum')->group(function () {

    Route::apiResource('movimientos', MovimientoController::class);

    Route::get('/categorias', function (Request $request) {
        return response()->json(
            $request->user()->categorias()->get()
        );
    });

    Route::post('/logout', [AuthController::class, 'logout']);

});