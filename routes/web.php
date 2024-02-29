<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('dashboard');

Route::get('profile/{username}', [ProfileController::class, 'index'])->name('profile.index');
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('albums/store', [AlbumController::class, 'store'])->name('album.store');
Route::put('albums/{album}/update', [AlbumController::class, 'update'])->name('album.update');
Route::delete('albums/{album}/delete', [AlbumController::class, 'delete'])->name('album.delete');

Route::get('profile/{username}/photos/{album}', [PhotoController::class, 'index'])->name('photo.index');
Route::post('profile/{username}/photos/{album}/post', [PhotoController::class, 'store'])->name('photo.store');
Route::get('profile/{username}/photos/{photo}/detail', [PhotoController::class, 'detail'])->name('photo.detail');
Route::put('profile/{username}/photos/{photo}/update', [PhotoController::class, 'update'])->name('photo.update');
Route::delete('profile/{username}/photos/{photo}/delete', [PhotoController::class, 'delete'])->name('photo.delete');

Route::post('like/{photo}', [LikeController::class, 'like'])->name('like.store');
Route::post('comment/{photo}', [CommentController::class, 'comment'])->name('comment.store');