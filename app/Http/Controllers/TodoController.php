<?php

namespace App\Http\Controllers;

use App\Todo;
use App\Http\Requests\storeTodoRequest;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($completed = null)
    {
        $todos = Todo::orderBy('date')
                        ->where('completed', 0)->paginate(15);

        if($completed)
        {
            $todos = Todo::orderBy('date')
                            ->where('completed', $completed)->paginate(15);
        }
        
        return $this->makeResponse('todos/manageTodos', compact('todos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(storeTodoRequest $request)
    {
        $todo = Todo::create($request->all());

        return ['message' => 'تم اضافة العمل الادارى!'];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(storeTodoRequest $request, Todo $todo)
    {
        $todo->update($request->all());

        return ['message' => 'تم تحديث العمل الادارى بنجاح'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();

        return ['message' => 'تم حذف العمل الادارى!'];
    }
}
