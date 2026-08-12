<?php

use App\Http\Controllers\Api\V1\JWTController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware([])->prefix('jwt')->group(function () {
    Route::get('/', [JWTController::class, 'index'])->name('jwt.index');
});
