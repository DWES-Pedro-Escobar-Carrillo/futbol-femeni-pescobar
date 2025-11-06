<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }} - Guia Futbol Femení</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 min-h-screen flex-col">

        <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 mx-auto">
            {{-- Incloem el menú de navegació --}}
            @include('partials.menu')
        </header>

        <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
            <main class="w-full max-w-[335px] lg:max-w-4xl">

                {{-- Aquí es carregaran els missatges d'èxit o error --}}
                @include('partials.messages')

                {{-- Aquí es carregarà el contingut de cada pàgina --}}
                @yield('content')

            </main>
        </div>

    </body>
</html>