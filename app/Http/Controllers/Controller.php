<?php

namespace App\Http\Controllers;

/**
 * @OA\OpenApi(
 *     @OA\Info(title="Tomato Scan API Documentation", version="1.0"),
 *     @OA\Server(
 *         url="https://tomascan.nurulmustofa.my.id",
 *         description="Production Server"
 *     ),
 *     @OA\Server(
 *         url="http://localhost:8000",
 *         description="localhost Server"
 *     ),
 *     @OA\Components(
 *         @OA\SecurityScheme(
 *             securityScheme="bearerAuth",
 *             type="http",
 *             scheme="bearer",
 *             bearerFormat="JWT",
 *             description="Enter your bearer token in the format: Bearer <your-token>"
 *         )
 *     )
 * )
 */
abstract class Controller {}
