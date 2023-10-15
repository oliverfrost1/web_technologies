@props(['todo', 'tags', 'unselectedTags'])

<div class="sidebar-holder" id="sidebar-holder">
    <a href="{{ route('Main') }}"><i class="fa-regular fa-circle-xmark" style="color: #ffffff;"></i></a>
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
    <div class="sidebar-tag">
        <div class="sidebar-form-row">
            <label class="sidebar-label" for="tag">Tag</label>
            @foreach ($tags as $tag)
                <form class="sidebar-form" action="{{route('removeTag')}}" method="POST">
                    @csrf
                    <button class="add-todo-button tag-button">{{ $tag->name }} <span class="remove-icon">X</span></button>
                    <input type="hidden" name="tagid" value="{{ $tag->id }}">
                    <input type="hidden" name="todoid" value="{{ $todo->id }}">
                </form>
            @endforeach
            <form class="sidebar-form" id="add-tag-form" action="{{ route('addNewTag') }}" method="post">
                @csrf
                <input list="tag-choices" id="tagName" name="tagName" autocomplete="off" required/>
                <datalist id="tag-choices">
                    @foreach ($unselectedTags as $unselectedTag)
                        <option value="{{$unselectedTag->name}}"></option>
                    @endforeach
                </datalist>
                <input type="hidden" name="todoid" value="{{ $todo->id }}">
            </form>
        </div>
        <script>
            const toggleButton = document.getElementById('toggle-tag-input');
            const tagInput = document.getElementById('tag-choices');
            const addTagForm = document.getElementById('add-tag-form');

            tagInput.addEventListener('keydown', function (event) {
                if (event.key === 'Enter' && tagInput.value.trim() !== '') {
                    // Prevent the default Enter key behavior (e.g., new line in textarea)
                    event.preventDefault();
                    addTagForm.submit();
                }
            });

            toggleButton.addEventListener('click', function () {
                toggleButton.style.display = 'none';
                tagInput.style.display = 'block';
                tagInput.focus();
            });

            tagInput.addEventListener('blur', function () {
                if (tagInput.value === '') {
                    toggleButton.style.display = 'block';
                    tagInput.style.display = 'none';
                }
            });
        </script>
    </div>
</div>
