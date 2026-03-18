<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\VizitkaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Project management via JS fetch
    Route::get('/projects', [ProjectController::class, 'index']);
    Route::post('/projects/{slug}', [ProjectController::class, 'store']);
    Route::delete('/projects/{slug}', [ProjectController::class, 'destroy']);
    Route::post('/upload', [ProjectController::class, 'upload']);
});

Route::get('/v/{slug}', function ($slug) {
    return view('vizitka', compact('slug'));
});

// Vizitka public API
Route::get('/api/vizitka/{slug}', [VizitkaController::class, 'show']);
Route::post('/api/vizitka/{slug}/view', [VizitkaController::class, 'incrementViews']);
Route::post('/api/vizitka/{slug}/click', [VizitkaController::class, 'incrementClicks']);

require __DIR__.'/auth.php';
