<div class="todo-element {{ $completed ? 'todo-element-complete' : '' }}" id="{{ $id }}">
    <div class="todo-element-checkbox">
        <form method="post" action="{{ route('changeCompletionStatus', $id) }}" accept-charset="UTF-8"
            id="changeCompletionStatus">
            @csrf
            <input type="hidden" name="todo_id" value="{{ $id }}" />
            <input type="checkbox" class="toggle-completed" id="todoCheckbox"
                @if ($completed === 1) checked @endif onchange="this.form.submit()" />
        </form>
        <form method="post" action="{{route('test')}}" accept-charset="UTF-8">
            @csrf
            <input type="hidden" name="todoid" value="{{ $id }}">
            <input type="hidden" name="tagid[]" value="{{ 1 }}">
            <input type="submit" value="Test">
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
