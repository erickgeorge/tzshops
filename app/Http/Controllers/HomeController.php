<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Material;
use App\Notification;
use App\Technician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\WorkOrderStaff;
use App\PurchasingOrder;
use App\Directorate;
use App\WorkOrder;
use App\Department;
use App\Section;
use App\WorkOrderMaterial;
use App\WorkOrderTransport;
use App\Note;

use Redirect;
use PDF;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {  

           if ((Auth::user()->change_password == null)) {
                   $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('changepassword2', ['role' => $role,'notifications' => $notifications]);
        }
        else{
             $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
            return view('dashboard', ['role' => $role, 'notifications' => $notifications]);   
        }



     $data['wo'] = Workorder::OrderBy('created_at', 'DESC')->paginate(10);
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
//         return response()->json($role);
        if ($role['user_role']->role_id == 1){
            return view('work_orders', ['role' => $role, 'wo' => WorkOrder::OrderBy('created_at', 'DESC')->GET(), 'notifications' => $notifications]);
        }else{
            if (strpos(auth()->user()->type, "HOS") !== false) {
                return view('work_orders', [
                    'role' => $role,
                    'wo' => WorkOrder::where('problem_type', substr(strstr(auth()->user()->type, " "), 1))->OrderBy('created_at', 'DESC')->get(),
                    'notifications' => $notifications
                ]);
            } elseif (auth()->user()->type == 'STORE') {
                return view('stores', ['role' => $role, 'items' => Material::all(), 'notifications' => $notifications]);
            }
        }
        return view('dashboard', ['role' => $role, 'items' => Material::all(), 'notifications' => $notifications]);
              

               




    }

    public function WorkorderView()
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
//        return response()->json(WorkOrder::with('user')->with('room.block')->where('problem_type', substr(strstr(auth()->user()->type, " "), 1))->where('status', '<>', 0)->get());
     
    
    if(request()->has('start'))  { //date filter
        
        
        $from=request('start');
        $to=request('end');
        
        
        $nextday = date("Y-m-d", strtotime("$to +1 day"));

        $to=$nextday;
        if(request('start')>request('end')){
            $to=request('start');
        $from=request('end');
        }// start> end
        
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        if ($role['user_role']->role_id == 1){
            return view('work_orders', [
                'role' => $role,
                'notifications' => $notifications,
                'wo' => WorkOrder::whereBetween('created_at', [$from, $to])->OrderBy('created_at', 'DESC')->get()
            ]);
        }//if role=1

        else { //role role not 1



                $type=explode(",",auth()->user()->type);
                $length=count($type);


                   if($length==1){

            if (strpos(auth()->user()->type, "HOS") !== false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr(auth()->user()->type, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }else if (auth()->user()->type == "Maintenance coordinator"){
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', 'Others')->whereBetween('created_at', [$from, $to])->OrderBy('created_at', 'DESC')->get()
                ]);
            }
            
            else if (auth()->user()->type == "Estates Director"){
                return view('work_orders', ['role' => $role,'notifications' => $notifications, 'wo' => WorkOrder::whereBetween('created_at', [$from, $to])->OrderBy('created_at', 'DESC')->get()]);
            }  else
            
        {// HOS and their work order type 

        return view('work_orders', [
            'role' => $role,
            'notifications' => $notifications,
            'wo' => WorkOrder::where('client_id', auth()->user()->id)->whereBetween('created_at', [$from, $to])->OrderBy('created_at', 'DESC')->get()
        ]);
   
        
        
    }//

}


 //lenght not 1

 else if($length==2){




$v1=$type[0];
$v2=$type[1];




            if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false){
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', $v2)->whereBetween('created_at', [$from, $to])->OrderBy('created_at', 'DESC')->get()
                ]);
            }

                else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false){
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type',$v1)->orwhere('problem_type', $v2)->whereBetween('created_at', [$from, $to])->OrderBy('created_at', 'DESC')->get()
                ]);
            }
            else  if(strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false){
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', $v1)->orwhere('problem_type', substr(strstr($v2, " "), 1))->whereBetween('created_at', [$from, $to])->OrderBy('created_at', 'DESC')->get()
                ]);
            }

}



 }
}


 
//lenght
// end start 
        else {//dtsrt fdate
    
     $role = User::where('id', auth()->user()->id)->with('user_role')->first();


        if ($role['user_role']->role_id == 1){
            return view('work_orders', ['role' => $role, 'wo' => WorkOrder::OrderBy('created_at', 'DESC')->GET(),'notifications' => $notifications]);
        }else{


             $type=explode(",",auth()->user()->type);
                $length=count($type);


                   if($length==1){

            if (strpos(auth()->user()->type, "HOS") !== false) {
                return view('work_orders', ['role' => $role, 'notifications' => $notifications,'wo' => WorkOrder::where('problem_type', substr(strstr(auth()->user()->type, " "), 1))->where('status', '<>', 0)->orwhere('client_id', auth()->user()->id, " ")->OrderBy('created_at', 'DESC')->get()]);
            }else if (auth()->user()->type == "Maintenance coordinator"){
                return view('work_orders', ['role' => $role,'notifications' => $notifications, 'wo' => WorkOrder::where('problem_type', 'Others')->orwhere('client_id', auth()->user()->id, " ")->OrderBy('created_at', 'DESC')->get()]);
            }
            else if (auth()->user()->type == "Estates Director"){
                return view('work_orders', ['role' => $role,'notifications' => $notifications, 'wo' => WorkOrder::OrderBy('created_at', 'DESC')->GET()]);
            }
            else{
                
        return view('work_orders', ['role' => $role,'notifications' => $notifications, 'wo' => WorkOrder::where('client_id', auth()->user()->id)->OrderBy('created_at', 'DESC')->get()]);
            }
   }

 else if($length==2){




$v1=$type[0];
$v2=$type[1];




            if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false){
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', $v2)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

                else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false){
                return view('work_orders',[
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type',$v1)->orwhere('problem_type', $v2)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
            else  if(strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false){
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', $v1)->orwhere('problem_type', substr(strstr($v2, " "), 1))->OrderBy('created_at', 'DESC')->get()
                ]);
            }

}




    }
}



}




    

    public function createUserView()
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();

        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $directorate = Directorate::where('name','<>',null)->OrderBy('name','ASC')->get();
        $departments = Department::where('directorate_id', 1)->get();
        $sections = Section::where('department_id', 1)->get();
        return view('create_user', [
            'directorates' => $directorate,
            'role' => $role,
            'sections' => $sections,
            'departments' => $departments,
            'notifications' => $notifications
        ]);
    }

    public function storesView()
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
           $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('stores', ['role' => $role, 'items' => Material::where('stock','>=',1)->orderBy('name','ASC')->get(),'notifications' => $notifications]);

    }
    
    
    
     public function storeshosView()
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('storeshos', ['role' => $role, 'items' => Material::all(),'notifications' => $notifications]);
    }
    

    public function usersView()
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $users = User::with('section.department.directorate')->where('id', '<>', auth()->user()->id)->where('status', '=', 1)->get();


        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
//        return response()->json($users);
        return view('viewusers', ['display_users' => $users, 'role' => $role,'notifications' => $notifications]);

    }

    public function createWOView()
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('createworkorders', ['role' => $role,'notifications' => $notifications]);
    }

    public function dashboard()
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('dashboard', ['role' => $role,'notifications' => $notifications]);
    }

    public function notificationView()
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('notification', ['role' => $role,'notifications' => $notifications]);
    }

    public function passwordView(){
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('changepassword', ['role' => $role,'notifications' => $notifications]);
    }


    public function passwordView2(){
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('changepassword2', ['role' => $role,'notifications' => $notifications]);
    }

public function profileView(){
    $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
         $user = Auth::user();
        return view('changeprofile', ['role' => $role,'notifications' => $notifications,'user' => $user]);
    }
    
    public function myprofileView(){
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $user = Auth::user();
        return view('myprofile', ['role' => $role,'notifications' => $notifications,'user' => $user]);
    }
   
   public function AddMaterialVO(){

     $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('addmaterial', ['role' => $role,'notifications' => $notifications]);
   }

   public function techniciansView(){

     $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
  
    return view('technicians', [
            'role' => $role,
            'techs' => Technician::where('type', substr(strstr(auth()->user()->type, " "), 1))->orderBy('fname','ASC')->get(),
            'notifications' => $notifications

        ]);
   }
   
   
    public function workOrderNeedMaterialView()
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        
        $wo_material=   WorkOrderMaterial::
                       select(DB::raw('work_order_id'),'hos_id')
                     ->where('status',0)
                     ->groupBy('work_order_id')
                     ->groupBy('hos_id')
                     ->get();
        
        
        return view('womaterialneeded', ['role' => $role, 'items' => $wo_material,'notifications' => $notifications]);
    }



     public function workOrderMaterialRejected()
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        
        $wo_material=   WorkOrderMaterial::
                       select(DB::raw('work_order_id'),'hos_id')
                     ->where('status',-1)
                     ->orwhere('status',17)
                     ->groupBy('work_order_id')
                     ->groupBy('hos_id')
                     ->get();
        
        
        return view('rejectedmaterialwith_wo', ['role' => $role, 'items' => $wo_material,'notifications' => $notifications]);
    }

      public function MaterialReceivewithWo()
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        
        $wo_material=   WorkOrderMaterial::
                       select(DB::raw('work_order_id'),'receiver_id')
                     ->where('status',3)
                     ->groupBy('work_order_id')
                     ->groupBy('receiver_id')
                     ->get();
        
        
        return view('receivedmaterialwith_wo', ['role' => $role, 'items' => $wo_material,'notifications' => $notifications]);
    }



    public function MaterialpurchasedView()
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        
        $wo_material=   WorkOrderMaterial::
                       select(DB::raw('work_order_id'),'hos_id')
                     ->where('status',15)
                     ->groupBy('work_order_id')
                     ->groupBy('hos_id')
                     ->get();
        
        
        return view('womaterialpurchased', ['role' => $role, 'items' => $wo_material,'notifications' => $notifications]);
    }



    public function workOrderMissingMaterialView()
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 10)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        
        $wo_material=   WorkOrderMaterial::
                     select(DB::raw('work_order_id'),'hos_id')
                     ->where('status',10)
                    
                     ->groupBy('work_order_id')
                      ->groupBy('hos_id')
                     ->get();
        
        
        return view('womaterialmissing', ['role' => $role, 'items' => $wo_material,'notifications' => $notifications]);
    }
    
     public function workOrderMaterialInspectionView($id)
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
       
        $wo_material=   WorkOrderMaterial::
                    
                     where('work_order_id',$id)->where('status',0)->orwhere('work_order_id',$id)->where('status',9)
                     
            
                     ->get();
                     
        
        
        return view('material_inspection_view', ['role' => $role, 'items' => $wo_material,'notifications' => $notifications ,  'wo' => WorkOrder::where('id', $id)->first(),]);
    }


        public function workOrderMaterialpurchased($id)
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        
        $wo_material=   WorkOrderMaterial::
                    
                     where('work_order_id',$id)->where('status',15)
                    ->get();
        
        return view('womaterialtoprocureviewbyheadprocurement', ['role' => $role, 'items' => $wo_material,'notifications' => $notifications]);
    }


    public function workOrderMaterialMissingInspectionView($id)
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 10)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        
        $wo_material=   WorkOrderMaterial::
                    
                     where('work_order_id',$id)->where('status',10)
                     
            
                     ->get();
        
        
        return view('material_missing_inspection_view', ['role' => $role, 'items' => $wo_material,'notifications' => $notifications]);
    }
    
    public function workOrderApprovedMaterialView()
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        
        $wo_material=   WorkOrderMaterial::
                     select(DB::raw('work_order_id'))
                     ->where('status',3)
                    
                     ->groupBy('work_order_id')
                     
                     ->get();
            
        return view('womaterialapproved', ['role' => $role, 'items' => $wo_material,'notifications' => $notifications]);
    }
    



       public function workorderwithmissingmaterial()
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        
        $wo_material=   WorkOrderMaterial::
                     select(DB::raw('work_order_id'))
                     ->where('status',5)
                    
                     ->groupBy('work_order_id')
                     
                     ->get();
               
        return view('womaterialtoprocure', ['role' => $role, 'items' => $wo_material,'notifications' => $notifications]);
    }
    

       public function materialacceptedbyiow()
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        
        $wo_material=   WorkOrderMaterial::
                     select(DB::raw('work_order_id'))
                     ->where('status',1)
                    
                     ->groupBy('work_order_id')
                     
                     ->get();
               
        return view('womaterialacceptedbyiowtostore', ['role' => $role, 'items' => $wo_material,'notifications' => $notifications]);
    }
    


    
    
    public function work_order_purchasing_requestView()
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        
        $wo_material=   PurchasingOrder::
                     select(DB::raw('work_order_id'))
                     ->where('status',0)
                    
                     ->groupBy('work_order_id')
                     
                     ->get();
            
            
        
            
            
        return view('wo_purchasing_request', ['role' => $role, 'items' => $wo_material,'notifications' => $notifications]);
    }
    
    
    
    
    
    
    public function wo_release_grn()
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        
        $wo_material=   PurchasingOrder::
                     select(DB::raw('work_order_id'))
                     ->where('status',2)
                    
                     ->groupBy('work_order_id')
                     
                     ->get();
            
            
        
            
            
        return view('wo_release_grn', ['role' => $role, 'items' => $wo_material,'notifications' => $notifications]);
    }
    public function workOrdergrnView()
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        
        $wo_material=   PurchasingOrder::
                     select(DB::raw('work_order_id'))
                     ->where('status',1)
                    
                     ->groupBy('work_order_id')
                     
                     ->get();
            
            
        
            
            
        return view('wo_grn', ['role' => $role, 'items' => $wo_material,'notifications' => $notifications]);
    }
    
    
    
    
    public function workOrderReleasedMaterialView()
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        
        
        
        $wo_material = WorkOrderMaterial::
                     select(DB::raw('work_order_id,material_id,sum(quantity) as quantity'))
                     ->where('status',2)
                     ->groupBy('material_id')
                     ->groupBy('work_order_id')
                     ->orderBy('work_order_id')
                     ->orderBy('updated_at','ASC')
                     ->get();
        
        
        
        
        return view('womaterialreleased', ['role' => $role, 'items' => $wo_material,'notifications' => $notifications]);
    }
    
    
    
    
    public function transport_request_View()
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('wo_trasport_request', ['role' => $role, 'items' => WorkOrderTransport::where('status', 0)->orderBy(DB::raw('ABS(DATEDIFF(time, NOW()))'))->get(),'notifications' => $notifications]);
    }
    
    
    public function woTransportAcceptedView()
    {
        if(request()->has('start') && request()->has('end') )  {
        
        
        $from=request('start');
        $to=request('end');
        
        if(request('start')>request('end')){
            $to=request('start');
        $from=request('end');
        }
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('wo_trasport_accept', ['role' => $role, 'items' => WorkOrderTransport::where('status', 1)->whereBetween('updated_at', [$from, $to])->get(),'notifications' => $notifications]);
    
        }
        
        
        
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('wo_trasport_accept', ['role' => $role, 'items' => WorkOrderTransport::where('status', 1)->get(),'notifications' => $notifications]);
    }
    
    public function woTransportRejectedView()
    {
        
        if(request()->has('start') && request()->has('end') )  {
        
        
        $from=request('start');
        $to=request('end');
        
        if(request('start')>request('end')){
            $to=request('start');
        $from=request('end');
        }
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('wo_trasport_accept', ['role' => $role, 'items' => WorkOrderTransport::where('status', -1)->whereBetween('updated_at', [$from, $to])->get(),'notifications' => $notifications]);
    
        }
        
        
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('wo_trasport_accept', ['role' => $role, 'items' => WorkOrderTransport::where('status', -1)->get(),'notifications' => $notifications]);
    }
    
    
    
    public function woMaterialAcceptedView()
    {
        
        if(request()->has('start') && request()->has('end') )  {
        
        
        $from=request('start');
        $to=request('end');
        
        if(request('start')>request('end')){
            $to=request('start');
        $from=request('end');
        }
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('wo_material_accepted', ['role' => $role, 'items' => WorkOrderMaterial::where('status', 1)->whereBetween('updated_at', [$from, $to])->get(),'notifications' => $notifications]);
 
        }
        
        
        
         $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('wo_material_accepted', ['role' => $role, 'items' => WorkOrderMaterial::where('status', 1)->get(),'notifications' => $notifications]);
   }
       
     



   
   
   
   public function woMaterialRejectedView()
    {
        
        if(request()->has('start') && request()->has('end') )  {
        
        
        $from=request('start');
        $to=request('end');
        
        if(request('start')>request('end')){
            $to=request('start');
        $from=request('end');
        }
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('wo_material_rejected', ['role' => $role, 'items' => WorkOrderMaterial::where('status',-1)->whereBetween('updated_at', [$from, $to])->get(),'notifications' => $notifications]);
 
        }
        
        
        
         $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('wo_material_rejected', ['role' => $role, 'items' => WorkOrderMaterial::where('status', -1)->get(),'notifications' => $notifications]);
   }
   
   
   
   
   
    public function unattendedWorkOrdersView()
    {
        
        if(request()->has('start') && request()->has('end') )  {
        
        
        $from=request('start');
        $to=request('end');
        
        if(request('start')>request('end')){
            $to=request('start');
        $from=request('end');
        }
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('completed_wo', ['role' => $role, 'wo' => WorkOrder::where('status',-1)->whereBetween('updated_at', [$from, $to])->get(),'notifications' => $notifications]);
 
        }
        
        
        
         $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('completed_wo', ['role' => $role, 'wo' => WorkOrder::where('status',-1)-> orderBy(DB::raw('ABS(DATEDIFF(created_at, NOW()))'))->  get(),'notifications' => $notifications]);
   }
   
   
    public function completedWorkOrdersView()
    {
        
        if(request()->has('start') && request()->has('end') )  {
        
        
        $from=request('start');
        $to=request('end');
        
        if(request('start')>request('end')){
            $to=request('start');
        $from=request('end');
        }
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('unattended_wo', ['role' => $role, 'wo' => WorkOrder::where('status',2)->whereBetween('updated_at', [$from, $to])->get(),'notifications' => $notifications]);
 
        }
        
        
        
         $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('unattended_wo', ['role' => $role, 'wo' => WorkOrder::where('status',2)-> orderBy(DB::raw('ABS(DATEDIFF(created_at, NOW()))'))->  get(),'notifications' => $notifications]);
   }
   
   
   
    public function roomreportView()
    {
        
        $wo_room = WorkOrder::
                     select(DB::raw('count(id) as total_room,count(location) as total_location, location,room_id'))
                     
                     ->groupBy('room_id')
                     ->groupBy('location')
                     ->get();
                     
                     
                     
        
        
         $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('roomreport', ['role' => $role, 'wo' =>$wo_room,'notifications' => $notifications]);
   }
   
   
      public function storereportView()
    {
        
  


             $tottal_item = Material::
                     select(DB::raw('name,sum(stock) as stock ,count(*) as totalstock,type,description'))
                     ->groupBy('name')
                     ->groupBy('type')
                      ->groupBy('description')
                     ->get();
        
         $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('storereport', ['role' => $role, 'items' => $tottal_item,'notifications' => $notifications, ]);
   }

   
   
    public function woduration()
    {
        
        if(request()->has('start') && request()->has('end') )  {
        
        
        $from=request('start');
        $to=request('end');
        
        if(request('start')>request('end')){
            $to=request('start');
        $from=request('end');
        }
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('woduration', ['role' => $role, 'wo' => WorkOrder::where('status',2)->whereBetween('updated_at', [$from, $to])->get(),'notifications' => $notifications]);
 
        }
        
        
        
         $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('woduration', ['role' => $role, 'wo' => WorkOrder::where('status',2)-> orderBy(DB::raw('ABS(DATEDIFF(created_at, NOW()))'))->  get(),'notifications' => $notifications]);
   }
   







 public function techniciancount()
    {
        
        
        $wo_technician_count = WorkOrderStaff::
                     select(DB::raw('count(work_order_id) as total_wo,staff_id as staff_id'))
                     ->where('status',0)
                     ->groupBy('staff_id')
                     
                     ->get();
        
        if(request()->has('start') && request()->has('end') )  {
        
        
        $from=request('start');
        $to=request('end');
        
        if(request('start')>request('end')){
            $to=request('start');
        $from=request('end');
        }
        
        $wo_technician_count = WorkOrderStaff::
                     select(DB::raw('count(work_order_id) as total_wo,staff_id as staff_id'))
                     ->where('status',1)
                     ->whereBetween('created_at', [$from, $to])
                     ->groupBy('staff_id')
                     
                     ->get();
                     
                    
        
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('techniciancount', ['role' => $role, 'wo' => $wo_technician_count,'notifications' => $notifications]);
 
        }
        
        
        
         $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('techniciancount', ['role' => $role, 'wo' =>$wo_technician_count ,'notifications' => $notifications]);
   }




















public function techniciancountcomp()
    {
        
        
        $wo_technician_count = WorkOrderStaff::
                     select(DB::raw('count(work_order_id) as total_wo,staff_id as staff_id'))
                     ->where('status',1)
                     ->groupBy('staff_id')
                     
                     ->get();
        
        if(request()->has('start') && request()->has('end') )  {
        
        
        $from=request('start');
        $to=request('end');
        
        if(request('start')>request('end')){
            $to=request('start');
        $from=request('end');
        }
        
        $wo_technician_count = WorkOrderStaff::
                     select(DB::raw('count(work_order_id) as total_wo,staff_id as staff_id'))
                     ->where('status',1)
                     ->whereBetween('created_at', [$from, $to])
                     ->groupBy('staff_id')
                     
                     ->get();
                     
                    
        
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('techniciancountcomp', ['role' => $role, 'wo' => $wo_technician_count,'notifications' => $notifications]);
 
        }
        
        
        
         $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('techniciancountcomp', ['role' => $role, 'wo' =>$wo_technician_count ,'notifications' => $notifications]);
   }
























   
    public function hoscount()
    {
        
        $wo_hos_count = WorkOrder::
                     select(DB::raw('count(id) as total_wo,staff_id as staff_id'))
                     ->where('status',2)
                     ->groupBy('staff_id')
                     
                     ->get();
        
        if(request()->has('start') && request()->has('end') )  {
        
        
        $from=request('start');
        $to=request('end');
        
        if(request('start')>request('end')){
            $to=request('start');
        $from=request('end');
        }
        
        $wo_hos_count = WorkOrder::
                     select(DB::raw('count(id) as total_wo,staff_id as staff_id'))
                     ->where('status',2)
                     ->whereBetween('created_at', [$from, $to])
                     ->groupBy('staff_id')
                     
                     ->get();
        
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('hoscount', ['role' => $role, 'wo' => $wo_hos_count,'notifications' => $notifications]);
 
        }
        
        
        
         $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('hoscount', ['role' => $role, 'wo' =>$wo_hos_count ,'notifications' => $notifications]);
   }
   
   
   public function wo_materialView($id)
   
    {
    
        $wo_material = WorkOrderMaterial::
                     select(DB::raw('work_order_id,material_id,sum(quantity) as quantity'))
                     ->where('status',3)
                     ->where('work_order_id',$id)
                     ->groupBy('material_id')
                     ->groupBy('work_order_id')
                     
                     ->get();
        
        
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('womaterialView', ['role' => $role, 'items' => $wo_material,'notifications' => $notifications]);
    }



   
     public function wo_material_to_purchaseView($id)
   
    {
    
        $wo_material = WorkOrderMaterial::
                     select(DB::raw('work_order_id,staff_id,material_id,sum(quantity) as quantity'))
                     ->where('status',5) //status for material to procure
                     ->where('work_order_id',$id)
                     ->groupBy('material_id')
                     ->groupBy('work_order_id') 
                     ->groupBy('staff_id')      
                     
                     ->get();
        
        
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('womaterialtoprocureview', ['role' => $role, 'items' => $wo_material,'notifications' => $notifications]);
    }



public function wo_material_acceptedbyIOWView($id)
   
    {
        $wo_material = WorkOrderMaterial::
                     select(DB::raw('work_order_id,staff_id,material_id,sum(quantity) as quantity'))
                     ->where('status',1) //status for material to procure
                     ->where('work_order_id',$id)
                     ->groupBy('material_id')
                     ->groupBy('work_order_id') 
                     ->groupBy('staff_id')      
                     
                     ->get();
        
        
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('requestedmaterialinstore', ['role' => $role, 'items' => $wo_material,'notifications' => $notifications, 'wo_materials' =>WorkOrderMaterial::where('work_order_id', $id)->where('status',1)->get(),
            'wo' => WorkOrder::where('id', $id)->first()
            ]);
    }


  
     public function wo_material_to_purchaseViewbystore(request $id)
   
    {
    
        $wo_material = WorkOrderMaterial::where('status', 5)
                   
                     ->get();
        
        
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('womaterialtoprocureviewbystore', ['role' => $role, 'items' => $wo_material,'notifications' => $notifications]);
    }

 

      public function wo_material_purchasedViewbyheadprocurement(request $id)
   
    {
    
        $wo_material = WorkOrderMaterial::where('status', 15)
                   
                     ->get();
        
        
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('womaterialtoprocureviewbyheadprocurement', ['role' => $role, 'items' => $wo_material,'notifications' => $notifications]);
    }




    
      public function wo_materialmissingView($id)
   
    {
        
          $wo_material = WorkOrderMaterial::
                     select(DB::raw('work_order_id,material_id,sum(quantity) as quantity'))
                     ->where('status',4)
                     ->where('work_order_id',$id)
                     ->groupBy('material_id')
                     ->groupBy('work_order_id')
                     
                     ->get();
        
        
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('womaterialView', ['role' => $role, 'items' => $wo_material,'notifications' => $notifications]);
    }
    
   
   
    public function wo_purchasing_orderView($id)
   
    {
         
        $wo_material = PurchasingOrder::
                     select(DB::raw('work_order_id,material_list_id,sum(quantity) as quantity'))
                     ->where('status',1)
                     ->where('work_order_id',$id)
                     ->groupBy('material_list_id')
                     ->groupBy('work_order_id')
                     
                     ->get();
        
        
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('purchasingOrderView', ['role' => $role, 'items' => $wo_material,'notifications' => $notifications]);
    }
   
   

   
     public function wo_grn_listView($id)
   
    {
        
     
        $wo_material = PurchasingOrder::
                     select(DB::raw('work_order_id,material_list_id,sum(quantity) as quantity'))
                     ->where('status',1)
                     ->where('work_order_id',$id)
                     ->groupBy('material_list_id')
                     ->groupBy('work_order_id')
                     
                     ->get();
        
        
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('grnProcurementlist', ['role' => $role, 'items' => $wo_material,'notifications' => $notifications]);
    }
   
   


   
    public function procureiow_list($id)
   
    {
        
        $wo_material = PurchasingOrder::
                     select(DB::raw('work_order_id,material_list_id,sum(quantity) as quantity'))
                     ->where('status',0)
                     ->where('work_order_id',$id)
                     ->groupBy('material_list_id')
                     ->groupBy('work_order_id')
                     
                     ->get();
        
        
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('purchasingOrderView', ['role' => $role, 'items' => $wo_material,'notifications' => $notifications]);
    }
   
   
   
    public function wo_procurement_orderView($id)
   
    {
        
        
        
        $wo_material = PurchasingOrder::
                     select(DB::raw('work_order_id,material_list_id,sum(quantity) as quantity'))
                     ->where('status',1)
                     ->where('work_order_id',$id)
                     ->groupBy('material_list_id')
                     ->groupBy('work_order_id')
                     
                     ->get();
        
        
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('procurementOrderView', ['role' => $role, 'items' => $wo_material,'notifications' => $notifications]);
    }
   

         public function WorkorderReportView()
    {
        
         
        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('workorderreport', ['role' => $role,'notifications' => $notifications, ]);
   }

   public function allhos(){
    $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
    $all = User::where('type','like','%HOS%')->get();
    $role = User::where('id', auth()->user()->id)->with('user_role')->first();
    $head = 'All HOS Details';
        return view('otherreports', ['role' => $role,'head'=>$head,'rle' => $all,'notifications' => $notifications, ]);

   }
   public function alltechnicians(){
    $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
    $all = Technician::get();
    $role = User::where('id', auth()->user()->id)->with('user_role')->first();
    $head = 'All Technicians Details';
        return view('otherreports', ['role' => $role,'head'=>$head,'rle' => $all,'notifications' => $notifications, ]);
   }

   public function alliow(){
    $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
    $all = User::where('type','like','%Inspector%')->get();
    $role = User::where('id', auth()->user()->id)->with('user_role')->first();
    $head = 'All Inspectors of work Details';
        return view('otherreports', ['role' => $role,'head'=>$head,'rle' => $all,'notifications' => $notifications, ]);
   }


}
   
   
   
   
   