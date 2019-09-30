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

Route::get('/storeshos', 'HomeController@storeshosView');


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

Route::post('purchasing_order/work_order/{id}', 'WorkOrderController@purchasingorder')->name('work.purchasingorder');

Route::post('procurement/grn/{id}', 'PurchasingOrderController@signGRN')->name('procurement.grn');





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

Route::post('close/satisfied/{id}', 'WorkOrderController@closeWOSatisfied')->name('workorder.satisfied');
Route::post('close/notsatisfied/{id}', 'WorkOrderController@closeWONotSatisfied')->name('workorder.notsatisfied');




Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('rejected/work/orders', 'WorkOrderController@deletedWOView');
Route::post('read/notification/{id}/{type}', 'NotificationController@readNotification')->name('notify.read');

Route::post('/myprofile', 'UserController@update_avatar');


Route::get('add/technician', 'TechnicianController@techView')->name('techs.view');
Route::post('create/technician', 'TechnicianController@createTech')->name('tech.create');
Route::get('edit/technician/{id}', 'TechnicianController@editTechView')->name('tech.edit.view');
Route::post('edit/technician/{id}', 'TechnicianController@editTech')->name('tech.edit');
Route::post('delete/technician/{id}', 'TechnicianController@deleteTech')->name('tech.delete');


Route::post('/myprofile', 'UserController@update_avatar');

Route::get('/addmaterial', 'StoreController@addmaterialView')->name('add_material');

Route::post('newmaterial', 'StoreController@addnewmaterail')->name('material.create');
Route::get('/incrementmaterial/{id}', 'StoreController@incrementmaterialView')->name('storeIncrement.view');


Route::post('incrementmaterial', 'StoreController@incrementmaterial')->name('material.increment');

Route::get('technicians', 'HomeController@techniciansView');






Route::get('work_order_material_needed', 'HomeController@workOrderNeedMaterialView')->name('wo.materialneeded');
Route::get('work_order_material_iow/{id}', 'HomeController@workOrderMaterialInspectionView')->name('material.inspection.view');



Route::get('work_order_approved_material', 'HomeController@workOrderApprovedMaterialView')->name('work_order_approved_material');

Route::get('wo_material_view/{id}', 'HomeController@wo_materialView')->name('store.materialview');


Route::get('work_order_purchasing_request', 'HomeController@work_order_purchasing_requestView')->name('work_order_purchasing_request');

Route::get('workorder/procurement', 'PurchasingOrderController@procurematerial')->name('procurematerial');


Route::get('wo_purchasing_order/{id}', 'HomeController@wo_purchasing_orderView')->name('procurementorder.view');
Route::get('grn_procurement/{id}', 'HomeController@wo_grn_listView')->name('procurement.grn.view');

Route::get('wo_procurement_order/{id}', 'HomeController@wo_procurement_orderView')->name('procurementorder.view');

Route::get('wo_procurement_order/{id}', 'HomeController@procureiow_list')->name('procureiow_list.view');
Route::get('po/accept/{id}', 'PurchasingOrderController@purchasingOrderAccept')->name('po.accept');

Route::get('po/reject/{id}', 'PurchasingOrderController@purchasingOrderReject')->name('po.reject');
Route::get('work_order_procurement_request', 'PurchasingOrderController@work_order_procurement_requestView')->name('work_order_procurement_request');
Route::get('grn_release/{id}', 'PurchasingOrderController@grn_releaseView')->name('grn_release.view');



Route::get('work_order_released_material', 'HomeController@workOrderReleasedMaterialView')->name('work_order_released_material');

Route::get('work_order_grn', 'HomeController@workOrdergrnView')->name('work_order_grn');

Route::get('wo_release_grn', 'HomeController@wo_release_grn')->name('wo_release_grn');
Route::get('grn_release_list/{id}', 'PurchasingOrderController@grn_release_list')->name('grn_release_list');
Route::get('procurement_release/{id}', 'PurchasingOrderController@procurement_release')->name('procurement.release');






Route::get('accept/material/{id}', 'StoreController@acceptMaterial')->name('store.materialaccept');
Route::get('reject/material/{id}', 'StoreController@rejectMaterial')->name('store.materialreject');

Route::get('store/material_request/{id}','StoreController@material_request_hos')->name('material_request_hos');



Route::get('release/material/{id}', 'StoreController@releaseMaterial')->name('store.materialrelease');



Route::get('wo_transport_request', 'HomeController@transport_request_View')->name('wo_transport_request');


//Route::get('transport_request/accept/{id}','WorkOrderController@transport_request_accept')->name('transportrequest.accept');
Route::post('transport_request/accept','WorkOrderController@transport_request_accept')->name('transportrequest.accept');


Route::get('transport_request/reject/{id}','WorkOrderController@transport_request_reject')->name('transportrequest.reject');




Route::get('work_order_material_accepted', 'HomeController@woMaterialAcceptedView')->name('woMaterialAccepted');


Route::get('work_order_material_rejected', 'HomeController@woMaterialRejectedView')->name('woMaterialRejected');










Route::get('wo_transport_request_accepted', 'HomeController@woTransportAcceptedView')->name('woTransportAccepted');

Route::get('wo_transport_request_rejected', 'HomeController@woTransportRejectedView')->name('woTransportRejected');



Route::get('gettechniciandetails/{id}', 'TechnicianController@getTechnicianDetails');

Route::get('work_order_technician_complete/{id}', 'WorkOrderController@woTechnicianComplete')->name('workOrder.technicianComplete');



Route::get('/unattended_work_orders', 'HomeController@unattendedWorkOrdersView')->name('unattended_work_orders');

Route::get('/completed_work_orders', 'HomeController@completedWorkOrdersView')->name('completed_work_orders');



Route::get('/roomreport', 'HomeController@roomreportView')->name('roomreport');

Route::get('/woduration', 'HomeController@woduration')->name('woduration');

Route::get('/hoscount', 'HomeController@hoscount')->name('hoscount');

Route::get('/techniciancount', 'HomeController@techniciancount')->name('techniciancount');
Route::get('/techniciancountcomp', 'HomeController@techniciancountcomp')->name('techniciancountcomp');

Route::get('work_order_change_type/{id}', 'WorkOrderController@woChangeTypeView')->name('workOrder.changetype');

Route::post('/changewoType', 'WorkOrderController@changewoType')->name('change_wo_ptype');


 Route::get('pdf', 'NotesController@pdf');

 Route::get('sms', 'SmsController@sendSms');




 Route::get('manage_Houses', 'AssetsController@HousesView')->name('register.house');

 
Route::post('HouseRegistration', 'AssetsController@RegisterHouse')->name('house.save');
Route::post('delete/House/{id}', 'AssetsController@deleteHouse')->name('house.delete');
Route::POST('edit/House', 'AssetsController@editHouse')->name('house.edit');
Route::get('Register_Staffhouse', 'AssetsController@Registerstaffhouseview')->name('registerstaffhouse');




Route::post('HallRegistration', 'AssetsController@RegisterHalls')->name('hall.save');
Route::post('delete/Hall/{id}', 'AssetsController@deleteHall')->name('hall.delete');
Route::POST('edit/Hall', 'AssetsController@editHall')->name('hall.edit');
Route::get('Register_hall', 'AssetsController@Registerhallview')->name('registerhall');




Route::post('CampusRegistration', 'AssetsController@RegisteCampus')->name('campus.save');
Route::POST('edit/Campus', 'AssetsController@editcampus')->name('campus.edit');
Route::post('delete/Campus/{id}', 'AssetsController@deletecampus')->name('campus.delete');
Route::get('Register_Campus', 'AssetsController@Registercampusview')->name('registercampus');



Route::post('ZoneRegistration', 'AssetsController@RegisterZone')->name('zone.save');
Route::post('delete/zone/{id}', 'AssetsController@deletezone')->name('zone.delete');
Route::POST('edit/zone', 'AssetsController@editzone')->name('zone.edit');
Route::get('Register_Zone', 'AssetsController@Registercleanzoneview')->name('registercleaningzone');



Route::post('CleaningAreaRegistration', 'AssetsController@RegisterCleaningArea')->name('area.save');
Route::post('delete/cleanarea/{id}', 'AssetsController@deletecleanarea')->name('cleanarea.delete');
Route::POST('edit/cleaningarea', 'AssetsController@editcleanarea')->name('cleanarea.edit');
Route::get('Register_Cleaningarea', 'AssetsController@Registercleaningareaview')->name('Registercleaningarea');





