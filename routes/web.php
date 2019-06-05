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

Route::get('password','HomeController@passwordView' );
Route::get('/changeprofile','HomeController@profileView' );
Route::get('/myprofile','HomeController@myprofileView' );

Route::get('/dashboard', 'HomeController@dashboardView');


Route::get('/settings', 'HomeController@settingsView');

// Route::get('/create_user', 'HomeController@createUserView')->name('view.create.user');


Route::get('/stores', 'HomeController@storesView');
Route::get('/work_order', 'HomeController@WorkorderView')->name('work_order');

Route::get('/viewusers', 'HomeController@usersView')->name('users.view');

Route::get('/createworkorders', 'HomeController@createWOView');



Route::get('/addmaterial', 'HomeController@AddMaterialVO');





Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/createuser', 'UserController@create')->name('user.create');

Route::post('/viewusers/delete/{id}', 'UserController@deleteUser')->name('user.delete');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
Route::get('/create_user', 'HomeController@createUserView')->name('createUserView');

Route::post('workorder/create', 'WorkOrderController@create')->name('workorder.create');
Route::post('workorder/reject/{id}', 'WorkOrderController@rejectWO')->name('workorder.reject');
Route::post('workorder/accept/{id}', 'WorkOrderController@acceptWO')->name('workorder.accept');
Route::get('edit/work_order/view/{id}', 'WorkOrderController@editWOView')->name('workOrder.edit.view');
Route::get('view/work_order/{id}', 'WorkOrderController@viewWO')->name('workOrder.view');
Route::post('edit/work_order/{id}', 'WorkOrderController@editWO')->name('workOrder.edit');
Route::post('inspect/work_order/{id}', 'WorkOrderController@fillInspectionForm')->name('work.inspection');

Route::post('assigntech/work_order/{id}', 'WorkOrderController@assigntechnicianforwork')->name('work.assigntechnician');
Route::post('transportrequest/work_order/{id}', 'WorkOrderController@transportforwork')->name('work.transport');

Route::post('materialadd/work_order/{id}', 'WorkOrderController@materialaddforwork')->name('work.materialadd');
Route::post('redirect/workorder/{id}', 'WorkOrderController@redirectToSecretary')->name('to.secretary.workorder');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('departments', 'UserController@getDepartments')->name('departments.view');
Route::get('areas', 'UserController@getAreas')->name('areas.view');
Route::get('blocks', 'UserController@getBlocks')->name('blocks.view');
Route::get('rooms', 'UserController@getRooms')->name('rooms.view');
Route::get('sections', 'UserController@getSections')->name('departments.view');
Route::get('edit/user/view/{id}', 'UserController@editUserView')->name('user.edit.view');
Route::get('manage_directorates', 'DirectorateController@departmentsView')->name('dir.manage');
Route::post('edit/user/{id}', 'UserController@editUser')->name('user.edit');

Route::post('password/change', 'UserController@changePassword')->name('password.change');


Route::post('save/directorate', 'DirectorateController@createDirectorate')->name('directorate.save');

Route::POST('edit/directorate', 'DirectorateController@editDirectorate')->name('directorate.edit');
Route::post('delete/directorate/{id}', 'DirectorateController@deleteDirectorate')->name('directorate.delete');


Route::POST('edit/department', 'DirectorateController@editDepartment')->name('department.edit');
Route::post('delete/department/{id}', 'DirectorateController@deleteDepartment')->name('department.delete');



Route::POST('edit/section', 'DirectorateController@editSection')->name('section.edit');
Route::post('delete/section/{id}', 'DirectorateController@deleteSection')->name('section.delete');


Route::post('save/department', 'DirectorateController@createDepartment')->name('department.save');
Route::post('save/section', 'DirectorateController@createSection')->name('section.save');


Route::post('', 'UserController@changeProfile')->name('profile.change');
Route::get('track/work_order/{id}', 'WorkOrderController@trackWO')->name('workOrder.track');
Route::post('close/work/order/{id}/{receiver_id}', 'WorkOrderController@closeWorkOrder')->name('workorder.close');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('rejected/work/orders', 'WorkOrderController@deletedWOView');
Route::post('read/notification/{id}/{type}', 'NotificationController@readNotification')->name('notify.read');

Route::post('/myprofile', 'UserController@update_avatar');


/*Route::get('add/technician', 'WorkOrderController@addTechView')->name('tech.add');
Route::post('create/technician', 'WorkOrderController@createTech')->name('tech.create');*/


Route::post('/myprofile', 'UserController@update_avatar');

Route::get('/addmaterial', 'StoreController@addmaterialView')->name('add_material');

Route::post('newmaterial', 'StoreController@addnewmaterail')->name('material.create');
Route::get('/incrementmaterial/{id}', 'StoreController@incrementmaterialView')->name('storeIncrement.view');


Route::post('incrementmaterial', 'StoreController@incrementmaterial')->name('material.increment');













