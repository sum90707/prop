<?php

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

Route::get('/', 'HomeController@index')->name('home');
Route::get('local/{lang}', 'LanguageController@switchLang')->name('lang.switch');


Route::get('/login', 'LoginController@loginPage')->name('login.page');
Route::get('/register', 'LoginController@registerPage')->name('register.page');



Route::post('/login', 'LoginController@login')->name('login');
Route::post('/register', 'LoginController@register')->name('register');
Route::get('/logout', 'LoginController@logout')->name('logout');

Route::group(['middleware' => 'auth'], function () {

    Route::prefix('user')->group(function() {
        Route::get('profile', 'UserController@profile')->name('user.profile');
        Route::post('save', 'UserController@save')->name('user.save');
        Route::post('uploadImage', 'UserController@uploadImage')->name('user.image');

        Route::get('changPassword', 'UserController@changePwd')->name('user.change.password');
        Route::post('changeSave', 'UserController@changeSave')->name('user.save.password');

        Route::group(['middleware' => 'checkAuth:admin|teacher'], function () {
            Route::get('manage', 'UserController@managePage')->name('user.manage');
            Route::get('list', 'UserController@list')->name('user.list');
            Route::put('toggle/{user}', 'UserController@toggle')->name('user.toggle');
            Route::put('toggle/auth/{user}', 'UserController@toggleAuth')->name('user.toggle.auth');
            Route::put('toggle/lang/{user}', 'UserController@toggleLang')->name('user.toggle.lang');
        });
        
    });

    Route::prefix('quesition')->group(function() {
        Route::get('create/{quesition?}', 'QuesitionController@createPage')->name('quesition.create.page');
        Route::post('save', 'QuesitionController@save')->name('quesition.save');
        Route::get('list', 'QuesitionController@list')->name('quesition.list');
        Route::put('toggle/{quesition}', 'QuesitionController@toggle')->name('quesition.toggle');

        Route::get('test', 'QuesitionController@testController')->name('quesition.test');
    });

});