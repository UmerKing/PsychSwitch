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
Auth::routes(['verify' => true]);
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/doctors/registered', 'Admin\Doctors\DoctorsController@registered');
Route::get('/doctors/unconfirmed', 'Admin\Doctors\DoctorsController@unconfirmed');
Route::get('/admin', 'Admin\DashboardController@index')
    ->middleware('is_admin')
    ->name('index');