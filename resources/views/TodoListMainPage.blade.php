@extends('Layout')

@section('content')
    <div class="todo-page-layout">
        <x-LeftSidebar :allTags="$allTags" :filterTags="$filterTags" :isSorted="$isSorted" />
        <div class="center-page">
            <form method="post" action="{{ route('createTodoElement') }}" accept-charset="UTF-8" id="addItemToTodo">
                @csrf
                <div class="todo-adder-form-layout">
                    <div class="todo-title-and-date-holder">
                        <div class="text-input-container">
                            <input type="text" class="add-todo-title" id="title" name="title"
                                placeholder="Take the trash out" required autofocus>
                            <input type="hidden" class="add-todo-date-picker" id="duedate" name="duedate"
                                title="Due date">
                            <i id="dueDateButton" class="fa-regular fa-clock todo-button icon"></i>
                            <i class="fa-solid fa-plus todo-button icon" id="plus-icon-add-todo"></i>
                        </div>
                    </div>
                    @error('createError')
                        <p style="color:red;">{{ $message }}</p>
                    @enderror
                </div>
            </form>
            <br />
            <div class="todolist-holder">
                @php
                    $lastUserId = null;
                @endphp

                @foreach ($todos->sortBy('due_date')->sortBy('completed')->sortBy('user_id') as $index => $todo)
                    @if ($lastUserId !== $todo->user_id && $todo->user_email)
                        <div class="big-white-text padding-top-and-bottom">UID:
                            {{ $todo->user_id }} - {{ $todo->user_email }}</div>
                        @php
                            $lastUserId = $todo->user_id;
                        @endphp
                    @endif

                    <x-ToDoElement :title="$todo->title" :id="$todo->id" :completed="$todo->completed" :userid="$todo->user_email ? $todo->user_id : null"
                        :duedate="$todo->due_date ? date('d/m/Y', strtotime($todo->due_date)) : ''" />
                @endforeach
            </div>
        </div>

        <x-RightSidebar :todo="$todos->find($openedId)" :tags="$tags" :unselectedTags="$unselectedTags" />
        <script src="{{ asset('js/mainPage.js') }}" defer></script>
        <script src="{{ asset('js/todoElement.js') }}" defer></script>
    </div>
@stop
