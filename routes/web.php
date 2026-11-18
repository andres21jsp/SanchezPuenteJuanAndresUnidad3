<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MovimientoController;
use App\Http\Controllers\CategoriaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DivisaController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [
        DashboardController::class, 'index'
    ])->name('dashboard');

    Route::resource('movimientos', MovimientoController::class)
        ->only(['store', 'edit', 'update', 'destroy']);

    Route::post('/categorias', [
        CategoriaController::class, 'store'
    ])->name('categorias.store');

    Route::get('/profile', [
        ProfileController::class, 'edit'
    ])->name('profile.edit');

    Route::patch('/profile', [
        ProfileController::class, 'update'
    ])->name('profile.update');

    Route::delete('/profile', [
        ProfileController::class, 'destroy'
    ])->name('profile.destroy');

    Route::post('/divisas/convertir', [
    DivisaController::class, 'convertir'
])->name('divisas.convertir')->middleware('throttle:30,1');
});

require __DIR__.'/auth.php';