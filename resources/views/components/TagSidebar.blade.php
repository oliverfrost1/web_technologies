@props(['allTags', 'filterTags'])
<div class="sidebar-holder">
    <label class="sidebar-label" for="tags">Tags</label>
    @foreach ($allTags as $tag)
        <div class="center-vertically-flex">
            <form method="get" action="{{ route('filterByTags') }}" accept-charset="UTF-8" class="center-vertically-flex">
                <input type="hidden" name="tag" value="{{ $tag->id }}">
                <input type="checkbox" name="tag" class="toggle-completed" value="{{ $tag->id }}"
                    id="tag_{{ $tag->id }}" @if (in_array($tag->id, (array) $filterTags)) checked @endif
                    onchange="this.form.submit()">
            </form>
            <form method="post" action="" accept-charset="UTF-8" class="center-vertically-flex" id="editTag-{{ $tag->id }}">
                <label class="sidebar-label"> {{ $tag->name }} </label>
                <i class="fa-solid fa-pen-to-square " style="color:white"
                    onclick="document.getElementById('editTag-{{ $tag->id }}').submit()"></i>
            </form>
            <form method="post" action={{ route('removeTag') }} accept-charset="UTF-8"  class="center-vertically-flex element-icon" id="removeTag-{{ $tag->id }}">
                @csrf
                <input type="hidden" name="id" value="{{ $tag->id }}">
                <i class="fa-solid fa-trash-can"
                    onclick="document.getElementById('removeTag-{{ $tag->id }}').submit()"></i>
            </form>
        </div>
    @endforeach
</div>
