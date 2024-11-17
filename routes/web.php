<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbsensiController;

Route::get('/', [AbsensiController::class, 'index']);
Route::post('/absensi', [AbsensiController::class, 'store']);

