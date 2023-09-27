<?php

namespace App\Models;

class TodoElement
{
  public string $title;
  public string $id;
  public bool $completed;

  public function __construct(string $title, string $id, bool $completed)
  {
    $this->title = $title;
    $this->id = $id;
    $this->completed = $completed;
  }
}