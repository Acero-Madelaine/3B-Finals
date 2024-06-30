<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubjectController;

Route::get('/students/{id}/subjects', [SubjectController::class, 'index2']);
Route::post('/students/{id}/subjects', [SubjectController::class, 'store2']);
Route::get('/students/{id}/subjects/{subject_id}', [SubjectController::class, 'show2']);
Route::patch('/students/{id}/subjects/{subject_id}', [SubjectController::class, 'update2']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
