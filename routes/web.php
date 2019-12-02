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
Route::get('firstloginpassword','HomeController@passwordView2' );

Route::get('/changeprofile','HomeController@profileView' );
Route::get('/myprofile','HomeController@myprofileView' );
Route::get('/myprofile','HomeController@myprofileView' )->name('myprofile');


Route::get('/dashboard', 'HomeController@dashboardView');


Route::get('/settings', 'HomeController@settingsView');

// Route::get('/create_user', 'HomeController@createUserView')->name('view.create.user');


Route::get('/stores', 'HomeController@storesView')->name('store');

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



///////////////////////////////////////////////////////////////
Route::get('minutesheets','MinuteController@minutesheets')->name('minutesheets');
Route::get('minutesheet/{id}','MinuteController@minutesheet')->name('minutesheet');
Route::post('newsheets','MinuteController@newsheet')->name('newsheet');
Route::get('conversation','MinuteController@conversation')->name('conversation');
Route::post('addconv','MinuteController@addconv')->name('addconv');

Route::get('/s-minutesheet','MinuteController@sminutesheet')->name('s-minutesheet');
Route::post('savesign','UserController@savesign')->name('savesign');
///////////////////////////////////////////////////////////////

Route::post('redirect/workorder/{id}', 'WorkOrderController@redirectToSecretary')->name('to.secretary.workorder');
Route::post('redirect/workorder_to_hos/{id}', 'WorkOrderController@redirectToHoS')->name('to.HoS.workorder');

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
Route::get('settings', 'DirectorateController@departmentsView')->name('dir.manage');
Route::post('edit/user/{id}', 'UserController@editUser')->name('user.edit');

Route::post('password/change', 'UserController@changePassword')->name('password.change');


Route::post('save/directorate', 'DirectorateController@createDirectorate')->name('directorate.save');

Route::POST('edit/directorate', 'DirectorateController@editDirectorate')->name('directorate.edit');
Route::post('delete/directorate/{id}', 'DirectorateController@deleteDirectorate')->name('directorate.delete');


Route::POST('edit/department', 'DirectorateController@editDepartment')->name('department.edit');
Route::post('delete/department/{id}', 'DirectorateController@deleteDepartment')->name('department.delete');

//////////////////////////////////////////
Route::get('/allhos','HomeController@allhos')->name('allhos');
Route::get('/alltechnicians','HomeController@alltechnicians')->name('alltechnicians');
Route::get('/alliow','HomeController@alliow')->name('alliow');
//////////////////////////////////////////

Route::POST('edit/section', 'DirectorateController@editSection')->name('section.edit');
Route::post('delete/section/{id}', 'DirectorateController@deleteSection')->name('section.delete');


Route::post('save/department', 'DirectorateController@createDepartment')->name('department.save');
Route::post('save/section', 'DirectorateController@createSection')->name('section.save');


Route::post('', 'UserController@changeProfile')->name('profile.change');
Route::get('track/work_order/{id}', 'WorkOrderController@trackWO')->name('workOrder.track');
Route::post('close/work/order/{id}/{receiver_id}', 'WorkOrderController@closeWorkOrder')->name('workorder.close');
Route::post('close/work/order/complete/{id}/{receiver_id}', 'WorkOrderController@closeWorkOrdercomplete')->name('workorder.close.complete');

Route::post('close/satisfied/{id}', 'WorkOrderController@closeWOSatisfied')->name('workorder.satisfied');
Route::post('close/notsatisfied/{id}', 'WorkOrderController@closeWONotSatisfied')->name('workorder.notsatisfied');




Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('rejected/work/orders', 'WorkOrderController@deletedWOView');


Route::get('received/materials/from_store/{id}', 'WorkOrderController@receivedmaterialview')->name('material.received');




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

Route::get('technicians', 'HomeController@techniciansView')->name('technicians');


Route::get('work_order_material_needed', 'HomeController@workOrderNeedMaterialView')->name('wo.materialneededyi');


Route::get('material_rejected_with_workorder', 'HomeController@workOrderMaterialRejected');

Route::get('material_received_with_workorder', 'HomeController@MaterialReceivewithWo');


Route::get('rejected/materials/{id}', 'WorkOrderController@rejectedmaterialview')->name('material.rejected');



Route::get('work_order_material_purchased', 'HomeController@MaterialpurchasedView')->name('wo.materialneededy');


Route::get('work_order_material_iow/{id}', 'HomeController@workOrderMaterialInspectionView')->name('material.inspection.view');

Route::get('work_order_material_purchased/{id}', 'HomeController@workOrderMaterialpurchased')->name('material.inspection.view1');




Route::get('work_order_approved_material', 'HomeController@workOrderApprovedMaterialView')->name('work_order_approved_material');



Route::get('work_order_with_missing_material', 'HomeController@workorderwithmissingmaterial')->name('work_order_with_missing_material');



Route::get('wo_material/{id}', 'HomeController@wo_materialView')->name('store.materialview');

Route::get('wo_material_to_procure/{id}', 'HomeController@wo_material_to_purchaseView')->name('store.material_to_procure_view');

Route::get('/wo_material_reserved_from_store/{id}', 'HomeController@wo_material_to_purchaseViewbystore')->name('wo.reserved.material');

Route::get('/wo_material_purchased_by_head_of_procurement', 'HomeController@wo_material_purchasedViewbyheadprocurement');


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



Route::get('material/not/material/{id}', 'StoreController@materialnotreserve')->name('store.materialtohos');


Route::get('material/afterpurchase/{id}', 'StoreController@materialafterpurchase')->name('store.material.afterpurchase');


Route::get('material/material/{id}', 'StoreController@materialtoreserveonebyone')->name('store.material.reserve');

Route::get('accept/material/{id}', 'StoreController@acceptMaterial')->name('store.materialaccept');

Route::get('accept/material/with/rejected/{id}', 'StoreController@Materialacceptedwithrejected')->name('store.materialaccept.reject');




Route::get('return/material/{id}', 'StoreController@returnMaterialHOS')->name('store.materialreturn');


Route::get('accept/material/independently/{id}', 'StoreController@acceptMaterialonebyone')->name('store.materialacceptonebyone');

Route::post('reject/material/{id}', 'StoreController@rejectMaterial')->name('store.materialreject');
Route::post('reject/material/independent/{id}', 'StoreController@rejectMaterialonebyone')->name('store.materialrejectonebyone');

Route::get('store/material_request/{id}','StoreController@material_request_hos')->name('material_request_hos');

Route::get('store/material_reserve/{id}','StoreController@ReserveMaterial')->name('ReserveMaterial');

Route::get('send/material_again/{id}','StoreController@materialaddagain')->name('SendMaterialAgain');

Route::get('received/materials/from_store/tick/material_received/{id}','WorkOrderController@tickmaterial');


Route::get('send/material_rejected_again/{id}','StoreController@materialrejectedaddagain')->name('SendMaterialrejectedAgain');






Route::get('release/material/{id}', 'StoreController@releaseMaterial')->name('store.materialrelease');

Route::get('notify/store/material/{id}', 'StoreController@releaseMaterialafterpurchased')->name('store.materialafterpurchase');



Route::get('wo_transport_request', 'HomeController@transport_request_View')->name('wo_transport_request');


//Route::get('transport_request/accept/{id}','WorkOrderController@transport_request_accept')->name('transportrequest.accept');
Route::post('transport_request/accept','WorkOrderController@transport_request_accept')->name('transportrequest.accept');


Route::get('transport_request/reject/{id}','WorkOrderController@transport_request_reject')->name('transportrequest.reject');




Route::get('work_order_material_accepted/{id}', 'HomeController@woMaterialAcceptedView')->name('woMaterialAccepted');


Route::get('work_order_material_rejected', 'HomeController@woMaterialRejectedView')->name('woMaterialRejected');

Route::get('comp','UserController@comp')->name('comp');


Route::post('Complaint','UserController@Complaint')->name('Complaint');
Route::get('complian/{id}','UserController@complian')->name('complian');

Route::get('allpdf','NotesController@allpdf')->name('allpdf');
 Route::get('wowithdurationpdf','NotesController@wowithdurationpdf');
 Route::get('roomreportpdf','NotesController@roomreportpdf');
 Route::get('techniciancompleteworkpdf','NotesController@techniciancompleteworkpdf');
 Route::get('hosCountpdf','NotesController@hosCountpdf');
 Route::get('unattendedwopdf','NotesController@unattendedwopdf');
 Route::get('completewopdf','NotesController@completewopdf'); 
 Route::get('work_order_material_purchased/grnpdf/{id}','NotesController@grnotepdf');
 Route::get('received/materials/from_store/issuenotepdf/{id}','NotesController@issuenotepdf');


Route::get('wo_transport_request_accepted', 'HomeController@woTransportAcceptedView')->name('woTransportAccepted');

Route::get('wo_transport_request_rejected', 'HomeController@woTransportRejectedView')->name('woTransportRejected');



Route::get('gettechniciandetails/{id}', 'TechnicianController@getTechnicianDetails');

Route::get('work_order_technician_complete/{id}', 'WorkOrderController@woTechnicianComplete')->name('workOrder.technicianComplete');



Route::get('/unattended_work_orders', 'HomeController@unattendedWorkOrdersView')->name('unattended_work_orders');

Route::get('/completed_work_orders', 'HomeController@completedWorkOrdersView')->name('completed_work_orders');



Route::get('/roomreport', 'HomeController@roomreportView')->name('roomreport');
Route::get('/store_report', 'HomeController@storereportView')->name('store_report');

Route::get('/woduration', 'HomeController@woduration')->name('woduration');

Route::get('/hoscount', 'HomeController@hoscount')->name('hoscount');

Route::get('/techniciancount', 'HomeController@techniciancount')->name('techniciancount');
Route::get('/techniciancountcomp', 'HomeController@techniciancountcomp')->name('techniciancountcomp');

Route::get('work_order_change_type/{id}', 'WorkOrderController@woChangeTypeView')->name('workOrder.changetype');

Route::post('/changewoType', 'WorkOrderController@changewoType')->name('change_wo_ptype');


 Route::get('pdf', 'NotesController@pdf');

 Route::get('userpdf', 'NotesController@userspdf');
 Route::get('materialpdf', 'NotesController@storespdf'); 
 Route::get('unatendedwopdf', 'NotesController@unatendedpdf');               


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


Route::get('work_order_material_missing', 'HomeController@workOrderMissingMaterialView')->name('wo.materialneeded');

Route::get('work_order_material_missing/{id}', 'HomeController@workOrderMaterialMissingInspectionView')->name('material.missing.inspection.view');
Route::get('insufficient/material/{id}', 'StoreController@insufficientMaterial')->name('store.insufficientmaterial');




 Route::get('/technician_report', 'AssetsController@TecnicianView')->name('view.report');

 Route::get('/workorder_report', 'HomeController@WorkorderReportView');

 Route::get('htmlpdf58','PDFController@htmlPDF58');
Route::get('generatePDF58','PDFController@generatePDF58');


Route::POST('editmaterialrequest', 'WorkOrderController@editmaterialforwork')->name('requestagain.save');

Route::POST('rejected/materials/edit/Material/{id}', 'WorkOrderController@editmaterial')->name('material.edit');

Route::POST('work_order_material_purchased/edit/Material/{id}', 'StoreController@incrementmaterialmodal');

Route::POST('work_order_material_purchased/edit2/Material/{id}', 'StoreController@incrementmaterialmodal2');


Route::POST('work_order_material_iow/reject/Material/{id}', 'StoreController@materialrejectonebyone');


Route::POST('edit/work_order/view/edit/Material_hos/{id}', 'WorkOrderController@editmaterialhos')->name('material.edit');


 Route::get('wo_material_reserved', 'HomeController@material_reserved');

 Route::get('wo_material_accepted', 'HomeController@material_accepted');

 //Route::get('requested/material/{id}', 'StoreController@MaterialrequestView')->name('store.materialaccept');

 Route::get('wo_material_accepted_by_iow', 'HomeController@materialacceptedbyiow')->name('wo_material_accepted_by_iow');  //after material accepted by iow then flow to store

 Route::get('wo_material_accepted_by_iow/{id}', 'HomeController@wo_material_acceptedbyIOWView')->name('store.materia_accepte_by_iow'); //material accepted by iow view



 Route::post('delete/material/{id}', 'StoreController@deletematerial')->name('material.delete');
 Route::get('trackreport/{id}','NotesController@trackreport')->name('trackreport');