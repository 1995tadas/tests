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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/question/{url}/create/', 'QuestionController@create')->name('question.create');
Route::get('/question/{id}/edit/', 'QuestionController@edit')->name('question.edit');
Route::put('/question/{id}', 'QuestionController@update')->name('question.update');
Route::post('/question', 'QuestionController@store')->name('question.store');
Route::delete('/question/{id}', 'QuestionController@destroy')->name('question.destroy');
Route::get('/test/create', 'TestController@create')->name('test.create');
Route::get('/test', 'TestController@index')->name('test.index');
Route::get('/test/{url}', 'TestController@show')->name('test.show');
Route::delete('/test/{id}', 'TestController@destroy')->name('test.destroy');
Route::post('/test', 'TestController@store')->name('test.store');
