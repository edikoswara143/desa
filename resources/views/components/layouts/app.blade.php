<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net" />
        <link
            href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600"
            rel="stylesheet"
        />
        <title>@yield('title')</title>
        @livewireStyles @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="scroll-smooth bg-gray-300 antialiased">
        <sectio
            class="mx-auto flex h-screen max-w-sm flex-col bg-gradient-to-b from-slate-200 to-sky-200 px-4 shadow"
        >
        <livewire:components.partial.header/>
            <main class="py-20">
                {{ $slot }}
            </main>
            <livewire:components.partial.bottom-navigation/>
        </section>

        @livewireScripts
    </body>
</html>
