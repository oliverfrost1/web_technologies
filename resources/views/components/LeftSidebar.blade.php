@props(['allTags', 'filterTags', 'isSorted'])
<div class="sidebar-holder">
    <label class="sidebar-label" for="tags"><i class="fa-solid fa-filter"></i> Filters</label>
    <form class="sort-button" method="get" action="{{ route('FilterTodos') }}" accept-charset="UTF-8">
        <input class="sidebar-button" type="submit"
            value="{{ $isSorted ? 'Show Completed Todos' : 'Hide Completed Todos' }}">
    </form>
    <br />
    <label class="sidebar-label" for="tags"><i class="fa-solid fa-tags"></i> Tags</label>
    @foreach ($allTags as $tag)
        <div class="center-vertically-flex">
            <form method="get" action="{{ route('filterByTags') }}" accept-charset="UTF-8"
                class="center-vertically-flex">
                <input type="hidden" name="tag" value="{{ $tag->id }}">
                <input type="checkbox" name="tag" class="toggle-completed" value="{{ $tag->id }}"
                    id="tag_{{ $tag->id }}" @if (in_array($tag->id, (array) $filterTags)) checked @endif
                    onchange="this.form.submit()">
            </form>
            <form method="post" action={{ route('updateTag') }} accept-charset="UTF-8" class="center-vertically-flex"
                id="editTag-{{ $tag->id }}">
                @csrf
                <label class="sidebar-label" id="tagLabel-{{ $tag->id }}">{{ $tag->name }}</label>
                <input type="hidden" name="tagId" value="{{ $tag->id }}">
                <input type="text" name="tagName" class="input-container add-todo-title"
                    id="editField-{{ $tag->id }}" style="display: none;" value="{{ $tag->name }}">
                <i class="fa-solid fa-pen-to-square element-icon" style="color:white"
                    onclick="enableEditField('{{ $tag->id }}')"></i>
            </form>
            <form method="post" action={{ route('removeTag') }} accept-charset="UTF-8"
                class="center-vertically-flex element-icon" id="removeTag-{{ $tag->id }}">
                @csrf
                <input type="hidden" name="id" value="{{ $tag->id }}">
                <i class="fa-solid fa-trash-can"
                    onclick="document.getElementById('removeTag-{{ $tag->id }}').submit()"></i>
            </form>
        </div>
    @endforeach

</div>