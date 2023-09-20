<!DOCTYPE html>
<html>
  <head>
      <title>Example App</title>
      <link rel="stylesheet" href="{{ asset('css/app.css') }}">
      <script src="{{ asset('js/app.js') }}" defer></script>
  </head>
  <body>
    <div class="center-page">
      <h1 class="header1">TODO LIST</h1>
      <form method="post" action="{{ route('SaveItem') }}" accept-charset="UTF-8" id="addItemToTodo">
          @csrf
          <input type="text" id="title" name="title" placeholder="Title">
          <input type="submit" value="Add Todo">
      </form>
      <br/>
      @foreach ($todos as $todo)
        <x-ToDoElement :title="$todo" :id="$todo" />
      @endforeach
    </div>
  </body>
</html>
