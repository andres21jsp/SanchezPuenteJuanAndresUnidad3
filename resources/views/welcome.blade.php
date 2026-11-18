<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ExpenseFlow | Finanzas personales</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-800 antialiased">

    <nav class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between">

            <div class="flex items-center gap-3">
                <x-application-logo class="w-10 h-10"/>
                <span class="text-xl font-bold">ExpenseFlow</span>
            </div>

            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="bg-emerald-600 text-white px-5 py-3 rounded-xl">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="font-semibold">
                        Iniciar sesión
                    </a>

                    <a href="{{ route('register') }}"
                       class="bg-emerald-600 text-white px-5 py-3 rounded-xl">
                        Crear cuenta
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 py-20">

        <section class="grid lg:grid-cols-2 gap-12 items-center">

            <div>
                <span class="bg-emerald-100 text-emerald-700 px-4 py-2 rounded-full text-sm font-semibold">
                    Finanzas personales inteligentes
                </span>

                <h1 class="text-5xl font-bold leading-tight mt-6">
                    Toma el control de
                    <span class="text-emerald-600">tus finanzas.</span>
                </h1>

                <p class="text-lg text-slate-500 mt-6">
                    Administra tus ingresos, registra tus gastos,
                    organiza tus movimientos y conoce tu situación
                    financiera desde una sola plataforma.
                </p>

                <a href="{{ route('register') }}"
                   class="inline-block bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-4 rounded-xl mt-8 font-semibold">
                    Comenzar ahora
                </a>
            </div>

            <div class="bg-slate-900 rounded-3xl p-8 shadow-xl text-white">

                <p class="text-slate-300">Ejemplo de balance financiero</p>

                <h2 class="text-5xl font-bold mt-3">
                    $4,650.00
                </h2>

                <p class="text-slate-400 mt-2">Saldo disponible · MXN</p>

                <div class="grid grid-cols-2 gap-4 mt-8">

                    <div class="bg-slate-800 rounded-xl p-5">
                        <p class="text-slate-400">Ingresos</p>
                        <p class="text-2xl text-emerald-400 font-bold mt-2">
                            $7,500
                        </p>
                    </div>

                    <div class="bg-slate-800 rounded-xl p-5">
                        <p class="text-slate-400">Gastos</p>
                        <p class="text-2xl text-red-400 font-bold mt-2">
                            $2,850
                        </p>
                    </div>

                </div>
            </div>

        </section>

        <section class="grid md:grid-cols-3 gap-6 mt-20">

            <div class="bg-white p-8 rounded-2xl border shadow-sm">
                <h3 class="text-xl font-bold text-emerald-600">
                    Control financiero
                </h3>
                <p class="text-slate-500 mt-3">
                    Registra y administra todos tus ingresos y gastos.
                </p>
            </div>

            <div class="bg-white p-8 rounded-2xl border shadow-sm">
                <h3 class="text-xl font-bold text-emerald-600">
                    Seguridad
                </h3>
                <p class="text-slate-500 mt-3">
                    Protege tu información mediante autenticación y acceso personalizado.
                </p>
            </div>

            <div class="bg-white p-8 rounded-2xl border shadow-sm">
                <h3 class="text-xl font-bold text-emerald-600">
                    Conversión de divisas
                </h3>
                <p class="text-slate-500 mt-3">
                    Consulta tipos de cambio mediante servicios externos.
                </p>
            </div>

        </section>

    </main>

    <footer class="border-t bg-white py-8 text-center text-slate-500">
        © {{ date('Y') }} ExpenseFlow | Finanzas personales
    </footer>

</body>
</html>