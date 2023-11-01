<!DOCTYPE html>
<html>

<head>
    <title>Todo app</title>
    <link rel="stylesheet" href="{{ asset('css/shared.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/todo-element.css') }}">
    <script src="https://kit.fontawesome.com/e16fd4e2a9.js" crossorigin="anonymous"></script>
</head>

<body>
    <x-TopBar />
    @yield('content')
</body>
<footer>
    <script src="{{ asset('js/app.js') }}" defer></script>
</footer>

</html>
