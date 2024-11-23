<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Column;
use Illuminate\Http\Request;

class ColumnController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/columns",
     *     summary="Get all Columns",
     *     tags={"Columns"},
     *     @OA\Response(
     *         response=200,
     *         description="A list of all projects",
     *     )
     * )
     */
    public function index()
    {
        return Column::with('tasks')->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * @OA\Post(
     *     path="/api/columns",
     *     summary="Create a new project",
     *     tags={"Columns"},
     *     @OA\Response(
     *         response=200,
     *         description="The created project",
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name", "projectId", "order"},
     *             @OA\Property(property="name", type="string", example="Column Name", ),
     *             @OA\Property(property="projectId", type="integer", example=1, description="The ID of the user associated with the project"),
     *             @OA\Property(property="order", type="integer", example=1, description="The URL or file path of the project's background image")
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
        ]);

        $column = Column::create($request->all());

        // Return the created project as a response
        return response()->json($column, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/columns/{id}",
     *     summary="Get a column by ID",
     *     tags={"Columns"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the column to retrieve",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="The requested column",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Column 1"),
     *             @OA\Property(property="projectId", type="integer", example=101),
     *             @OA\Property(property="order", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Column not found"
     *     )
     * )
     */
    public function show($id)
    {
        $column = Column::find($id);
        if (!$column) {
            return response()->json(['error' => 'Column not found'], 404);
        }
        return response()->json($column);
    }
    /**
     * @OA\Put(
     *     path="/api/columns/{id}",
     *     summary="Update a column by ID",
     *     tags={"Columns"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the column to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name", "projectId", "order"},
     *             @OA\Property(property="name", type="string", example="Updated Column", description="Updated name of the column"),
     *             @OA\Property(property="projectId", type="integer", example=102, description="Updated project ID"),
     *             @OA\Property(property="order", type="integer", example=2, description="Updated order of the column")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Column updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Updated Column"),
     *             @OA\Property(property="projectId", type="integer", example=102),
     *             @OA\Property(property="order", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Column not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $column = Column::find($id);
        if (!$column) {
            return response()->json(['error' => 'Column not found'], 404);
        }

        try {
            $request->validate([
                'name' => 'nullable|string|max:255',
            ]);

            $column->update($request->all());

            return response()->json($column);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'An unexpected error occurred'], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/columns/{id}",
     *     summary="Delete a column by ID",
     *     tags={"Columns"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the column to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Column deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Column not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $column = Column::find($id);
        if (!$column) {
            return response()->json(['error' => 'Column not found'], 404);
        }

        $column->delete();

        return response()->json(null, 204);
    }
}
