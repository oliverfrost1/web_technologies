<?php

namespace App\Http\Controllers;

use App\Services\TagService;
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
        $result = $this->tagService->createOrAttachTag($request->tagName, $user, $request->todoid);

        if (! $result) {
            return $this->errorResponse('You need to log in to add this tag to todo.', 'createError');
        }

        return back();
    }

    public function changeSelectedTags(Request $request)
    {
        $selectedTags = session()->get('selectedTags', []);
        $currentTag = $request->tag;
        $tagIndex = array_search($currentTag, $selectedTags);

        if ($tagIndex !== false) {
            unset($selectedTags[$tagIndex]);
        } elseif ($currentTag) {
            $selectedTags[] = $currentTag;
        }

        $selectedTags = array_values($selectedTags);
        session()->put('selectedTags', $selectedTags);

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
        $selectedTags = $this->tagService->deleteTag($request->id, session()->get('selectedTags'));
        session()->put('selectedTags', $selectedTags);

        return back();
    }

    private function errorResponse($message, $inputKey)
    {
        return back()->withErrors([
            $inputKey => $message,
        ])->onlyInput($inputKey);
    }
}
