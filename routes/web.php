<?php

use App\Constants\Map;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [\App\Http\Controllers\GameController::class, 'scene'])->name('game');

Route::post('/move', [\App\Http\Controllers\GameController::class, 'update'])->name('move');

Route::get('/gameover', function () {
    session([
        'score' => 0,
    ]);

    return view('gameover');
})->name('gameover');
