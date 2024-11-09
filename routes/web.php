<?php

use App\Http\Controllers\ScrambleDocsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// https://github.com/dedoc/scramble/pull/548
ScrambleDocsController::registerUiRoute(path: 'docs/api')->name('custom.scramble.docs.ui');
