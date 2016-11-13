<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Task;
use App\Http\Requests;
use Tymon\JWTAuth\Facades\JWTAuth;


class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private function getUser() {
        $user = JWTAuth::parseToken()->authenticate();
        if (!$user)
            return response()->json(['message' => 'User not authenticated'], 401);
        return $user;
    }

    public function index(){
        $user = $this->getUser();
        $tasks = Task::with('labels')->where('user_id', $user->id)->get();
        if (!$tasks)
            return response()->json(['message' => 'Error getting the tasks'], 404);
        return response()->json(['tasks' => $tasks]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $this->getUser();

        $validator = $this->validate($request, [
            'title' => 'required|max:255',
            'content' => 'required|string|max:255',
            'archived' => 'max:1',
            'done' => 'max:1'
        ]);
        if ($validator)
            return response()->json(['message' => 'Validation error'], 400);

        $task = new Task();
        $task->title = $request->input('title');
        $task->content = $request->input('content');
        $task->archived = 0;
        $task->done = 0;
        $user->tasks()->save($task);
        foreach ($request->input('labels') as $label)
            $task->labels()->attach($label);
        return response()->json($request->input('labels'), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        $user = $this->getUser();
        $taskList = $task->with('labels')->get();
        $task = $taskList->find($task->id);

        if(!$task or !$taskList)
            return response()->json(['message' => 'Tasks not found'], 404);

        return response()->json(['data' => $task], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $user = $this->getUser();
        $task = $user->tasks->find($task);
        $task->title = $request->input('title');
        $task->content = $request->input('content');
        if ($request->input('archived'))
            $task->archived = 1;
        else
            $task->archived = 0;
        if ($request->input('done'))
            $task->done = 1;
        else
            $task->done = 0;
        $task->save();
        return response()->json(['message' => 'edit success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $user = $this->getUser();
        $task = $user->tasks->find($task);
        if (!$task)
            return response()->json(['message' => 'Task not found'], 404);

        $task->delete();
        return response()->json(['message' => 'delete success'], 200);
    }
}
