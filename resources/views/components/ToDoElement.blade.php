<div class="todo-element {{ $completed ? 'todo-element-complete' : '' }}" id="{{ $id }}">
    <div class="todo-element-checkbox">
        <form method="post" action="{{ route('changeCompletionStatus', $id) }}" accept-charset="UTF-8" id="addItemToTodo">
            @csrf
            <input type="hidden" name="todo_id" value="{{ $id }}" />
            <input type="checkbox" id="todoCheckbox" @if ($completed === 1) checked @endif
                onchange="this.form.submit()" />
        </form>
    </div>

    @if ($duedate)
        <div class="todo-due-date {{ $completed ? 'todo-due-date-complete' : '' }}">
            <label>{{ $duedate }}</label>
        </div>
    @endif

    <form method="get" class="todo-text" action="{{ route('Main') }}" accept-charset="UTF-8"
        id="openSelectedWindow{{ $id }}">
        <input type="hidden" name="id" value="{{ $id }}">
        <button type="submit" class="todo-title {{ $completed ? 'todo-title-complete' : '' }}">
            {{ $title }}
        </button>
    </form>
</div>
