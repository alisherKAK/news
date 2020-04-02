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

Auth::routes();

#region News
Route::name('news.')
    ->prefix('news')
    ->group(function (){
        Route::post('/search', 'NewsController@search')
            ->name('search');

        Route::get('/', 'NewsController@index')
            ->name('index');
        Route::get('/create', 'NewsController@create')
            ->name('create');
        Route::post('/', 'NewsController@store')
            ->name('store');
        Route::get('/{news}/show', 'NewsController@show')
            ->name('show');

        Route::get('/{news}/edit', 'NewsController@edit')
            ->name('edit');
        Route::put('/{news}/update', 'NewsController@update')
            ->name('update');

        Route::delete('/{news}/delete', 'NewsController@destroy')
            ->name('delete');

        Route::get('/{news}/add_author', 'NewsController@addAuthor')
            ->name('add.author');
        Route::post('/{news}/store_author', 'NewsController@storeAuthor')
            ->name('store.author');
    });
Route::redirect('/home', '/news');
Route::redirect('/', '/news');
#endregion

#region Categories
Route::name('categories.')
    ->prefix('categories')
    ->middleware('auth')
    ->group(function() {
        Route::get('/', 'CategoryController@index')
            ->name('index');
        Route::get('/create', 'CategoryController@create')
            ->name('create');
        Route::post('/', 'CategoryController@store')
            ->name('store');
        Route::delete('/{category}', 'CategoryController@destroy')
            ->name('delete');
    });
#endregion

#region Comments
Route::name('comments.')
    ->prefix('comments')
    ->middleware('auth')
    ->group(function () {

        Route::post('/', 'CommentController@store')
            ->name('store');
        Route::delete('/{comment}', 'CommentController@destroy')
            ->name('destroy');

    });
#endregion
