<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:api'], function()
{
    Route::resource('user', 'ApiController\UserController');
    Route::resource('group', 'ApiController\GroupController');
    Route::resource('user-group', 'ApiController\UsersGroupsController');
});

Route::post('login', 'ApiController\ApiController@login');
Route::post('register', 'ApiController\ApiController@register');
Route::group(['middleware' => 'auth:api'], function(){
Route::post('details', 'ApiController\ApiController@details');
});
