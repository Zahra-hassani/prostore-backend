<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SignUpController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('products',ProductController::class);
Route::apiResource('auth',AuthController::class)->only('store');
Route::apiResource('check-token',AuthController::class)->only('show');
Route::apiResource('signup',SignUpController::class)->only('store');     
Route::apiResource('/reviews',ReviewController::class);
