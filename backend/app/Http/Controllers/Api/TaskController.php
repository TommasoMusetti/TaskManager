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

    public function completeTask(Request $request)
    {
        Task::whereIn('id', $request->ids)
        ->update(['checked' => 1]);

        if(count($request->ids) > 1){
            return response()->json([ 'message' => 'Tasks completate con successo!'], 201);
        }
        else{
            return response()->json([ 'message' => 'Task completata con successo!'], 201);
        }
        
    }

    public function removeTask(Request $request)
    {
        Task::whereIn('id', $request->ids)->delete();

        if(count($request->ids) > 1){
            return response()->json([ 'message' => 'Tasks eliminate con successo!'], 201);
        }
        else{
            return response()->json([ 'message' => 'Task eliminata con successo!'], 201);
        }
    }

}
