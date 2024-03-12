<?php

use App\Http\Controllers\AdminArticleController;
use App\Http\Controllers\ArticleController;
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
    if (Auth::check()) {
        return redirect('/dashboard');
    }

    return view('welcome');
});

Route::get('/dashboard', [ArticleController::class, 'allArticles'])
    ->middleware('auth')
    ->name('dashboard');

Route::resource('articles', ArticleController::class)
    ->except('destroy')
    ->middleware('auth');

Route::resource('articles', AdminArticleController::class)
    ->only('destroy')
    ->middleware('auth');

Route::get('/dashboard/trashed', [AdminArticleController::class, 'trashed'])
    ->middleware('auth')
    ->name('articles.trashed');

Route::group(['prefix' => 'articles/{article}'], function () {
    Route::get('/show', [AdminArticleController::class, 'show'])
        ->name('articles.admin.show')
        ->withTrashed()
        ->middleware('auth');

    Route::post('/publish', [AdminArticleController::class, 'publishArticle'])
        ->name('article.publish')
        ->middleware('auth');

    Route::post('/restore', [AdminArticleController::class, 'restore'])
        ->middleware('auth')
        ->withTrashed()
        ->name('articles.restore');
});

require __DIR__.'/auth.php';
