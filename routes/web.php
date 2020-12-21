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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/', 'App\Http\Controllers\PagesController@index');

Route::get('/signup', function(){
    return view('pages.signup');
});

Route::post('/signup','App\Http\Controllers\RegisterController@register');
Route::get('/email/verify', function(){
    return view('cognito.verify');
});
Route::get('/login', function(){
    return view('pages.login');
})->name("login");


Route::post('/login','App\Http\Controllers\LoginController@login');

Route::get("/user/home", function(){
    return view('pages.user');
})->name("user/home");
Route::get('/email/verify', function(){
    return view('cognito.verify');
})->name('cognito.verification-notice');;

Route::group(['middleware' => 'web', 'namespace' => 'App\Http\Controllers'], function () {
    Route::get('/password-reset', 'Auth\ResetPasswordController@showResetForm')
        ->name('cognito.password-reset');
    Route::get('/email/verify', function(){
        return view('cognito.verify');
    })->name('cognito.verification-notice');
    Route::post('/email/verify', 'Auth\VerificationController@verify')
        ->name('cognito.verification.verify');
    Route::post('/email/resend', 'Auth\VerificationController@resend')
        ->name('cognito.verification-resend');

});
        
