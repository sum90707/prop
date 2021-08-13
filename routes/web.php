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

Route::get('/', 'LoginController@index')->name('home');
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

        Route::group(['middleware' => 'checkAuth:admin|teacher'], function () {
            Route::get('manage', 'UserController@managePage')->name('user.manage');
            Route::get('list', 'UserController@list')->name('user.list');
            Route::put('toggle/{user}', 'UserController@toggle')->name('user.toggle');
            Route::put('toggle/auth/{user}', 'UserController@toggleAuth')->name('user.toggle.auth');
            Route::put('toggle/lang/{user}', 'UserController@toggleLang')->name('user.toggle.lang');
        });
        
    });

    
});
