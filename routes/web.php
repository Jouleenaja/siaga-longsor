<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'beranda'])->name('beranda');
Route::get('/sensor', [PageController::class, 'sensor'])->name('sensor');
Route::get('/riwayat', [PageController::class, 'riwayat'])->name('riwayat');
