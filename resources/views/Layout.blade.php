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
    @foreach (glob(resource_path('views/modals/*.blade.php')) as $file)
        @include('modals.'.basename($file, '.blade.php'))
    @endforeach
    <x-TopBar />
    @yield('content')
</body>

</html>