@props(['allTags', 'filterTags', 'isSorted'])
<aside class="sidebar-holder">
    <label class="sidebar-label" for="tags"><i class="fa-solid fa-filter"></i> Filters</label>
    <form method="get" action="{{ route('filter-todos') }}" accept-charset="UTF-8">
        <input id="hide-completed" class="sidebar-button" type="submit"
            value="{{ $isSorted ? 'Show Completed Todos' : 'Hide Completed Todos' }}">
    </form>
    <br />
    <label class="sidebar-label" for="tags"><i class="fa-solid fa-tags"></i> Tags</label>
    @foreach ($allTags as $tag)
        <div class="center-vertically-flex">
            <form method="get" action="{{ route('filterByTags') }}" accept-charset="UTF-8"
                class="center-vertically-flex">
                <input type="hidden" name="tag" value="{{ $tag->id }}">
                <input type="checkbox" name="tag" class="toggle-completed-checkbox" value="{{ $tag->id }}"
                    id="tag-checkbox" @if (in_array($tag->id, (array) $filterTags)) checked @endif>
            </form>
            <form method="post" action={{ route('updateTag', ['id' => $tag->id]) }} accept-charset="UTF-8"
                class="center-vertically-flex" id="editTag-{{ $tag->id }}">
                @csrf
                @method('PUT')
                <label class="sidebar-label" id="tagLabel-{{ $tag->id }}">{{ $tag->name }}</label>
                <input type="hidden" name="tagId" value="{{ $tag->id }}">
                <input type="text" name="tagName" class="text-input-container add-todo-title"
                    id="editField-{{ $tag->id }}" style="display: none;" value="{{ $tag->name }}">
                <i class="fa-solid fa-pen-to-square element-icon icon-color"  data-tag-id="{{ $tag->id }}"
                    id="enable-edit-field-icon"></i>
            </form>
            <form method="post" action={{ route('removeTag', ['id' => $tag->id]) }} accept-charset="UTF-8"
                class="center-vertically-flex element-icon" id="removeTag-{{ $tag->id }}">
                @csrf
                @method('DELETE')
                <input type="hidden" name="id" value="{{ $tag->id }}">
                <i class="fa-solid fa-trash-can" id="delete-tag-icon" data-tag-id="{{ $tag->id }}"></i>
            </form>
        </div>
    @endforeach
    <script src="{{ asset('js/leftSidebarTagCRUDHandler.js') }}" defer></script>

</aside>
