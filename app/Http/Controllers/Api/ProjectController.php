<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Project;
use Auth;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/projects",
     *     summary="Get all projects",
     *     tags={"Projects"},
     *     @OA\Response(
     *         response=200,
     *         description="A list of all projects",
     *     )
     * )
     */
    public function index()
    {
        return Project::all();
    }

    /**
     * @OA\Post(
     *     path="/api/projects",
     *     summary="Create a new project",
     *     tags={"Projects"},
     *     @OA\Response(
     *         response=200,
     *         description="The created project",
     *     ),
       *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             required={"name", "userId", "backImg"},
 *             @OA\Property(property="name", type="string", example="My Project", description="The name of the project"),
 *             @OA\Property(property="userId", type="integer", example=123, description="The ID of the user associated with the project"),
 *             @OA\Property(property="backImg", type="string", example="https://example.com/project-image.jpg", description="The URL or file path of the project's background image")
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
        // Validate incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'userId' => 'required|integer',
            'backImg' => 'required|string',
        ]);

        $project = Project::create($request->all());
    
        // Return the created project as a response
        return response()->json($project, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/projects/{id}",
     *     summary="Get a project by ID",
     *     tags={"Projects"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The ID of the project",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="The project data",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Project not found"
     *     )
     * )
     */
    public function show($id)
    {
        return Project::findOrFail($id);
    }

    /**
     * @OA\Put(
     *     path="/api/projects/{id}",
     *     summary="Update an existing project",
     *     tags={"Projects"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The ID of the project to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="The updated project",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Project not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $project->update($request->all());
        return $project;
    }

    /**
     * @OA\Delete(
     *     path="/api/projects/{id}",
     *     summary="Delete a project",
     *     tags={"Projects"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The ID of the project to delete",
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Project successfully deleted"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Project not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        Project::destroy($id);
        return response()->noContent();
    }
}
