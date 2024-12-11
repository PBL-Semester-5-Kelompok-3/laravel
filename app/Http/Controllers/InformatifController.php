<?php

namespace App\Http\Controllers;

use App\Models\Informatif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Schema(
 *     schema="Informatif",
 *     type="object",
 *     required={"id", "title", "type", "content"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="Tomato Planting Tips"),
 *     @OA\Property(property="type", type="string", example="Planting"),
 *     @OA\Property(property="content", type="string", example="informatif_image.jpg")
 * )
 */

class InformatifController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/informatifs",
     *     tags={"Informatif"},
     *     security={{"bearerAuth": {}}},
     *     summary="Create a new Informatif",
     *     description="Create a new informatifs with an image",
     *     operationId="storeInformatif",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"title", "type", "content"},
     *                 @OA\Property(property="title", type="string", example="Tomato Planting Tips"),
     *                 @OA\Property(property="type", type="string", example="Planting"),
     *                 @OA\Property(property="content", type="string", format="binary")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Informatif created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Informatif created successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/Informatif")
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
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'content' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Validation failed', 'message' => $validator->errors()], 422);
        }

        $imagePath = $request->file('content')->store('informatifs', 'public');

        $informatif = Informatif::create([
            'title' => $request->title,
            'type' => $request->type,
            'content' => $imagePath,
        ]);

        return response()->json(['message' => 'Informatif created successfully', 'data' => $informatif], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/informatifs",
     *     tags={"Informatif"},
     *     security={{"bearerAuth": {}}},
     *     summary="Get all informatifs",
     *     description="Retrieve a list of all informatifs",
     *     operationId="indexInformatifs",
     *     @OA\Response(
     *         response=200,
     *         description="List of informatifs",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Informatif")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function index()
    {
        $informatifs = Informatif::all();
        return response()->json($informatifs);
    }

    /**
     * @OA\Get(
     *     path="/api/informatifs/{id}",
     *     tags={"Informatif"},
     *     security={{"bearerAuth": {}}},
     *     summary="Get a single informatifs",
     *     description="Retrieve details of a specific informatifs by its ID",
     *     operationId="showInformatif",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Informatif details",
     *         @OA\JsonContent(ref="#/components/schemas/Informatif")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Informatif not found"
     *     )
     * )
     */
    public function show($id)
    {
        $informatif = Informatif::find($id);
        if (!$informatif) {
            return response()->json(['error' => 'Informatif not found'], 404);
        }
        return response()->json($informatif);
    }

    /**
     * @OA\Put(
     *     path="/api/informatifs/{id}",
     *     tags={"Informatif"},
     *     security={{"bearerAuth": {}}},
     *     summary="Update an existing Informatif",
     *     description="Update the informatifs by its ID",
     *     operationId="updateInformatif",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"title", "type"},
     *                 @OA\Property(property="title", type="string", example="Updated Tomato Planting Tips"),
     *                 @OA\Property(property="type", type="string", example="Planting"),
     *                 @OA\Property(property="content", type="string", format="binary")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Informatif updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Informatif updated successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/Informatif")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $informatif = Informatif::find($id);
        if (!$informatif) {
            return response()->json(['error' => 'Informatif not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'type' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Validation failed', 'message' => $validator->errors()], 422);
        }

        if ($request->hasFile('content')) {
            Storage::delete('public/' . $informatif->content);
            $imagePath = $request->file('content')->store('informatifs', 'public');
            $informatif->content = $imagePath;
        }

        $informatif->update($request->only('title', 'type'));

        return response()->json(['message' => 'Informatif updated successfully', 'data' => $informatif]);
    }

    /**
     * @OA\Delete(
     *     path="/api/informatifs/{id}",
     *     tags={"Informatif"},
     *     security={{"bearerAuth": {}}},
     *     summary="Delete an Informatif",
     *     description="Delete a specific informatifs by its ID",
     *     operationId="destroyInformatif",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Informatif deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Informatif deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Informatif not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $informatif = Informatif::find($id);
        if (!$informatif) {
            return response()->json(['error' => 'Informatif not found'], 404);
        }

        Storage::delete('public/' . $informatif->content);
        $informatif->delete();

        return response()->json(['message' => 'Informatif deleted successfully']);
    }
}
