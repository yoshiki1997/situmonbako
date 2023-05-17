<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

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

/*Route::get('/', function () {
    return view('welcome');
});*/
Route::get('/', [\App\Http\Controllers\PostController::class, 'index']);
Route::get('/questions/{question_id}', [\App\Http\Controllers\PostController::class, 'show']);
Route::get('/search',[\App\Http\Controllers\PostController::class, 'search']);
Route::get('/tagssearch',[\App\Http\Controllers\PostController::class, 'tagsSearch']);



Route::get('/test', [\App\Http\Controllers\PostController::class, 'test']);


