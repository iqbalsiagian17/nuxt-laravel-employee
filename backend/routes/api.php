<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EmployeeController;

// Route publik (tanpa auth)
Route::post('login', [AuthController::class, 'login'])->name('login');

// Route proteksi JWT
Route::middleware(['jwt.auth'])->group(function () {
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);
});


Route::middleware(['auth:api'])->group(function () {
    Route::get('/employees', [EmployeeController::class, 'index']);
    Route::post('/employees', [EmployeeController::class, 'store']);
    Route::put('/employees/{id}', [EmployeeController::class, 'update']);
    Route::delete('/employees/{id}', [EmployeeController::class, 'destroy']);
    Route::post('/employees/{id}/upload-photo', [EmployeeController::class, 'uploadPhoto']);
    Route::get('/employees/search', [EmployeeController::class, 'search']);
    Route::get('/employees/unit/{id}', [EmployeeController::class, 'byUnit']);
});