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
    return view('welcome');
});

Route::get('/notification', 'HomeController@notificationView');

Route::get('/password','HomeController@passwordView' );

Route::get('/dashboard', 'HomeController@dashboardView');


Route::get('/settings', 'HomeController@settingsView');

// Route::get('/create_user', 'HomeController@createUserView')->name('view.create.user');


Route::get('/stores', 'HomeController@storesView');
Route::get('/work_order', 'HomeController@WorkorderView')->name('work_order');

Route::get('/viewusers', 'HomeController@usersView')->name('users.view');

Route::get('/createworkorders', 'HomeController@createWOView');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/createuser', 'UserController@create')->name('user.create');

Route::post('/viewusers/delete/{id}', 'UserController@deleteUser')->name('user.delete');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
Route::get('/create_user', 'HomeController@createUserView')->name('createUserView');

Route::post('workorder/create', 'WorkOrderController@create')->name('workorder.create');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('departments', 'UserController@getDepartments')->name('departments.view');
Route::get('sections', 'UserController@getSections')->name('departments.view');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
