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

        Route::get('chang-password', 'UserController@changePwd')->name('user.change.password');
        Route::post('change-save', 'UserController@changeSave')->name('user.save.password');

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
        Route::get('admin', 'QuesitionController@admin')->name('quesition.admin');
        Route::put('toggle/{quesition}', 'QuesitionController@toggle')->name('quesition.toggle');
        //test function route
        Route::get('test', 'QuesitionController@testController')->name('quesition.test');
    });


    Route::prefix('paper')->group(function() {
        Route::get('admin', 'PaperController@admin')->name('paper.admin');
        Route::get('list', 'PaperController@list')->name('paper.list');
        Route::get('form/{paper?}', 'PaperController@form')->name('paper.form');
        Route::post('save/{paper?}', 'PaperController@save')->name('paper.save');
        Route::put('toggle/{paper}', 'PaperController@toggle')->name('paper.toggle');
    });

});