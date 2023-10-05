<div class="sidebar-holder" id="sidebar-holder">
    <a href="{{ route('Main') }}">X</a>
    <form class="sidebar-form">
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
            <input type="checkbox" class="toggle-completed" name="completed" value="{{ $todo->completed }}">
        </div>
        <div class="sidebar-form-row">
            <label for="duedate">Due date</label>
            <input type="date" name="duedate" value="{{ $todo->duedate }}" placeholder="due date">
        </div>
        <div class="sidebar-form-row">
            <input type="submit" class="sidebar-button" value="Update todo">
            <input type="reset" class="sidebar-button">
        </div>
    </form>
    <form><input type="submit" class="sidebar-button" value="Delete todo"></form>
</div>
