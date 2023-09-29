<div class="todo-element" id="{{$id}}">
    <div class="todo-element-checkbox">
        <form method="post" action="{{ route('changeCompletionStatus') }}" accept-charset="UTF-8" id="addItemToTodo">
            @csrf
            <input type="hidden" name="todo_id" value="{{$id}}">
            <input type="checkbox" id="todoCheckbox" onchange="this.form.submit()">
        </form>
        
        
    </div>
    <div class=todo-title> {{$title}} </div>
</div>