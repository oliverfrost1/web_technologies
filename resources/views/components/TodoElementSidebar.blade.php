<div class="sidebar-holder" id="sidebar-holder">
    <a href="{{ route('Main') }}">X</a>
    <form class="sidebar-form" method="post" accept-charset="UTF-8" action="{{ route('updateTodoFields') }}">
        @csrf
        <div class="sidebar-form-row">
            <label for="title">Title</label>
            <input type="text" name="title" value="{{ $todo->title }}" placeholder="title">
        </div>
        <div class="sidebar-form-row">
            <label for="description">Description</label>
            <input type="text" multiple name="description" value="{{ $todo->description }}"
                placeholder="description">
        </div>
        <div class="sidebar-form-row">
            <label for="completed">Completed</label>
            <input type="checkbox" class="toggle-completed" name="completed"
                @if ($todo->completed == '1') checked @endif>
        </div>
        <div class="sidebar-form-row">
            <label for="duedate">Due date</label>
            <input type="date" name="due_date" value="{{ $todo->due_date }}" placeholder="due date">
        </div>
        <input type="hidden" name="id" value="{{ $todo->id }}">
        <div class="sidebar-form-row">
            <input type="submit" class="sidebar-button" value="Update todo">
        </div>
    </form>
    <form method="POST" action="{{ route('deleteTodoElement', $todo->id) }}">@csrf
        <input type="submit" class="sidebar-button" value="Delete todo">
    </form>
</div>
