<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $usuario = $request->user();

        $ingresos = $usuario->movimientos()
            ->where('tipo', 'ingreso')->sum('monto');

        $gastos = $usuario->movimientos()
            ->where('tipo', 'gasto')->sum('monto');

        $saldo = $ingresos - $gastos;

        $movimientos = $usuario->movimientos()
            ->with('categoria')
            ->orderByDesc('fecha')
            ->orderByDesc('id')
            ->get();

        $categorias = $usuario->categorias()
            ->orderBy('nombre')->get();

        return view('dashboard', compact(
            'ingresos',
            'gastos',
            'saldo',
            'movimientos',
            'categorias'
        ));
    }
}