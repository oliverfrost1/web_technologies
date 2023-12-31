@props(['todo', 'tags', 'unselectedTags'])

<aside class="sidebar-holder" id="sidebar-holder">
    @if ($todo)
        <a href="{{ route('main') }}"><i class="fa-solid fa-circle-xmark icon-color"></i></a>
        <form class="sidebar-form" method="post" accept-charset="UTF-8"
            action="{{ route('updateTodoFields', ['id' => $todo->id]) }}">
            @csrf
            @method('PUT')
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
                <input type="checkbox" class="toggle-completed-checkbox" name="completed"
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
        <div class="sidebar-tag">
            <div class="sidebar-form-row">
                <label class="sidebar-label" for="tag">Manage Tags</label>
                <div class="tag-holder">
                    @foreach ($tags as $tag)
                        <form class="sidebar-form"
                            action="{{ route('removeTagFromTodo', ['todoId' => $todo->id, 'tagId' => $tag->id]) }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="todo-button tag-button">{{ $tag->name }} <span
                                    class="remove-icon">X</span></button>
                            <input type="hidden" name="tagid" value="{{ $tag->id }}">
                            <input type="hidden" name="todoid" value="{{ $todo->id }}">
                        </form>
                    @endforeach
                </div>
                <form class="sidebar-form" id="add-tag-form" action="{{ route('addNewTag', ['id' => $todo->id]) }}"
                    method="post">
                    @csrf
                    <input list="tag-choices" id="tagName" name="tagName" autocomplete="off" required />
                    <datalist id="tag-choices">
                        @foreach ($unselectedTags as $unselectedTag)
                            <option value="{{ $unselectedTag->name }}"></option>
                        @endforeach
                    </datalist>
                    <input type="hidden" name="todoid" value="{{ $todo->id }}">
                </form>
            </div>
        </div>
    @else
        <div class="sidebar-label">Click on <i class="fa-solid fa-pen-to-square icon-color"></i> of a todo to
            edit it.</div>
    @endif
    <script src="{{ asset('js/rightSidebarTagHandler.js') }}" defer></script>
</aside>
