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
Route::get('/test/edit/{url}','TestController@edit')->name('test.edit')->middleware('test.author');
Route::put('/test/{url}','TestController@update')->name('test.update')->middleware('test.author');
Route::delete('/test/{url}', 'TestController@destroy')->name('test.destroy')->middleware('test.author');

Route::get('/question/{url}/create/', 'QuestionController@create')->name('question.create')->middleware('test.author');
Route::post('/question', 'QuestionController@store')->name('question.store')->middleware('test.author');
Route::get('/question/{id}/edit/', 'QuestionController@edit')->name('question.edit')->middleware('question.author');;
Route::put('/question/{id}', 'QuestionController@update')->name('question.update')->middleware('question.author');
Route::delete('/question/{id}', 'QuestionController@destroy')->name('question.destroy')->middleware('question.author');

Route::get('/solution/test/{url}/create', 'SolutionController@create')->name('solution.create')->middleware('not.test.author');
Route::post('/solution/test/{url}', 'SolutionController@store')->name('solution.store')->middleware('not.test.author');
Route::get('/solution/{id}', 'SolutionController@show')->name('solution.show')->middleware('solution.auth');
Route::get('/{id}/solution', 'SolutionController@index')->name('solution.index')->middleware('solution.auth');

