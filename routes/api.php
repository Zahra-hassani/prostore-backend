<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::prefix('/')->middleware('auth:sanctum')->group(function(){

// });
Route::apiResource('products',ProductController::class);
Route::apiResource('reviews',ReviewController::class);
Route::apiResource('auth',AuthController::class)->only('login');
// Route::middleware('auth:sanctum')->;