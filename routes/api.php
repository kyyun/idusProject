<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register/user', 'LoginController@registerUsers');

Route::post('/login', 'LoginController@loginUsers');

Route::post('/logout', 'LoginController@logOutUsers');

Route::get('/profile', 'UsersController@getProfile');

Route::get('/orderDetails/list', 'UsersController@getOrderDetailsList');

Route::get('/users/list', 'UsersController@getUsersList');
