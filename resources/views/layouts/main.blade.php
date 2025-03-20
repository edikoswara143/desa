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
  @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="scroll-smooth antialiased bg-gray-300">
  <section class="mx-auto max-w-sm flex flex-col h-screen bg-gradient-to-b from-slate-200 to-sky-200 shadow px-4">
    @include('layouts.header')

    <main>
      @yield('content')
    </main>

    @include('layouts.bottomnav')
  </section>
</body>

</html>
