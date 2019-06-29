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

Route::get('/',['uses'=>'UsersController@index','as'=>'home']);
Route::get('/book',['uses'=>'BookController@index','as'=>'book']);

Route::group(['prefix'=> 'admin'], function() {
    Route::get('/',['uses'=>'UsersController@login','as'=>'login']);
    Route::post('/',['uses'=>'UsersController@isLogin','as'=>'islogin']);

    Route::group(['middleware' =>'roles'],function (){
        Route::get('/dashboard',['uses'=>'UsersController@dashboard','as'=>'dashboard']);
        Route::get('/logout',['uses'=>'UsersController@logout','as'=>'logout']);
    });

});