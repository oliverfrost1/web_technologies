<?php

namespace App\Services\Contracts;

interface TodoService
{
    public function getTodoList($isSorted);

    public function getTodoById($id);

    public function getAttachedTagsForTodoByTodoId($todoId);

    public function createTodo($title, $dueDate, $userId);

    public function updateTodo($id, $updateData, $userId, $isAdmin);

    public function toggleTodoCompletionStatus($id);

    public function deleteTodo($id, $userId, $isAdmin);
}
