<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function addTask(Request $request)
    {
        $request->validate([
            'descrizione' => 'required|string',
        ]);

        Task::create([
            'descrizione' => $request->descrizione,
            'email' => $request->user_email
        ]);

        return response()->json(['message' => 'Task aggiunta con successo!'], 201);

    }

    public function viewTask(Request $request)
    {
        $tasks = Task::where('email', $request->email)->get();

        return response()->json($tasks, 201);
    }

    public function changeTask(Request $request)
    {
        $new_task = $request->task['descrizione'];
        $id = $request->id;
        $task = Task::find($id);
        
        $task->descrizione = $new_task;
        $task->save();

        return response()->json(['message' => 'Task aggiornata!'], 201);
    }

    public function completeTask()
    {
    }

    public function removeTask()
    {
    }

}
