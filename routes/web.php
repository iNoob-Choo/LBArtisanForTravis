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

Route::get('/', function () {
    return view('home');
})->middleware('auth');

Auth::routes();


Route::get('/home', 'HomeController@index')->name('user.dashboard');
Route::get('/users/logout', 'Auth\LoginController@userLogout')->name('user.logout');

Route::group(['prefix' => 'keys',  'middleware' => 'auth'], function()
{
    Route::resource('APIKEY','APIKEYController',['except' => [
    'show', 'edit', 'update',
    ]]);
});
Route::group(['prefix' => 'LB',  'middleware' => 'auth'], function()
{
    Route::resource('LoadBalancers','LBController');
    Route::resource('Frontend','FrontendServerController',['except' => [
    'create',
    ]]);
    Route::get('/Frontend/{Frontend}/create',function($id){
      $lb_id = $id;
      return view('frontendserver.create')->withLb_id($lb_id);
    })->name('Frontend.create');
    Route::resource('Backend','BackendServerController',['except' => [
    'create',
    ]]);
    Route::get('/Backend/{Backend}/create',function($id){
      $front_id = $id;
      return view('backendserver.create')->withFront_id($front_id);
    })->name('Backend.create');
    Route::get('/ssh/{lbid}', ['uses'=>'SSHController@index'])->name('LoadBalancers.deploy');
    Route::get('/shutdown/{lbid}',['uses'=>'LBController@shutDownLB'])->name('LoadBalancers.shutdown');
    Route::get('/boot/{lbid}',['uses'=>'LBController@bootLB'])->name('LoadBalancers.boot');
});

Route::group(['prefix' => 'users',  'middleware' => 'auth'], function()
{
  Route::get('/users/{users}/edit}',['uses'=>'UserController@edit'])->name('User.edit');
  Route::PUT('/users/{users}}',['uses'=>'UserController@update'])->name('User.update');
});
Route::group(['prefix' => 'admin',  'middleware' => 'auth:admin'], function()
{
    Route::resource('users','UserController');
});

Route::prefix('admin')->group(function() {
  Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
  Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
  Route::get('/', 'AdminController@index')->name('admin.dashboard');
  Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');

  // Password reset routes
  Route::post('/password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
  Route::get('/password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
  Route::post('/password/reset', 'Auth\AdminResetPasswordController@reset');
  Route::get('/password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');
});
