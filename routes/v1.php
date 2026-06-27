<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ReportController;
use App\Http\Controllers\Api\ApiController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/workshops', [ApiController::class, 'createWorkshop']);
Route::post('/reports/submit', [ReportController::class, 'submit']);
