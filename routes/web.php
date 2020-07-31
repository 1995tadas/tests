<?php

use Illuminate\Support\Facades\Auth;
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
    return view('home');
});

Auth::routes();


Route::get('/test', 'TestController@index')->name('test.index');
Route::get('/test/create', 'TestController@create')->name('test.create');
Route::post('/test', 'TestController@store')->name('test.store');
Route::get('/test/{url}', 'TestController@show')->name('test.show');

Route::get('user', 'UserController@show')->name('user.show');

Route::middleware('test.author')->group(function () {
    Route::get('/test/{url}/edit', 'TestController@edit')->name('test.edit');
    Route::put('/test/{url}', 'TestController@update')->name('test.update');
    Route::delete('/test/{url}', 'TestController@destroy')->name('test.destroy');

    Route::get('/question/{url}/create/', 'QuestionController@create')->name('question.create');
    Route::post('/question', 'QuestionController@store')->name('question.store');
});
Route::middleware('question.author')->group(function () {
    Route::get('/question/{id}/edit/', 'QuestionController@edit')->name('question.edit');
    Route::put('/question/{id}', 'QuestionController@update')->name('question.update');
    Route::delete('/question/{id}', 'QuestionController@destroy')->name('question.destroy');
});
Route::middleware('not.test.author')->group(function () {
    Route::get('/solution/test/{url}/create', 'SolutionController@create')->name('solution.create');
    Route::post('/solution/test/{url}', 'SolutionController@store')->name('solution.store');
});
Route::get('/solution/{id}', 'SolutionController@show')->name('solution.show')->middleware('solution.auth');
Route::get('/solution', 'SolutionController@indexUser')->name('solution.indexUser');
Route::get('/{url}/solution', 'SolutionController@index')->name('solution.index')->middleware('test.author');

Route::get('language/{locale?}', 'LanguageController@setLanguage')->name('language.setLanguage');
