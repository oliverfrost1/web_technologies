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
    <div class="todo-element-text-and-icon-holder">
        <div class="todo-element-text {{ $completed ? 'todo-title-complete' : '' }}">
            {{ $title }}
        </div>


        <div class="element-icon-container">
            <form method="get" action="{{ route('Main') }}" accept-charset="UTF-8"
                class="element-icon {{ $completed ? 'todo-element-icon-complete' : '' }}"
                id="openSelectedWindow{{ $id }}">
                <input type="hidden" name="id" value="{{ $id }}">
                <i class="fa-solid fa-pen-to-square " style="color:white"
                    onclick="document.getElementById('openSelectedWindow{{ $id }}').submit()"></i>
            </form>
            <form method="post" class="element-icon {{ $completed ? 'todo-element-icon-complete' : '' }}"
                action="{{ route('deleteTodoElement', $id) }}" accept-charset="UTF-8"
                id="deleteTodoForm-{{ $id }}">
                @csrf
                <input type="hidden" name="id" value="{{ $id }}">
                <i class="fa-solid fa-trash-can"
                    onclick="document.getElementById('deleteTodoForm-{{ $id }}').submit()"></i>
            </form>
        </div>
    </div>

</div>
