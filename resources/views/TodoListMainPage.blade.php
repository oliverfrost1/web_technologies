@extends('Layout')

@section('content')
    <div class="center-page">
        <h1 class="header1">TODO LIST</h1>
        <div class="button-header">
            <form class="sort-button" method="get" accept-charset="UTF-8">
                <input type="submit" formaction="{{$isSorted ? 'SortItems' : '/'}}">
            </form>
        </div>

        <form method="post" action="{{ route('SaveItem') }}" accept-charset="UTF-8" id="addItemToTodo">
            @csrf
            <input type="text" id="title" name="title" placeholder="Title">
            <input type="submit" value="Add Todo">
        </form>
        <br />
        @foreach ($todos as $todo)
            <x-ToDoElement :title="$todo->title" :id="$todo->id" :completed="$todo->completed" />
        @endforeach
    </div>
@stop
