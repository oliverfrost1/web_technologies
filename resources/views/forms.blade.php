


<!DOCTYPE html>
<HTML>

<HEAD>
    <TITLE>Example App</TITLE>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</HEAD>
<body>
  <form method="post" action="{{route("SaveItem")}}" accept-charset="UTF-8">
    @csrf
    <?php
      if (1==1) {
        echo "<h1>$testing</h1><h1>$sigurd</h1>";
      }
    ?>
    <x-ToDoElement title="Learn Laravel" id="1" />
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" placeholder="Skriv dit navn">
    <input type="submit" value="Submit" >
  </form>
</body>
  </HTML
