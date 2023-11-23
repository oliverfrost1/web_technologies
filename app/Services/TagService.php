<?php

namespace App\Services;

use App\Models\Tag;

class TagService
{
    private $todoService;

    public function __construct(TodoService $todoService)
    {
        $this->todoService = $todoService;
    }

    public function getUserTags()
    {
        $user = $this->getAuthenticatedUser();

        if (! $user) {
            return [];
        }

        if ($user->isAdmin()) {
            return Tag::all();
        }

        return Tag::where('user_id', $user->id)->get();
    }

    public function getTagsAssociatedWithTodo($todoId)
    {
        return $this->todoService->getTagsByTodoId($todoId);
    }

    public function getTagsNotAssociatedWithTodo($todoId)
    {
        $user = $this->getAuthenticatedUser();

        $query = Tag::query();

        if ($user && ! $user->isAdmin()) {
            $query->where('user_id', $user->id);
        }

        return $this->getUnrelatedTagsForTodo($query, $todoId);
    }

    public function createOrAttachTag($tagName, $admin, $todoId)
    {
        $todo = $this->todoService->getTodoById($todoId);

        if (! $tagName || ! $todo) {
            return false;
        }

        $tag = $this->getTagByName($tagName);

        $isDifferentUserCreatingExistingTag = $tag->user_id != $todo->user_id;

        if (! $tag || $isDifferentUserCreatingExistingTag) {
            $tag = $this->createTag($tagName, $todo->user_id);
        }

        $todo->tags()->attach($tag);

        return true;
    }

    public function updateTag($tagId, $tagName, $user)
    {
        $tag = $this->getTagById($tagId);

        if ($tag && ($tag->user_id === $user->id || $user->isAdmin())) {
            $tag->name = $tagName;
            $tag->save();

            return true;
        }

        return false;
    }

    public function detachTagFromTodo($tagId, $todoId)
    {
        $todo = $this->todoService->getTodoById($todoId);

        if ($todo) {
            $todo->tags()->detach($tagId);

            return true;
        }

        return false;
    }

    public function deleteTag($tagId)
    {
        Tag::destroy($tagId);
    }

    public function removeTagFromFilterList($tagId, $currentFilterTags)
    {
        $currentFilterTags = $currentFilterTags ?? [];
        $updatedFilterTags = array_diff($currentFilterTags, [$tagId]);

        return $updatedFilterTags;
    }

    private function getTagByName($tagName)
    {
        return Tag::where('name', $tagName)->first();
    }

    private function getTagById($tagId)
    {
        return Tag::find($tagId);
    }

    private function createTag($tagName, $userId)
    {
        return Tag::Create(['name' => $tagName, 'user_id' => $userId]);
    }

    private function getUnrelatedTagsForTodo($query, $todoId)
    {
        return $query->whereDoesntHave('todos', function ($query) use ($todoId) {
            $query->where('todos.id', $todoId);
        })->get();
    }

    private function getAuthenticatedUser()
    {
        return auth()->user();
    }
}
