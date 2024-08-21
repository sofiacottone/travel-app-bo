<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JwtAuthController;
use App\Http\Controllers\Api\DayController;
use App\Http\Controllers\Api\PhotoController;
use App\Http\Controllers\Api\PlaceController;
use App\Http\Controllers\Api\TripController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function () {
    Route::post('register', [JwtAuthController::class, 'register']);
    Route::post('login', [JwtAuthController::class, 'login']);
    Route::post('logout', [JwtAuthController::class, 'logout']);
    Route::get('authUser', [JwtAuthController::class, 'authUser']);
});


Route::middleware('auth:api')->group(function () {
    Route::apiResource('trips', TripController::class);
    Route::apiResource('trips.days', DayController::class);
    Route::apiResource('days.places', PlaceController::class);
    Route::apiResource('places.photos', PhotoController::class);
});
