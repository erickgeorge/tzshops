<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\session;
use App\Mail\MailNotify;
use App\Notification;
use App\landworkorders;
use App\User;
use App\WorkOrderProgress;
use App\WorkOrderStaff;
use App\Technician;

use Illuminate\Http\Request;
use App\WorkOrder;

use Illuminate\Support\Facades\Mail;


class LandscapingController extends Controller
{
    public function createlandwork(Request $request )
    {
        $request->validate([
            'details' => 'required',
        ]);


        if ($request['p_type'] == 'Choose...') {
            return redirect()->back()->withErrors(['message' => 'Problem Type required ']);
        }

        if ($request['location'] == 'Choose...') {
            return redirect()->back()->withErrors(['message' => 'Location required required ']);
        }
        $work_order = new landworkorders();


        if ($request['checkdiv'] == 'yesmanual') {

            $work_order->location = $request['manual'];

        } else {

            $work_order->room_id = $request['room'];
            $work_order->block_id = $request['block'];
            $work_order->area_id = $request['area'];
            $work_order->loc_id = $request['location'];

        }
        
        $work_order->status = 1;
        $work_order->client_id = auth()->user()->id;
        $work_order->maintenance_section = $request['p_type'];
        $work_order->details = $request['details'];

        $work_order->save();

        return redirect()->back()->with(['message' => 'Works order for ladscaping is successfully created']);
    }




       public function createlandwo()
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('createlandworkorder', ['role' => $role,'notifications' => $notifications]);
    }

   

      public function landworkorderview()
    {
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
        
     

            return view('land_work_orders', [
                'role' => $role,
                'notifications' => $notifications,
                'wo' => landworkorders::whereBetween('created_at', [$from, $to])->OrderBy('created_at', 'DESC')->get()
            ]);
        
           }

            else
            
        {// HOS and their work order type 

        return view('land_work_orders', [
            'role' => $role,
            'notifications' => $notifications,
            'wo' => landworkorders::OrderBy('created_at', 'DESC')->get()
        ]);
   
        
        
    }//




}

      public function trackwoland($id)
    {
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        return view('track_work_order_landscaping', [
            'role' => $role,
            'notifications' => $notifications,
            'wo' => landworkorders::where('id', $id)->first()
        ]);
    }
  


      public function viewwolandsc($id)
    {
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
//        return response()->json(WorkOrder::where('id', $id)->first());
        return view('view_work_order_for_land', [
            'role' => $role,
            'notifications' => $notifications,
            'wo' => landworkorders::where('id', $id)->first()
        ]);
    }




    public function acceptwoforlandsc($id)
    {

        $wO = landworkorders::where('id', $id)->first();
        $wO->staff_id = auth()->user()->id;
        $wO->status = 1;
        $wO->save();



        $notify = new Notification();
        $notify->sender_id = auth()->user()->id;
        $notify->receiver_id = $wO->client_id;
        $notify->type = 'wo_accepted';
        $notify->status = 0;
        $notify->message = 'Your work order for Landscaping of ' . $wO->created_at . ' about ' . $wO->maintenance_section . ' has been accepted.';
        $notify->save();




        $work = landworkorders::where('id', $id)->first();
        $cfirstname= $work['user']->fname;
        $clastname=$work['user']->lname;
        $cmobile=$work['user']->phone;
 
        $msg='Dear  '. $cfirstname.'  '.$clastname.'. Your landscaping work order No: WO-'.$wO->id.' sent to Estate Directorate on  ' . $wO->created_at . ' of  maintenance section :' . $wO->maintenance_section . '  about '.$wO->details.' has been ACCEPTED .              Thanks   Directorate of Estates.';


        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
        $emailReceiver = User::where('id', $wO->client_id)->first();

        $toEmail = $emailReceiver->email;
        $fuserName=$emailReceiver->fname;
        $luserName=$emailReceiver->lname;
        $userName=$fuserName.' '.$luserName;

        $senderf=auth()->user()->fname;
        $senderl=auth()->user()->lname;
        $sender=$senderf.' '.$senderl;
        $section=auth()->user()->type;


    

        $data = array('name'=>$userName, "body" => "Your Landscaping Work-Order No : $wO->id sent to Directorate of Estates on : $wO->created_at, of  maintenance section : $wO->maintenance_section has been ACCEPTED.Please login in the system for further information .",

                    "footer"=>"Thanks", "footer1"=>" $sender , $section " , "footer2"=>"Directorate  of Estates"
                );
    
       Mail::send('email', $data, function($message) use ($toEmail,$sender,$userName) {
       
       $message->to($toEmail,$userName)
            ->subject('LANDSCAPING WORK ORDER ACCEPTANCE.');
       $message->from('udsmestates@gmail.com',$sender);
       });
        
    

        return redirect()->route('workOrder.edit.view', [$wO->id])->with([
            'role' => $role,
            'notifications' => $notifications,
            'techs' => User::where('type', 'TECHNICIAN')->get(),
            'message' => 'Landscaping work order accepted . You can now edit it!',
            'wo' => landworkorders::where('id', $id)->first()
        ]);
    }


      public function editwolandscaping($id)
    {
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
//        return response()->json(WorkOrder::where('id', $id)->first());


        $staff=WorkOrderStaff::where('work_order_id', $id)->get();
        
        
        return view('edit_work_order_landscaping', [
            'techs' => Technician::where('type', substr(strstr(auth()->user()->type, " "), 1))->get(),
            'notifications' => $notifications,
            'staff' => $staff,
            'role' => $role, 'wo' => landworkorders::where('id', $id)->first()
        ]);
    }


}
