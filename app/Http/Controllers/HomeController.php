<?php

namespace App\Http\Controllers;

use App\Material;
use App\Notification;
use Illuminate\Http\Request;
use App\User;

use App\Directorate;
use App\WorkOrder;
use App\Department;
use App\Section;


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
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
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
        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
//        return response()->json(WorkOrder::with('user')->with('room.block')->where('problem_type', substr(strstr(auth()->user()->type, " "), 1))->where('status', '<>', 0)->get());
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        if ($role['user_role']->role_id == 1){
            return view('work_orders', ['role' => $role, 'wo' => WorkOrder::all(), 'notifications' => $notifications]);
        }else{
            if (strpos(auth()->user()->type, "HOS") !== false) {
                return view('work_orders', [
                    'role' => $role,
                    'wo' => WorkOrder::where('problem_type', substr(strstr(auth()->user()->type, " "), 1))->where('status', '<>', 0)->get(),
                    'notifications' => $notifications
                ]);
            }else if (auth()->user()->type == "SECRETARY"){
                return view('work_orders', ['role' => $role, 'wo' => WorkOrder::where('problem_type', 'Others')->get(), 'notifications' => $notifications]);
            }
        }
        return view('work_orders', ['role' => $role, 'wo' => WorkOrder::where('client_id', auth()->user()->id)->get(), 'notifications' => $notifications]);
    }

    public function createUserView()
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $directorate = Directorate::all();
        $departments = Department::where('directorate_id', 1)->get();
        $sections = Section::where('department_id', 1)->get();
        return view('create_user', [
            'directorates' => $directorate,
            'role' => $role, 'sections' => $sections,
            'departments' => $departments,
            'notifications' => $notifications
        ]);
    }

    public function storesView()
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('stores', ['role' => $role, 'items' => Material::all(), 'notifications' => $notifications]);
    }

    public function usersView()
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
        $users = User::with('section.department.directorate')->where('id', '<>', auth()->user()->id)->where('status', '=', 1)->get();


        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
//        return response()->json($users);
        return view('viewusers', ['display_users' => $users, 'role' => $role, 'notifications' => $notifications]);

    }

    public function createWOView()
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('createworkorders', ['role' => $role, 'notifications' => $notifications]);
    }

    public function dashboard()
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('dashboard', ['role' => $role, 'notifications' => $notifications]);
    }

    public function notificationView()
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('notification', ['role' => $role, 'notifications' => $notifications]);
    }

    public function passwordView(){
        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('changepassword', ['role' => $role, 'notifications' => $notifications]);
    }
public function profileView(){
    $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('changeprofile', ['role' => $role, 'notifications' => $notifications]);
    }

}