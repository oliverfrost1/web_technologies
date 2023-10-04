<div class="sidebar-holder">
    <a href="{{ route('Main') }}">X</a>
    <form>
        <div>{{ $todo->due_date }}{{ $todo->duedate }}{{ $todo->duedate }}</div>
        <div>testing</div>
        <div>{{ $todo->title }}</div>
        <div>{{ $todo->id }}</div>
        <div>{{ $todo->completed }}</div>
        <input type="text" name="title" value="{{ $todo->title }}" placeholder="title">
        <input type="text" name="description" value="{{ $todo->description }}" placeholder="description">
        <input type="checkbox" name="completed">
        <input type="date" name="duedate" value="{{ $todo->duedate }}" placeholder="due date">
        <button>Update fields</button>
    </form>
</div>
