<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\KnowlegeController;
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

Route::get('/', [PostController::class, 'index'])->name('index');
Route::get('/tagssearch', [PostController::class, 'tagsSearch']);


Route::get('/dashboard', [DashboardController::class, 'index'] 
)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/store',[DashboardController::class, 'store'])->name('storeHistory');

Route::get('/post', [PostController::class, 'index'] 
)->middleware(['auth', 'verified'])->name('post');

Route::post('/likes', [LikeController::class, 'store']);
Route::post('/searchhistory', [SearchHistoryController::class, 'store'])->name('search.history');
Route::get('/search', [PostController::class, 'search'])->name('search');
Route::post('/problemstore', [DashboardController::class, 'problemstore'])->name('problem.store');
Route::post('/problemurlstore', [DashboardController::class, 'problemurlstore'])->name('problem.url.store');
Route::post('/destroy/{id}', [DashboardController::class, 'destroy'])->name('destroy.problem');
Route::post('/update/{id}', [DashboardController::class, 'update'])->name('updateproblem');
Route::post('/update/{id}/description', [DashboardController::class, 'descriptionupdate'])->name('description_update');
Route::post('/update/{id}/comment', [DashboardController::class, 'inputHistoryComment'])->name('history.comment.input');

Route::get('/historia', [KnowlegeController::class, 'index'])->name('historia.index');


require __DIR__.'/auth.php';
