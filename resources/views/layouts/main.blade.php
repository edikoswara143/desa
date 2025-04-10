<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- @vite(['resources/js/app.js']) --}}

</head>

<body class="scroll-smooth bg-gray-300 antialiased">
    <section class="mx-auto flex h-screen max-w-sm flex-col bg-gradient-to-b from-slate-200 to-sky-200 px-4 shadow">
        @include('layouts.header')

        <main>
            @yield('content')
        </main>

        @include('layouts.bottomnav')
    </section>
    @livewireScriptConfig
</body>

</html>
