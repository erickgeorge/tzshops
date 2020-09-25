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
use App\Des;
use App\Desdepartment;
use App\Section;
use App\workordersection;
use App\WorkOrderMaterial;
use App\WorkOrderTransport;
use App\iowzone;
use App\usertype;
use App\Note;
use App\landmaintainancesection;
use Redirect;
use PDF;

use App\zoneinspector;
use App\download;
use Illuminate\Support\Facades\File;

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
            if (auth()->user()->type == 'Inspector Of Works'){
                return redirect()->route('onprocessworkorders');
                }

            if (auth()->user()->type == 'STORE'){
                return redirect()->route('wo_material_accepted_by_iow');
            }

            if (auth()->user()->type == 'Head Procurement'){
                return redirect()->route('work_order_with_missing_material');
            }

             $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
            if((auth()->user()->type == 'Supervisor Landscaping' )||(auth()->user()->type == 'USAB' ))
            {
                 return redirect()->route('assessmentform.view');
            }
                else{
                     return redirect()->route('work_order');
                }

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
        return redirect()->route('work_order');

    }
    public function Workorderredirectedview(){

        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();

            if(request()->has('start'))  { //date filter


        $from=request('start');
        $to=request('end');


        $nextday = date("Y-m-d", strtotime("$to +1 day"));

        $to=$nextday;
        if(request('start')>request('end')){
            $to=request('start');
        $from=request('end');
        }// start> end

        return view('redirectedwo', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('redirectwo', 1)->whereBetween('created_at', [$from, $to])->OrderBy('created_at', 'DESC')->get()
                ]);
    }
        else

        return view('redirectedwo', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('redirectwo', 1)->OrderBy('created_at', 'DESC')->get()
                ]);

    }



        public function completed_work_orders()
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
            return view('completed_for_all_work_orders', [
                'role' => $role,
                'notifications' => $notifications,
                'wo' => WorkOrder::whereBetween('created_at', [$from, $to])->where('status', 30)->OrderBy('created_at', 'DESC')->get()
            ]);
        }//if role=1

        else { //role role not 1



            if (strpos(auth()->user()->type, "HOS") !== false) {
                return view('completed_for_all_work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr(auth()->user()->type, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->where('status', 30)->OrderBy('created_at', 'DESC')->get()
                ]);
            }else if (auth()->user()->type == "Maintenance coordinator"){
                return view('completed_for_all_work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::whereBetween('created_at', [$from, $to])->where('status', 30)->OrderBy('created_at', 'DESC')->get()
                ]);
            }


            else if (auth()->user()->type == "Estates Director"){
                return view('completed_for_all_work_orders', ['role' => $role,'notifications' => $notifications, 'wo' => WorkOrder::whereBetween('created_at', [$from, $to])->where('status', 30)->OrderBy('created_at', 'DESC')->get()]);
            }
            else if (auth()->user()->type == "DVC Admin"){
                return view('completed_for_all_work_orders', ['role' => $role,'notifications' => $notifications, 'wo' => WorkOrder::whereBetween('created_at', [$from, $to])->where('status', 30)->OrderBy('created_at', 'DESC')->get()]);
            }



             else

        {// HOS and their work order type

        return view('completed_for_all_work_orders', [
            'role' => $role,
            'notifications' => $notifications,
            'wo' => WorkOrder::where('client_id', auth()->user()->id)->whereBetween('created_at', [$from, $to])->where('status', 30)->OrderBy('created_at', 'DESC')->get()
        ]);



    }//

}

}  else{


               $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        if ($role['user_role']->role_id == 1){
            return view('completed_for_all_work_orders', [
                'role' => $role,
                'notifications' => $notifications,
                'wo' => WorkOrder::where('status', 30)->OrderBy('created_at', 'DESC')->get()
            ]);
        }//if role=1

        else { //role role not 1



            if (strpos(auth()->user()->type, "HOS") !== false) {
                return view('completed_for_all_work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr(auth()->user()->type, " "), 1))->where('status', '<>', 0)->where('status', 30)->OrderBy('created_at', 'DESC')->get()
                ]);
            }else if (auth()->user()->type == "Maintenance coordinator"){
                return view('completed_for_all_work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('status', 30)->OrderBy('created_at', 'DESC')->get()
                ]);
            }


            else if (auth()->user()->type == "Estates Director"){
                return view('completed_for_all_work_orders', ['role' => $role,'notifications' => $notifications, 'wo' => WorkOrder::where('status',  30)->OrderBy('created_at', 'DESC')->get()]);
            }
            else if (auth()->user()->type == "DVC Admin"){
                return view('completed_for_all_work_orders', ['role' => $role,'notifications' => $notifications, 'wo' => WorkOrder::where('status', 30)->OrderBy('created_at', 'DESC')->get()]);
            }



             else

        {// HOS and their work order type

        return view('completed_for_all_work_orders', [
            'role' => $role,
            'notifications' => $notifications,
            'wo' => WorkOrder::where('client_id', auth()->user()->id)->where('status',  30)->OrderBy('created_at', 'DESC')->get()
        ]);



    }//

}


}

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
                'wo' => WorkOrder::whereBetween('created_at', [$from, $to])->where('status', '<>', 30)->OrderBy('created_at', 'DESC')->get()
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
                    'wo' => WorkOrder::where('problem_type', substr(strstr(auth()->user()->type, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->where('status', '<>', 30)->OrderBy('created_at', 'DESC')->get()
                ]);
            }else if (auth()->user()->type == "Maintenance coordinator"){
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::whereBetween('created_at', [$from, $to])->where('status', '<>', 30)->OrderBy('created_at', 'DESC')->get()
                ]);
            }


            else if (auth()->user()->type == "Estates Director"){
                return view('work_orders', ['role' => $role,'notifications' => $notifications, 'wo' => WorkOrder::whereBetween('created_at', [$from, $to])->where('status', '<>', 30)->OrderBy('created_at', 'DESC')->get()]);
            }
            else if (auth()->user()->type == "DVC Admin"){
                return view('work_orders', ['role' => $role,'notifications' => $notifications, 'wo' => WorkOrder::whereBetween('created_at', [$from, $to])->where('status', '<>', 30)->OrderBy('created_at', 'DESC')->get()]);
            }



             else

        {// HOS and their work order type

        return view('work_orders', [
            'role' => $role,
            'notifications' => $notifications,
            'wo' => WorkOrder::where('client_id', auth()->user()->id)->whereBetween('created_at', [$from, $to])->where('status', '<>', 30)->OrderBy('created_at', 'DESC')->get()
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

else if($length==3){


$v1=$type[0];
$v2=$type[1];
$v3=$type[2];




            if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and strpos($v3, "HOS") !== false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and strpos($v3, "HOS") == false){
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', $v2)->orwhere('problem_type', $v3)->whereBetween('created_at', [$from, $to])->OrderBy('created_at', 'DESC')->get()
                ]);
            }

                else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and strpos($v3, "HOS") !== false){
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type',$v1)->orwhere('problem_type', $v2)->orwhere('problem_type', $v3)->whereBetween('created_at', [$from, $to])->OrderBy('created_at', 'DESC')->get()
                ]);
            }

            else  if(strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and strpos($v3, "HOS") == false){
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', $v1)->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->whereBetween('created_at', [$from, $to])->OrderBy('created_at', 'DESC')->get()
                ]);
            }
            else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and strpos($v3, "HOS") == false){
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type',$v1)->orwhere('problem_type', $v2)->orwhere('problem_type', $v3)->whereBetween('created_at', [$from, $to])->OrderBy('created_at', 'DESC')->get()
                ]);
            }
             else  if(strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and strpos($v3, "HOS") !== false){
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', $v1)->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->whereBetween('created_at', [$from, $to])->OrderBy('created_at', 'DESC')->get()
                ]);
            }
             else  if(strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and strpos($v3, "HOS") == false){
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', $v1)->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->whereBetween('created_at', [$from, $to])->OrderBy('created_at', 'DESC')->get()
                ]);
            }
             else  if(strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and strpos($v3, "HOS") !== false){
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', $v1)->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->whereBetween('created_at', [$from, $to])->OrderBy('created_at', 'DESC')->get()
                ]);
            }
             else  if(strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and strpos($v3, "HOS") == false){
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', $v1)->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->whereBetween('created_at', [$from, $to])->OrderBy('created_at', 'DESC')->get()
                ]);
            }

}


else if($length==4){


$v1=$type[0];
$v2=$type[1];
$v3=$type[2];
$v4=$type[3];




            if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

                else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

            else  if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
            else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
             else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
             else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
             else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
            else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
            else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
          else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
           else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
          else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
          else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
         else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }


}



else if($length==5){


$v1=$type[0];
$v2=$type[1];
$v3=$type[2];
$v4=$type[3];
$v5=$type[4];




            if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

               else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

            else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
           else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
            else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
             else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
            else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
             else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
           else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
            else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
          else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
          else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
         else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
         else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
       else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }


}




 }
}



////////// 1234 ///////////////////////////
if(request()->has('year'))  { //date filter


        $from=request('year');




        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        if ($role['user_role']->role_id == 1){
            return view('work_orders', [
                'role' => $role,
                'notifications' => $notifications,
                'wo' => WorkOrder::whereYear('created_at',$from)->where('status', '<>', 30)->OrderBy('created_at', 'DESC')->get()
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
                    'wo' => WorkOrder::where('problem_type', substr(strstr(auth()->user()->type, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->where('status', '<>', 30)->OrderBy('created_at', 'DESC')->get()
                ]);
            }else if (auth()->user()->type == "Maintenance coordinator"){
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::whereYear('created_at',$from)->where('status', '<>', 30)->OrderBy('created_at', 'DESC')->get()
                ]);
            }


            else if (auth()->user()->type == "Estates Director"){
                return view('work_orders', ['role' => $role,'notifications' => $notifications, 'wo' => WorkOrder::whereYear('created_at',$from)->where('status', '<>', 30)->OrderBy('created_at', 'DESC')->get()]);
            }
            else if (auth()->user()->type == "DVC Admin"){
                return view('work_orders', ['role' => $role,'notifications' => $notifications, 'wo' => WorkOrder::whereYear('created_at',$from)->where('status', '<>', 30)->OrderBy('created_at', 'DESC')->get()]);
            }



             else

        {// HOS and their work order type

        return view('work_orders', [
            'role' => $role,
            'notifications' => $notifications,
            'wo' => WorkOrder::where('client_id', auth()->user()->id)->whereYear('created_at',$from)->where('status', '<>', 30)->OrderBy('created_at', 'DESC')->get()
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
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false){
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', $v2)->whereYear('created_at',$from)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

                else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false){
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type',$v1)->orwhere('problem_type', $v2)->whereYear('created_at',$from)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
            else  if(strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false){
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', $v1)->orwhere('problem_type', substr(strstr($v2, " "), 1))->whereYear('created_at',$from)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

}

else if($length==3){


$v1=$type[0];
$v2=$type[1];
$v3=$type[2];




            if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and strpos($v3, "HOS") !== false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and strpos($v3, "HOS") == false){
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', $v2)->orwhere('problem_type', $v3)->whereYear('created_at',$from)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

                else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and strpos($v3, "HOS") !== false){
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type',$v1)->orwhere('problem_type', $v2)->orwhere('problem_type', $v3)->whereYear('created_at',$from)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

            else  if(strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and strpos($v3, "HOS") == false){
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', $v1)->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->whereYear('created_at',$from)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
            else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and strpos($v3, "HOS") == false){
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type',$v1)->orwhere('problem_type', $v2)->orwhere('problem_type', $v3)->whereYear('created_at',$from)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
             else  if(strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and strpos($v3, "HOS") !== false){
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', $v1)->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->whereYear('created_at',$from)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
             else  if(strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and strpos($v3, "HOS") == false){
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', $v1)->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->whereYear('created_at',$from)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
             else  if(strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and strpos($v3, "HOS") !== false){
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', $v1)->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->whereYear('created_at',$from)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
             else  if(strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and strpos($v3, "HOS") == false){
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', $v1)->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->whereYear('created_at',$from)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

}


else if($length==4){


$v1=$type[0];
$v2=$type[1];
$v3=$type[2];
$v4=$type[3];




            if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

                else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

            else  if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
            else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
             else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
             else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
             else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
            else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
            else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
          else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
           else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
          else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
          else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
         else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }


}



else if($length==5){


$v1=$type[0];
$v2=$type[1];
$v3=$type[2];
$v4=$type[3];
$v5=$type[4];




            if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

               else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

            else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
           else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
            else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
             else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
            else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
             else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
           else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
            else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
          else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
          else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
         else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
         else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
       else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->whereYear('created_at',$from)->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }


}




 }
}
////////// --1234-- ///////////////////////////



//lenght
// end start
        else {//dtsrt fdate

     $role = User::where('id', auth()->user()->id)->with('user_role')->first();


        if ($role['user_role']->role_id == 1){
            return view('work_orders', ['role' => $role, 'wo' => WorkOrder::where('status', '<>', 30)->OrderBy('created_at', 'DESC')->GET(),'notifications' => $notifications]);
        }else{


             $type=explode(",",auth()->user()->type);
                $length=count($type);


                   if($length==1){

            if (strpos(auth()->user()->type, "HOS") !== false) {
                return view('work_orders', ['role' => $role, 'notifications' => $notifications,'wo' => WorkOrder::where('problem_type', substr(strstr(auth()->user()->type, " "), 1))->where('status', '<>', 0)->where('status', '<>', 30)->orwhere('client_id', auth()->user()->id, " ")->OrderBy('created_at', 'DESC')->get()]);
            }else if (auth()->user()->type == "Maintenance coordinator"){
                return view('work_orders', ['role' => $role,'notifications' => $notifications, 'wo' => WorkOrder::where('status', '<>', 30)->OrderBy('created_at', 'DESC')->get()]);
            }
            else if (auth()->user()->type == "Estates Director"){
                return view('work_orders', ['role' => $role,'notifications' => $notifications, 'wo' => WorkOrder::where('status', '<>', 30)->OrderBy('created_at', 'DESC')->GET()]);
            }



            else if (auth()->user()->type == "DVC Admin"){
                return view('work_orders', ['role' => $role,'notifications' => $notifications, 'wo' => WorkOrder::where('status', '<>', 30)->OrderBy('created_at', 'DESC')->GET()]);
            }

            else{

        return view('work_orders', ['role' => $role,'notifications' => $notifications, 'wo' => WorkOrder::where('client_id', auth()->user()->id)->where('status', '<>', 30)->OrderBy('created_at', 'DESC')->get()]);
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


else if($length==3){




$v1=$type[0];
$v2=$type[1];
$v3=$type[2];




            if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and strpos($v3, "HOS") !== false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and strpos($v3, "HOS") == false){
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', $v2)->orwhere('problem_type', $v3)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

                else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and strpos($v3, "HOS") !== false){
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type',$v1)->orwhere('problem_type', $v2)->orwhere('problem_type', $v3)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

            else  if(strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and strpos($v3, "HOS") == false){
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', $v1)->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->OrderBy('created_at', 'DESC')->get()
                ]);
            }
            else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and strpos($v3, "HOS") == false){
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type',$v1)->orwhere('problem_type', $v2)->orwhere('problem_type', $v3)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
             else  if(strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and strpos($v3, "HOS") !== false){
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', $v1)->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->OrderBy('created_at', 'DESC')->get()
                ]);
            }
             else  if(strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and strpos($v3, "HOS") == false){
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', $v1)->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->OrderBy('created_at', 'DESC')->get()
                ]);
            }
             else  if(strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and strpos($v3, "HOS") !== false){
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', $v1)->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->OrderBy('created_at', 'DESC')->get()
                ]);
            }
             else  if(strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and strpos($v3, "HOS") == false){
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', $v1)->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->OrderBy('created_at', 'DESC')->get()
                ]);
            }

}


else if($length==4){


$v1=$type[0];
$v2=$type[1];
$v3=$type[2];
$v4=$type[3];




            if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

                else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

            else  if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
            else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
             else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
             else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
             else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
            else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
            else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
          else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
           else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
          else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
          else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
         else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }


}


else if($length==5){


$v1=$type[0];
$v2=$type[1];
$v3=$type[2];
$v4=$type[3];
$v5=$type[4];




            if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

               else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

            else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
           else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
            else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
             else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
            else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
             else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
           else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
            else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
          else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
          else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
         else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
         else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }
       else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {
                return view('work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr($v1, " "), 1))->orwhere('problem_type', substr(strstr($v2, " "), 1))->orwhere('problem_type', substr(strstr($v3, " "), 1))->orwhere('problem_type', substr(strstr($v4, " "), 1))->orwhere('problem_type', substr(strstr($v5, " "), 1))->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get()
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
        $des = Des::where('name','<>',null)->OrderBy('name','ASC')->get();
        $departments = Department::where('directorate_id', 1)->get();

        $desp = desdepartment::all();
        return view('create_user', [
            'directorates' => $directorate,
            'role' => $role,
            'worksec' => workordersection::OrderBy('section_name', 'ASC')->get(),
             'maintsec' => landmaintainancesection::OrderBy('section', 'ASC')->get(),
            'zone' => iowzone::OrderBy('zonename', 'ASC')->get(),
            'departments' => $departments,
            'notifications' => $notifications,
            'des'=> $des,
            'desp'=>$desp
        ]);
    }

    public function storesView()
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
           $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('stores', ['role' => $role, 'items' => Material::where('stock','>=',0)->orderBy('name','ASC')->get(),'notifications' => $notifications]);

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
        $users = User::where('status', '=', 1)->orderBy('fname','ASC')->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();





//        return response()->json($users);
        return view('viewusers', ['display_users' => $users, 'role' => $role,'notifications' => $notifications]);

    }


        public function iowzone()
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();

        $role = User::where('id', auth()->user()->id)->with('user_role')->first();

        $IoW = User::where('id', '<>', auth()->user()->id)->where('status', '=', 1)->where('type', 'inspector of works')->where('IoW', 1)->get();
//        return response()->json($users);
        return view('iowzone', ['role' => $role,'notifications' => $notifications , 'IoW' => $IoW ]);

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
        return redirect()->route('work_order');
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
    //

     $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();

        if(($role['user_role']['role_id'] == 1)||(auth()->user()->type == 'Maintenance coordinator')) {

             return view('technicians', [
            'role' => $role,
            'techs' => Technician::where('status',0)->get(),
            'notifications' => $notifications

        ]);
        } else{

               $type=explode(",",auth()->user()->type);
                $length=count($type);


                   if($length==1){



        return view('technicians', [
            'role' => $role,
            'techs' => Technician::where('status',0)->where('type', substr(strstr(auth()->user()->type, " "), 1))->orderBy('fname','ASC')->get(),
            'notifications' => $notifications

        ]);
        }

        else if($length==2){




    $v1=$type[0];
    $v2=$type[1];




            if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false) {
                return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                     'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orderBy('fname','ASC')->get()

                ]);
            }else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false) {
                return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                     'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orderBy('fname','ASC')->get()

                ]);
                }
                else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false) {
                return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                     'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orderBy('fname','ASC')->get()

                ]);
                 }
            else  if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false) {
                return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                     'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orderBy('fname','ASC')->get()

                ]);

}



    }


    else if($length==3){




$v1=$type[0];
$v2=$type[1];
$v3=$type[2];




            if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and strpos($v3, "HOS") !== false) {
                return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orderBy('fname','ASC')->get()

                ]);
            }else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and strpos($v3, "HOS") == false){
                return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                     'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }

                else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and strpos($v3, "HOS") !== false){
                return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }

            else  if(strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and strpos($v3, "HOS") == false){
                return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }
            else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and strpos($v3, "HOS") == false){
                return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }
             else  if(strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and strpos($v3, "HOS") !== false){
                return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }
             else  if(strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and strpos($v3, "HOS") == false){
                return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }
             else  if(strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and strpos($v3, "HOS") !== false){
                return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }
             else  if(strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and strpos($v3, "HOS") == false){
                return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }

}


else if($length==4){


$v1=$type[0];
$v2=$type[1];
$v3=$type[2];
$v4=$type[3];




            if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false) {
                return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false) {
                return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }

                else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false) {
                return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }

            else  if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false) {
                return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }
            else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false) {
                return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }
             else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false) {
                return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }
             else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false) {
                return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }
             else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false) {
                return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }
             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false) {
                return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }
            else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false) {
                return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }
            else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false) {
                 return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }
          else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false) {
                return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }
           else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false) {
                return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }
          else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false) {
                return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }
          else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false) {
                return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }
         else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false) {
                 return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }




}

          else if($length==5){


$v1=$type[0];
$v2=$type[1];
$v3=$type[2];
$v4=$type[3];
$v5=$type[4];




            if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {
                return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {
               return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }

               else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {
               return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }

            else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {
               return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }
           else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {
                return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }
            else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {
               return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }
             else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {
                return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }
            else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {
               return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }
             else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {
               return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }
           else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {
              return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }
            else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {
               return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }
          else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {
               return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }
          else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {
               return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }
         else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {
               return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }
         else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {
               return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }
       else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {
               return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {
               return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {
               return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {
               return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {
               return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {
               return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {
               return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {
                return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {
               return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {
                return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {
               return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {
               return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {
                return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {
                return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {
                return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {
                return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {
                return view('technicians', [
                    'role' => $role,
                    'notifications' => $notifications,
                   'techs' => Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get()
                ]);
            }


}

   }
   }

//
    public function workOrderNeedMaterialView()
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();

        $iozone =  zoneinspector::where('inspector',auth()->user()->id)->first();
        $iozonename = iowzone::where('id',$iozone['zone'])->first();

        $wo_material=   WorkOrderMaterial::where('zone', $iozone['zone'])->
                       select(DB::raw('work_order_id'),'hos_id' )
                     ->where('status',0)
                     ->orwhere('status', 9)
                     ->groupBy('work_order_id')
                     ->groupBy('hos_id')

                     ->get();

        $mc_material=   WorkOrderMaterial::
                       select(DB::raw('work_order_id'),'hos_id' , 'zone')
                     ->where('status',0)
                     ->orwhere('status', 9)
                     ->groupBy('work_order_id')
                     ->groupBy('hos_id')
                     ->groupBy('zone')
                     ->get();

        return view('womaterialneeded', ['role' => $role, 'items' => $wo_material, 'mcitems' => $mc_material,'notifications' => $notifications]);
    }



     public function workOrderMaterialRejected()
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();

        $iozone =  zoneinspector::where('inspector',auth()->user()->id)->first();
        $iozonename = iowzone::where('id',$iozone['zone'])->first();

        $wo_materialed=   WorkOrderMaterial::where('zone', $iozone['zone'])->
                       select(DB::raw('work_order_id'),'hos_id')
                     ->where('status',-1)
                     ->orwhere('status',17)
                     ->orwhere('status', 44)
                     ->groupBy('work_order_id')
                     ->groupBy('hos_id')
                     ->get();

        $wo_material=   WorkOrderMaterial::
                       select(DB::raw('work_order_id'),'hos_id')
                     ->where('status',-1)
                     ->orwhere('status',17)
                     ->orwhere('status', 44)
                     ->groupBy('work_order_id')
                     ->groupBy('hos_id')
                     ->get();


        return view('rejectedmaterialwith_wo', ['role' => $role, 'materialed' => $wo_materialed,'items' => $wo_material,'notifications' => $notifications]);
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

     public function workOrderMaterialInspectionView($id , $zoneid)
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $iozone =  zoneinspector::where('inspector',auth()->user()->id)->first();

        $wo_material=   WorkOrderMaterial::where('zone', $iozone['zone'])->

                     where('work_order_id',$id)->where('status',0)->orwhere('work_order_id',$id)->where('status',9)
                     ->get();

        $mc_material=   WorkOrderMaterial::
                     where('work_order_id',$id)->where('zone',$zoneid)->where('status',0)->orwhere('work_order_id',$id)->where('zone',$zoneid)->where('status',9)
                     ->get();



        return view('material_inspection_view', ['role' => $role, 'items' => $wo_material, 'mcitems' => $mc_material,'notifications' => $notifications ,  'wo' => WorkOrder::where('id', $id)->first(),]);
    }



         public function workOrderMaterialInspectionViewforinspector($id)
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();

        $iozone =  zoneinspector::where('inspector',auth()->user()->id)->first();

        $wo_material=   WorkOrderMaterial::where('zone', $iozone['zone'])->

                     where('work_order_id',$id)->where('status',0)->orwhere('work_order_id',$id)->where('status',9)
                     ->get();

        return view('material_inspection_view', ['role' => $role, 'items' => $wo_material,'notifications' => $notifications ,  'wo' => WorkOrder::where('id', $id)->first(),]);
    }


        public function workOrderMaterialpurchased($id)
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();

        $wo_material=   WorkOrderMaterial::

                     where('work_order_id',$id)->where('status',15)->orwhere('work_order_id',$id)->where('status',100)
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
                     select(DB::raw('work_order_id'),'hos_id')
                     ->where('status',5)

                     ->groupBy('work_order_id')
                      ->groupBy('hos_id')

                     ->get();

        return view('womaterialtoprocure', ['role' => $role, 'items' => $wo_material,'notifications' => $notifications]);
    }


       public function materialacceptedbyiow()
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();

        $wo_material=   WorkOrderMaterial::
                     select(DB::raw('work_order_id'),'hos_id')
                     ->where('status',1)

                     ->groupBy('work_order_id')
                     ->groupBy('hos_id')

                     ->get();

        return view('womaterialacceptedbyiowtostore', ['role' => $role, 'items' => $wo_material,'notifications' => $notifications]);
    }



           public function material_reserved()
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();

        $wo_material=   WorkOrderMaterial::
                     select(DB::raw('work_order_id'),'hos_id' ,'status')
                     ->where('status',5)->orwhere('status',100)

                     ->groupBy('work_order_id')
                      ->groupBy('hos_id')
                         ->groupBy('status')


                     ->get();

        return view('womaterialreserved', ['role' => $role, 'items' => $wo_material,'notifications' => $notifications]);
    }



          public function material_accepted()
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();

         $iozone =  zoneinspector::where('inspector',auth()->user()->id)->first();
        $iozonename = iowzone::where('id',$iozone['zone'])->first();

        $wo_materiald=   WorkOrderMaterial::where('zone', $iozone['zone'])->
                       select(DB::raw('work_order_id'),'hos_id','accepted_by')
                     ->where('status',1)->orwhere('copyforeaccepted' , 1)

                    ->groupBy('work_order_id')
                    ->groupBy('hos_id')
                    ->groupBy('accepted_by')

                     ->get();

        $wo_material=   WorkOrderMaterial::
                     select(DB::raw('work_order_id'),'hos_id','accepted_by')
                     ->where('status',1)->orwhere('copyforeaccepted' , 1)

                     ->groupBy('work_order_id')
                      ->groupBy('hos_id')
                      ->groupBy('accepted_by')


                     ->get();
               //
        return view('womaterialaccepted', ['role' => $role, 'items' => $wo_material,'notifications' => $notifications,'materls' => $wo_materiald]);
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
        return view('wo_trasport_reject', ['role' => $role, 'items' => WorkOrderTransport::where('status', -1)->whereBetween('updated_at', [$from, $to])->get(),'notifications' => $notifications]);

        }


        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('wo_trasport_reject', ['role' => $role, 'items' => WorkOrderTransport::where('status', -1)->get(),'notifications' => $notifications]);
    }



    public function woMaterialAcceptedView($id)
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
        return view('wo_material_accepted', ['role' => $role, 'items' => WorkOrderMaterial::where('work_order_id',$id)->where('status', 1)->orwhere('work_order_id',$id)->where('copyforeaccepted' , 1)->whereBetween('updated_at', [$from, $to])->get(),'notifications' => $notifications]);

        }



         $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('wo_material_accepted', ['role' => $role, 'items' => WorkOrderMaterial::where('work_order_id',$id)->where('status', 1)->orwhere('work_order_id',$id)->where('copyforeaccepted' , 1)->get(),'notifications' => $notifications]);
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
        return view('unattended_wo', ['role' => $role, 'wo' => WorkOrder::where('status',30)->whereBetween('updated_at', [$from, $to])->get(),'notifications' => $notifications]);

        }



         $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('unattended_wo', ['role' => $role, 'wo' => WorkOrder::where('status',30)-> orderBy(DB::raw('ABS(DATEDIFF(created_at, NOW()))'))->  get(),'notifications' => $notifications]);
   }



    public function roomreportView()
    {

        $wo_room = WorkOrder::
                     select(DB::raw('count(id) as total_room,count(location) as total_location, location,loc_id'))

                     ->groupBy('loc_id')
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
                     ->where('status',30)
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
                     ->where('status',30)
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

                     where('status',5) //status for material to procure

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



     public function wo_material_to_purchaseViewbystore($id)

    {

        $wo_material = WorkOrderMaterial::where('work_order_id',$id)->where('status', 5)->orwhere('work_order_id',$id)->where('status',100)

                     ->get();


        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('womaterialtoprocureviewbystore', ['role' => $role, 'items' => $wo_material,'notifications' => $notifications]);
    }



      public function wo_material_purchasedViewbyheadprocurement($id)

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
    $head = 'All Heads of Sections Details';
        return view('otherreports', ['role' => $role,'head'=>$head,'rle' => $all,'notifications' => $notifications, ]);

   }
   public function alltechnicians(){
    $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
    $role = User::where('id', auth()->user()->id)->with('user_role')->first();

//
//

        if(($role['user_role']['role_id'] == 1)||(auth()->user()->type == 'Maintenance coordinator')) {


                $techs= Technician::where('status',0)->orderby('fname')->get();
        } else{

               $type=explode(",",auth()->user()->type);
                $length=count($type);


                   if($length==1){



                    $techs= Technician::where('status',0)->where('type', substr(strstr(auth()->user()->type, " "), 1))->orderBy('fname','ASC')->get();



        }

        else if($length==2){




    $v1=$type[0];
    $v2=$type[1];




            if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false) {
                $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orderBy('fname','ASC')->get();


            }else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false) {
                $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orderBy('fname','ASC')->get();


                }
                else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false) {
                    $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orderBy('fname','ASC')->get();


                 }
            else  if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false) {
                $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orderBy('fname','ASC')->get();



}



    }


    else if($length==3){




$v1=$type[0];
$v2=$type[1];
$v3=$type[2];




            if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and strpos($v3, "HOS") !== false) {
                $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orderBy('fname','ASC')->get();


            }else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and strpos($v3, "HOS") == false){
                $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orderBy('fname','ASC')->get();

            }

                else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and strpos($v3, "HOS") !== false){
                    $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orderBy('fname','ASC')->get();

            }

            else  if(strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and strpos($v3, "HOS") == false){
                $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orderBy('fname','ASC')->get();

            }
            else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and strpos($v3, "HOS") == false){
                $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orderBy('fname','ASC')->get();

            }
             else  if(strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and strpos($v3, "HOS") !== false){
                $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orderBy('fname','ASC')->get();

            }
             else  if(strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and strpos($v3, "HOS") == false){
                $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orderBy('fname','ASC')->get();

            }
             else  if(strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and strpos($v3, "HOS") !== false){
                $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orderBy('fname','ASC')->get();

            }
             else  if(strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and strpos($v3, "HOS") == false){
                $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orderBy('fname','ASC')->get();

            }

}


else if($length==4){


$v1=$type[0];
$v2=$type[1];
$v3=$type[2];
$v4=$type[3];




            if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false) {
                $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get();

            }else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false) {
                $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get();

            }

                else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false) {
                    $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get();

            }

            else  if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false) {
                $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get();

            }
            else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false) {

                $techs = Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get();

            }
             else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false) {

                $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get();

            }
             else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false) {

                $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get();

            }
             else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false) {

                $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get();

            }
             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false) {

                $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get();

            }
            else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false) {

                $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get();

            }
            else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false) {

                $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get();

            }
          else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false) {

            $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get();

            }
           else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false) {

            $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get();

            }
          else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false) {

            $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get();

            }
          else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false) {

            $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get();

            }
         else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false) {

                    $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orderBy('fname','ASC')->get();

            }




}

          else if($length==5){


$v1=$type[0];
$v2=$type[1];
$v3=$type[2];
$v4=$type[3];
$v5=$type[4];




            if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {

                $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

            }else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {

                $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

            }

               else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {

                    $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

            }

            else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {

                $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

            }
           else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {

            $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

            }
            else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {

                $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

            }
             else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {

                    $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

            }
            else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {

                $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

            }
             else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {

                    $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

            }
           else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {

                    $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

            }
            else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {

                $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

            }
          else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {

            $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

            }
          else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {

                    $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

            }
         else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {

                    $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

            }
         else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {

                    $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

            }
       else if (strpos($v1, "HOS") !== false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {

                    $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {

                    $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {

                $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {

                $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {

                    $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {

                $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {

                $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {

                $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") !== false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {

                    $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {

                $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {

                $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {

                $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") !== false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {

                $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") !== false ) {

                    $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") !== false and  strpos($v5, "HOS") == false ) {

                    $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") !== false ) {

                    $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

            }

             else if (strpos($v1, "HOS") == false and strpos($v2, "HOS") == false and  strpos($v3, "HOS") == false and strpos($v4, "HOS") == false and  strpos($v5, "HOS") == false ) {

                   $techs= Technician::where('status',0)->where('type', substr(strstr($v1, " "), 1))->orwhere('type', substr(strstr($v2, " "), 1))->orwhere('type', substr(strstr($v3, " "), 1))->orwhere('type', substr(strstr($v4, " "), 1))->orwhere('type', substr(strstr($v5, " "), 1))->orderBy('fname','ASC')->get();

            }


}

   }



//
//



    $head = 'All Technicians Details';
        return view('technicians', ['role' => $role,'head'=>$head,'techs' => $techs,'notifications' => $notifications, ]);
   }

   public function alliow(){
    $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
    $all = User::where('type','like','%Inspector%')->get();
    $role = User::where('id', auth()->user()->id)->with('user_role')->first();
    $head = 'All Inspectors of Works Details';
        return view('otherreports', ['role' => $role,'head'=>$head,'rle' => $all,'notifications' => $notifications, ]);
   }

   public function anonymousroomreport()
    {

        $wo_room = WorkOrder::
                     select(DB::raw('count(id) as total_room,area_id'))

                     ->groupBy('area_id')
                     ->where('loc_id',$_GET['room'])
                     ->get();





         $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('anonymousroom', ['role' => $role, 'wo' =>$wo_room,'notifications' => $notifications]);
   }
   public function anonymousroomreportextended()
    {

        $wo_room = WorkOrder::
                     select(DB::raw('count(id) as total_room,block_id'))

                     ->groupBy('block_id')
                     ->where('area_id',$_GET['room'])
                     ->get();





         $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('anonymousroomextended', ['role' => $role, 'wo' =>$wo_room,'notifications' => $notifications]);
   }
    public function inroomreportextendedwithrooms()
    {

        $wo_room = WorkOrder::
                     select(DB::raw('count(id) as total_room,room_id'))

                     ->groupBy('room_id')
                     ->where('block_id',$_GET['room'])
                     ->get();





         $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('foundrooms', ['role' => $role, 'wo' =>$wo_room,'notifications' => $notifications]);
   }
   public function knownroomreport()
    {

        $wo_room = WorkOrder::where('location',$_GET['workorders'])->OrWhere('room_id',$_GET['workorders'])->get();





         $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('knownroom', ['role' => $role, 'wo' =>$wo_room,'notifications' => $notifications]);
   }

   public function downloads()
   {
    $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
    $role = User::where('id', auth()->user()->id)->with('user_role')->first();
    $data = download::get();
    return view('download', ['role' => $role,'notifications' => $notifications,'data'=>$data]);
   }

   public function newdownloads()
   {
    $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
    $role = User::where('id', auth()->user()->id)->with('user_role')->first();
    return view('downloadsnew', ['role' => $role,'notifications' => $notifications]);
   }

   public function savedownloads(Request $request)
   {
    $request->validate([
        "file" => "required|mimes:pdf",
        'name' => 'required',

    ]);


    $path = public_path('download/'.date('Y.m.d.H.i.s'));

      if(!File::isDirectory($path))
      {
        File::makeDirectory($path,$mode = 0777, true, true);
      }

      if($file = $request->file('file'))
      {
          $filename = time().'-'.$request['name'].'.'.$file->getClientOriginalExtension();
          $targetpath = $path;

          if($file->move($targetpath, $filename))
          {
            $data = new download();
            $data->name = $request['name'];
            $data->document = $filename;

            $data->date = date('Y.m.d.H.i.s');
            $data->uploadedBy = auth()->user()->id;
            $data->save();

            return redirect()->route('downloads')->with(['message'=>'document uploaded succesfully!']);
          }
      }else{
          return redirect()->back()->withErrors(['message'=>'Oops, something is wrong. try again!']);
      }




   }

   public function viewdownloads($id)
   {
       $data = download::where('id',$id)->first();
       $path = public_path('download/'.$data['date'].'/'.$data['document']);

        return response()->file($path);
   }

   public function deletedownload($id)
   {
    download::find($id)->delete();
    return redirect()->back()->with(['message'=>'Document deleted successfully!']);
   }

   public function editdownloads($id)
   {
    $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
    $role = User::where('id', auth()->user()->id)->with('user_role')->first();
    $data = download::where('id',$id)->first();
    return view('downloadsedit', ['role' => $role,'notifications' => $notifications,'data'=>$data]);

   }

   public function saveheaddownloads(Request $request)
   {
    $data = download::where('id',$request['id'])->first();
    $data->name = $request['name'];
    $data->save();

    return redirect()->route('downloads')->with(['message'=>'document heading updated succesfully!']);

   }

   public function savefiledownloads(Request $request)
   {

    $request->validate([
        "file" => "required|mimes:pdf",
    ]);

    $data = download::where('id',$request['id'])->first();

    $path = public_path('download/'.date('s.i.H.d.m.Y'));

      if(!File::isDirectory($path))
      {
        File::makeDirectory($path,$mode = 0777, true, true);
      }

      if($file = $request->file('file'))
      {
          $filename = time().'-'.$data['name'].'.'.$file->getClientOriginalExtension();
          $targetpath = $path;

          if($file->move($targetpath, $filename))
          {


            $data->document = $filename;

            $data->date = date('s.i.H.d.m.Y');
            $data->uploadedBy = auth()->user()->id;
            $data->save();

            return redirect()->route('downloads')->with(['message'=>'document updated succesfully!']);
          }
      }else{
          return redirect()->back()->withErrors(['message'=>'Oops, something is wrong. try again!']);
      }

   }

   public function filterhos(){
        if(isset($_GET['year'])&&isset($_GET['month'])){
        if(($_GET['year']!='')&&($_GET['month']!='')){
            $wo_hos_count = WorkOrder::
            select(DB::raw('count(id) as total_wo,staff_id as staff_id'))
                ->where('status',30)
                ->whereYear('created_at', $_GET['year'])
                ->whereMonth('created_at', $_GET['month'])
                ->groupBy('staff_id')

                ->get();

            $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
            $role = User::where('id', auth()->user()->id)->with('user_role')->first();
            return view('hoscount', ['role' => $role, 'wo' => $wo_hos_count,'notifications' => $notifications]);
        }
        else if(($_GET['year']!='')&&($_GET['month']==''))
        {
            $wo_hos_count = WorkOrder::
            select(DB::raw('count(id) as total_wo,staff_id as staff_id'))
                ->where('status',30)
                ->whereYear('created_at', $_GET['year'])
                ->groupBy('staff_id')

                ->get();

            $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
            $role = User::where('id', auth()->user()->id)->with('user_role')->first();
            return view('hoscount', ['role' => $role, 'wo' => $wo_hos_count,'notifications' => $notifications]);
        }
        else{
            return redirect()->route('hoscount');
        }
        }
        else{
            return redirect()->route('hoscount');
        }

   }

}

