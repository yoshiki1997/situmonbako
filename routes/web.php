<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\KnowlegeController;
use App\Http\Controllers\UserPageController;
use App\Http\Controllers\SuggestController;
use App\Http\Controllers\ProblemReplyController;
use App\Http\Controllers\FavoriteController;
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

URL::forceScheme('https');

Route::get('/', [PostController::class, 'index'])->name('index');
Route::get('/tagssearch', [PostController::class, 'tagsSearch']);


Route::get('/dashboard', [DashboardController::class, 'index'] 
)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile', [ProfileController::class, 'setImg'])->name('profile.img');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Post

Route::get('/post', [PostController::class, 'index'] 
)->middleware(['auth', 'verified'])->name('post');

Route::get('/search', [PostController::class, 'search'])->name('search');

//likecontroller

Route::post('/likes', [LikeController::class, 'store']);

//searchhistory

Route::post('/searchhistory', [SearchHistoryController::class, 'store'])->name('search.history');

// DashboardController

Route::post('/problemstore', [DashboardController::class, 'problemstore'])->name('problem.store');
Route::post('/problemurlstore', [DashboardController::class, 'problemurlstore'])->name('problem.url.store');
Route::post('/destroy/{id}', [DashboardController::class, 'destroy'])->name('destroy.problem');
Route::post('/update/{id}', [DashboardController::class, 'update'])->name('updateproblem');
Route::post('/update/{id}/description', [DashboardController::class, 'descriptionupdate'])->name('description_update');
Route::post('/update/{id}/history/comment', [DashboardController::class, 'inputHistoryComment'])->name('history.comment.input');
Route::post('/update/{id}/like/comment', [DashboardController::class, 'inputLikeComment'])->name('like.comment.input');
Route::post('/follow/{user}', [DashboardController:: class, 'Follow'])->name('follow');
Route::post('/store',[DashboardController::class, 'store'])->name('storeHistory');

// userpage

Route::get('/user/{id}', [UserPageController::class, 'index'])->name('user.page');

// knowlegecontroller

Route::get('/historia', [KnowlegeController::class, 'index'])->name('historia.index');
Route::get('/history/search', [KnowlegeController::class, 'search'])->name('history.search');
Route::get('/historia/category', [KnowlegeController::class, 'searchByCategory'])->name('get.category.problems');
Route::get('/history/{id}', [KnowlegeController::class, 'pickup'])->name('history.pickup');
Route::post('/problemlikes', [KnowlegeController::class, 'problemLikes'])->name('problem.likes');
Route::post('/history/delete/{id}', [KnowlegeController::class, 'destory'])->name('destory.problem.history');
Route::patch('reply/{id}/update', [KnowlegeController::class, 'updateReply'])->name('update.reply');

//SuggestController

Route::get('/suggest', [SuggestController::class, 'suggest'])->name('suggest');

// ProblemReplyController

Route::post('/reply/{id}', [ProblemReplyController::class, 'Reply'])->name('reply');

// FavoriteController

Route::middleware('auth')->group(function () {
    Route::get('/fav/{user_id}', [FavoriteController::class, 'index'])->name('fav.index');
});

//Delete

Route::post('/follow/{user}/delete', [DashboardController:: class, 'deleteFollow'])->name('delete');
Route::delete('/history/reply/{id}/delete', [KnowlegeController::class, 'destroyReply'])->name('destory.reply');
Route::post('/destroy/history/{id}', [DashboardController::class, 'destroyHistory'])->name('destroy.history');

require __DIR__.'/auth.php';
