<?php

namespace App\Http\Controllers;

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

    public function store(Request $request)
    {
        $request->user()->movimientos()
            ->create($this->validar($request));

        return back()->with('success',
            'Movimiento registrado correctamente.');
    }

    public function edit(Request $request, $id)
    {
        $movimiento = $request->user()
            ->movimientos()->findOrFail($id);

        $categorias = $request->user()->categorias()->get();

        return view('movimientos.edit', compact(
            'movimiento', 'categorias'
        ));
    }

    public function update(Request $request, $id)
    {
        $movimiento = $request->user()
            ->movimientos()->findOrFail($id);

        $movimiento->update($this->validar($request));

        return redirect()->route('dashboard')
            ->with('success', 'Movimiento actualizado.');
    }

    public function destroy(Request $request, $id)
    {
        $movimiento = $request->user()
            ->movimientos()->findOrFail($id);

        $movimiento->delete();

        return back()->with('success',
            'Movimiento eliminado correctamente.');
    }
}