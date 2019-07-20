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

//Route::get('/',['uses'=>'UsersController@index','as'=>'home']);
Route::get('/',['uses'=>'BookController@index','as'=>'book']);
Route::post('/room-booking/save',['uses'=>'BookController@save','as'=>'room-booking.save']);
Route::get('/room-booking/show-all',['uses'=>'BookController@listsBooking','as'=>'room-booking.show-all']);
Route::get('/room-booking/search',['uses'=>'BookController@search','as'=>'room-booking.search']);

Route::group(['prefix'=> 'admin'], function() {
    Route::get('/',['uses'=>'UsersController@login','as'=>'login']);
    Route::post('/',['uses'=>'UsersController@isLogin','as'=>'islogin']);

    Route::group(['middleware' =>'roles'],function (){
        Route::get('/dashboard',['uses'=>'UsersController@dashboard','as'=>'dashboard']);   
        Route::get('/add-new',['uses'=>'UsersController@createBooking','as'=>'lists-booking.add-new']);  
        Route::post('/save',['uses'=>'UsersController@saveBooking','as'=>'lists-booking.save']);     
        Route::get('/lists-booking/{action}',['uses'=>'UsersController@listsBooking','as'=>'lists-booking']);
        Route::get('/lists-booking/edit/{id}',['uses'=>'UsersController@editBooking','as'=>'edit-booking']);
        Route::post('/lists-booking/update/{id}',['uses'=>'UsersController@updateBooking','as'=>'update-booking']);
        Route::post('/lists-booking/delete',['uses'=>'UsersController@deleteBooking','as'=>'delete-booking']);
        Route::get('/search',['uses'=>'UsersController@search','as'=>'search-booking']);
        Route::get('/logout',['uses'=>'UsersController@logout','as'=>'logout']);
    });

});