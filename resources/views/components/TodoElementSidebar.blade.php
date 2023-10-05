@props(['todo', 'tags']);

<div class="sidebar-holder" id="sidebar-holder">
    <a href="{{ route('Main') }}">X</a>
    <div class="sidebar-tag">
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
        <div class="sidebar-form-row">
            <label for="tag">Tag</label>

            @foreach ($tags as $tag)
                <button>{{ $tag->name }}</button>
            @endforeach

            <button id="toggle-tag-input">Add Tag</button>
            <form id="add-tag-form" action="{{ route('addNewTag') }}" method="post">
                @csrf
                <input type="text" name="tagName" id="tag-input" placeholder="Enter Tag Name" style="display: none;">
                <input type="hidden" name="todoid" value="{{ $todo->id }}">
                <button type="submit">Create Tag</button>
            </form>
        </div>

        <!-- JavaScript to toggle the visibility of the button and input field -->
        <script>
            const toggleButton = document.getElementById('toggle-tag-input');
            const tagInput = document.getElementById('tag-input');

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
    <form><input type="submit" class="sidebar-button" value="Delete todo"></form>

</div>
