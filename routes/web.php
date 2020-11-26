<?php
use Illuminate\Support\Facades\Auth;
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
Auth::routes();
Route::get('/', function () {
    return view('welcome');
});

Route::get('/notification', 'HomeController@notificationView')->middleware('auth');

Route::get('password','HomeController@passwordView' )->middleware('auth');
Route::get('firstloginpassword','HomeController@passwordView2' )->middleware('auth');

Route::get('/changeprofile','HomeController@profileView' )->middleware('auth');
Route::get('/myprofile','HomeController@myprofileView' )->name('myprofile')->middleware('auth');


Route::get('/dashboard', 'HomeController@WorkorderView')->middleware('auth');


Route::get('/settings', 'HomeController@settingsView')->middleware('auth');

// Route::get('/create_user', 'HomeController@createUserView')->name('view.create.user')->middleware('auth');


Route::get('/stores', 'HomeController@storesView')->name('store')->middleware('auth');

Route::get('/storeshos', 'HomeController@storeshosView')->middleware('auth');


Route::get('/completed_works_order', 'HomeController@completed_work_orders')->name('completed_works_order')->middleware('auth');


Route::get('/work_order', 'HomeController@WorkorderView')->name('work_order')->middleware('auth');

Route::get('/redirected_work_order', 'HomeController@Workorderredirectedview')->middleware('auth');

Route::get('/viewusers', 'HomeController@usersView')->name('users.view')->middleware('auth');

Route::get('/selectzoneforinspectorofwork', 'HomeController@iowzone')->name('users.inspectorofwork')->middleware('auth');


Route::get('/createworkorders', 'HomeController@createWOView')->middleware('auth');



Route::get('/addmaterial', 'HomeController@AddMaterialVO')->middleware('auth');


/////////////////////////
Route::get('depgenerate','NotesController@depgenerate')->name('depgenerate')->middleware('auth');
Route::get('colgenerate','NotesController@colgenerate')->name('colgenerate')->middleware('auth');
/////////////////////
Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::post('/createuser', 'UserController@create')->name('user.create')->middleware('auth');

Route::post('/createuseriow', 'UserController@createuseriow')->name('user.createiow')->middleware('auth');

Route::post('/viewusers/delete/{id}', 'UserController@deleteUser')->name('user.delete')->middleware('auth');




Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard')->middleware('auth');
Route::get('/create_user', 'HomeController@createUserView')->name('createUserView')->middleware('auth');
//Route::post('workorder/create', 'WorkOrderController@create')->name('workorder.create');
Route::post('workorder/reject/{id}', 'WorkOrderController@rejectWO')->name('workorder.reject');
Route::post('workorder/accept/{id}', 'WorkOrderController@acceptWO')->name('workorder.accept');
Route::get('edit/work_order/view/{ids}', 'WorkOrderController@editWOView')->name('workOrder.edit.view');
Route::get('view/work_order/{id}', 'WorkOrderController@viewWO')->name('workOrder.view');
Route::post('edit/work_order/{id}', 'WorkOrderController@editWO')->name('workOrder.edit');
Route::post('edit/work_order/zone/two/{id}', 'WorkOrderController@editWOzonetwo')->name('workOrder.edit.zoneloctwo');
Route::post('edit/work_order/zone/{id}', 'WorkOrderController@editWOzone')->name('workOrder.edit.zoneloc');
Route::post('inspect/work_order/{id}', 'WorkOrderController@fillInspectionForm')->name('work.inspection');
Route::post('fillinspection/work/afteriow{id}', 'WorkOrderController@fillInspectionFormafterrejectiow')->name('work.inspection.afterioreject');
Route::get('myzone','WorkOrderController@myzone')->name('myzone');


Route::post('workorder/create', 'WorkOrderController@create')->name('workorder.create')->middleware('auth');
Route::post('workorder/reject/{id}', 'WorkOrderController@rejectWO')->name('workorder.reject')->middleware('auth');
Route::post('workorder/accept/{id}', 'WorkOrderController@acceptWO')->name('workorder.accept')->middleware('auth');
Route::get('edit/work_order/view/{id}', 'WorkOrderController@editWOView')->name('workOrder.edit.view')->middleware('auth');
Route::get('view/work_order/{id}', 'WorkOrderController@viewWO')->name('workOrder.view')->middleware('auth');
Route::post('edit/work_order/{id}', 'WorkOrderController@editWO')->name('workOrder.edit')->middleware('auth');
Route::post('edit/work_order/zone/{id}', 'WorkOrderController@editWOzone')->name('workOrder.edit.zoneloc')->middleware('auth');
//Route::post('inspect/work_order/{id}', 'WorkOrderController@fillInspectionForm')->name('work.inspection')->middleware('auth');
Route::get('myzone','WorkOrderController@myzone')->name('myzone')->middleware('auth');

Route::post('assigntech/work_order/{id}', 'WorkOrderController@assigntechnicianforwork')->name('work.assigntechnician')->middleware('auth');

Route::post('assigntechafterreject/work_order/{id}', 'WorkOrderController@assigntechnicianafterreject')->name('work.assigntechnician.afterreject')->middleware('auth');

Route::post('satisfiedwithtechnician/{id}', 'WorkOrderController@satisfiedwithtech')->name('satisfiedwithtechnician')->middleware('auth');
Route::post('assigntechforinspection/work_order/{id}', 'WorkOrderController@assigntechnicianforinspection')->name('work.assigntechnicianforinspection')->middleware('auth');

Route::post('transportrequest/work_order/{id}', 'WorkOrderController@transportforwork')->name('work.transport')->middleware('auth');

Route::post('transrequest/work_order/{id}', 'WorkOrderController@transportforworkiowreje')->name('work.transportiowreje')->middleware('auth');

Route::post('materialadd/work_order/{id}', 'WorkOrderController@materialaddforwork')->name('work.materialadd')->middleware('auth');

Route::post('purchasing_order/work_order/{id}', 'WorkOrderController@purchasingorder')->name('work.purchasingorder')->middleware('auth');

Route::post('procurement/grn/{id}', 'PurchasingOrderController@signGRN')->name('procurement.grn')->middleware('auth');



///////////////////////////////////////////////////////////////
Route::get('minutesheets','MinuteController@minutesheets')->name('minutesheets')->middleware('auth');
Route::get('minutesheet/{id}','MinuteController@minutesheet')->name('minutesheet')->middleware('auth');
Route::post('newsheets','MinuteController@newsheet')->name('newsheet')->middleware('auth');
Route::get('conversation','MinuteController@conversation')->name('conversation')->middleware('auth');
Route::post('addconv','MinuteController@addconv')->name('addconv')->middleware('auth');
Route::get('closeminute/{id}','MinuteController@closeminute')->name('closeminute')->middleware('auth');
Route::get('/s-minutesheet','MinuteController@sminutesheet')->name('s-minutesheet')->middleware('auth');
Route::post('savesign','UserController@savesign')->name('savesign')->middleware('auth');
///////////////////////////////////////////////////////////////

Route::post('redirect/workorder/{id}', 'WorkOrderController@redirectToSecretary')->name('to.secretary.workorder')->middleware('auth');
Route::get('direct_torate', 'UserController@getdepedit')->name('get_depa')->middleware('auth');
Route::get('departments', 'UserController@getDepartments')->name('departments.view')->middleware('auth');
Route::get('companytender', 'UserController@getcompany')->name('companyies.view')->middleware('auth');
Route::get('areas', 'UserController@getAreas')->name('areas.view')->middleware('auth');
Route::get('blocks', 'UserController@getBlocks')->name('blocks.view')->middleware('auth');
Route::get('rooms', 'UserController@getRooms')->name('rooms.view')->middleware('auth');
Route::get('sections', 'UserController@getSections')->name('departments.view')->middleware('auth');
Route::get('edit/user/view/{id}', 'UserController@editUserView')->name('user.edit.view')->middleware('auth');
Route::get('assign/iow/zone/{id}', 'UserController@assigniowzoneview')->name('iow.assign.zone')->middleware('auth');
Route::get('/Manage_departments', 'DirectorateController@departmentsView')->name('dipartment.manage')->middleware('auth');
Route::get('Manage/locations', 'DirectorateController@LocationView')->name('location.manage')->middleware('auth');
Route::get('Manage/Blocks', 'DirectorateController@BlocksView')->name('Blocks.manage')->middleware('auth');
Route::get('Manage/Areas', 'DirectorateController@AreasView')->name('Areas.manage')->middleware('auth');
Route::get('Manage/Rooms', 'DirectorateController@RoomsView')->name('Rooms.manage')->middleware('auth');
Route::post('deactivate/Location/{id}', 'DirectorateController@deactivateLocation')->name('Location.delete')->middleware('auth');
Route::post('deactivate/Arrea/{id}', 'DirectorateController@deactivateArea')->name('areass.delete')->middleware('auth');
Route::post('deactivate/room/{id}', 'DirectorateController@deactivateroom')->name('roomnumber.delete')->middleware('auth');
Route::post('deactivate/block/{id}', 'DirectorateController@deactivateBlock')->name('blocks.delete')->middleware('auth');
Route::POST('Manage/edit/locationn', 'DirectorateController@editlocationns')->name('Location.edit')->middleware('auth');
Route::POST('Manage/edit/Areass', 'DirectorateController@editAreass')->name('Area.edit')->middleware('auth');

Route::POST('Manage/edit/Blocks', 'DirectorateController@editBlocks')->name('Block.edit')->middleware('auth');

Route::POST('Manage/edit/rooms', 'DirectorateController@editRooms')->name('Room.edit')->middleware('auth');


Route::get('Manage/Add/locations', 'DirectorateController@addLocationView')->middleware('auth');
Route::get('Manage/Add/Areass', 'DirectorateController@addAreassView')->middleware('auth');
Route::get('/blockss', 'DirectorateController@addBlockssView')->name('manageblocks')->middleware('auth');
Route::get('/Roomss', 'DirectorateController@addRoomsView')->name('managerooms')->middleware('auth');

Route::post('save/locationss', 'DirectorateController@createlocations')->name('add.location')->middleware('auth');
Route::post('save/Areass', 'DirectorateController@createreass')->name('add.areass')->middleware('auth');
Route::post('save/Blockss', 'DirectorateController@createblockss')->name('add.blockss')->middleware('auth');
Route::post('save/Roomss', 'DirectorateController@createrooms')->name('add.roomss')->middleware('auth');

Route::get('Manage/section', 'DirectorateController@workordersectionView')->name('section.manage')->middleware('auth');

Route::get('Manage/IoWZones', 'DirectorateController@IoWZonesview')->name('manage.IoWZones')->middleware('auth');
Route::get('Manage/IoWZones/with/iow', 'DirectorateController@IoWZoneswithiowview')->name('manage.IoWZones.iow')->middleware('auth');

Route::get('Manage/IoWZones/location/{id}/{zone}', 'DirectorateController@IoWZonesviewlocation')->name('view.location')->middleware('auth');

Route::get('Manage/Inspectorofwork/{zone}', 'DirectorateController@IoWZonesviewinspector')->name('view.iowwithloc')->middleware('auth');

Route::get('Manage/directorate', 'DirectorateController@directorateView')->name('dir.manage')->middleware('auth');

Route::get('Manage/Add/directorate', 'DirectorateController@adddirectorateView')->middleware('auth');

Route::get('Manage/Add/department', 'DirectorateController@adddepartmentView')->middleware('auth');

Route::get('Manage/Add/section', 'DirectorateController@addsectionView')->middleware('auth');

Route::get('Manage/Add/iowzone', 'DirectorateController@addiowzoneView')->middleware('auth');
Route::get('Add/iowzone/location/{id}/{zone}', 'DirectorateController@addiowzonelocationView')->name('add.iowzone.location')->middleware('auth');



Route::post('edit/user/{id}', 'UserController@editUser')->name('user.edit')->middleware('auth');
Route::post('assign/zone/{id}', 'UserController@assignzoneiow')->name('user.createzoneiow')->middleware('auth');

Route::post('password/change', 'UserController@changePassword')->name('password.change')->middleware('auth');


Route::post('save/directorate', 'DirectorateController@createDirectorate')->name('directorate.save')->middleware('auth');

Route::POST('Manage/edit/directorate', 'DirectorateController@editDirectorate')->name('directorate.edit')->middleware('auth');
Route::post('delete/directorate/{id}', 'DirectorateController@deleteDirectorate')->name('directorate.delete')->middleware('auth');


Route::POST('Manage/edit/department', 'DirectorateController@editDepartment')->name('department.edit')->middleware('auth');
Route::post('delete/department/{id}', 'DirectorateController@deleteDepartment')->name('department.delete')->middleware('auth');

//////////////////////////////////////////
Route::get('/allhos','HomeController@allhos')->name('allhos')->middleware('auth');
Route::get('/alltechnicians','HomeController@alltechnicians')->name('alltechnicians')->middleware('auth');
Route::get('/alliow','HomeController@alliow')->name('alliow')->middleware('auth');
//////////////////////////////////////////

Route::POST('Manage/edit/workordersection', 'DirectorateController@editworkorderSection')->name('workordersection.edit')->middleware('auth');

Route::POST('Manage/edit/iowzone', 'DirectorateController@editiowzone')->name('workordersection.edit')->middleware('auth');

Route::POST('/Manage/IoWZones/location/edit/{id}', 'DirectorateController@editiowzonelocation')->name('edit/iowzone/location')->middleware('auth');

Route::post('delete/workordersection/{id}', 'DirectorateController@deleteWorkorderSection')->name('worksection.delete')->middleware('auth');

Route::post('delete/iowzone/{id}', 'DirectorateController@deleteiowzone')->name('iowzone.delete')->middleware('auth');
Route::post('delete/iowzone/location/{id}', 'DirectorateController@deleteiowzonelocation')->name('iowzonelocation.delete')->middleware('auth');
Route::post('save/department', 'DirectorateController@createDepartment')->name('department.save')->middleware('auth');

Route::post('save/section/workorder', 'DirectorateController@createworkorderection')->name('section.save')->middleware('auth');

Route::post('save/iowzone', 'DirectorateController@createiowzone')->name('iowzone.save')->middleware('auth');
Route::post('save/iowzone/location/{id}/{zone}', 'DirectorateController@createiowzonelocation')->name('iowzone.location.save')->middleware('auth');



Route::post('', 'UserController@changeProfile')->name('profile.change')->middleware('auth');

Route::get('track/work_order/{id}', 'WorkOrderController@trackWO')->name('workOrder.track')->middleware('auth');
Route::post('close/work/order/{id}/{receiver_id}', 'WorkOrderController@closeWorkOrder')->name('workorder.close')->middleware('auth');

Route::post('close/work/order/inspector/{id}/{receiver_id}', 'WorkOrderController@closeWorkOrderinspector')->name('workorder.inspector')->middleware('auth');

Route::post('close/work/order/complete/{id}/{receiver_id}', 'WorkOrderController@closeWorkOrdercomplete')->name('workorder.close.complete')->middleware('auth');

Route::post('close/approved/{id}', 'WorkOrderController@WOapproveIoW')->name('workorder.iowapprove')->middleware('auth');

Route::post('close/satisfied/{id}', 'WorkOrderController@closeWOSatisfied')->name('workorder.satisfied')->middleware('auth');
Route::post('close/notsatisfied/{id}', 'WorkOrderController@closeWONotSatisfied')->name('workorder.notsatisfied')->middleware('auth');

Route::post('close/notsatisfied/iow/{id}', 'WorkOrderController@closeWONotSatisfiedbyiow')->name('workorder.notsatisfiedbyiow')->middleware('auth');






Route::get('rejected/work/orders', 'WorkOrderController@deletedWOView')->middleware('auth');


Route::get('received/materials/from_store/{id}', 'WorkOrderController@receivedmaterialview')->name('material.received')->middleware('auth');




Route::post('read/notification/{id}', 'NotificationController@readNotification')->name('notify.read')->middleware('auth');

Route::post('/myprofile', 'UserController@update_avatar')->middleware('auth');


Route::get('add/technician', 'TechnicianController@techView')->name('techs.view')->middleware('auth');
Route::post('create/technician', 'TechnicianController@createTech')->name('tech.create')->middleware('auth');
Route::get('edit/technician/{id}', 'TechnicianController@editTechView')->name('tech.edit.view')->middleware('auth');
Route::post('edit/technician/{id}', 'TechnicianController@editTech')->name('tech.edit')->middleware('auth');
Route::post('delete/technician/{id}', 'TechnicianController@deleteTech')->name('tech.delete')->middleware('auth');


Route::post('/myprofile', 'UserController@update_avatar')->middleware('auth');

Route::get('/addmaterial', 'StoreController@addmaterialView')->name('add_material')->middleware('auth');

Route::post('newmaterial', 'StoreController@addnewmaterail')->name('material.create')->middleware('auth');
Route::get('/incrementmaterial/{id}', 'StoreController@incrementmaterialView')->name('storeIncrement.view')->middleware('auth');


Route::post('incrementmaterial', 'StoreController@incrementmaterial')->name('material.increment')->middleware('auth');

Route::get('technicians', 'HomeController@alltechnicians')->name('technicians')->middleware('auth');


Route::get('work_order_material_needed', 'HomeController@workOrderNeedMaterialView')->name('wo.materialneededyi')->middleware('auth');

Route::get('work_order_material_needed_for_des', 'HomeController@workOrderNeedMaterialViewfordes')->name('wo.des')->middleware('auth');



Route::get('material_rejected_with_workorder', 'HomeController@workOrderMaterialRejected')->middleware('auth');

Route::get('material_received_with_workorder', 'HomeController@MaterialReceivewithWo')->middleware('auth');


Route::get('rejected/materials/{id}', 'WorkOrderController@rejectedmaterialview')->name('material.rejected')->middleware('auth');



Route::get('work_order_material_purchased', 'HomeController@MaterialpurchasedView')->name('wo.materialneededy')->middleware('auth');


Route::get('work_order_material_desd/{id}/{zoneid}' , 'HomeController@workOrderMaterialInspectionViewdes')->middleware('auth');

Route::get('work_order_material_iow/{id}/{zoneid}' , 'HomeController@workOrderMaterialInspectionView')->name('material.inspection.view')->middleware('auth');

Route::get('work_order_material_iow/{id}' , 'HomeController@workOrderMaterialInspectionViewforinspector')->name('material.inspection.view')->middleware('auth');

Route::get('work_order_material_purchased/{id}', 'HomeController@workOrderMaterialpurchased')->name('material.inspection.view1')->middleware('auth');




Route::get('work_order_approved_material', 'HomeController@workOrderApprovedMaterialView')->name('work_order_approved_material')->middleware('auth');



Route::get('work_order_with_missing_material', 'HomeController@workorderwithmissingmaterial')->name('work_order_with_missing_material')->middleware('auth');


Route::get('all_grns', 'HomeController@allgrns')->name('allgrn')->middleware('auth');

Route::get('all_isse_note', 'HomeController@allissuenote')->name('allissnote')->middleware('auth');


Route::get('wo_material/{id}', 'HomeController@wo_materialView')->name('store.materialview')->middleware('auth');

Route::get('wo_material_to_procure/{id}', 'HomeController@wo_material_to_purchaseView')->name('store.material_to_procure_view')->middleware('auth');

Route::get('all_wo_materials_to_purchases', 'HomeController@all_wo_materials')->name('material_to_purchase')->middleware('auth');

Route::get('/wo_material_reserved_from_store/{id}', 'HomeController@wo_material_to_purchaseViewbystore')->name('wo.reserved.material')->middleware('auth');

Route::get('/wo_material_purchased_by_head_of_procurement', 'HomeController@wo_material_purchasedViewbyheadprocurement')->middleware('auth');


Route::get('work_order_purchasing_request', 'HomeController@work_order_purchasing_requestView')->name('work_order_purchasing_request')->middleware('auth');

Route::get('workorder/procurement', 'PurchasingOrderController@procurematerial')->name('procurematerial')->middleware('auth');


Route::get('wo_purchasing_order/{id}', 'HomeController@wo_purchasing_orderView')->name('procurementorder.view')->middleware('auth');
Route::get('grn_procurement/{id}', 'HomeController@wo_grn_listView')->name('procurement.grn.view')->middleware('auth');

Route::get('wo_procurement_order/{id}', 'HomeController@wo_procurement_orderView')->name('procurementorder.view')->middleware('auth');

Route::get('wo_procurement_order/{id}', 'HomeController@procureiow_list')->name('procureiow_list.view')->middleware('auth');
Route::get('po/accept/{id}', 'PurchasingOrderController@purchasingOrderAccept')->name('po.accept')->middleware('auth');

Route::get('po/reject/{id}', 'PurchasingOrderController@purchasingOrderReject')->name('po.reject')->middleware('auth');
Route::get('work_order_procurement_request', 'PurchasingOrderController@work_order_procurement_requestView')->name('work_order_procurement_request')->middleware('auth');
Route::get('grn_release/{id}', 'PurchasingOrderController@grn_releaseView')->name('grn_release.view')->middleware('auth');



Route::get('work_order_released_material', 'HomeController@workOrderReleasedMaterialView')->name('work_order_released_material')->middleware('auth');

Route::get('work_order_grn', 'HomeController@workOrdergrnView')->name('work_order_grn')->middleware('auth');

Route::get('wo_release_grn', 'HomeController@wo_release_grn')->name('wo_release_grn')->middleware('auth');
Route::get('grn_release_list/{id}', 'PurchasingOrderController@grn_release_list')->name('grn_release_list')->middleware('auth');
Route::get('procurement_release/{id}', 'PurchasingOrderController@procurement_release')->name('procurement.release')->middleware('auth');

Route::get('material/to/reserve/in/store/{id}/{woid}', 'StoreController@materialtoreserveinstore')->name('store.materialtoreserves')->middleware('auth');

Route::get('material/not/material/{id}', 'StoreController@materialnotreserve')->name('store.materialtohos')->middleware('auth');


Route::get('material/afterpurchase/{id}', 'StoreController@materialafterpurchase')->name('store.material.afterpurchase')->middleware('auth');


Route::get('material/material/{id}', 'StoreController@materialtoreserveonebyone')->name('store.material.reserve')->middleware('auth');

Route::get('accept/material/{id}', 'StoreController@acceptMaterial')->name('store.materialaccept')->middleware('auth');

Route::get('accept/material/mc/{id}/{zoneid}', 'StoreController@acceptMaterialiow')->name('store.materialacceptmc')->middleware('auth');

Route::get('accept/material/des/{id}/{zoneid}', 'StoreController@acceptMaterialdes')->name('store.materialacceptdes')->middleware('auth');

Route::get('accept/material/with/rejected/{id}/{hosid}', 'StoreController@Materialacceptedwithrejected')->name('store.materialaccept.reject')->middleware('auth');


Route::get('accept/material/des/rejected/{id}/{hosid}', 'StoreController@Materialacceptedwithrejecteddes')->name('store.materialaccept.reject.des')->middleware('auth');




Route::get('return/material/{id}', 'StoreController@returnMaterialHOS')->name('store.materialreturn')->middleware('auth');


Route::get('accept/material/independently/{id}', 'StoreController@acceptMaterialonebyone')->name('store.materialacceptonebyone')->middleware('auth');

Route::post('reject/material/{id}/{hosid}', 'StoreController@rejectMaterial')->name('store.materialreject')->middleware('auth');
Route::post('reject/des/material/{id}/{hosid}', 'StoreController@rejectMaterialdes')->name('store.materialreject.des')->middleware('auth');

Route::post('reject/material/independent/{id}', 'StoreController@rejectMaterialonebyone')->name('store.materialrejectonebyone')->middleware('auth');

Route::get('store/material_request/{id}','StoreController@material_request_hos')->name('material_request_hos')->middleware('auth');

Route::get('store/material_reserve/{id}','StoreController@ReserveMaterial')->name('ReserveMaterial')->middleware('auth');

Route::get('send/material_again/{id}','StoreController@materialaddagain')->name('SendMaterialAgain')->middleware('auth');

Route::get('received/materials/from_store/tick/material_received/{id}','WorkOrderController@tickmaterial')->middleware('auth');


Route::get('send/material_rejected_again/{id}','StoreController@materialrejectedaddagain')->name('SendMaterialrejectedAgain')->middleware('auth');






Route::get('release/material/{id}', 'StoreController@releaseMaterial')->name('store.materialrelease')->middleware('auth');

Route::get('notify/store/material/', 'StoreController@releaseMaterialafterpurchased')->name('store.materialafterpurchase')->middleware('auth');



Route::get('wo_transport_request', 'HomeController@transport_request_View')->name('wo_transport_request')->middleware('auth');


//Route::get('transport_request/accept/{id}','WorkOrderController@transport_request_accept')->name('transportrequest.accept')->middleware('auth');
Route::post('transport_request/accept','WorkOrderController@transport_request_accept')->name('transportrequest.accept')->middleware('auth');


Route::get('transport_request/reject/{id}','WorkOrderController@transport_request_reject')->name('transportrequest.reject')->middleware('auth');




Route::get('work_order_material_accepted/{id}', 'HomeController@woMaterialAcceptedView')->name('woMaterialAccepted')->middleware('auth');


Route::get('work_order_material_rejected', 'HomeController@woMaterialRejectedView')->name('woMaterialRejected')->middleware('auth');

Route::get('comp','UserController@comp')->name('comp')->middleware('auth');


Route::post('Complaint','UserController@Complaint')->name('Complaint')->middleware('auth');
Route::get('complian/{id}','UserController@complian')->name('complian')->middleware('auth');

Route::get('allpdf','NotesController@allpdf')->name('allpdf')->middleware('auth');
 Route::get('wowithdurationpdf','NotesController@wowithdurationpdf')->middleware('auth');
 Route::get('roomreportpdf','NotesController@roomreportpdf')->middleware('auth');
 Route::get('techniciancompleteworkpdf','NotesController@techniciancompleteworkpdf')->middleware('auth');
 Route::get('hosCountpdf','NotesController@hosCountpdf')->middleware('auth');
 Route::get('unattendedwopdf','NotesController@unattendedwopdf')->middleware('auth');
 Route::get('completewopdf','NotesController@completewopdf')->middleware('auth');
 Route::get('grnpdf/{id}','NotesController@grnotepdf')->name('allgrnss')->middleware('auth');
  Route::get('allissuenotes/{id}','NotesController@allissuenotepdf')->name('allissuenote')->middleware('auth');
 Route::get('received/materials/from_store/issuenotepdf/{id}','NotesController@issuenotepdf')->middleware('auth');

// iow myzone ////////
Route::get('newworkorders','WorkOrderController@newworkorders')->name('newworkorders')->middleware('auth');
// Route::get('acceptedworkorders','WorkOrderController@acceptedworkorders')->name('acceptedworkorders')->middleware('auth');
Route::get('onprocessworkorders','WorkOrderController@onprocessworkorders')->name('onprocessworkorders')->middleware('auth');
// Route::get('closedworkorders','WorkOrderController@closedworkorders')->name('closedworkorders')->middleware('auth');
Route::get('completedworkorders','WorkOrderController@completedworkorders')->name('completedworkorders')->middleware('auth');
Route::get('rejectedworkorders','WorkOrderController@rejectedworkorders')->name('rejectedworkorders')->middleware('auth');

Route::get('workzones','WorkOrderController@workzones')->name('workzones')->middleware('auth');
// end here ///////////
Route::get('wo_transport_request_accepted', 'HomeController@woTransportAcceptedView')->name('woTransportAccepted')->middleware('auth');

Route::get('wo_transport_request_rejected', 'HomeController@woTransportRejectedView')->name('woTransportRejected')->middleware('auth');



Route::get('gettechniciandetails/{id}', 'TechnicianController@getTechnicianDetails')->middleware('auth');

Route::get('work_order_technician_complete/{id}', 'WorkOrderController@woTechnicianComplete')->name('workOrder.technicianComplete')->middleware('auth');


Route::get('work_order_technician_complete_inspection/{id}', 'WorkOrderController@TechnicianCompleteinspection')->name('workOrder.technicianCompleteinspection')->middleware('auth');

Route::post('work_order_technician_delete/{id}', 'WorkOrderController@Techniciandeletefromlist')->name('workOrder.techniciandelete')->middleware('auth');
Route::get('work_order_technician_assign_leader/{id}/{id2}', 'WorkOrderController@Technicianassignleader')->name('workOrder.technicianassignleader')->middleware('auth');
Route::get('work_order_technician_assign_leader_inspection/{id}/{id2}', 'WorkOrderController@Technicianassignleaderinspection')->name('workOrder.technicianassignleaderinspection')->middleware('auth');

Route::get('work_order_technician_assign_leader_after_reject_iow/{id}/{id2}', 'WorkOrderController@Technicianassignleaderafteriowreject')->name('workOrder.assignleaderafterrejectiow')->middleware('auth');



Route::get('/unattended_work_orders', 'HomeController@unattendedWorkOrdersView')->name('unattended_work_orders')->middleware('auth');

Route::get('/completed_work_orders', 'HomeController@completedWorkOrdersView')->name('completed_work_orders')->middleware('auth');



Route::get('/roomreport', 'HomeController@roomreportView')->name('roomreport')->middleware('auth');
Route::get('/store_report', 'HomeController@storereportView')->name('store_report')->middleware('auth');

Route::get('/woduration', 'HomeController@woduration')->name('woduration')->middleware('auth');

Route::get('/hoscount', 'HomeController@hoscount')->name('hoscount')->middleware('auth');

Route::get('/techniciancount', 'HomeController@techniciancount')->name('techniciancount')->middleware('auth');
Route::get('/techniciancountcomp', 'HomeController@techniciancountcomp')->name('techniciancountcomp')->middleware('auth');

Route::get('work_order_change_type/{id}', 'WorkOrderController@woChangeTypeView')->name('workOrder.changetype')->middleware('auth');

Route::post('/changewoType', 'WorkOrderController@changewoType')->name('change_wo_ptype')->middleware('auth');


 Route::get('pdf', 'NotesController@pdf')->middleware('auth');

 Route::get('userpdf', 'NotesController@userspdf')->middleware('auth');
 Route::get('materialpdf', 'NotesController@storespdf')->middleware('auth');
 Route::get('unatendedwopdf', 'NotesController@unatendedpdf')->middleware('auth');


 Route::get('sms', 'SmsController@sendSms')->middleware('auth');




 Route::get('manage_Houses', 'AssetsController@HousesView')->name('register.house')->middleware('auth');
 Route::get('manage_Campus', 'AssetsController@managecampus')->name('register.campus')->middleware('auth');
 Route::get('manage_Hall_of_resdence', 'AssetsController@Hallofresdence')->name('register.hallofres')->middleware('auth');
 Route::get('manage_Cleaning_area', 'AssetsController@Cleaningarea')->name('register.cleaningareas')->middleware('auth');
 Route::get('manage_Cleaning_zone', 'AssetsController@cleaningzone')->name('register.cleanningzone')->middleware('auth');


Route::post('HouseRegistration', 'AssetsController@RegisterHouse')->name('house.save')->middleware('auth');
Route::post('CompanyRegistration', 'AssetsController@Registercompany')->name('company.save')->middleware('auth');
Route::post('Renewcompanytender/{id}', 'AssetsController@Renewtender')->name('companyrenewcontract')->middleware('auth');
Route::post('Company_registration', 'AssetsController@Renewcompany')->name('company.save.renew')->middleware('auth');
Route::post('Addnewsheet', 'AssetsController@addnewsheetc')->name('addnew.sheet')->middleware('auth');
Route::post('delete/House/{id}', 'AssetsController@deleteHouse')->name('house.delete')->middleware('auth');
Route::POST('edit/House', 'AssetsController@editHouse')->name('house.edit')->middleware('auth');
Route::POST('edit/company', 'AssetsController@editcompany')->name('company.edit')->middleware('auth');
Route::get('Register_Staffhouse', 'AssetsController@Registerstaffhouseview')->name('registerstaffhouse')->middleware('auth');

Route::get('Register_tender', 'AssetsController@Registercompanyview')->name('registercompany')->middleware('auth');
Route::get('Add_new_company', 'AssetsController@Renewcompanycontract')->name('renew_company_contract')->middleware('auth');
Route::get('Renew_tender_contract/{ids}', 'AssetsController@Renewtendercontract')->name('renew_contract')->middleware('auth');
Route::get('add_new_sheet', 'AssetsController@addnewsheet')->name('add_new_sheet')->middleware('auth');




Route::post('HallRegistration', 'AssetsController@RegisterHalls')->name('hall.save')->middleware('auth');
Route::post('delete/Hall/{id}', 'AssetsController@deleteHall')->name('hall.delete')->middleware('auth');
Route::post('delete/company/{id}', 'AssetsController@deletecompany')->name('company.delete')->middleware('auth');
Route::post('cleaming/delete/company/{id}', 'AssetsController@deletecleaningcompany')->name('cleaning.company.delete')->middleware('auth');
Route::POST('edit/Hall', 'AssetsController@editHall')->name('hall.edit')->middleware('auth');
Route::get('Register_hall', 'AssetsController@Registerhallview')->name('registerhall')->middleware('auth');




Route::post('CampusRegistration', 'AssetsController@RegisteCampus')->name('campus.save')->middleware('auth');
Route::POST('edit/Campus', 'AssetsController@editcampus')->name('campus.edit')->middleware('auth');
Route::post('delete/Campus/{id}', 'AssetsController@deletecampus')->name('campus.delete')->middleware('auth');
Route::get('Register_Campus', 'AssetsController@Registercampusview')->name('registercampus')->middleware('auth');



Route::post('ZoneRegistration', 'AssetsController@RegisterZone')->name('zone.save')->middleware('auth');
Route::post('delete/zone/{id}', 'AssetsController@deletezone')->name('zone.delete')->middleware('auth');
Route::POST('edit/zone', 'AssetsController@editzone')->name('zone.edit')->middleware('auth');
Route::get('Register_Zone', 'AssetsController@Registercleanzoneview')->name('registercleaningzone')->middleware('auth');



Route::post('CleaningAreaRegistration', 'AssetsController@RegisterCleaningArea')->name('area.save')->middleware('auth');
Route::post('delete/cleanarea/{id}', 'AssetsController@deletecleanarea')->name('cleanarea.delete')->middleware('auth');
Route::POST('edit/cleaningarea', 'AssetsController@editcleanarea')->name('cleanarea.edit')->middleware('auth');
Route::get('Register_Cleaningarea', 'AssetsController@Registercleaningareaview')->name('Registercleaningarea')->middleware('auth');


Route::get('work_order_material_missing', 'HomeController@workOrderMissingMaterialView')->name('wo.materialneeded')->middleware('auth');

Route::get('work_order_material_missing/{id}', 'HomeController@workOrderMaterialMissingInspectionView')->name('material.missing.inspection.view')->middleware('auth');
Route::get('insufficient/material/{id}', 'StoreController@insufficientMaterial')->name('store.insufficientmaterial')->middleware('auth');




 Route::get('/technician_report', 'AssetsController@TecnicianView')->name('view.report')->middleware('auth');

 Route::get('/workorder_report', 'HomeController@WorkorderReportView')->middleware('auth');

 Route::get('htmlpdf58','PDFController@htmlPDF58')->middleware('auth');
Route::get('generatePDF58','PDFController@generatePDF58')->middleware('auth');


Route::POST('editmaterialrequest', 'WorkOrderController@editmaterialforwork')->name('requestagain.save')->middleware('auth');

Route::POST('rejected/materials/edit/Material/{id}', 'WorkOrderController@editmaterial')->name('material.edit')->middleware('auth');

Route::POST('work_order_material_purchased/edit/Material/{id}', 'StoreController@incrementmaterialmodal')->middleware('auth');

Route::POST('work_order_material_purchased/edit2/Material/{id}', 'StoreController@incrementmaterialmodal2')->middleware('auth');


Route::POST('work_order_material_iow/reject/Material/{id}', 'StoreController@materialrejectonebyone')->name('material_onebyone')->middleware('auth');


Route::POST('work_order_material_dess/reject/Material/{id}', 'StoreController@materialrejectonebyonedes')->name('material_onebyone_des')->middleware('auth');


Route::POST('rwork_order_material_iow/reject/Material/{id}', 'StoreController@redirecttohos')->name('redirect.workorder')->middleware('auth');


Route::POST('redirectwotohos{id}', 'StoreController@redirectworkordertohos')->name('redirect_wo')->middleware('auth');


Route::POST('edit/work_order/view/edit/Material_hos/{id}', 'WorkOrderController@editmaterialhos')->name('material.edit')->middleware('auth');


 Route::get('wo_material_reserved', 'HomeController@material_reserved')->middleware('auth');

 Route::get('wo_material_accepted', 'HomeController@material_accepted')->middleware('auth');

 //Route::get('requested/material/{id}', 'StoreController@MaterialrequestView')->name('store.materialaccept')->middleware('auth');

 Route::get('wo_material_accepted_by_iow', 'HomeController@materialacceptedbyiow')->name('wo_material_accepted_by_iow')->middleware('auth');  //after material accepted by iow then flow to store

 Route::get('wo_material_accepted_by_iow/{id}', 'HomeController@wo_material_acceptedbyIOWView')->name('store.materia_accepte_by_iow')->middleware('auth'); //material accepted by iow view



 Route::post('delete/material/{id}/{woid}', 'StoreController@deletematerial')->name('material.delete')->middleware('auth');
 Route::get('trackreport/{id}','NotesController@trackreport')->name('trackreport')->middleware('auth');
 Route::get('techforreport/{id}','NotesController@techforreport')->name('techforreport')->middleware('auth');
 Route::get('hoscompletedjob/{id}','WorkOrderController@hoscompletedjob')->name('hoscompletedjob')->middleware('auth');
 Route::get('inroomreport','HomeController@anonymousroomreport')->name('inroomreport')->middleware('auth');

 Route::get('inroomreportextended','HomeController@anonymousroomreportextended')->name('inroomreportextended')->middleware('auth');
Route::get('inroomreporwithrooms','HomeController@inroomreportextendedwithrooms')->name('inroomreporwithrooms')->middleware('auth');

Route::get('thisroomreport','HomeController@knownroomreport')->name('thisroomreport')->middleware('auth');
Route::get('desdepts','NotesController@desdepts')->name('desdepts')->middleware('auth');

Route::get('locationpdf','NotesController@locationpdfs')->name('locationpdfs')->middleware('auth');
Route::get('areapdf','NotesController@areapdfs')->name('areapdfs')->middleware('auth');
Route::get('blockpdf','NotesController@blockpdfs')->name('blockpdfs')->middleware('auth');
Route::get('roomspdf','NotesController@roomspdfs')->name('roomspdfs')->middleware('auth');


Route::get('iowwithzones','NotesController@iowzones')->name('zones')->middleware('auth');

Route::get('iowonlyzones','NotesController@iowonlyzones')->middleware('auth');

Route::get('iowfromzones/{zone}','NotesController@iowfromzones')->name('iowwith.zone')->middleware('auth');

Route::get('iowwithlocation/{id}','NotesController@iowlocation')->name('zones')->middleware('auth');

//////////////////// non building assets & cleaning company ////////////////////////////
Route::get('nonbuildingasset','AssetsController@nonbuildingasset')->name('nonbuildingasset')->middleware('auth');


Route::get('tender','AssetsController@cleaningcompany')->name('cleaningcompany')->middleware('auth');

Route::get('tender_with_expired_contract','AssetsController@cleaningcompanywithexpirecontract')->name('cleaningcompanywithexpiredcontract')->middleware('auth');

Route::get('tenders_with_reached_assessment_day','AssetsController@cleaningcompanyreached')->name('tenders_reached')->middleware('auth');



Route::get('cleaningcompanywithexpired','AssetsController@cleaningcompanynew')->name('cleaning_company')->middleware('auth');

Route::get('cleaningcompany','AssetsController@cleaningcompanynew')->name('cleaning_company')->middleware('auth');

Route::get('cleaningcompanyexpired','AssetsController@cleaningcompanyexpired')->name('cleaning_company_expired')->middleware('auth');

Route::get('cleaningcompanyreport','AssetsController@cleaningcompanyreport')->name('cleaningcompanyreport')->middleware('auth');

Route::get('assessmentsheet','AssetsController@assessmentsheet')->name('assessment_sheet')->middleware('auth');


Route::get('incomplete_assessment_sheet','AssetsController@incompleteassessmentsheet')->name('incomplete_assessment_sheet')->middleware('auth');

Route::get('registernonbuildingasset','AssetsController@registernonbuildingasset')->name('registernonbuildingasset')->middleware('auth');
Route::post('submitnonAsset','AssetsController@SubmitnonAsset')->name('nonbuildingasset.create')->middleware('auth');
Route::get('NonBuildAsset','AssetsController@NonBuildAsset')->name('NonBuildAsset')->middleware('auth');
Route::get('NonassetIn','AssetsController@NonassetIn')->name('NonassetIn')->middleware('auth');
Route::get('NonassetAt','AssetsController@NonassetAt')->name('NonassetAt')->middleware('auth');


Route::get('procurementAddMaterial','StoreController@procurementAddMaterial')->name('procurementAddMaterial')->middleware('auth');
Route::post('procuredmaterialsadding','StoreController@procuredmaterialsadding')->name('procuredmaterialsadding')->middleware('auth');
Route::get('ProcurementHistory','StoreController@ProcurementHistory')->name('ProcurementHistory')->middleware('auth');
Route::get('procuredMaterials/{id}','StoreController@procuredMaterials')->name('procuredMaterials')->middleware('auth');

Route::post('AcceptProcuredMaterial','StoreController@AcceptProcuredMaterial')->name('AcceptProcuredMaterial')->middleware('auth');

Route::get('exportProcure/{id}','NotesController@exportProcure')->name('exportProcure')->middleware('auth');

Route::post('ReceivedProcurement','StoreController@ReceivedProcurement')->name('ReceivedProcurement')->middleware('auth');
Route::get('PrintNote/{id}','NotesController@PrintNote')->name('PrintNote')->middleware('auth');
Route::get('materialEntryHistory','StoreController@materialEntryHistory')->name('materialEntryHistory')->middleware('auth');
Route::get('materialEntry/{id}','StoreController@materialEntry')->name('materialEntry')->middleware('auth');
Route::get('materialEntrypdf/{id}','NotesController@materialEntrypdf')->name('materialEntrypdf')->middleware('auth');


Route::post('importUserExcel','ImportExcelController@importUserExcel')->name('importUserExcel')->middleware('auth');
Route::get('excelinsertusers','ImportExcelController@excelinsertusers')->name('excelinsertusers')->middleware('auth');
Route::post('change_user_type/{check}','UserController@changetypeview')->name('changeusertype')->middleware('auth');



//landscaping
Route::post('workorder/create/landscaping', 'LandscapingController@createlandwork')->name('wo.create.landscaping')->middleware('auth');

Route::get('/createlandworkorders', 'LandscapingController@createlandwo')->middleware('auth');
Route::get('/Land/work_order', 'LandscapingController@landworkorderview')->name('Land_work_order')->middleware('auth');
Route::get('track/work_order/landscaping/{id}', 'LandscapingController@trackwoland')->name('workOrder.track.landscaping')->middleware('auth');
Route::get('view/work_order/landscaping/{id}', 'LandscapingController@viewwolandsc')->name('workorder.view.landsc')->middleware('auth');
Route::post('workorder/accept/landscaping/{id}', 'LandscapingController@acceptwoforlandsc')->name('workorder.accept.landscaping')->middleware('auth');
Route::get('edit/assessmentform/landscaping/{id}/{company}/{month}', 'LandscapingController@editwolandscaping')->name('workOrder.edit.landscaping')->middleware('auth');

Route::post('inspect/work_order/landscaping/{id}', 'LandscapingController@landinspectionForm')->name('work.inspection.landscaping')->middleware('auth');
Route::post('assessment/work_order/landscaping/{id}/{comp}/{date}/{status}/{nextmonth}', 'LandscapingController@landassessmentForm')->name('work.assessment.landscaping')->middleware('auth');
Route::post('chrosscheck/assessment/work_order/landscaping/{id}/{asid}', 'LandscapingController@crosschecklandassessmentForm')->name('crosscheck.assessment.landscaping')->middleware('auth');

Route::post('assessment/activity/form/landscaping/{id}/{companys}', 'LandscapingController@landassessmentactivityForm')->name('work.assessment.activity.landscaping')->middleware('auth');

Route::post('editassessment_sheet/{id}', 'LandscapingController@editassessmentsheet')->name('edit.assessment.sheet')->middleware('auth');

Route::post('editassessment_sheet_proceeding/{id}/{type}', 'LandscapingController@editassessmentsheetproceeding')->name('edit.assessment.proceeding')->middleware('auth');

Route::post('edit_sheet_proceeding/{id}/{type}', 'LandscapingController@editassessmentsheetproceedingtwo')->name('edit.assessment.proceeding.two')->middleware('auth');



Route::get('finalsave/sheet/{name}', 'LandscapingController@finalsave_sheet')->name('finalsavesheet')->middleware('auth');


Route::post('companysupervisorsatisfied/{id}/{company}/{sheet}/{month}/', 'LandscapingController@supervisorsatisfied')->name('supervisorsatisfied')->middleware('auth');

Route::post('crosscheck/assessment/activity/form/forsignature/{id}/{type}/{company}/{date}/{status}/{nextmonth}', 'LandscapingController@crosschecklandassessmentactivityforsignature')->name('croscheck.assessment.activity.landscaping.beforesignature')->middleware('auth');


Route::post('crosscheck/assessment/activity/form/supervisor/{id}/{type}/{company}/{date}/{status}/{nextmonth}', 'LandscapingController@crosschecklandassessmentactivitysupervisor')->name('croscheck.assessment.activity.landscaping')->middleware('auth');

Route::post('crosscheck/assessment/activity/form/usab/{id}/{type}/{company}/{date}/{status}/{nextmonth}', 'LandscapingController@crosschecklandassessmentactivityusab')->name('croscheck.assessment.activity.usab')->middleware('auth');



Route::post('crosscheck/assessment/activity/form/usab/adoffiser/{id}/{type}/{company}/{date}/{status}/{nextmonth}', 'LandscapingController@crosschecklandassessmentactivityadofficer')->name('croscheck.assessment.activity.adoficer')->middleware('auth');



Route::post('crosscheck/assessment/activity/form/second/{id}/{company}/{month}', 'LandscapingController@crosschecklandassessmentactivitysecond')->name('croscheck.assessment.activity.landscapingsecond')->middleware('auth');

Route::post('eddited/assessment/activity/form/{id}/{tender}/{month}', 'LandscapingController@editedlandassessmentactivity')->name('edited.assessment.activity.landscaping')->middleware('auth');



Route::post('approveassessmentifpaid/{id}/{tender}/{month}', 'LandscapingController@approveassessmentifpaid')->name('approveassessmentifpaid')->middleware('auth');
Route::get('approveassessmentform/{id}/{tender}/{month}', 'LandscapingController@approveassessment')->name('approveassessment')->middleware('auth');
Route::get('approveassessmentformdean/{id}/{tender}/{month}', 'LandscapingController@approveassessmentdean')->name('approveassessmentdean')->middleware('auth');
Route::get('approveassessmentfordeputymanager/{id}/{tender}/{month}', 'LandscapingController@approveassessmentdeputymanager')->name('approveassessmentdeputy')->middleware('auth');

Route::get('approveassessmentformprinciple/{id}/{tender}/{month}', 'LandscapingController@approveassessmentprinciple')->name('approveassessmentprinciple')->middleware('auth');
Route::get('approveassessmentforpayment/{id}/{tender}/{month}', 'LandscapingController@approveassessmentforpayment')->name('approveassessmentforpayment')->middleware('auth');
Route::get('approveassessmentformbydvc/{id}/{tender}/{month}', 'LandscapingController@approveassessmentformbydvc')->name('approveassessmentformbydvc')->middleware('auth');
Route::post('appdatepayment/{id}', 'LandscapingController@apdatepayment')->name('updatepayment')->middleware('auth');

Route::post('rejectassessmentwithreason/{id}/{tender}/{month}', 'LandscapingController@rejectassessmentwithreason')->name('rejectwithreasonassessment')->middleware('auth');

Route::post('rejectassessmentwithreasonestate/{id}/{tender}/{month}', 'LandscapingController@rejectassessmentwithreasonestate')->name('rejectwithreasonassessmentestate')->middleware('auth');

Route::post('rejectassessmentwithreasondean/{id}/{tender}/{month}', 'LandscapingController@rejectassessmentwithreasondean')->name('rejectwithreasonassessmentdean')->middleware('auth');

Route::post('rejectassessmentwithreasondeanonly/{id}/{tender}/{month}', 'LandscapingController@rejectassessmentwithreasondeanonly')->name('rejectwithreasonassessmentdeanonly')->middleware('auth');


Route::get('addassessmentpdf/{id}/{tender}','NotesController@addassessmentpdf')->name('addassessmentpdfform')->middleware('auth');

Route::get('assessmentpdf/{id}/{tender}/{month}','NotesController@assessmentpdf')->name('assessmentpdfform')->middleware('auth');
Route::get('Maintainance/section', 'LandscapingController@maintainancesection')->name('section.maintenance')->middleware('auth');

Route::get('Assessment/form', 'LandscapingController@assessmentformview')->name('assessmentform.view')->middleware('auth');

Route::get('Assessment/formsecond', 'LandscapingController@assessmentformviewsecond')->name('assessmentform.view.second')->middleware('auth');


Route::get('Add/maintainance/section', 'LandscapingController@addsection')->name('addmsection')->middleware('auth');

Route::get('Add/company/for/assessment/{id}/{tender}', 'LandscapingController@addcompanyforassessment')->name('addcompanytoassess')->middleware('auth');

Route::post('save/section', 'LandscapingController@createmaintainancesection')->name('section.save.maintainance')->middleware('auth');
Route::post('delete/maintainancesection/{id}', 'LandscapingController@deletemaintainanceSection')->name('maintainancesection.delete')->middleware('auth');
Route::get('track/company/forms/{id}', 'LandscapingController@trackcompanyview')->name('track_company')->middleware('auth');
Route::get('company_report_with_month/', 'LandscapingController@companywithmonth')->name('comapy_view_month')->middleware('auth');
Route::get('track/company/assessment/forms/{id}', 'LandscapingController@trackcompanyassessmentview')->name('track_company_assessment')->middleware('auth');
Route::get('companyreportview/{id}', 'LandscapingController@companyreport')->name('view_company_month')->middleware('auth');



Route::get('viewcompanyreportlinegraph/{tender}/{company}/{area}', 'LandscapingController@companylinereport')->name('view_company_line_report')->middleware('auth');


Route::get('viewcompanyreportview/{tender}/{company}/{area}', 'LandscapingController@viewcompanyreport')->name('view_company_report')->middleware('auth');


Route::get('viewcompanyreportforcompany/{tender}/{company}', 'LandscapingController@viewcompanyreportfor_company')->name('view_company_report_for_company')->middleware('auth');




Route::get('viewassessmentsheet/{id}', 'LandscapingController@viewassessmentsheet')->name('view_assessment_sheet')->middleware('auth');
Route::get('companyreporteditview/{id}', 'LandscapingController@companyeditreport')->name('edit_company_month')->middleware('auth');
Route::post('companyreporteditview/edit/comment/new' , 'LandscapingController@updatecomments')->name('update.comment');
Route::get('foward_dvc_admin/{id}' , 'LandscapingController@fowardtodvc')->name('foward.dvc.adimin');

Route::get('viewmothwithtenderreport/{id}/{tender}', 'LandscapingController@companytenderformonthreport')->name('companywithmothtenderreport')->middleware('auth');

Route::post('assessmentreports','NotesController@assessmentviewpdf')->name('assessments')->middleware('auth');

Route::post('tenderreports','NotesController@tenderviewpdf')->name('tendersreport')->middleware('auth');
Route::post('viewtrendingscorereport/{tender}/{company}','NotesController@trendingscorereport')->name('trendingscore_report')->middleware('auth');
Route::get('viewtrendingscorereportforcompany/{tender}/{month}','NotesController@trendingscorereportcompany')->name('trendingscore_report_company')->middleware('auth');
Route::get('cleaning_company_report','NotesController@landcleaningcompanyreport')->name('landscapingcleaningcompanyreport')->middleware('auth');
Route::get('cleaning_company_report_expired','NotesController@landcleaningcompanyreportexpired')->name('landscapingcleaningcompanyreportexpired')->middleware('auth');

Route::get('cleaning_area_report','NotesController@landcleaningareareport')->name('landscapingcleaningarea')->middleware('auth');

Route::get('viewsheetbeforeproceeding/{id}', 'LandscapingController@viewsheetbeforeproceeding')->name('view_sheet_before_proceeding')->middleware('auth');

Route::post('delete/assessmentsheet/{id}/{name}', 'LandscapingController@deleteassessmentsheet')->name('assess.sheet.delete')->middleware('auth');
Route::POST('viewsheetbeforeproceeding/edit/assessment/sheets', 'LandscapingController@editassessmentsheeeet')->name('assessment.sheet.edit')->middleware('auth');



//ppu
Route::get('physicalplanning','PhysicalPlanningController@physicalplanning')->name('physicalplanning')->middleware('auth');
Route::get('infrastructureproject','PhysicalPlanningController@infrastructureproject')->name('infrastructureproject')->middleware('auth');
Route::get('newinfrastructureproject','PhysicalPlanningController@newinfrastructureproject')->name('newinfrastructureproject')->middleware('auth');
Route::post('postinfrastructureproject','PhysicalPlanningController@postinfrastructureproject')->name('postinfrastructureproject')->middleware('auth');
Route::get('ppuprojectview/{id}','PhysicalPlanningController@ppuprojectview')->name('ppuprojectview')->middleware('auth');
Route::get('ppuprojectforwarddvc/{id}','PhysicalPlanningController@ppuprojectforwarddvc')->name('ppuprojectforwarddvc')->middleware('auth');
Route::get('ppueditproject/{id}','PhysicalPlanningController@ppueditproject')->name('ppueditproject')->middleware('auth');
Route::post('saveeditedproject','PhysicalPlanningController@saveeditedproject')->name('saveeditedproject')->middleware('auth');

Route::post('ppurejectproject','PhysicalPlanningController@ppurejectproject')->name('ppurejectproject')->middleware('auth');
Route::get('ppuprojectforwarddes/{id}','PhysicalPlanningController@ppuprojectforwarddes')->name('ppuprojectforwarddes')->middleware('auth');
Route::get('ppuprojectforwardppu/{id}','PhysicalPlanningController@ppuprojectforwardppu')->name('ppuprojectforwardppu')->middleware('auth');
Route::post('ppuprojectdraftsman','PhysicalPlanningController@ppuprojectdraftsman')->name('ppuprojectdraftsman')->middleware('auth');
Route::post('ppudraftsdraws','PhysicalPlanningController@ppudraftsdraws')->name('ppudraftsdraws')->middleware('auth');
Route::get('viewppudraws/{id}/{type}/{name}/','PhysicalPlanningController@viewppudraws')->name('viewppudraws')->middleware('auth');
Route::get('ppuforwardplanDES/{id}','PhysicalPlanningController@ppuforwardplanDES')->name('ppuforwardplanDES')->middleware('auth');
Route::get('ppuforwardplanDvcAdmin/{id}','PhysicalPlanningController@ppuforwardplanDvcAdmin')->name('ppuforwardplanDvcAdmin')->middleware('auth');
Route::get('ppuApproveplanDES/{id}','PhysicalPlanningController@ppuApproveplanDES')->name('ppuApproveplanDES')->middleware('auth');
Route::post('ppuForwardPlansQS','PhysicalPlanningController@ppuForwardPlansQS')->name('ppuForwardPlansQS')->middleware('auth');
Route::get('pputrack/{id}','PhysicalPlanningController@pputrack')->name('pputrack')->middleware('auth');
Route::get('ppubudgetAppoveDES/{id}','PhysicalPlanningController@ppubudgetAppoveDES')->name('ppubudgetAppoveDES')->middleware('auth');
Route::get('ppuForwardDVCppu/{id}','PhysicalPlanningController@ppuForwardDVCppu')->name('ppuForwardDVCppu')->middleware('auth');
Route::post('ppuForwardBudgetppu','PhysicalPlanningController@ppuForwardBudgetppu')->name('ppuForwardBudgetppu')->middleware('auth');
Route::get('ppubudgetAppoveDVC/{id}','PhysicalPlanningController@ppubudgetAppoveDVC')->name('ppubudgetAppoveDVC')->middleware('auth');
Route::get('ppubudgetApprovedDVC/{id}','PhysicalPlanningController@ppubudgetApprovedDVC')->name('ppubudgetApprovedDVC')->middleware('auth');
Route::get('ppudrawingslibrary','PhysicalPlanningController@ppudrawingslibrary')->name('ppudrawingslibrary')->middleware('auth');
Route::get('ppudrawingsview/{id}','PhysicalPlanningController@ppudrawingsview')->name('ppudrawingsview')->middleware('auth');
Route::get('ppubudgetlibrary','PhysicalPlanningController@ppubudgetlibrary')->name('ppubudgetlibrary')->middleware('auth');
Route::get('ppubudgetview/{id}','PhysicalPlanningController@ppubudgetview')->name('ppubudgetview')->middleware('auth');


// Assets in deep
Route::get('assetsManager','AssetsController@assetsManager')->name('assetsManager')->middleware('auth');

Route::get('assetsNewLand','AssetsController@assetsNewland')->name('assetsNewLand')->middleware('auth');
Route::post('assetsNewLandSave','AssetsController@assetsNewLandSave')->name('assetsNewLandSave')->middleware('auth');
Route::get('assetsLand','AssetsController@assetsLand')->name('assetsLand')->middleware('auth');
Route::get('assetsLandView/{id}','AssetsController@assetsLandView')->name('assetsLandView')->middleware('auth');Route::get('assetsLandView/{id}','AssetsController@assetsLandView')->name('assetsLandView')->middleware('auth');
Route::get('assetsLandEdit/{id}','AssetsController@assetsLandEdit')->name('assetsLandEdit')->middleware('auth');Route::get('assetsLandView/{id}','AssetsController@assetsLandView')->name('assetsLandView')->middleware('auth');
Route::post('assetsLandEditSave','AssetsController@assetsLandEditSave')->name('assetsLandEditSave')->middleware('auth');Route::get('assetsLandView/{id}','AssetsController@assetsLandView')->name('assetsLandView')->middleware('auth');

Route::get('assetsNewPlantMachinery','AssetsController@assetsNewPlantMachinery')->name('assetsNewPlantMachinery')->middleware('auth');
Route::post('assetsNewPlantMachinerySave','AssetsController@assetsNewPlantMachinerySave')->name('assetsNewPlantMachinerySave')->middleware('auth');
Route::get('assetsPlantMachinery','AssetsController@assetsPlantMachinery')->name('assetsPlantMachinery')->middleware('auth');
Route::get('assetsPlantMachineryView/{id}','AssetsController@assetsPlantMachineryView')->name('assetsPlantMachineryView')->middleware('auth');
Route::get('assetsPlantMachineryEdit/{id}','AssetsController@assetsPlantMachineryEdit')->name('assetsPlantMachineryEdit')->middleware('auth');
Route::post('assetsPlantMachineryEditSave','AssetsController@assetsPlantMachineryEditSave')->name('assetsPlantMachineryEditSave')->middleware('auth');

Route::get('assetsNewMotorVehicle','AssetsController@assetsNewMotorVehicle')->name('assetsNewMotorVehicle')->middleware('auth');
Route::post('assetsNewMotorVehicleSave','AssetsController@assetsNewMotorVehicleSave')->name('assetsNewMotorVehicleSave')->middleware('auth');
Route::get('assetsMotorVehicle','AssetsController@assetsMotorVehicle')->name('assetsMotorVehicle')->middleware('auth');
Route::get('assetsMotorVehicleView/{id}','AssetsController@assetsMotorVehicleView')->name('assetsMotorVehicleView')->middleware('auth');
Route::get('assetsMotorVehicleEdit/{id}','AssetsController@assetsMotorVehicleEdit')->name('assetsMotorVehicleEdit')->middleware('auth');
Route::post('assetsMotorVehicleEditSave','AssetsController@assetsMotorVehicleEditSave')->name('assetsMotorVehicleEditSave')->middleware('auth');

Route::get('assetsNewIntangible','AssetsController@assetsNewIntangible')->name('assetsNewIntangible')->middleware('auth');
Route::post('assetsNewIntangibleSave','AssetsController@assetsNewIntangibleSave')->name('assetsNewIntangibleSave')->middleware('auth');
Route::get('assetsIntangible','AssetsController@assetsIntangible')->name('assetsIntangible')->middleware('auth');
Route::get('assetsIntangibleView/{id}','AssetsController@assetsIntangibleView')->name('assetsIntangibleView')->middleware('auth');
Route::get('assetsIntangibleEdit/{id}','AssetsController@assetsIntangibleEdit')->name('assetsIntangibleEdit')->middleware('auth');
Route::post('assetsIntangibleEditSave','AssetsController@assetsIntangibleEditSave')->name('assetsIntangibleEditSave')->middleware('auth');

Route::get('assetsNewFurniture','AssetsController@assetsNewFurniture')->name('assetsNewFurniture')->middleware('auth');
Route::post('assetsNewFurnitureSave','AssetsController@assetsNewFurnitureSave')->name('assetsNewFurnitureSave')->middleware('auth');
Route::get('assetsFurniture','AssetsController@assetsFurniture')->name('assetsFurniture')->middleware('auth');
Route::get('assetsFurnitureView/{id}','AssetsController@assetsFurnitureView')->name('assetsFurnitureView')->middleware('auth');
Route::get('assetsFurnitureEdit/{id}','AssetsController@assetsFurnitureEdit')->name('assetsFurnitureEdit')->middleware('auth');
Route::post('assetsFurnitureEditSave','AssetsController@assetsFurnitureEditSave')->name('assetsFurnitureEditSave')->middleware('auth');

Route::get('assetsNewEquipment','AssetsController@assetsNewEquipment')->name('assetsNewEquipment')->middleware('auth');
Route::post('assetsNewEquipmentSave','AssetsController@assetsNewEquipmentSave')->name('assetsNewEquipmentSave')->middleware('auth');
Route::get('assetsEquipment','AssetsController@assetsEquipment')->name('assetsEquipment')->middleware('auth');
Route::get('assetsEquipmentView/{id}','AssetsController@assetsEquipmentView')->name('assetsEquipmentView')->middleware('auth');
Route::get('assetsEquipmentEdit/{id}','AssetsController@assetsEquipmentEdit')->name('assetsEquipmentEdit')->middleware('auth');
Route::post('assetsEquipmentEditSave','AssetsController@assetsEquipmentEditSave')->name('assetsEquipmentEditSave')->middleware('auth');

Route::get('assetsNewComputerEquipment','AssetsController@assetsNewComputerEquipment')->name('assetsNewComputerEquipment')->middleware('auth');
Route::post('assetsNewComputerEquipmentSave','AssetsController@assetsNewComputerEquipmentSave')->name('assetsNewComputerEquipmentSave')->middleware('auth');
Route::get('assetsComputerEquipment','AssetsController@assetsComputerEquipment')->name('assetsComputerEquipment')->middleware('auth');
Route::get('assetsComputerEquipmentView/{id}','AssetsController@assetsComputerEquipmentView')->name('assetsComputerEquipmentView')->middleware('auth');
Route::get('assetsComputerEquipmentEdit/{id}','AssetsController@assetsComputerEquipmentEdit')->name('assetsComputerEquipmentEdit')->middleware('auth');
Route::post('assetsComputerEquipmentEditSave','AssetsController@assetsComputerEquipmentEditSave')->name('assetsComputerEquipmentEditSave')->middleware('auth');

Route::get('assetsNewBuilding','AssetsController@assetsNewBuilding')->name('assetsNewBuilding')->middleware('auth');
Route::post('assetsNewBuildingSave','AssetsController@assetsNewBuildingSave')->name('assetsNewBuildingSave')->middleware('auth');
Route::get('assetsBuilding','AssetsController@assetsBuilding')->name('assetsBuilding')->middleware('auth');
Route::get('assetsBuildingView/{id}','AssetsController@assetsBuildingView')->name('assetsBuildingView')->middleware('auth');
Route::get('assetsBuildingEdit/{id}','AssetsController@assetsBuildingEdit')->name('assetsBuildingEdit')->middleware('auth');
Route::post('assetsBuildingEditSave','AssetsController@assetsBuildingEditSave')->name('assetsBuildingEditSave')->middleware('auth');


Route::get('assetsNewWorkinProgress','AssetsController@assetsNewWorkinProgress')->name('assetsNewWorkinProgress')->middleware('auth');
Route::post('assetsNewWorkinProgressSave','AssetsController@assetsNewWorkinProgressSave')->name('assetsNewWorkinProgressSave')->middleware('auth');
Route::get('assetsWorkinProgress','AssetsController@assetsWorkinProgress')->name('assetsWorkinProgress')->middleware('auth');
Route::get('assetsWorkinProgressView/{id}','AssetsController@assetsWorkinProgressView')->name('assetsWorkinProgressView')->middleware('auth');
Route::get('assetsWorkinProgressEdit/{id}','AssetsController@assetsWorkinProgressEdit')->name('assetsWorkinProgressEdit')->middleware('auth');
Route::post('assetsWorkinProgressEditSave','AssetsController@assetsWorkinProgressEditSave')->name('assetsWorkinProgressEditSave')->middleware('auth');
Route::get('assetsWorkinProgressReallocate/{id}','AssetsController@assetsWorkinProgressReallocate')->name('assetsWorkinProgressReallocate')->middleware('auth');
Route::post('assetsWorkinProgressReallocateSave','AssetsController@assetsWorkinProgressReallocateSave')->name('assetsWorkinProgressReallocateSave')->middleware('auth');

Route::POST('assetsAssesBuildingSave','AssetsController@assetsAssesBuildingSave')->name('assetsAssesBuildingSave')->middleware('auth');
Route::POST('assetsAssesFurnitureSave','AssetsController@assetsAssesFurnitureSave')->name('assetsAssesFurnitureSave')->middleware('auth');
Route::POST('assetsAssesEquipmentSave','AssetsController@assetsAssesEquipmentSave')->name('assetsAssesEquipmentSave')->middleware('auth');
Route::POST('assetsAssesComputerEquipmentSave','AssetsController@assetsAssesComputerEquipmentSave')->name('assetsAssesComputerEquipmentSave')->middleware('auth');
Route::POST('assetsAssesPlantMachinerySave','AssetsController@assetsAssesPlantMachinerySave')->name('assetsAssesPlantMachinerySave')->middleware('auth');
Route::POST('assetsAssesMotorVehicleSave','AssetsController@assetsAssesMotorVehicleSave')->name('assetsAssesMotorVehicleSave')->middleware('auth');
Route::POST('assetsAssesIntangibleSave','AssetsController@assetsAssesIntangibleSave')->name('assetsAssesIntangibleSave')->middleware('auth');
Route::POST('assetsAssesLandSave','AssetsController@assetsAssesLandSave')->name('assetsAssesLandSave')->middleware('auth');

//export assets - in format
Route::get('assetExcel/export/','ExcelController@export')->name('assetExcel/export/')->middleware('auth');
Route::get('assetExcel/bexport/','ExcelController@bexport')->name('assetExcel/bexport/')->middleware('auth');

Route::get('assetinfo/export/{id}/{type}','AssetsController@exportinfo')->name('assetinfo/export/')->middleware('auth');
Route::get('asset/assesment/export/{type}','AssetsController@assesExport')->name('asset/assesment/export/')->middleware('auth');
Route::get('assetssummaryall','AssetsController@assetssummaryall')->name('assetssummaryall')->middleware('auth');
Route::get('assetsSummaryFiltered','AssetsController@assetsSummaryFiltered')->name('assetsSummaryFiltered')->middleware('auth');
Route::get('assetreportfromsummary','ExcelController@assetreportfromsummary')->name('assetreportfromsummary')->middleware('auth');
// assets ends here

//merged

Route::post('printreportm/{id}','NotesController@printmonthreport')->name('print.month.report')->middleware('auth');

Route::post('ppuprojectdraftsman','PhysicalPlanningController@ppuprojectdraftsman')->name('ppuprojectdraftsman')->middleware('auth');

Route::get('yearlyplantmachinery','AssetsController@yearlyplantmachinery')->name('yearlyplantmachinery')->middleware('auth');
Route::get('yearlymotorvehicle','AssetsController@yearlymotorvehicle')->name('yearlymotorvehicle')->middleware('auth');
Route::get('yearlycomputerequipment','AssetsController@yearlycomputerequipment')->name('yearlycomputerequipment')->middleware('auth');
Route::get('yearlyequipment','AssetsController@yearlyequipment')->name('yearlyequipment')->middleware('auth');
Route::get('yearlyfurniture','AssetsController@yearlyfurniture')->name('yearlyfurniture')->middleware('auth');
Route::get('yearlyintangible','AssetsController@yearlyintangible')->name('yearlyintangible')->middleware('auth');
Route::get('yearlyland','AssetsController@yearlyland')->name('yearlyland')->middleware('auth');
Route::get('yearlybuilding','AssetsController@yearlybuilding')->name('yearlybuilding')->middleware('auth');

Route::get('yearlyexport','ExcelController@yearlyexport')->name('yearlyexport')->middleware('auth');
Route::get('usersoptions','UserController@usersoptions')->name('usersoptions')->middleware('auth');
Route::get('usersfiltered','UserController@usersfiltered')->name('usersfiltered')->middleware('auth');
Route::post('restorepassword/{id}','UserController@restorepassword')->name('restorepassword')->middleware('auth');
Route::get('downloads','HomeController@downloads')->name('downloads')->middleware('auth');
Route::get('newdownloads','HomeController@newdownloads')->name('newdownloads')->middleware('auth');
Route::post('savedownloads','HomeController@savedownloads')->name('savedownloads')->middleware('auth');
Route::get('viewdownloads/{id}','HomeController@viewdownloads')->name('viewdownloads')->middleware('auth');
Route::get('deletedownload/{id}','HomeController@deletedownload')->name('deletedownload')->middleware('auth');

Route::post('work_order/require/material/{id}', 'WorkOrderController@requirematerial')->name('workOrder.requirematerial');

Route::get('editdownloads/{id}','HomeController@editdownloads')->name('editdownloads')->middleware('auth');
Route::post('saveheaddownloads','HomeController@saveheaddownloads')->name('saveheaddownloads')->middleware('auth');
Route::post('savefiledownloads','HomeController@savefiledownloads')->name('savefiledownloads')->middleware('auth');

Route::get('sendreturnlocation','UserController@sendreturnlocation')->name('sendreturnlocation')->middleware('auth');
Route::get('fetchstatus1','UserController@fetchstatus1')->name('fetchstatus1')->middleware('auth');
Route::post('work_order/require/material/{id}', 'WorkOrderController@requirematerial')->name('workOrder.requirematerial');
Route::get('filterhos','HomeController@filterhos')->name('filterhos')->middleware('auth');
Route::POST('deleteprofilepicture','UserController@deleteprofilepicture')->name('deleteprofilepicture')->middleware('auth');

Route::get('deactivatedusers','HomeController@deactivatedusers')->name('deactivatedusers')->middleware('auth');
Route::get('activateuser/{id}','HomeController@activateuser')->name('activateuser')->middleware('auth');

Route::get('deactivatedtechnicians','HomeController@deactivatedtechnicians')->name('deactivatedtechnicians')->middleware('auth');
Route::get('activatetechnician/{id}','HomeController@activatetechnician')->name('activatetechnician')->middleware('auth');

Route::get('exportdeactivatedtechs','NotesController@exportdeactivatedtechs')->name('exportdeactivatedtechs')->middleware('auth');
Route::get('exportdeactivatedusers','NotesController@exportdeactivatedusers')->name('exportdeactivatedusers')->middleware('auth');
Route::get('transfertoWIP/{id}','AssetsController@transfertoWIP')->name('transfertoWIP')->middleware('auth');

Route::get('assessingroup','AssetsController@assessingroup')->name('assessingroup')->middleware('auth');
// Route::get('manageusertype','UserController@manageusertype')->name('manageusertype')->middleware('auth');
// Route::post('saveusertype','UserController@saveusertype')->name('saveusertype')->middleware('auth');
// Route::post('editsaveusertype','UserController@editsaveusertype')->name('editsaveusertype')->middleware('auth');
// auto refresh on selection
Route::get('getTechSec1','TechnicianController@getTechSec1')->name('getTechSec1')->middleware('auth');
Route::get('gethossect','UserController@gethossect')->name('gethossect')->middleware('auth');

Route::get('getnameMAT','StoreController@getnameMAT')->name('getnameMAT')->middleware('auth');
Route::get('getdescriptionMAT','StoreController@getdescriptionMAT')->name('getdescriptionMAT')->middleware('auth');
Route::get('getbrandMAT','StoreController@getbrandMAT')->name('getbrandMAT')->middleware('auth');

Route::get('descmaterials','StoreController@descmaterials')->name('descmaterials')->middleware('auth');
Route::get('namematerials','StoreController@namematerials')->name('namematerials')->middleware('auth');

Route::get('readcomments','MinuteController@readcomments')->name('readcomments')->middleware('auth');
Route::get('sendcomments','MinuteController@sendcomments')->name('sendcomments')->middleware('auth');
Route::post('sendcomment','MinuteController@sendcomment')->name('sendcomment')->middleware('auth');
Route::get('depDirects','UserController@depDirects')->name('depDirects')->middleware('auth');
//
