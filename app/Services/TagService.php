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
        $user = auth()->user();

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
        $tags = Tag::whereHas('todos', function ($query) use ($todoId) {
            $query->where('todos.id', $todoId);
        })->get();

        return $tags;
    }

    public function getTagsNotAssociatedWithTodo($todoId)
    {
        $user = auth()->user();

        if (! $user) {
            return [];
        }

        $query = Tag::query();

        if (! $user->isAdmin()) {
            $query->where('user_id', $user->id);
        }

        $unselectedTags = $query->whereDoesntHave('todos', function ($query) use ($todoId) {
            $query->where('todos.id', $todoId);
        })->get();

        return $unselectedTags;
    }

    public function createOrAttachTag($tagName, $admin, $todoId)
    {
        $todo = $this->todoService->getTodoById($todoId);
        if (! $tagName || ! $todo) {
            return false;
        }

        $tag = $this->getTagByName($tagName);

        if (! $tag || $tag->user_id != $todo->user_id) {
            $tag = Tag::Create(['name' => $tagName, 'user_id' => $todo->user_id]);
        }

        $todo->tags()->attach($tag);

        return true;
    }

    public function updateTag($tagId, $tagName, $user)
    {
        $tag = Tag::find($tagId);
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
        $tag = Tag::where('name', $tagName)->first();

        return $tag;
    }
}
