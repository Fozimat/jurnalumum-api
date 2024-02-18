<?php

use App\Http\Controllers\v1\AkunController;
use App\Http\Controllers\v1\Auth\AuthController;
use App\Http\Controllers\v1\JurnalController;
use App\Http\Controllers\v1\KategoriController;
use App\Http\Controllers\v1\SubKategoriController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function () {
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/auth/logout', [AuthController::class, 'logout']);

        Route::get('/kategori', [KategoriController::class, 'index']);
        Route::get('/kategori/{id}', [KategoriController::class, 'show']);
        Route::post('/kategori', [KategoriController::class, 'store']);
        Route::put('/kategori/{id}', [KategoriController::class, 'update']);
        Route::delete('/kategori/{id}', [KategoriController::class, 'destroy']);

        Route::get('/sub-kategori', [SubKategoriController::class, 'index']);
        Route::get('/sub-kategori/{id}', [SubKategoriController::class, 'show']);
        Route::post('/sub-kategori', [SubKategoriController::class, 'store']);
        Route::put('/sub-kategori/{id}', [SubKategoriController::class, 'update']);
        Route::delete('/sub-kategori/{id}', [SubKategoriController::class, 'destroy']);

        Route::get('/akun', [AkunController::class, 'index']);
        Route::get('/akun/{id}', [AkunController::class, 'show']);
        Route::get('/akun/sub-kategori/{id}', [AkunController::class, 'showSubKategori']);
        Route::post('/akun', [AkunController::class, 'store']);
        Route::put('/akun/{id}', [AkunController::class, 'update']);
        Route::delete('/akun/{id}', [AkunController::class, 'destroy']);

        Route::get('/jurnal', [JurnalController::class, 'index']);
        Route::post('/jurnal', [JurnalController::class, 'store']);
    });
});
