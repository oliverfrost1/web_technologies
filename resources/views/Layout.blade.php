<!DOCTYPE html>
<html>

<head>
    <title>Todo app</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
    <body>
        <x-top-bar />
        @yield('content')
    </body>
</html>
