<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubjectController;

Route::get('/students/{id}/subjects', [SubjectController::class, 'index2']);
Route::post('/students/{id}/subjects', [SubjectController::class, 'store2']);
Route::get('/students/{id}/subjects/{subject_id}', [SubjectController::class, 'show2']);
Route::patch('/students/{id}/subjects/{subject_id}', [SubjectController::class, 'update2']);

use App\Http\Controllers\StudentController;

Route::get('/students', [StudentController::class, 'index']);
Route::post('/students', [StudentController::class, 'store']);
Route::get('/students/{id}', [StudentController::class, 'show']);
Route::patch('/students/{id}', [StudentController::class, 'update']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
