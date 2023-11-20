<div class="todo-element {{ $completed ? 'todo-element-complete' : '' }}" id="{{ $id }}">
    <div class="todo-element-checkbox">
        <form method="post" action="{{ route('changeCompletionStatus', $id) }}" accept-charset="UTF-8"
            id="changeCompletionStatus">
            @csrf
            @method('PUT')
            <input type="hidden" name="todo_id" value="{{ $id }}" />
            <input type="checkbox" class="toggle-completed-checkbox" id="todoCheckbox"
                @if ($completed === 1) checked @endif onchange="this.form.submit()" />
        </form>
    </div>

    @if ($duedate)
        @php
            $duedateTimestamp = DateTime::createFromFormat('d/m/Y', $duedate)->getTimestamp();
            $isDue = $duedateTimestamp < time();
            $completeStyling = $completed ? 'todo-element-due-date-complete' : '';
            $overdueStyling = $isDue && !$completed ? 'todo-element-due-date-overdue' : '';
        @endphp
        <div class="todo-element-due-date {{ $completeStyling }} {{ $overdueStyling }}">
            <label>{{ $duedate }}</label>
        </div>
    @endif
    <div class="big-white-text-and-icon-holder">
        <div class="big-white-text {{ $completed ? 'todo-title-complete' : '' }}">
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
                action="{{ route('deleteTodo', $id) }}" accept-charset="UTF-8"
                id="deleteTodoForm-{{ $id }}">
                @csrf
                @method('DELETE')
                <input type="hidden" name="id" value="{{ $id }}">
                <i class="fa-solid fa-trash-can"
                    onclick="document.getElementById('deleteTodoForm-{{ $id }}').submit()"></i>
            </form>
        </div>
    </div>

</div>
