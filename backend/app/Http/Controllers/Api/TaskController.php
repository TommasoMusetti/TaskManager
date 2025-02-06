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

        return response()->json(['message' => 'Task aggiornata!'], 200);
    }

    public function completeTask(Request $request)
    {
        $records = Task::whereIn('id', $request->ids)->get();

        foreach ($records as $record) {
            $record->update([
                'checked' => $record->checked == 0 ? 1 : 0
            ]);
        }

        $message = count($request->ids) > 1
            ? 'Stato delle tasks aggiornato con successo!'
            : 'Stato della task aggiornato con successo!';

        return response()->json(['message' => $message], 200);
        
        
    }

    public function removeTask(Request $request)
    {
        Task::whereIn('id', $request->ids)->delete();

        $message = count($request->ids) > 1
            ? 'Tasks eliminate con successo!'
            : 'Task eliminata con successo!';

        return response()->json(['message' => $message], 200);
    }

}
