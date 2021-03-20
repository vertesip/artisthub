<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/profile', function () {
    return view('profile');
});


Auth::routes();

Route::get('/profile/{userId}', [App\Http\Controllers\ProfileController::class, 'profile'])->name('id.show');

Route::post('follow/{user}', [App\Http\Controllers\FollowsController::class, 'store'])->name('follow.store');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/post/create', [App\Http\Controllers\PostsController::class, 'create'])->name('posts');
Route::post('/post', [App\Http\Controllers\PostsController::class, 'store'])->name('post');
Route::get('/post/{post}', [App\Http\Controllers\PostsController::class, 'show'])->name('post.show');
Route::post('/post/{post}/likes', [App\Http\Controllers\LikeController::class, 'store'])->name('post.like');
Route::delete('/post/{post}/likes', [App\Http\Controllers\LikeController::class, 'destroy'])->name('post.delete');


Route::get('/commentsDisplay', [App\Http\Controllers\CommentController::class, 'commentsDisplay'])->name('commentsDisplay');
Route::post('/comments/create', [App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');

Route::get('/music/upload', [App\Http\Controllers\MusicController::class, 'upload'])->name('upload');
Route::post('/music', [App\Http\Controllers\MusicController::class, 'store'])->name('storedupload');

Route::get('/profile/{username}', [App\Http\Controllers\ProfileController::class, 'profile'])->name('profile.show');
Route::get('/profile/{username}/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile/{username}', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');



//Search

Route::get('/search' , [App\Http\Controllers\ProfileController::class, 'search'])->name('search');

//OAuth

Route::get('/login/google', [App\Http\Controllers\Auth\LoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/login/google/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleGoogleCallback'])->name('google.callback');

Route::get('/login/facebook', [App\Http\Controllers\Auth\LoginController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('/login/facebook/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleFacebookCallback'])->name('facebook.callback');
