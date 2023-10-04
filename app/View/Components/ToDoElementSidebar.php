<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ToDoElementSidebar extends Component
{
    /**
     * Create a new component instance.
     */
    public $todo;
    public function __construct($todo)
    {
        $this->todo = $todo;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.TodoElementSidebar');
    }
}
