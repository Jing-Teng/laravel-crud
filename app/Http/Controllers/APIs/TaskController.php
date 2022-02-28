<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::select('id','name','due_date')
            ->orderBy('updated_at', 'desc')
            ->get()
            ->toArray();
        return $tasks;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'due_date' => 'required|date'
        ]);

        // simple validate time format
        $date = strtotime($request->due_date);
        if ($date === false) {
            abort('422', 'bad time format');
        }
        $task = Task::create([
            'name'=>$request->name,
            'due_date'=>$request->due_date
        ]);

        return $task;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::findOrFail($id)->toArray();
        return $task;
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
        $task = Task::findOrFail($id);

        if( $request->has('name') ){
            $task->name = $request->name;
        }
        if( $request->has('due_date') ){
            $date = strtotime($request->due_date);
            if ($date === false) {
                abort('422', 'bad time format');
            }

            $task->due_date = $request->due_date;
        }

        $task->save();

        return $task;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return $task;
    }

}
