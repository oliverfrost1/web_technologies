@extends('Layout')

@section('content')
    <div class="todo-page-layout">
        <div class="center-page">
            <h1 class="title">Todo List</h1>

            <form method="post" action="{{ route('SaveItem') }}" accept-charset="UTF-8" id="addItemToTodo">
                @csrf
                <div class="todo-title-and-date-holder">
                    <div class="input-container">
                        <input type="text" class="add-todo-title" id="title" name="title"
                            placeholder="Take the thrash out" required autofocus>
                        <input type="date" class="add-todo-date-picker" id="duedate" name="duedate" title="Due date">
                    </div>
                </div>

                <div class="center-children-in-parent">
                    <input type="submit" class="add-todo-button" value="Add Todo">
                </div>
            </form>

            <div class="button-header">
                <form class="sort-button" method="get" action="{{ route('FilterTodos') }}" accept-charset="UTF-8">
                    <input class="sort-button" type="submit" value="{{ $isSorted ? 'Hide Completed' : 'Show All' }}">
                </form>
            </div>

            <br />
            <div class="todolist-holder">
                @foreach ($todos->sortBy('due_date')->sortBy('completed') as $todo)
                    <x-ToDoElement :title="$todo->title" :id="$todo->id" :completed="$todo->completed" :duedate="$todo->due_date ? date('d/m/Y', strtotime($todo->due_date)) : ''" />
                @endforeach
            </div>

        </div>

        @foreach ($todos as $todo)
            @if ($todo->id == $openedId)
                <x-TodoElementSidebar :todo="$todo" :tags="$tags" :unselectedTags="$unselectedTags" />
            @break
        @endif
    @endforeach


</div>
@stop
