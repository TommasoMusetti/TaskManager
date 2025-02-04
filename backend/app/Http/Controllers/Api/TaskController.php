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
        ]);

        return response()->json(['message' => 'Task aggiunta con successo!'], 201);

    }

    public function viewTask()
    {
    }

    public function changeTask()
    {
    }

    public function completeTask()
    {
    }

    public function removeTask()
    {
    }

}
