<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\CardController;
use App\Http\Controllers\v1\AccountController;
use App\Http\Controllers\v1\JournalController;
use App\Http\Controllers\v1\CategoryController;
use App\Http\Controllers\v1\Auth\AuthController;
use App\Http\Controllers\v1\SubCategoryController;
use App\Http\Controllers\v1\IncomeStatementReportController;

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

        Route::prefix('categories')->group(function () {
            Route::get('/', [CategoryController::class, 'index']);
            Route::get('/{id}', [CategoryController::class, 'show']);
            Route::post('/', [CategoryController::class, 'store']);
            Route::put('/{id}', [CategoryController::class, 'update']);
            Route::delete('/{id}', [CategoryController::class, 'destroy']);
        });

        Route::prefix('subcategories')->group(function () {
            Route::get('/', [SubCategoryController::class, 'index']);
            Route::get('/{id}', [SubCategoryController::class, 'show']);
            Route::post('/', [SubCategoryController::class, 'store']);
            Route::put('/{id}', [SubCategoryController::class, 'update']);
            Route::delete('/{id}', [SubCategoryController::class, 'destroy']);
        });

        Route::prefix('accounts')->group(function () {
            Route::get('/', [AccountController::class, 'index']);
            Route::get('/{id}', [AccountController::class, 'show']);
            Route::get('/subcategory/{id}', [AccountController::class, 'showSubcategory']);
            Route::post('/', [AccountController::class, 'store']);
            Route::put('/{id}', [AccountController::class, 'update']);
            Route::delete('/{id}', [AccountController::class, 'destroy']);
        });

        Route::prefix('journals')->group(function () {
            Route::get('/', [JournalController::class, 'index']);
            Route::get('/{id}', [JournalController::class, 'show']);
            Route::post('/', [JournalController::class, 'store']);
        });

        Route::prefix('reports')->group(function () {
            Route::get('/income-statement', [IncomeStatementReportController::class, 'index']);
            Route::get('/income-statement/export', [IncomeStatementReportController::class, 'export']);
        });

        Route::prefix('cards')->group(function () {
            Route::get('/', [CardController::class, 'index']);
        });
    });
});
