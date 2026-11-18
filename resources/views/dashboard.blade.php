<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800">
            ExpenseFlow | Panel financiero
        </h2>
    </x-slot>

    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8">
                <h1 class="text-3xl font-bold text-slate-800">
                    Hola, {{ Auth::user()->name }}
                </h1>
                <p class="text-slate-500">
                    Administra tus finanzas personales.
                </p>
            </div>

            @if(session('success'))
                <div class="mb-6 bg-emerald-100 text-emerald-800 p-4 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 bg-red-100 text-red-700 p-4 rounded-xl">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- Indicadores financieros -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                <div class="bg-emerald-700 text-white p-6 rounded-2xl shadow">
                    <p class="text-emerald-100">Saldo disponible</p>
                    <h2 class="text-3xl font-bold mt-2">
                        ${{ number_format($saldo, 2) }}
                    </h2>
                    <p class="text-sm mt-2">MXN</p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow">
                    <p class="text-slate-500">Total de ingresos</p>
                    <h2 class="text-3xl font-bold text-emerald-600 mt-2">
                        ${{ number_format($ingresos, 2) }}
                    </h2>
                    <p class="text-sm text-slate-400 mt-2">MXN</p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow">
                    <p class="text-slate-500">Total de gastos</p>
                    <h2 class="text-3xl font-bold text-red-500 mt-2">
                        ${{ number_format($gastos, 2) }}
                    </h2>
                    <p class="text-sm text-slate-400 mt-2">MXN</p>
                </div>

            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

                <!-- Formulario de movimientos -->
                <div class="lg:col-span-2 bg-white rounded-2xl shadow p-6">

                    <h2 class="text-xl font-bold mb-6">
                        Nuevo movimiento
                    </h2>

                    <form action="{{ route('movimientos.store') }}"
                          method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <div>
                                <label class="block text-sm font-medium mb-1">
                                    Concepto
                                </label>

                                <input type="text" name="concepto"
                                       value="{{ old('concepto') }}"
                                       placeholder="Ej. Pago de nómina"
                                       class="w-full rounded-lg border-gray-300"
                                       required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1">
                                    Monto (MXN)
                                </label>

                                <input type="number" name="monto"
                                       value="{{ old('monto') }}"
                                       step="0.01" min="0.01"
                                       placeholder="0.00"
                                       class="w-full rounded-lg border-gray-300"
                                       required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1">
                                    Tipo de movimiento
                                </label>

                                <select name="tipo"
                                        class="w-full rounded-lg border-gray-300">
                                    <option value="ingreso">Ingreso</option>
                                    <option value="gasto">Gasto</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1">
                                    Categoría
                                </label>

                                <select name="categoria_id"
                                        class="w-full rounded-lg border-gray-300">
                                    <option value="">Sin categoría</option>

                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id }}">
                                            {{ $categoria->nombre }}
                                            ({{ $categoria->tipo }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1">
                                    Fecha
                                </label>

                                <input type="date" name="fecha"
                                       value="{{ old('fecha', date('Y-m-d')) }}"
                                       class="w-full rounded-lg border-gray-300"
                                       required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1">
                                    Descripción
                                </label>

                                <input type="text" name="descripcion"
                                       value="{{ old('descripcion') }}"
                                       placeholder="Información adicional"
                                       class="w-full rounded-lg border-gray-300">
                            </div>

                        </div>

                        <button type="submit"
                                class="mt-6 bg-emerald-600 hover:bg-emerald-700
                                       text-white px-6 py-3 rounded-lg font-semibold">
                            Guardar movimiento
                        </button>

                    </form>
                </div>

                <!-- Formulario de categorías -->
                <div class="bg-white rounded-2xl shadow p-6">

                    <h2 class="text-xl font-bold mb-6">
                        Nueva categoría
                    </h2>

                    <form action="{{ route('categorias.store') }}"
                          method="POST">
                        @csrf

                        <label class="block text-sm font-medium mb-1">
                            Nombre
                        </label>

                        <input type="text" name="nombre"
                               placeholder="Ej. Transporte"
                               class="w-full rounded-lg border-gray-300 mb-4"
                               required>

                        <label class="block text-sm font-medium mb-1">
                            Tipo
                        </label>

                        <select name="tipo"
                                class="w-full rounded-lg border-gray-300 mb-4">
                            <option value="ingreso">Ingreso</option>
                            <option value="gasto">Gasto</option>
                        </select>

                        <button type="submit"
                                class="w-full bg-slate-800 hover:bg-slate-900
                                       text-white py-3 rounded-lg">
                            Crear categoría
                        </button>
                    </form>

                </div>

            </div>

            <!-- Convertidor de divisas -->
<div class="bg-white rounded-2xl shadow p-6 mb-8">

    <h2 class="text-xl font-bold text-slate-800">
        Convertidor de divisas
    </h2>

    <p class="text-sm text-slate-500 mb-6">
        Tipos de cambio de referencia proporcionados por Frankfurter API.
    </p>

    <form action="{{ route('divisas.convertir') }}" method="POST">

        @csrf

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <div>
                <label class="block text-sm font-medium mb-1">
                    Cantidad
                </label>

                <input type="number" name="cantidad"
                       min="0.01" step="0.01"
                       placeholder="1000.00"
                       class="w-full rounded-lg border-gray-300"
                       required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">
                    Moneda de origen
                </label>

                <select name="origen"
                        class="w-full rounded-lg border-gray-300">

                    <option value="MXN">MXN - Peso mexicano</option>
                    <option value="USD">USD - Dólar</option>
                    <option value="EUR">EUR - Euro</option>
                    <option value="CAD">CAD - Dólar canadiense</option>
                    <option value="GBP">GBP - Libra esterlina</option>
                    <option value="JPY">JPY - Yen japonés</option>

                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">
                    Moneda de destino
                </label>

                <select name="destino"
                        class="w-full rounded-lg border-gray-300">

                    <option value="USD">USD - Dólar</option>
                    <option value="MXN">MXN - Peso mexicano</option>
                    <option value="EUR">EUR - Euro</option>
                    <option value="CAD">CAD - Dólar canadiense</option>
                    <option value="GBP">GBP - Libra esterlina</option>
                    <option value="JPY">JPY - Yen japonés</option>

                </select>
            </div>

        </div>

        <button type="submit"
                class="mt-5 bg-emerald-600 hover:bg-emerald-700
                       text-white px-6 py-3 rounded-lg font-semibold">
            Convertir divisas
        </button>

    </form>

    @if(session('conversion'))

        @php
            $c = session('conversion');
        @endphp

        <div class="mt-6 bg-emerald-50 border border-emerald-200
                    rounded-xl p-6">

            <p class="text-sm text-emerald-700">
                Resultado de la conversión
            </p>

            <h3 class="text-3xl font-bold text-emerald-800 mt-2">

                {{ number_format($c['cantidad'], 2) }}
                {{ $c['origen'] }}

                =

                {{ number_format($c['resultado'], 2) }}
                {{ $c['destino'] }}

            </h3>

            <p class="text-sm text-slate-600 mt-3">
                Tipo de cambio: {{ $c['tasa'] }}
            </p>

            <p class="text-sm text-slate-600">
                Fecha de referencia: {{ $c['fecha'] }}
            </p>

            <p class="text-xs text-slate-400 mt-2">
                Fuente: Frankfurter API
            </p>

        </div>

    @endif

</div>

            <!-- Historial de movimientos -->
            <div class="bg-white rounded-2xl shadow p-6">

                <h2 class="text-xl font-bold mb-6">
                    Historial de movimientos
                </h2>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">

                        <thead class="bg-slate-100 text-slate-600">
                            <tr>
                                <th class="p-4">Concepto</th>
                                <th class="p-4">Categoría</th>
                                <th class="p-4">Fecha</th>
                                <th class="p-4">Tipo</th>
                                <th class="p-4">Monto</th>
                                <th class="p-4">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($movimientos as $movimiento)

                                <tr class="border-b hover:bg-slate-50">

                                    <td class="p-4 font-medium">
                                        {{ $movimiento->concepto }}
                                    </td>

                                    <td class="p-4">
                                        {{ $movimiento->categoria?->nombre ?? 'Sin categoría' }}
                                    </td>

                                    <td class="p-4">
                                        {{ $movimiento->fecha->format('d/m/Y') }}
                                    </td>

                                    <td class="p-4">
                                        <span class="px-3 py-1 rounded-full
                                            {{ $movimiento->tipo === 'ingreso'
                                                ? 'bg-green-100 text-green-700'
                                                : 'bg-red-100 text-red-700' }}">
                                            {{ ucfirst($movimiento->tipo) }}
                                        </span>
                                    </td>

                                    <td class="p-4 font-semibold
                                        {{ $movimiento->tipo === 'ingreso'
                                            ? 'text-green-600'
                                            : 'text-red-600' }}">

                                        {{ $movimiento->tipo === 'ingreso' ? '+' : '-' }}
                                        ${{ number_format($movimiento->monto, 2) }}

                                    </td>

                                    <td class="p-4">

                                        <div class="flex gap-4">

                                            <a href="{{ route('movimientos.edit', $movimiento->id) }}"
                                               class="text-blue-600 font-semibold">
                                                Editar
                                            </a>

                                            <form action="{{ route('movimientos.destroy', $movimiento->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('¿Eliminar este movimiento?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="text-red-600 font-semibold">
                                                    Eliminar
                                                </button>
                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="6" class="p-10 text-center text-gray-400">
                                        Todavía no tienes movimientos registrados.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>