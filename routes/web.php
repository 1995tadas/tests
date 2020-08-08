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

Route::middleware('auth')->group(function () {
    Route::get('/tests', 'TestController@index')->name('test.index');
    Route::get('/tests/create', function () {
        return view('test.create');
    })->name('test.create');
    Route::post('/tests', 'TestController@store')->name('test.store');
    Route::get('/tests/{url}', 'TestController@show')->name('test.show');
});


Route::middleware(['test.author', 'auth'])->group(function () {
    Route::get('/tests/{url}/edit', 'TestController@edit')->name('test.edit');
    Route::put('/tests/{url}', 'TestController@update')->name('test.update');
    Route::delete('/tests/{url}', 'TestController@destroy')->name('test.destroy');

    Route::get('/questions/{url}/create/', 'QuestionController@create')->name('question.create');
    Route::post('/questions', 'QuestionController@store')->name('question.store');
});
Route::middleware(['question.author', 'auth'])->group(function () {
    Route::get('/questions/{id}/edit/', 'QuestionController@edit')->name('question.edit');
    Route::put('/questions/{id}', 'QuestionController@update')->name('question.update');
    Route::delete('/questions/{id}', 'QuestionController@destroy')->name('question.destroy');
});
Route::middleware(['not.test.author', 'auth'])->group(function () {
    Route::get('/solutions/{url}/create', 'SolutionController@create')->name('solution.create');
    Route::post('/solutions/{url}', 'SolutionController@store')->name('solution.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/solutions/{id}', 'SolutionController@show')->name('solution.show')->middleware('solution.auth');
    Route::get('/solutions', 'SolutionController@indexUser')->name('solution.indexUser');
    Route::get('/{url}/solutions', 'SolutionController@index')->name('solution.index')->middleware('test.author');
});
Route::middleware('auth')->group(function () {
    Route::put('settings/{parameter}', 'SettingController@store')->name('setting.store');
    Route::get('users', 'UserController@show')->name('user.show');
});

Route::get('languages/{locale?}', 'LanguageController@setLanguage')->name('language.setLanguage');


