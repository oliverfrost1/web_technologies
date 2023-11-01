<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ToDoElement extends Component
{
    /**
     * Create a new component instance.
     */
    public $title;
    public $id;
    public $completed;
    public $duedate;
    public function __construct($title, $id, $completed, $duedate)
    {
        $this->title = $title;
        $this->id = $id;
        $this->completed = $completed;
        $this->duedate = $duedate;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ToDoElement');
    }
}
