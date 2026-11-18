<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ExpenseFlow') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-slate-100">

    <div class="min-h-screen flex flex-col justify-center items-center px-4 py-12">

        <a href="/" class="flex flex-col items-center">

            <x-application-logo class="w-20 h-20"/>

            <h1 class="text-3xl font-bold text-slate-800 mt-4">
                ExpenseFlow
            </h1>

            <p class="text-slate-500 mt-2">
                Control inteligente de tus finanzas
            </p>

        </a>

        <div class="w-full sm:max-w-md mt-8 px-8 py-8
                    bg-white shadow-lg rounded-2xl border border-slate-200">

            {{ $slot }}

        </div>

        <p class="text-sm text-slate-400 mt-8">
            © {{ date('Y') }} ExpenseFlow
        </p>

    </div>

</body>
</html>