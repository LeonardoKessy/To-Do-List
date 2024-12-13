<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Http\Resources\TaskResource;
use App\Http\Services\Filters\TaskFilter;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class taskController extends Controller
{
    public function index(Request $request)
    {
        $queries = (new TaskFilter)->getFilters($request);
        $tasks = Task::where($queries)->paginate();

        return TaskResource::collection($tasks);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tittle' => 'required|max:255',
            'detail' => 'required|max:511',
            'color' => 'required',
            'user_id' => 'required',
        ]);

        $task = Task::create($validated);
        return new TaskResource($task);
    }

    public function show(string $id)
    {
        $task = Task::find($id);
        
        if (!$task) {
            $data = [
                "message" => "Not Found.",
                "status" => 404
            ];
            return response()->json($data, 404);
        }

        return new TaskResource($task);
    }

    public function update(Request $request, string $id)
    {
        $task = Task::find($id);
        if (!$task) {
            $data = [
                "message" => "Not Found.", 
                "status" => 404
            ];
            return response()->json($data, 404);
        }

        $request->validate([
            'name' => 'required|max:255',
            'detail' => 'required|max:511',
            'color' => 'required',
        ]);

        $task->name = $request->name;
        $task->detail = $request->detail;
        $task->color = $request->color;

        $task->save();

        return new TaskResource($task);
    }

    public function updatePartial(Request $request, string $id)
    {
        $task = Task::find($id);
        if (!$task) {
            $data = [
                "message" => "Not Found.", 
                "status" => 404
            ];
            return response()->json($data, 404);
        }

        $request->validate([
            'name' => 'max:255',
            'detail' => 'max:511',
        ]);

        if ($request->has('name')) $task->name = $request->name;
        if ($request->has('detail')) $task->detail = $request->detail;
        if ($request->has('color')) $task->color = $request->color;

        $task->save();

        return new TaskResource($task);
    }

    public function destroy(string $id)
    {
        $task = Task::find($id);

        if (!$task) {
            $data = [
                "message" => "Not Found.",
                "status" => 404
            ];
            return response()->json($data, 404);
        }

        $task->delete();

        return new TaskResource($task);
    }
}
