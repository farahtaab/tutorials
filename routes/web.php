<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImportIfixitController;
use App\Http\Controllers\GuideController;

Route::get('/', function () {
    return redirect()->route('guides.index');
});

Route::get('/import-ifixit', ImportIfixitController::class);
Route::get('/guides', [GuideController::class, 'index'])->name('guides.index');
Route::get('/guides/{id}', [GuideController::class, 'show'])->name('guides.show');
