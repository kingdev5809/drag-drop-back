<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;


class TaskController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/tasks",
     *     summary="Get all Tasks",
     *     tags={"Tasks"},
     *     @OA\Response(
     *         response=200,
     *         description="A list of all Tasks",
     *     )
     * )
     */
    public function index()
    {
        return Task::all();
    }
    /**
     * @OA\Get(
     *     path="/api/tasks/{id}",
     *     summary="Get task by ID",
     *     tags={"Tasks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the task to retrieve",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Task retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Task 1"),
     *             @OA\Property(property="description", type="string", example="This is task description."),
     *             @OA\Property(property="columnId", type="integer", example=101),
     *             @OA\Property(property="created_at", type="string", example="2024-01-01T12:00:00"),
     *             @OA\Property(property="updated_at", type="string", example="2024-01-01T12:00:00")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Task not found"
     *     )
     * )
     */
    public function show($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        return response()->json($task);
    }

    /**
     * @OA\Post(
     *     path="/api/tasks",
     *     summary="Create a new task",
     *     tags={"Tasks"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name", "description", "columnId", "userId"},
     *             @OA\Property(property="name", type="string", example="New Task"),
     *             @OA\Property(property="description", type="string", example="Task description goes here"),
     *             @OA\Property(property="columnId", type="integer", example=1),
     *             @OA\Property(property="userId", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Task created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="New Task"),
     *             @OA\Property(property="description", type="string", example="Task description goes here"),
     *             @OA\Property(property="columnId", type="integer", example=1),
     *             @OA\Property(property="created_at", type="string", example="2024-01-01T12:00:00"),
     *             @OA\Property(property="updated_at", type="string", example="2024-01-01T12:00:00")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'columnId' => 'required|integer',
        ]);

        $task = Task::create($request->all());

        return response()->json($task, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/tasks/{id}",
     *     summary="Update task by ID",
     *     tags={"Tasks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the task to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name", "description", "columnId", "userId"},
     *             @OA\Property(property="name", type="string", example="Updated Task"),
     *             @OA\Property(property="description", type="string", example="Updated task description"),
     *             @OA\Property(property="columnId", type="integer", example=1),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Task updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Updated Task"),
     *             @OA\Property(property="description", type="string", example="Updated task description"),
     *             @OA\Property(property="columnId", type="integer", example=1),
     *             @OA\Property(property="created_at", type="string", example="2024-01-01T12:00:00"),
     *             @OA\Property(property="updated_at", type="string", example="2024-01-01T12:00:00")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Task not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        $request->validate([
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'columnId' => 'nullable|integer',
            'order' => 'nullable|integer',
        ]);

        $task->update($request->all());

        return response()->json($task);
    }

    /**
     * @OA\Delete(
     *     path="/api/tasks/{id}",
     *     summary="Delete task by ID",
     *     tags={"Tasks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the task to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Task deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Task not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        $task->delete();

        return response()->json(null, 204);
    }
}
