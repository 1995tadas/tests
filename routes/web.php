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

Route::middleware('auth')->prefix('tests')->name('tests.')->group(function () {
    Route::get('', 'TestController@index')->name('index');
    Route::get('create', function () {
        return view('test.create');
    })->name('create');
    Route::post('', 'TestController@store')->name('store');
    Route::get('{url}', 'TestController@show')->name('show');
});

Route::middleware(['test.author', 'auth'])->prefix('tests')->name('tests.')->group(function () {
    Route::get('{url}/edit', 'TestController@edit')->name('edit');
    Route::put('{url}', 'TestController@update')->name('update');
    Route::delete('{url}', 'TestController@destroy')->name('destroy');
});
Route::middleware(['test.author', 'auth'])->prefix('questions')->name('questions.')->group(function () {
    Route::get('{url}/create/', 'QuestionController@create')->name('create');
    Route::post('', 'QuestionController@store')->name('store');
});

Route::middleware(['question.author', 'auth'])->prefix('questions')->name('questions.')->group(function () {
    Route::get('{id}/edit/', 'QuestionController@edit')->name('edit');
    Route::put('{id}', 'QuestionController@update')->name('update');
    Route::delete('{id}', 'QuestionController@destroy')->name('destroy');
});
Route::middleware(['not.test.author', 'auth'])->prefix('solutions')->name('solutions.')->group(function () {
    Route::get('{url}/create', 'SolutionController@create')->name('create');
    Route::post('{url}', 'SolutionController@store')->name('store');
});

Route::middleware('auth')->name('solutions.')->group(function () {
    Route::get('/solutions/{id}', 'SolutionController@show')->name('show')->middleware('solution.auth');
    Route::get('/solutions', 'SolutionController@indexUser')->name('index_user');
    Route::get('/{url}/solutions', 'SolutionController@index')->name('index')->middleware('test.author');
});
Route::middleware('auth')->group(function () {
    Route::put('settings/{parameter}', 'SettingController@store')->name('settings.store');
    Route::get('users', 'UserController@show')->name('users.show');
});

Route::get('languages/{locale?}', 'LanguageController@setLanguage')->name('languages.set_language');

Route::put('solutions/{id}','SolutionController@showResults')->name('solutions.showResults')->middleware('solution.auth');

