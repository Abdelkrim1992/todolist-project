<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Todo;
use App\Events\TodoEvent;

class TodoListController extends Controller
{
    public function index(){

        return auth()->user()->todos;
    }

    public function store(Request $request){

        $todo = auth()->user()->todos()->create([
            'text' => $request->text,
            'completed' => false
        ]);

        try {
            TodoEvent::dispatch('added', $todo);
        } catch (\Throwable $e) {
            \Log::error('Failed to dispatch TodoEvent: ' . $e->getMessage());
        }
        
    }
 
    public function update(Request $request, $id){
        
        $todo = auth()->user()->todos()->findOrFail($id);
        $todo_update = $todo->update($request->only('text','completed'));

        try {
            TodoEvent::dispatch('updated', $todo_update);
        } catch (\Throwable $e) {
            \Log::error('Failed to dispatch TodoEvent: ' . $e->getMessage());
        }

        return response()->json($todo);
    }

    public function destroy($id){

        $todo = auth()->user()->todos()->findOrFail($id);
        $todo_delete = $todo->delete();

        try {
            TodoEvent::dispatch('deleted', $todo_delete);
        } catch (\Throwable $e) {
            \Log::error('Failed to dispatch TodoEvent: ' . $e->getMessage());
        }

        return response()->json(['message' => 'Deleted']);
    }

}
