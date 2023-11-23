<?php

namespace App\Services\Contracts;

interface TagService
{
    public function getUserTags();

    public function getTagsAssociatedWithTodo($todoId);

    public function getTagsNotAssociatedWithTodo($todoId);

    public function createOrAttachTag($tagName, $todoId);

    public function updateTag($tagId, $tagName, $user);

    public function detachTagFromTodo($tagId, $todoId);

    public function deleteTag($tagId);

    public function removeTagFromFilterList($tagId, $currentFilterTags);

    public function getTagByNameAndUserId($tagName, $userId);
}
