<!DOCTYPE html>
<html>

<head>
    <title>Example App</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
  <h1>Todo list</h1>
  <form method="post" action="{{ route('SaveItem') }}" accept-charset="UTF-8" id="addItemToTodo">
    @csrf
    @foreach ($todos as $todo)
      <x-ToDoElement :title="$todo" :id="$todo" />
    @endforeach
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" placeholder="Skriv dit navn">
    <input type="submit" value="Submit">
  </form>
</body>

</html>
