<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoriaController extends Controller
{
    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:100',
                Rule::unique('categorias')->where(
                    fn ($query) => $query
                        ->where('user_id', $request->user()->id)
                        ->where('tipo', $request->tipo)
                ),
            ],
            'tipo' => 'required|in:ingreso,gasto',
        ]);

        $request->user()->categorias()->create($datos);

        return back()->with('success',
            'Categoría registrada correctamente.');
    }
}