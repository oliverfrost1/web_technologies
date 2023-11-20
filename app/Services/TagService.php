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

    public function getAllTagsOnUser()
    {
        $user = auth()->user();
        $tags = [];
        if ($user) {
            if ($user->isAdmin()) {
                $tags = Tag::all();
            } else {
                $tags = Tag::where('user_id', $user->id)->get();
            }
        }

        return $tags;
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
        $tags = $this->getTagsAssociatedWithTodo($todoId);
        $tag_ids = $tags->pluck('id')->toArray();
        $user = auth()->user();
        $unselectedTags = [];
        if ($user) {
            if ($user->isAdmin()) {
                $unselectedTags = Tag::whereNotIn('id', $tag_ids)->get();
            } else {
                $unselectedTags = Tag::where('user_id', $user->id)->whereNotIn('id', $tag_ids)->get();
            }
        }

        return $unselectedTags;
    }

    public function createOrAttachTag($tagName, $user, $todoId)
    {
        if (! $tagName || $user->isAdmin()) {
            return false;
        }

        $tag = $this->getTagByName($tagName) ?? Tag::Create(['name' => $tagName, 'user_id' => $user->id]);

        if ($tag && $user) {
            $todo = $this->todoService->getTodoById($todoId);
            if ($todo) {
                $todo->tags()->attach($tag);

                return true;
            }
        }

        return false;
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

    public function deleteTag($tagId, $selectedTags)
    {
        $tagIndex = array_search($tagId, (array) $selectedTags);
        if ($tagIndex !== false) {
            unset($selectedTags[$tagIndex]);
            $selectedTags = array_values($selectedTags);
        }
        Tag::destroy($tagId);

        return $selectedTags;
    }

    private function getTagByName($tagName)
    {
        $tag = Tag::where('name', $tagName)->first();

        return $tag;
    }
}
