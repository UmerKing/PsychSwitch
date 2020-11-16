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

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('index');

Route::middleware(['is_doctor'])->group(function () {
    Route::get('/approval', 'HomeController@approval')->name('approval');
    Route::middleware(['approved'])->group(function () {
        Route::get('/doctor/profile', 'DoctorController@profile')->name('doctor.profile');
        Route::post('/doctor/update/{id}', 'DoctorController@update');
        Route::get('/doctor/timings', 'DoctorController@timingsAndRates');
        Route::post('/doctor/store', 'TimingSlotController@store');
        Route::get('/doctor/timings/show', 'TimingSlotController@show');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::middleware(['is_admin'])->group(function () {
        Route::get('/doctors/unconfirmed', 'Admin\Doctors\DoctorsController@unconfirmed')->name('admin.doctors.unconfirmed');
        Route::get('/doctors/registered', 'Admin\Doctors\DoctorsController@registered')->name('admin.doctors.registered');
        Route::get('/doctors/{doctor_id}/approve', 'Admin\Doctors\DoctorsController@approve')->name('admin.doctors.approve');
        Route::get('/doctors/{id}/profile', 'Admin\Doctors\DoctorsController@profile')->name('admin.doctors.profile');
        Route::get('/admin', 'Admin\DashboardController@index')->name('index');
        Route::get('/doctors/{notification_id}/markread', 'Admin\Doctors\DoctorsController@markRead')->name('admin.doctors.markread');
    });
});