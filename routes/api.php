<?php

use App\Http\Controllers\v1\AkunController;
use App\Http\Controllers\v1\Auth\AuthController;
use App\Http\Controllers\v1\JurnalController;
use App\Http\Controllers\v1\KategoriController;
use App\Http\Controllers\v1\LaporanLabaRugiController;
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

        Route::prefix('kategori')->group(function () {
            Route::get('/', [KategoriController::class, 'index']);
            Route::get('/{id}', [KategoriController::class, 'show']);
            Route::post('/', [KategoriController::class, 'store']);
            Route::put('/{id}', [KategoriController::class, 'update']);
            Route::delete('/{id}', [KategoriController::class, 'destroy']);
        });

        Route::prefix('sub-kategori')->group(function () {
            Route::get('/', [SubKategoriController::class, 'index']);
            Route::get('/{id}', [SubKategoriController::class, 'show']);
            Route::post('/', [SubKategoriController::class, 'store']);
            Route::put('/{id}', [SubKategoriController::class, 'update']);
            Route::delete('/{id}', [SubKategoriController::class, 'destroy']);
        });

        Route::prefix('akun')->group(function () {
            Route::get('/', [AkunController::class, 'index']);
            Route::get('/{id}', [AkunController::class, 'show']);
            Route::get('/sub-kategori/{id}', [AkunController::class, 'showSubKategori']);
            Route::post('/', [AkunController::class, 'store']);
            Route::put('/{id}', [AkunController::class, 'update']);
            Route::delete('/{id}', [AkunController::class, 'destroy']);
        });

        Route::prefix('jurnal')->group(function () {
            Route::get('/', [JurnalController::class, 'index']);
            Route::get('/{id}', [JurnalController::class, 'show']);
            Route::post('/', [JurnalController::class, 'store']);
        });

        Route::prefix('laporan')->group(function () {
            Route::get('/laba-rugi', [LaporanLabaRugiController::class, 'index']);
            Route::get('/laba-rugi/export', [LaporanLabaRugiController::class, 'export']);
        });
    });
});
