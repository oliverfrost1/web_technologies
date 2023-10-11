<!DOCTYPE html>
<html>

<head>
    <title>Todo app</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://kit.fontawesome.com/e16fd4e2a9.js" crossorigin="anonymous"></script>
</head>

<body>
    <x-top-bar />
    @yield('content')
</body>

</html>
