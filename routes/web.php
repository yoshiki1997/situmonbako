<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
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

Route::post('/likes', [LikesController::class, 'store'])->name('likes.store');

require __DIR__.'/auth.php';
