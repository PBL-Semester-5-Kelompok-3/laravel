<?php

namespace App\Http\Controllers;

/**
 * @OA\OpenApi(
 *     @OA\Info(title="Tomato Scan API Documentation", version="1.0"),
 *     @OA\Server(url="http://127.0.0.1:8000"),
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
abstract class Controller
{
    //
}
