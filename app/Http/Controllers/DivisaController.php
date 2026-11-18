<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DivisaController extends Controller
{
    public function convertir(Request $request)
    {
        $datos = $request->validate([
            'cantidad' => 'required|numeric|min:0.01|max:999999999',
            'origen' => 'required|in:MXN,USD,EUR,CAD,GBP,JPY',
            'destino' => 'required|in:MXN,USD,EUR,CAD,GBP,JPY|different:origen',
        ]);

        try {
            $origen = $datos['origen'];
            $destino = $datos['destino'];

            $respuesta = Http::timeout(10)
                ->acceptJson()
                ->get("https://api.frankfurter.dev/v2/rate/{$origen}/{$destino}")
                ->throw()
                ->json();

            $tasa = $respuesta['rate'];

            $resultado = round($datos['cantidad'] * $tasa, 2);

            return back()->with('conversion', [
                'cantidad' => $datos['cantidad'],
                'origen' => $origen,
                'destino' => $destino,
                'resultado' => $resultado,
                'tasa' => $tasa,
                'fecha' => $respuesta['date'],
            ]);

        } catch (\Exception $e) {
            return back()->withErrors([
                'divisas' => 'No fue posible consultar el tipo de cambio.'
            ]);
        }
    }
}