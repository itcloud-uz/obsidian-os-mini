<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\VizitkaController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/projects', [ProjectController::class, 'index']);
    Route::post('/projects/{slug}', [ProjectController::class, 'store']); // Use POST since updateOrCreate handles it
    Route::delete('/projects/{slug}', [ProjectController::class, 'destroy']);
});

// Public routes
Route::get('/vizitka/{slug}', [VizitkaController::class, 'show']);
Route::post('/vizitka/{slug}/view', [VizitkaController::class, 'incrementViews']);
Route::post('/vizitka/{slug}/click', [VizitkaController::class, 'incrementClicks']);
