<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\Auth\AuthController;
use App\Http\Controllers\V1\RecipeController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
        Route::middleware('auth:jwt')->group(function () {
            Route::post('/logout', [AuthController::class, 'logout']);
            Route::get('/user-profile', [AuthController::class, 'userProfile']);
        });
    });
    Route::middleware('auth:jwt')->group(function () {
        Route::apiResource('recipes', RecipeController::class);
    });
    
});


