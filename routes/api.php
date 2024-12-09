<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ContinentController;
use App\Http\Controllers\CountryController;
use Illuminate\Support\Facades\Route;

// Logout
Route::post('/login', [LoginController::class, 'create']);

Route::middleware('auth:sanctum')->group(function () {
    // Logout
    Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth:sanctum');

    // Continents
    Route::resource('continents', ContinentController::class)->only(['index', 'show']);

    // Countries
    Route::resource('countries', CountryController::class)->only(['index', 'show']);

    // Cities
    Route::resource('cities', CityController::class)->only(['index', 'show']);
});
