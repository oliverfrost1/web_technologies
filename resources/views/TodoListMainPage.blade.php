@extends('Layout')

@section('content')
    <div class="todo-page-layout">
        <div class="center-page">
            <h1 class="header1">TODO LIST</h1>
            <div class="button-header">
                <form class="sort-button" method="get" action="{{ route('Main') }}" accept-charset="UTF-8">
                    <input class="sort-button" type="submit" value="{{ $isSorted ? 'Show All' : 'Hide Completed' }}">
                    <?php
                        Cookie::queue(Cookie::make('isSorted',$isSorted))
                    ?>
                </form>
            </div>

            <form method="post" action="{{ route('SaveItem') }}" accept-charset="UTF-8" id="addItemToTodo">
                @csrf
                <input type="text" id="title" name="title" placeholder="Title">
                <input type="date" id="duedate" name="duedate">
                <input type="submit" value="Add Todo">
            </form>
            <br />
            @foreach ($todos->sortBy('due_date')->sortBy('completed') as $todo)
                <x-ToDoElement :title="$todo->title" :id="$todo->id" :completed="$todo->completed" :duedate="$todo->due_date ? date('d/m/Y', strtotime($todo->due_date)) : ''" />
            @endforeach

        </div>
        @foreach ($todos as $todo)
            @if ($todo->id == $openedId)
                <div class="sidebar-holder">
                    <x-TodoElementSidebar :title="$todo->title" :id="$todo->id" :completed="$todo->completed" :duedate="$todo->due_date" />
                </div>
            @break
        @endif
    @endforeach

    <div>
    @stop
