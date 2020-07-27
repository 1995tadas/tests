<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://kit.fontawesome.com/3c45c07865.js" crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nova+Round&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="wrapper d-flex align-items-stretch" id="app">
        <side-menu-component test-index = "{{route('test.index')}}" test-create="{{route('test.create')}}" home = "{{url('/')}}"
                             url = "{{request()->path()}}" log-in = "{{route('login')}}"
                            @guest
                                register = "{{route('register')}}"
                            @else
                                log-out = "{{route('logout')}}"
                                :user = true
                            @endguest>{{ csrf_field() }}</side-menu-component>
        <main class="flex-grow-1">
            @yield('content')
        </main>
    </div>
</body>
</html>
