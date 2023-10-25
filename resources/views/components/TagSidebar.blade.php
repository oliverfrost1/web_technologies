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
                <label class="sidebar-label"> {{ $tag->name }} </label>
            </form>
            <form method="post" action={{ route('removeTag') }} accept-charset="UTF-8" class="center-vertically-flex">
                @csrf
                <input type="hidden" name="id" value="{{ $tag->id }}">
                <input type="submit" class="sidebar-button tag-delete" value=" X ">
            </form>
        </div>
    @endforeach
</div>
