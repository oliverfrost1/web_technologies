@extends('Layout')

@section('content')
    <div class="todo-page-layout">
        <x-TagSidebar :allTags="$allTags" :filterTags="$filterTags" />
        <div class="center-page">

            <form method="post" action="{{ route('SaveItem') }}" accept-charset="UTF-8" id="addItemToTodo">
                @csrf
                <div class="todo-adder-form-layout">
                    <div class="todo-title-and-date-holder">
                        <div class="input-container">
                            <input type="text" class="add-todo-title" id="title" name="title"
                                placeholder="Take the thrash out" required autofocus>
                            <input type="hidden" class="add-todo-date-picker" id="duedate" name="duedate"
                                title="Due date">
                            <input type="button" class="todo-button" value="Add due date" id="dueDateButton">
                            <i class="fa-solid fa-plus todo-button icon"
                                onclick="document.getElementById('addItemToTodo').submit()"></i>

                        </div>
                    </div>
                    @error('createError')
                        <p style="color:red;">{{ $message }}</p>
                    @enderror
                </div>
            </form>

            <div class="button-header">
                <form class="sort-button" method="get" action="{{ route('FilterTodos') }}" accept-charset="UTF-8">
                    <input class="todo-button" type="submit"
                        value="{{ $isSorted ? 'Show Completed Todos' : 'Hide Completed Todos' }}">
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
