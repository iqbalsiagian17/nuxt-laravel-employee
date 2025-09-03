<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\ReligionController;
use App\Http\Controllers\Api\PositionController;
use App\Http\Controllers\Api\WorkUnitController;




Route::post('login', [AuthController::class, 'login'])->name('login');

Route::middleware(['auth:api'])->group(function () {

    // Employee routes
    Route::get('/employees', [EmployeeController::class, 'index']);
    Route::get('/employees/{id}', [EmployeeController::class, 'show']);
    Route::post('/employees', [EmployeeController::class, 'store']);
    Route::put('/employees/{id}', [EmployeeController::class, 'update']);
    Route::delete('/employees/{id}', [EmployeeController::class, 'destroy']);
    Route::post('/employees/{id}/upload-photo', [EmployeeController::class, 'uploadPhoto']);
    Route::get('/employees/search', [EmployeeController::class, 'search']);
    Route::get('/employees/unit/{id}', [EmployeeController::class, 'byUnit']);


    // Religion routes
    Route::get('/religions', [ReligionController::class, 'index']);
    Route::post('/religions', [ReligionController::class, 'store']);
    Route::get('/religions/{id}', [ReligionController::class, 'show']);
    Route::put('/religions/{id}', [ReligionController::class, 'update']);
    Route::delete('/religions/{id}', [ReligionController::class, 'destroy']);


    // Position routes
    Route::get('/positions', [PositionController::class, 'index']);
    Route::post('/positions', [PositionController::class, 'store']);
    Route::get('/positions/{id}', [PositionController::class, 'show']);
    Route::put('/positions/{id}', [PositionController::class, 'update']);
    Route::delete('/positions/{id}', [PositionController::class, 'destroy']);


    // Work Unit routes
    Route::get('/work-units', [WorkUnitController::class, 'index']);
    Route::post('/work-units', [WorkUnitController::class, 'store']);
    Route::get('/work-units/{id}', [WorkUnitController::class, 'show']);
    Route::put('/work-units/{id}', [WorkUnitController::class, 'update']);
    Route::delete('/work-units/{id}', [WorkUnitController::class, 'destroy']);    
});