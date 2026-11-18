<x-app-layout>

    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800">
            Editar movimiento
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto px-4">

            <div class="bg-white p-8 rounded-2xl shadow">

                <h2 class="text-2xl font-bold mb-6">
                    Actualizar movimiento
                </h2>

                @if($errors->any())
                    <div class="mb-4 bg-red-100 text-red-700 p-4 rounded-lg">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('movimientos.update', $movimiento->id) }}"
                      method="POST">

                    @csrf
                    @method('PUT')

                    <div class="space-y-4">

                        <div>
                            <label>Concepto</label>
                            <input type="text" name="concepto"
                                   value="{{ old('concepto', $movimiento->concepto) }}"
                                   class="w-full rounded-lg border-gray-300"
                                   required>
                        </div>

                        <div>
                            <label>Monto</label>
                            <input type="number" name="monto"
                                   value="{{ old('monto', $movimiento->monto) }}"
                                   min="0.01" step="0.01"
                                   class="w-full rounded-lg border-gray-300"
                                   required>
                        </div>

                        <div>
                            <label>Tipo de movimiento</label>

                            <select name="tipo"
                                    class="w-full rounded-lg border-gray-300">

                                <option value="ingreso"
                                    @selected(old('tipo', $movimiento->tipo) === 'ingreso')>
                                    Ingreso
                                </option>

                                <option value="gasto"
                                    @selected(old('tipo', $movimiento->tipo) === 'gasto')>
                                    Gasto
                                </option>

                            </select>
                        </div>

                        <div>
                            <label>Categoría</label>

                            <select name="categoria_id"
                                    class="w-full rounded-lg border-gray-300">

                                <option value="">Sin categoría</option>

                                @foreach($categorias as $categoria)

                                    <option value="{{ $categoria->id }}"
                                        @selected(old('categoria_id', $movimiento->categoria_id) == $categoria->id)>

                                        {{ $categoria->nombre }}
                                        ({{ $categoria->tipo }})

                                    </option>

                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label>Fecha</label>

                            <input type="date" name="fecha"
                                   value="{{ old('fecha', $movimiento->fecha->format('Y-m-d')) }}"
                                   class="w-full rounded-lg border-gray-300"
                                   required>
                        </div>

                        <div>
                            <label>Descripción</label>

                            <textarea name="descripcion"
                                      class="w-full rounded-lg border-gray-300">{{ old('descripcion', $movimiento->descripcion) }}</textarea>
                        </div>

                    </div>

                    <div class="flex gap-4 mt-6">

                        <button type="submit"
                                class="bg-emerald-600 text-white px-6 py-3 rounded-lg">
                            Guardar cambios
                        </button>

                        <a href="{{ route('dashboard') }}"
                           class="bg-gray-200 px-6 py-3 rounded-lg">
                            Cancelar
                        </a>

                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>