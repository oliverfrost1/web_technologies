<div class="todo-element {{ $completed ? 'todo-element-complete' : '' }}" id="{{ $id }}">
    <div class="todo-element-checkbox">
        <form method="post" action="{{ route('changeCompletionStatus', $id) }}" accept-charset="UTF-8" id="addItemToTodo">
            @csrf
            <input type="hidden" name="todo_id" value="{{ $id }}" />
            <input type="checkbox" id="todoCheckbox" @if ($completed === 1) checked @endif
                onchange="this.form.submit()" />
        </form>
    </div>
    <div class="todo-due-date {{ $completed ? 'todo-due-date-complete' : '' }}">
        <label id="dueDate">04/10</label>
    </div>
    <form method="get" class="todo-text" action="{{ route('forms', [], ['id' => $id]) }}" accept-charset="UTF-8"
        id="openSelectedWindow">
        <div class="todo-title {{ $completed ? 'todo-title-complete' : '' }}"
            onclick="document.getElementById('openSelectedWindow').submit()">
            {{ $title }}
        </div>
    </form>



    <form method="post" action="{{ route('deleteTodoElement', $id) }}" accept-charset="UTF-8" id="deleteTodoElement">
        @csrf
        <input type="hidden" name="todo_id" value="{{ $id }}" />
        <button type="submit" id="todoCheckbox">Slet</button>
    </form>
</div>
