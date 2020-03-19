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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function (){
    /* Login */
    Route::get('/dang-nhap', 'AuthController@showLogin')->name('admin.getLogin');
    Route::post('/dang-nhap', 'AuthController@postLogin')->name('admin.postLogin');

    /*Logout*/
    Route::get('/dang-xuat', 'AuthController@logout')->name('admin.logout');

    /* Forgot Password */
    Route::get('/quen-mat-khau', 'AuthController@showForgotPassword')->name('admin.getForgot');
    Route::post('/quen-mat-khau', 'AuthController@postForgotPassword')->name('admin.postForgotPassword');

    /* Reset Password */
    Route::get('/password/reset/{token}', 'AuthController@showResetPassword')->name('admin.getPasswordReset');
    Route::post('/password/reset/{token}', 'AuthController@postResetPassword')->name('admin.postResetPassword');

    Route::post('/active-account/{token}', 'AuthController@activeAccount')->name('admin.activeAccount');

    Route::group(['middleware' => 'adminmiddleware'], function () {
        /* Register */
        Route::get('/dang-ky', 'AuthController@showRegister')->name('admin.getRegister');
        Route::post('/dang-ky', 'AuthController@postRegister')->name('admin.postRegister');

        /* ChangePassword */
        Route::get('/doi-mat-khau', 'AuthController@showChangePassword')->name('admin.getChangePassword');
        Route::post('/doi-mat-khau', 'AuthController@postChangePassword')->name('admin.postChangePassword');

        Route::get('/', 'DashboardController@index')->name('admin.dashboard');
    });

});