<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Material;
use App\Notification;
use App\Technician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

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
     $data['wo'] = Workorder::paginate(10);
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
//         return response()->json($role);
        if ($role['user_role']->role_id == 1){
            return view('work_orders', ['role' => $role, 'wo' => WorkOrder::all(), 'notifications' => $notifications]);
        }else{
            if (strpos(auth()->user()->type, "HOS") !== false) {
                return view('work_orders', [
                    'role' => $role,
                    'wo' => WorkOrder::where('problem_type', substr(strstr(auth()->user()->type, " "), 1))->get(),
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
     
	
	if(request()->has('start'))  {
		
		
		$from=request('start');
		$to=request('end');
		
		if(request('start')>request('end')){
			$to=request('start').'-01';
		$from=request('end').'-01';
		}
		
		
		
		
		 $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        if ($role['user_role']->role_id == 1){
            return view('work_orders', [
                'role' => $role,
                'notifications' => $notifications,
                'wo' => WorkOrder::whereBetween('created_at', [$from, $to])->get()
            ]);
        }else{
            if (strpos(auth()->user()->type, "HOS") !== false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr(auth()->user()->type, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->get()
                ]);
            }else if (auth()->user()->type == "SECRETARY"){
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', 'Others')->whereBetween('created_at', [$from, $to])->get()
                ]);
            }
        }
        return view('work_orders', [
            'role' => $role,
            'notifications' => $notifications,
            'wo' => WorkOrder::where('client_id', auth()->user()->id)->whereBetween('created_at', [$from, $to])->get()
        ]);
   
		
		
	}
		else {
	
	 $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        if ($role['user_role']->role_id == 1){
            return view('work_orders', ['role' => $role, 'wo' => WorkOrder::all(),'notifications' => $notifications]);
        }else{
            if (strpos(auth()->user()->type, "HOS") !== false) {
                return view('work_orders', ['role' => $role, 'notifications' => $notifications,'wo' => WorkOrder::where('problem_type', substr(strstr(auth()->user()->type, " "), 1))->where('status', '<>', 0)->get()]);
            }else if (auth()->user()->type == "SECRETARY"){
                return view('work_orders', ['role' => $role,'notifications' => $notifications, 'wo' => WorkOrder::where('problem_type', 'Others')->get()]);
            }
        }
        return view('work_orders', ['role' => $role,'notifications' => $notifications, 'wo' => WorkOrder::where('client_id', auth()->user()->id)->get()]);
    }
	}

    public function createUserView()
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();

        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $directorate = Directorate::all();
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
        return view('stores', ['role' => $role, 'items' => Material::all(),'notifications' => $notifications]);
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
            'techs' => Technician::where('type', substr(strstr(auth()->user()->type, " "), 1))->get(),
            'notifications' => $notifications
        ]);
   }
   
   
    public function workOrderNeedMaterialView()
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('womaterialneeded', ['role' => $role, 'items' => WorkOrderMaterial::where('status', 0)->get(),'notifications' => $notifications]);
    }
	
	
	
	public function workOrderApprovedMaterialView()
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('womaterialapproved', ['role' => $role, 'items' => WorkOrderMaterial::where('status', 1)->get(),'notifications' => $notifications]);
    }
	
	
	
	
	public function workOrderReleasedMaterialView()
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('womaterialreleased', ['role' => $role, 'items' => WorkOrderMaterial::where('status',2 )->get(),'notifications' => $notifications]);
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
			$to=request('start').'-01';
		$from=request('end').'-01';
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
			$to=request('start').'-01';
		$from=request('end').'-01';
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
			$to=request('start').'-01';
		$from=request('end').'-01';
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
			$to=request('start').'-01';
		$from=request('end').'-01';
		}
		$notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('wo_material_accepted', ['role' => $role, 'items' => WorkOrderMaterial::where('status',-1)->whereBetween('updated_at', [$from, $to])->get(),'notifications' => $notifications]);
 
		}
		
		
		
         $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('wo_material_accepted', ['role' => $role, 'items' => WorkOrderMaterial::where('status', -1)->get(),'notifications' => $notifications]);
   }
}