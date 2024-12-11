<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InformatifController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);
Route::post('verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('logout', [AuthController::class, 'logout']);
Route::middleware('jwt.verify')->group(function () {
    // Route to get all informatifs
    Route::get('/informatifs', [InformatifController::class, 'index']);

    // Route to create a new informatif
    Route::post('/informatifs', [InformatifController::class, 'store']);

    // Route to get a single informatif by ID
    Route::get('/informatifs/{id}', [InformatifController::class, 'show']);

    // Route to update an informatif by ID
    Route::put('/informatifs/{id}', [InformatifController::class, 'update']);

    // Route to delete an informatif by ID
    Route::delete('/informatifs/{id}', [InformatifController::class, 'destroy']);
});
