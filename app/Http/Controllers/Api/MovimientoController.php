<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MovimientoController extends Controller
{
    private function validar(Request $request)
    {
        return $request->validate([
            'concepto' => 'required|string|max:150',
            'monto' => 'required|numeric|min:0.01|max:9999999999.99|decimal:0,2',
            'tipo' => 'required|in:ingreso,gasto',
            'fecha' => 'required|date',
            'descripcion' => 'nullable|string|max:1000',
            'categoria_id' => [
                'nullable',
                Rule::exists('categorias', 'id')->where(
                    fn ($query) => $query
                        ->where('user_id', $request->user()->id)
                        ->where('tipo', $request->tipo)
                ),
            ],
        ]);
    }

    public function index(Request $request)
    {
        $movimientos = $request->user()->movimientos()
            ->with('categoria')
            ->orderByDesc('fecha')
            ->get();

        return response()->json($movimientos);
    }

    public function store(Request $request)
    {
        $movimiento = $request->user()->movimientos()
            ->create($this->validar($request));

        return response()->json([
            'message' => 'Movimiento registrado',
            'data' => $movimiento
        ], 201);
    }

    public function show(Request $request, $id)
    {
        $movimiento = $request->user()->movimientos()
            ->with('categoria')
            ->findOrFail($id);

        return response()->json($movimiento);
    }

    public function update(Request $request, $id)
    {
        $movimiento = $request->user()->movimientos()
            ->findOrFail($id);

        $movimiento->update($this->validar($request));

        return response()->json([
            'message' => 'Movimiento actualizado',
            'data' => $movimiento
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $movimiento = $request->user()->movimientos()
            ->findOrFail($id);

        $movimiento->delete();

        return response()->json([
            'message' => 'Movimiento eliminado'
        ]);
    }
}