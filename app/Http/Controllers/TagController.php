<?php

namespace App\Http\Controllers;

use App\Services\Contracts\TagService;
use Illuminate\Http\Request;

class TagController extends Controller
{
    private $tagService;

    public function __construct(TagService $tagSerivce)
    {
        $this->tagService = $tagSerivce;
    }

    public function createOrAttachTagToTodo(Request $request)
    {
        $user = auth()->user();
        $result = $this->tagService->createOrAttachTag($request->tagName, $request->todoid);

        if (! $result) {
            return $this->errorResponse('You need to log in to add this tag to todo.', 'createError');
        }

        return back();
    }

    public function filterByTags(Request $request)
    {
        $tagsForFiltering = session()->get('tagsForFiltering', []);
        $currentTag = $request->tag;
        $tagIndex = array_search($currentTag, $tagsForFiltering);

        if ($tagIndex !== false) {
            unset($tagsForFiltering[$tagIndex]);
        } elseif ($currentTag) {
            $tagsForFiltering[] = $currentTag;
        }

        $tagsForFiltering = array_values($tagsForFiltering);
        session()->put('tagsForFiltering', $tagsForFiltering);

        return back();
    }

    public function updateTag(Request $request)
    {
        $user = auth()->user();

        if (! $user) {
            return $this->errorResponse('You need to log in to update this tag.', 'createError');
        }

        $this->tagService->updateTag($request->tagId, $request->tagName, $user);

        return back();
    }

    public function detachTagFromTodo(Request $request)
    {
        $result = $this->tagService->detachTagFromTodo($request->tagid, $request->todoid);

        if (! $result) {
            return $this->errorResponse('Failed to remove the tag from todo.', 'removeError');
        }

        return back();
    }

    public function deleteTag(Request $request)
    {
        $this->tagService->deleteTag($request->id);

        $updatedFilterTags = $this->tagService->removeTagFromFilterList($request->id, session()->get('tagsForFiltering'));
        session()->put('tagsForFiltering', $updatedFilterTags);

        return back();
    }

    private function errorResponse($message, $inputKey)
    {
        return back()->withErrors([
            $inputKey => $message,
        ])->onlyInput($inputKey);
    }
}
