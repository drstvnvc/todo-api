<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Todo;

class TodosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = Todo::all();
        return response()->json($todos, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $todo = createNewTodo($request->input('content'), $request->input('priority'));
        return response()->json($todo, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $todo = Todo::find($id);
        
        return response()->json($todo, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $todo = Todo::find($id);
        if (!$todo) {
            $todo = createNewTodo($request->input('content'), $request->input('priority'));
            return response()->json($todo, 201);
        }

        $todo->content = $request->input('content');
        $todo->priority = $request->input('priority');
        $todo->save();
        return response()->json($todo, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $todo = Todo::find($id);
        if (!$todo) {
            return response()->json('', 404);
        }
        $todo->delete();
        return response()->json($todo, 200);
    }

    private function createNewTodo($content, $priority) {
        $todo = new Todo;
        $todo->content = $content;
        $todo->priority = $priority;
        $todo->save();
        return $todo;
    }
}
