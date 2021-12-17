<?php

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

Route::get('/', function () {
  return view('index');
});

Route::group(['prefix' => 'posts'], function() {  
  Route::get('/', [PostsController::class, 'index']);
  Route::post('/', [PostsController::class, 'store']);
  Route::get('/create', [PostsController::class, 'create']);
  Route::get('/{post}/edit', [PostsController::class, 'edit']);
  Route::put('/{post}', [PostsController::class, 'update']);
  Route::delete('/{post}', [PostsController::class, 'destroy']);
  Route::get('/search', [PostsController::class, 'search']);
});

Route::group(['prefix' => 'books'], function() {  
  Route::get('/', [BooksController::class, 'index']);
  Route::post('/', [BooksController::class, 'store']);
  Route::get('/create', [BooksController::class, 'create']);
  Route::get('/{book}/edit', [BooksController::class, 'edit']);
  Route::put('/{book}', [BooksController::class, 'update']);
  Route::delete('/{book}', [BooksController::class, 'destroy']);
  Route::get('/search', [BooksController::class, 'search']);
});
