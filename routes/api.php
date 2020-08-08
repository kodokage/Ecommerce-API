<?php

use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'v1', 'namespace' => 'Api'], function () {

    Route::group(['namespace' => 'Auth', 'middleware' => 'guest:api'], function () {
        Route::post('register', 'RegisterController@register')->name('api.register');
        Route::post('login', 'LoginController@login')->name('api.login');
        Route::post('/social-auth/autorize', 'LoginController@socialAuth')->name('api.social.auth');
        Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('api.password.request');
        Route::post('password/reset', 'ResetPasswordController@reset')->name('api.password.reset');
    });

    Route::group(['namespace' => 'Auth'], function () {
        Route::post('/email/verify', 'VerificationController@verify')->name('api.verification.verify');
    });

    Route::group(['namespace' => 'Auth', 'middleware' => 'auth:api'], function () {
        Route::post('logout', 'LoginController@logout')->name('api.logout');
        Route::post('refresh', 'LoginController@refresh')->name('refresh.token');
    });

    Route::patch('/onboard', 'UserOnboardController@update')->name('onboard.update')->middleware('auth:api');

    Route::group(['prefix' => 'dashboard-buyer', 'middleware' => [ 'auth:api', 'Buyer']], function () {
        Route::get('/index', 'UserOnboardController@index');
        Route::post('/transaction', 'TransactionController@store');
    });
    
    Route::group(['prefix' => 'dashboard-seller', 'middleware' => ['auth:api', 'Seller']], function () {
        Route::get('/index', 'UserOnboardController@index'); 
        Route::get('/products', 'ProductController@userProduct'); 
        Route::post('/product', 'ProductController@store');
        Route::patch('/product/{id}', 'ProductController@update');
        Route::delete('/product/{id}','ProductController@destroy');
    });

    Route::group(['prefix' => 'admin', 'middleware' => ['auth:api', 'Admin']], function () {
            Route::get('/index', 'AdminController@index');
            Route::get('/users', 'AdminController@users');
            Route::patch('/user/{id}', 'AdminController@update');
            Route::get('/products', 'AdminController@getProduct');
            Route::patch('/product/{id}', 'AdminController@updateProduct');
            Route::get('/transactions', 'TransactionController@index');
            Route::patch('/transaction/{id}', 'TransactionController@update');
            Route::patch('/subscription/{id}', 'SubscriptionController@update');
    });

    Route::group(['prefix'=>'dashboard'], function(){
            Route::get('/products', 'ProductController@index');
            Route::get('/product/{id}', 'ProductController@show');
            Route::get('/subscription', 'SubscriptionController@index')->middleware('auth:api');
            Route::get('/subscription/{id}', 'SubscriptionController@show')->middleware('auth:api');
            Route::post('/subscription', 'SubscriptionController@store')->middleware('auth:api');
    });
            
});