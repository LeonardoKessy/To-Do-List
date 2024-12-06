<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class taskController extends Controller
{
    public function index()
    {
        Task::factory()->count(5)->create();
        $tasks = Task::all();
        $data = $this->__buildReturn($tasks, 200);
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'detail' => 'required|max:511',
            'color' => 'required',
            'user_id' => 'required',
        ]);

        $task = Task::create($validated);
        $data = $this->__buildReturn($task, 201);
        return response()->json($data, 201);
    }

    public function show(string $id)
    {
        $task = Task::find($id);
        
        if (!$task) {
            $data = $this->__buildReturn(null, 404, "Not Found");
            return response()->json($data, 404);
        }

        $data = $this->__buildReturn($task, 200);
        return response()->json($data, 200);
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

        $data = [
            "message" => "Task modified successfully.",
            "task" => $task,
            "status" => 200
        ];
        return response()->json($data, 200);
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

        $data = [
            "message" => "Task modified successfully.",
            "task" => $task,
            "status" => 200
        ];
        return response()->json($data, 200);
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

        $data = [
            "message" => "Task '$id' deleted.",
            "status" => 200
        ];
        return response()->json($data, 200);
    }

    private function __buildReturn(Collection|Task|null $tasks = null, int $status = 200, string $message = ""): array {
        $data = [];
        
        if ($message) $data['message'] = $message;
        if ($tasks) $data['tasks'] = $tasks;
        $data['status'] = $status;
 
        return $data;
    }
}
