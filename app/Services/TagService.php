<?php

namespace App\Services;

use App\Models\Tag;

class TagService
{
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
}
