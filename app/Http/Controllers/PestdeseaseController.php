<?php

namespace App\Http\Controllers;

use App\Models\PestAndDisease;
use Illuminate\Http\Request;

class PestdeseaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/api/pests-and-diseases",
     *     tags={"PestAndDisease"},
     *     summary="Get all pests and diseases",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="Successful operation")
     * )
     */
    public function index()
    {
        $pestsAndDiseases = PestAndDisease::all();
        return response()->json($pestsAndDiseases);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/api/pests-and-diseases",
     *     tags={"PestAndDisease"},
     *     summary="Create a new pest or disease",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="warning", type="string"),
     *             @OA\Property(property="genus", type="string"),
     *             @OA\Property(property="scientific_name", type="string"),
     *             @OA\Property(property="aliases", type="string"),
     *             @OA\Property(property="symptoms", type="string"),
     *             @OA\Property(property="solutions", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="source", type="string")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Created successfully")
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'warning' => 'nullable|string',
            'genus' => 'nullable|string|max:255',
            'scientific_name' => 'nullable|string|max:255',
            'aliases' => 'nullable|string',
            'symptoms' => 'nullable|string',
            'solutions' => 'nullable|array',
            'source' => 'nullable|string|max:255',
        ]);

        $pestAndDisease = PestAndDisease::create($validated);
        return response()->json($pestAndDisease, 201);
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *     path="/api/pests-and-diseases/{id}",
     *     tags={"PestAndDisease"},
     *     summary="Get a pest or disease by ID",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Successful operation")
     * )
     */
    public function show(PestAndDisease $pestAndDisease)
    {
        return response()->json($pestAndDisease);
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/api/pests-and-diseases/{id}",
     *     tags={"PestAndDisease"},
     *     summary="Update a pest or disease",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="warning", type="string"),
     *             @OA\Property(property="genus", type="string"),
     *             @OA\Property(property="scientific_name", type="string"),
     *             @OA\Property(property="aliases", type="string"),
     *             @OA\Property(property="symptoms", type="string"),
     *             @OA\Property(property="solutions", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="source", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Updated successfully")
     * )
     */
    public function update(Request $request, PestAndDisease $pestAndDisease)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'warning' => 'nullable|string',
            'genus' => 'nullable|string|max:255',
            'scientific_name' => 'nullable|string|max:255',
            'aliases' => 'nullable|string',
            'symptoms' => 'nullable|string',
            'solutions' => 'nullable|array',
            'source' => 'nullable|string|max:255',
        ]);

        $pestAndDisease->update($validated);
        return response()->json($pestAndDisease);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/api/pests-and-diseases/{id}",
     *     tags={"PestAndDisease"},
     *     summary="Delete a pest or disease",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Deleted successfully")
     * )
     */
    public function destroy(PestAndDisease $pestAndDisease)
    {
        $pestAndDisease->delete();
        return response()->json(null, 204);
    }
}
