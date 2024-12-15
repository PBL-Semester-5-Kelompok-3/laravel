<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Pest;
use App\Models\Schedule;
use App\Models\Solution;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="History",
 *     type="object",
 *     required={"id_user", "id_disease", "label"},
 *     @OA\Property(property="id", type="integer", description="ID of the history"),
 *     @OA\Property(property="id_user", type="integer", description="ID of the user"),
 *     @OA\Property(property="id_disease", type="integer", description="ID of the disease"),
 *     @OA\Property(property="image_path", type="string", nullable=true, description="Path to the image"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Timestamp when the history was created"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Timestamp when the history was last updated")
 * )
 */
class HistoryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/histories",
     *     operationId="getAllHistories",
     *     tags={"Histories"},
     *     summary="Get all histories",
     *     description="Returns a list of all histories.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/History")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function getAll()
    {
        $histories = History::with(['user', 'disease'])->get();
        // $schedules = Schedule::where('id_disease', $histories->disease->id)->get();
        // $solutions = Solution::where('id_disease', $histories->disease->id)->get();
        // $pest = Pest::where('id_disease', $histories->disease->id)->get();
        // return response()->json([$histories, $schedules, $solutions, $pest], 200);
        $result = [];
        foreach ($histories as $history) { // Iterasi melalui setiap elemen dalam koleksi
            if ($history->disease) { // Periksa apakah disease tersedia
                // Ambil data jadwal, solusi, dan hama berdasarkan id_disease
                $schedules = Schedule::where('id_disease', $history->disease->id)->get();
                $solutions = Solution::where('id_disease', $history->disease->id)->get();
                $pests = Pest::where('id_disease', $history->disease->id)->get();

                $result[] = [
                    'history' => [
                        'id' => $history->id,
                        'id_user' => $history->id_user,
                        'id_disease' => $history->id_disease,
                        'image_path' => asset('storage/' . $history->image_path), // Path lengkap
                        'created_at' => $history->created_at,
                        'updated_at' => $history->updated_at,
                        'user' => $history->user,
                        'disease' => $history->disease,
                    ],
                    'schedule' => $schedules,
                    'solutions' => $solutions,
                    'pest' => $pests,
                ];
            } else {
                $result[] = [
                    'history' => $history,
                    'schedule' => null,
                    'solutions' => null,
                    'pest' => null,
                ];
            }
        }
        return response()->json($result, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/histories/user/{id_user}",
     *     operationId="getHistoriesByUser",
     *     tags={"Histories"},
     *     summary="Get histories by user ID",
     *     description="Returns a list of histories for a specific user.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id_user",
     *         in="path",
     *         description="ID of the user",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/History")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No histories found for this user"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function getByUser($id_user)
    {
        $histories = History::with(['disease'])
            ->where('id_user', $id_user)
            ->get();

        if ($histories->isEmpty()) {
            return response()->json(['message' => 'No histories found for this user'], 404);
        }

        return response()->json($histories, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/histories",
     *     operationId="createHistory",
     *     tags={"Histories"},
     *     summary="Create a new history",
     *     description="Creates a new history record and returns it.",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"id_user", "id_disease", "image_path"},
     *                 @OA\Property(property="id_user", type="integer", example=1, description="ID of the user"),
     *                 @OA\Property(property="id_disease", type="integer", example=2, description="ID of the disease"),
     *                 @OA\Property(property="image_path", type="string", format="binary", description="Uploaded image file")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="History created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/History")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function store(Request $request)
    {
        // Validasi request
        $validated = $request->validate([
            'id_user' => 'required|exists:users,id',
            'id_disease' => 'required|exists:diseases,id',
            'image_path' => 'required|file|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Simpan file gambar
        if ($request->hasFile('image_path')) {
            $file = $request->file('image_path');
            $filePath = $file->store('histories', 'public'); // Simpan di folder 'public/histories'
        } else {
            return response()->json([
                'message' => 'File upload failed. Please include a valid image file.',
            ], 400);
        }

        // Buat entri history
        $history = History::create([
            'id_user' => $validated['id_user'],
            'id_disease' => $validated['id_disease'],
            'image_path' => $filePath,
        ]);

        return response()->json([
            'message' => 'History created successfully',
            'history' => $history,
        ], 201);
    }
}
