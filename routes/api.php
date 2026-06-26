<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SignUpController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix("/dashboard")->middleware("auth:sanctum")->group(function () {
    Route::get("/current-reviews",[ReviewController::class,"currentMonthReviews"]);
    Route::get("/previous-month-reviews",[ReviewController::class,"getPreviousMonthReviews"]);
    Route::get("/current-month-users",[UserController::class,"currentMonthUsers"]);
    Route::get("/previous-month-users",[UserController::class,"getPreviousMonthUsers"]);
    Route::get("/current-month-products",[ProductController::class,"currentMonthProducts"]);
    Route::get("/previous-month-products",[ProductController::class,"previousMonthProducts"]);
});

Route::apiResource('products',ProductController::class);
Route::apiResource('auth',AuthController::class)->only('store');
Route::apiResource('check-token',AuthController::class)->only('show');
Route::apiResource('signup',SignUpController::class)->only('store');     
Route::apiResource('/reviews',ReviewController::class);
