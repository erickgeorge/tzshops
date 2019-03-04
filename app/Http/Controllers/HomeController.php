<?php

namespace App\Http\Controllers;

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
        $role = User::where('id',auth()->user()->id)->with('user_role')->first();
        // return response()->json($role);
        if (strpos(auth()->user()->type, "HOS") !== false) {
        return view('work_order', ['role' => $role, 'wo' => WorkOrder::where('problem_type',substr(strstr( auth()->user()->type, " "), 1))->get()]);
        }elseif (auth()->user()->type == 'STORE') {
        return view('stores', ['role' => $role]);
        }
        return view('dashboard', ['role' => $role]);
    }

     public function WorkorderView()
    {
        $role = User::where('id',auth()->user()->id)->with('user_role')->first();
        // return response()->json($role);
        if (strpos(auth()->user()->type, "HOS") !== false) {
          return view('work_order', ['role' => $role, 'wo' => WorkOrder::where('problem_type',substr(strstr( auth()->user()->type, " "), 1))->get()]);
        }
        return view('work_order', ['role' => $role, 'wo' => WorkOrder::where('client_id', auth()->user()->id)->get()]);
    }
      public function createUserView()
    {

        $role = User::where('id',auth()->user()->id)->with('user_role')->first();
        $directorate=Directorate::all();
        $departments = Department::where('directorate_id', 1)->get();
        $sections = Section::where('department_id', 1)->get();
        return view('create_user',['directorates' => $directorate, 'role' => $role, 'sections' => $sections, 'departments' => $departments]);
}

  public function storesView()
    {
        $role = User::where('id',auth()->user()->id)->with('user_role')->first();
        return view('stores', ['role' => $role]);
}

public function usersView()    {
        $users = User::where('id','<>', auth()->user()->id)->paginate(5);
        $role = User::where('id',auth()->user()->id)->with('user_role')->first();
        return view('viewusers',['display_users' => $users, 'role' => $role]);

}

    public function createWOView()
    {
        $role = User::where('id',auth()->user()->id)->with('user_role')->first();
        return view('createworkorders', ['role' => $role]);
    }

    public function dashboard()
    {
        $role = User::where('id',auth()->user()->id)->with('user_role')->first();
        return view('dashboard', ['role' => $role]);
    }

    public function notificationView()
    {
        $role = User::where('id',auth()->user()->id)->with('user_role')->first();
        return view('notification', ['role' => $role]);
    }




}