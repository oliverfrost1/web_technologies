<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use App\Models\Tag;
use App\Models\TodoTag;


use Illuminate\Support\Facades\View;

class todoController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function showTodoList()
    {
        $todoId = request()->id;
        $tags = null;
        $unselectedTags = null;
        if($todoId){
            //Main page has been loaded with a todo selected
            $tags = $this -> getTagsAssociatedWithTodo($todoId);
            $unselectedTags = $this -> getTagsNotAssociatedWithTodo($todoId);
        }
        $isSorted = session()->get('isSorted');
        return View::make('TodoListMainPage', [
            "todos" => $isSorted ? $this->getTodo() : $this->getFilteredTodo(),
            "isSorted" => $isSorted,
            "openedId" => $todoId,
            "tags" => $tags,
            "unselectedTags" => $unselectedTags,
        ]);
    }

    public function changeSort(){
        $isSorted = session()->get('isSorted');
        $isSorted = $isSorted ? 0 : 1;
        session()->put('isSorted', $isSorted);
        return redirect()->route("Main");
    }

    //Creates a new tag and associates todo with the provided tag
    //Checks if a tag already exists with the name and uses that instead
    public function addNewTagToTodo(Request $request) {
        if(!$request->tagName){
            return back();
        }
        $tag = $this->getTagFromName($request->tagName);
        if($tag){
            $tagid = $tag->id;
            $request->merge(['tagid'=>$tagid]);
            if(!$this->todoHasAssociationsWithTag($tag)){
                return $this->attachTagToTodo($request);
            }
            //This tag already exists on the todo
            return back();
        }
        $tag = Tag::Create(["name" => $request->tagName]);
        $tagid = $tag->id;
        $request->merge(['tagid'=>$tagid]);
        return $this->attachTagToTodo($request);
    }
    //creates new association between an existing tag and a todo
    public function attachTagToTodo(Request $request){
        $todo = Todo::find( $request->todoid);
        $tag = Tag::find( $request->tagid);
        $todo->tags()->attach($tag);
        return back();
    }
    public function removeTagAssociation(Request $request){
        $tagId = $request->tagid;
        $todo = Todo::find($request->todoid);
        $todo->tags()->detach($tagId);
        //checks if any todos use this tag, if not delete it
        if(!$this->todoHasAssociationsWithTag($tagId)){
            Tag::destroy($tagId);
        }
        return back();
    }
    private function todoHasAssociationsWithTag($tagId)
    {
        return Todo::whereHas('tags', function ($query) use ($tagId) {
            $query->where('tags.id', $tagId);
        })->exists();
    }
    private function getTagsNotAssociatedWithTodo($todoId){
        $tags = $this-> getTagsAssociatedWithTodo($todoId);
        $tag_ids = $tags->pluck('id')->toArray();
        //TODO: Add where userid
        $unselectedTags = Tag::whereNotIn('id', $tag_ids)->get();
        return $unselectedTags;
    }
    private function getTagFromName($tagName){
        $tag = Tag::where('name', $tagName)->first();
        return $tag;
    }

    public function getTagsAssociatedWithTodo($todoId){
        $tags = Tag::whereHas('todos', function ($query) use ($todoId) {
            $query->where('todos.id', $todoId);
        })->get();
        return $tags;
    }
    /**
     * Store a newly created todo in the database.
     */
    public function store(Request $request)
    {
        if(!$request->title){
            return redirect()->route("Main");
        }
        Todo::create([
            "title" => $request->title,
            "due_date" => $request->duedate,
        ]);
        return redirect()->route("Main");
    }

    /**
     * Display the specified resource.
     */
    public function getTodo()
    {
        // gets the enitre todolist from the database
        return Todo::all();
    }
    public function getFilteredTodo()
    {
        // gets the enitre todolist from the database
        return Todo::where('completed', 0)->get();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

    }

    public function changeCompletionStatus($id)
    {
        # log the request
        \Log::info($id);
        $todo = Todo::find($id);
        \Log::info($todo);
        # TODO: Maybe change this.
        if ($todo->completed === 1) {
            $todo->completed = 0;
        } else {
            $todo->completed = 1;
        }
        $todo->save();
        return redirect()->route("Main");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteTodoElement($id)
    {
        # log the request
        \Log::info($id);
        $todo = Todo::find($id);
        $todo->delete();
        \Log::info($todo);
        return redirect()->route("Main");
    }
}
