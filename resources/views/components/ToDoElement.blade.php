<div class="todo-element {{ $completed ? 'todo-element-complete' : '' }}" id="{{ $id }}">
    <div class="todo-element-checkbox">
        <form method="post" action="{{ route('changeCompletionStatus', $id) }}" accept-charset="UTF-8"
            id="changeCompletionStatus">
            @csrf
            <input type="hidden" name="todo_id" value="{{ $id }}" />
            <input type="checkbox" class="toggle-completed" id="todoCheckbox"
                @if ($completed === 1) checked @endif onchange="this.form.submit()" />
        </form>
    </div>

    @if ($duedate)
        @php
            $duedateTimestamp = strtotime($duedate);
            $isDue = !empty($duedateTimestamp);
            $isComplete = $completed ? 'todo-due-date-complete' : '';
            $isOverdue = $isDue && !$completed ? 'todo-due-date-overdue' : '';
        @endphp

        <div class="todo-due-date {{ $isComplete }} {{ $isOverdue }}">
            <label>{{ $duedate }}</label>
        </div>
    @endif

    <form method="" class="todo-text" action="{{ route('Main') }}" accept-charset="UTF-8"
        id="openSelectedWindow{{ $id }}">
        <input type="hidden" name="id" value="{{ $id }}">
        <button type="submit" class="todo-title {{ $completed ? 'todo-title-complete' : '' }}">
            {{ $title }}
        </button>
    </form>
</div>
