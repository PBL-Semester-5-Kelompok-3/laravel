<?php

namespace App\Http\Controllers;

use App\Models\Disease;
use App\Models\Pest;
use App\Models\Schedule;
use App\Models\Solution;
use Illuminate\Http\Request;

class AfterScanController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/getAfterScan",
     *     tags={"Scan"},
     *     security={{"bearerAuth": {}}},
     *     summary="Get details of scanned disease",
     *     description="Retrieve details of a disease including its schedules, solutions, and pest based on the provided disease name.",
     *     operationId="getAfterScan",
     *     @OA\Parameter(
     *         name="disease",
     *         in="query",
     *         required=true,
     *         description="Name of the disease to retrieve details for",
     *         @OA\Schema(
     *             type="string",
     *             example="Bacterial_spot"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Disease details including schedules, solutions, and pest",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="disease",
     *                 type="string",
     *                 example="Bacterial_spot",
     *                 description="Name of the disease"
     *             ),
     *             @OA\Property(
     *                 property="schedule",
     *                 type="array",
     *                 description="List of schedules related to the disease",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="time", type="string", example="07:00 - 09:00"),
     *                     @OA\Property(property="description", type="string", example="Penyiraman tanaman secara rutin")
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="solutions",
     *                 type="array",
     *                 description="List of solutions related to the disease",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="title", type="string", example="Pemberian Pupuk Organik"),
     *                     @OA\Property(property="description", type="string", example="Gunakan pupuk organik untuk meningkatkan kesuburan tanah.")
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="pest",
     *                 type="array",
     *                 description="List of pests related to the disease",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="name", type="string", example="Kutu Daun (Aphids)")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Disease not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Disease not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Internal server error")
     *         )
     *     )
     * )
     */
    public function getAfterScan(Request $request)
    {
        // Retrieve the disease name from the request
        $diseaseName = $request->input('disease');

        // Find the disease details
        $disease = Disease::where('name', $diseaseName)->first();

        if (!$disease) {
            return response()->json([
                'message' => 'Disease not found',
            ], 404);
        }

        // Retrieve related schedules and solutions
        $schedules = Schedule::where('id_disease', $disease->id)->get();
        $solutions = Solution::where('id_disease', $disease->id)->get();
        $pest = Pest::where('id_disease', $disease->id)->get();

        // Prepare the JSON response
        return response()->json([
            'disease' => $disease->name,
            'disease_id' => $disease->id,
            'schedule' => $schedules->map(function ($schedule) {
                return [
                    'description' => $schedule->keterangan,
                ];
            }),
            'solutions' => $solutions->map(function ($solution) {
                return [
                    'title' => $solution->title,
                    'description' => $solution->keterangan_solution,
                ];
            }),
            'pest' => $pest->map(function ($pests) {
                return [
                    'name' => $pests->name,
                ];
            }),
        ]);
    }
}
