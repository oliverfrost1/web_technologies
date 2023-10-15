@props(['allTags', 'filterTags'])
<div class="sidebar-holder">
    <label class="sidebar-label" for="tags">Tags</label>
    @foreach ($allTags as $tag)
        <div>
            <form method="get" action="{{route('filterByTags')}}" accept-charset="UTF-8">
                @csrf
                <input type="hidden" name="tag" value="{{$tag->id}}">
                <input type="checkbox" name="tag" class="toggle-completed" value="{{$tag->id}}" id="tag_{{$tag->id}}"
                @if (in_array( $tag->id, (array)$filterTags)) checked @endif onchange="this.form.submit()">
                <label> {{$tag->name}} </label>
            </form>
        </div>
    @endforeach
</div>
