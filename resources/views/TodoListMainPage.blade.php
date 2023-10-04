@extends('Layout')

@section('content')
    <div class="center-page">
        <h1 class="header1">TODO LIST</h1>
        <form method="post" action="{{ route('SaveItem') }}" accept-charset="UTF-8" id="addItemToTodo">
            @csrf
            <input type="text" id="title" name="title" placeholder="Title">
            <input type="submit" value="Add Todo">
        </form>
        <br />
        @foreach ($todos->sortBy('completed') as $todo)
            <x-ToDoElement :title="$todo->title" :id="$todo->id" :completed="$todo->completed" />
        @endforeach
    </div>
@stop
