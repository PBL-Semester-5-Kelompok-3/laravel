<?php

namespace App\Http\Controllers;

/**
 * @OA\OpenApi(
 *     @OA\Info(title="Tomato Scan API Documentation", version="1.0"),
 *     @OA\Server(
 *          url="https://tomascan.nurulmustofa.my.id",
 *          description="Production Server"
 *      ),
 *     @OA\Server(
 *          url="https://localhost:8000",
 *          description="localhost Server"
 *      ),
 *     @OA\Components(
 *         @OA\SecurityScheme(
 *             securityScheme="Bearer",
 *             type="http",
 *             scheme="bearer",
 *             description="Enter your bearer token below. Example: `Bearer your.jwt.token`"
 *         )
 *     )
 * )
 */
abstract class Controller {}
