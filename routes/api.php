<?php

use App\Http\Controllers\Api\SensorController;
use Illuminate\Support\Facades\Route;

Route::get('/sensor/latest', [SensorController::class, 'latest']);
Route::post('/sensor', [SensorController::class, 'store']);
