<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [\App\Http\Controllers\PostController::class,'index'] )->name('posts');

Route::post('post/{post}/add-comment', [\App\Http\Controllers\PostController::class,'addComment'] )->name('posts.add-comment');
Route::post('post/comment/replay', [\App\Http\Controllers\PostController::class,'addReplay'] )->name('posts.add-replay');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
