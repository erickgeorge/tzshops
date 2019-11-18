<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\session;
use App\Mail\MailNotify;
use App\Notification;
use App\Technician;
use App\User;
use App\WorkOrderInspectionForm;
use App\WorkOrderStaff;
use App\WorkOrderTransport;
use App\WorkOrderProgress;
use App\WorkOrderMaterial;
use Illuminate\Http\Request;
use App\WorkOrder;
use App\PurchasingOrder;
use App\Material;
use Illuminate\Support\Facades\Mail;


class WorkOrderController extends Controller
{
    public function create(Request $request)
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
        $work_order = new WorkOrder();


        if ($request['checkdiv'] == 'yesmanual') {

            $work_order->location = $request['manual'];

        } else {

            $work_order->room_id = $request['room'];

        }


        $work_order->client_id = auth()->user()->id;
        $work_order->problem_type = $request['p_type'];
        $work_order->details = $request['details'];
        $work_order->save();

        return redirect()->route('work_order')->with(['message' => 'Work order successfully created']);
    }

    public function rejectWO(Request $request, $id)
    {
        $wO = WorkOrder::where('id', $id)->first();
        $wO->staff_id = auth()->user()->id;
        $wO->status = 0;
        $wO->reason = $request['reason'];
        $wO->save();

        $progress = new WorkOrderProgress();
        $progress->work_order_id = $id;
        $progress->status = "rejected";
        $progress->updated_by = auth()->user()->id;
        $progress->save();

        $notify = new Notification();
        $notify->sender_id = auth()->user()->id;
        $notify->receiver_id = $wO->client_id;
        $notify->type = 'wo_rejected';
        $notify->message = 'Your work order of ' . $wO->created_at . ' about ' . $wO->problem_type . ' has been rejected.';
        $notify->save();





  $work = WorkOrder::where('id', $id)->first();
  $cfirstname= $work['user']->fname;
  $clastname=$work['user']->lname;
  $cmobile=$work['user']->phone;
 
	$msg='Dear  '. $cfirstname.'  '.$clastname.'. Your work order No WO-'.$wO->id.' sent to Estate Directorate on  ' . $wO->created_at . ' of  Problem Type :' . $wO->problem_type . '  about '.$wO->details.' has been REJECTED .  Thanks   Directorate of Estates.';

         $basic  = new \Nexmo\Client\Credentials\Basic('6a962480', 'vTb5bfCxCPaGP9sU');
$client = new \Nexmo\Client($basic);

$message = $client->message()->send([
    'to' => '255745909129',
    'from' => 'ESTATE STAFF',
    'text' => $msg
]);

session::flash('message', ' Your workorder have been rejected successfully ');



//        return response()->json('success');
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


        /*
        Mail::to($toEmail)->send(new MailNotify(auth()->user()));

        $email_status = '';
        if (Mail::failures()) {
            $email_status = 'but Failed to send email';
        } else {
            $email_status = 'and Email sent successfully';
      }

 */ 


     $data = array('name'=>$userName, "body" => "Your Work-Order No : WO-$wO->id sent to Directorate of Estates on : $wO->created_at, of  Problem Type : $wO->problem_type has been REJECTED.Please login in the system for further information .",

                    "footer"=>"Thanks","footer1"=>"Directorate  of Estates"
                );
    
       Mail::send('email', $data, function($message) use ($toEmail,$sender,$userName) {
       
       $message->to($toEmail,$userName)
            ->subject('WORK ORDER ACCEPTANCE.');
       $message->from('udsmestates@gmail.com',$sender);
       });

        return redirect()->route('work_order')->with([
            'role' => $role,
            'notifications' => $notifications,
            'message' => 'Work order has been rejected ' ,
            'wo' => WorkOrder::where('problem_type', substr(strstr(auth()->user()->type, " "), 1))->where('status', '<>', 0)->get()]);
    }





    public function acceptWO($id)
    {
//        return response()->json($id);
        $wO = WorkOrder::where('id', $id)->first();
        $wO->staff_id = auth()->user()->id;
        $wO->status = 1;
        $wO->save();

        $progress = new WorkOrderProgress();
        $progress->work_order_id = $id;
        $progress->status = "accepted";
        $progress->updated_by = auth()->user()->id;
        $progress->save();

        $notify = new Notification();
        $notify->sender_id = auth()->user()->id;
        $notify->receiver_id = $wO->client_id;
        $notify->type = 'wo_accepted';
        $notify->status = 0;
        $notify->message = 'Your work order of ' . $wO->created_at . ' about ' . $wO->problem_type . ' has been accepted.';
        $notify->save();



 $work = WorkOrder::where('id', $id)->first();
  $cfirstname= $work['user']->fname;
  $clastname=$work['user']->lname;
  $cmobile=$work['user']->phone;
 
	$msg='Dear  '. $cfirstname.'  '.$clastname.'. Your work order No: WO-'.$wO->id.' sent to Estate Directorate on  ' . $wO->created_at . ' of  Problem Type :' . $wO->problem_type . '  about '.$wO->details.' has been ACCEPTED .				 Thanks   Directorate of Estates.';

/*
         $basic  = new \Nexmo\Client\Credentials\Basic('6a962480', 'vTb5bfCxCPaGP9sU');      
$client = new \Nexmo\Client($basic);

$message = $client->message()->send([
    'to' => '255745909129',
    'from' => 'ESTATE STAFF',
    'text' => $msg
]);
session::flash('message', ' Your workorder have been accepted successfully ');


*/





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


        /*
        Mail::to($toEmail)->send(new MailNotify(auth()->user()));

        $email_status = '';
        if (Mail::failures()) {
            $email_status = 'but Failed to send email';
        } else {
            $email_status = 'and Email sent successfully';
      }

 */ 

//for email that currently working disabled partially

/*
     $data = array('name'=>$userName, "body" => "Your Work-Order No : Wo-$wo->id sent to Directorate of Estates on : $wo->created_at, of  Problem Type : $wo->problem_type has been ACCEPTED.Please login in the system for further information .",

                    "footer"=>"Thanks","footer1"=>"Directorate  of Estates"
                );
    
       Mail::send('email', $data, function($message) use ($toEmail,$sender,$userName) {
       
       $message->to($toEmail,$userName)
            ->subject('WORK ORDER ACCEPTANCE.');
       $message->from('udsmestates@gmail.com',$sender);
       });
		
        */
		
		
		
		


        return redirect()->route('workOrder.edit.view', [$wO->id])->with([
            'role' => $role,
            'notifications' => $notifications,
            'techs' => User::where('type', 'TECHNICIAN')->get(),
            'message' => 'Work order accepted . You can now edit it!',
            'wo' => WorkOrder::where('id', $id)->first()
        ]);
    }

    public function editWOView($id)
    {
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
//        return response()->json(WorkOrder::where('id', $id)->first());


		$staff=WorkOrderStaff::where('work_order_id', $id)->get();
		
		
        return view('edit_work_order', [
            'techs' => Technician::where('type', substr(strstr(auth()->user()->type, " "), 1))->get(),
            'notifications' => $notifications,
			'staff' => $staff,
            'role' => $role, 'wo' => WorkOrder::where('id', $id)->first()
        ]);
    }

    public function viewWO($id)
    {
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
//        return response()->json(WorkOrder::where('id', $id)->first());
        return view('view_work_order', [
            'role' => $role,
            'notifications' => $notifications,
            'wo' => WorkOrder::where('id', $id)->first()
        ]);
    }

    public function editWO(Request $request, $id)
    {
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $wo = WorkOrder::where('id', $id)->first();
        if (isset($request['emergency'])) {
            $wo->emergency = 1;
        } else {
            $wo->emergency = 0;
        }
        if (isset($request['labour'])) {
            $wo->needs_laboured = 1;
        } else {
            $wo->needs_laboured = 0;
        }
        if (isset($request['contractor'])) {
            $wo->needs_contractor = 1;
        } else {
            $wo->needs_contractor = 0;
        }
        $wo->save();
        return redirect()->route('workOrder.edit.view', [$id])->with([
            'role' => $role,
            'notifications' => $notifications,
            'message' => 'changes saved successfully',
            'wo' => WorkOrder::where('id', $id)->first()
        ]);
    }

    public function fillInspectionForm(Request $request, $id)
    {

        if ($request['technician'] == 'Choose...') {
            return redirect()->back()->withErrors(['message' => 'Technician required']);
        }


		 if ($request['status'] == 'Choose...') {
            return redirect()->back()->withErrors(['message' => 'Status of Inspection form required required']);
        }
		
		else if ($request['status'] == 'Report Before Work') {
           $statusfield=5;
        }
		else  { 
			 $statusfield=6;
		}
		

        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $mForm = WorkOrder::where('id', $id)->first();
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
   
             $mForm->status = $statusfield;
			
             $mForm->save();
 
            $form = new WorkOrderInspectionForm();
            $form->status = $request['status'];
			$form->date_inspected = $request['inspectiondate'];
			
			 $form->description = $request['details'];
            $form->technician_id = $request['technician'];
            $form->work_order_id = $id;
            $form->save();
        

        return redirect()->route('workOrder.edit.view', [$id])->with([
            'role' => $role,
            'notifications' => $notifications,
            'message' => 'Inspection from successfully updated',
            'wo' => WorkOrder::where('id', $id)->first()
        ]);
    }
	
	
	
public function transportforwork(Request $request, $id)
    {

      

        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $transport = new WorkOrderTransport();
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        
            $transport->time = $request['date'].' '.$request['time'];
            $transport->status = 0;
            $transport->coments = $request['coments'];
            $transport->work_order_id = $id;
             $transport->requestor_id = auth()->user()->id;
            
            $transport->save();
       
         $mForm = WorkOrder::where('id', $id)->first();
             $mForm->status =4;
            
             $mForm->save();
       

        return redirect()->route('workOrder.edit.view', [$id])->with([
            'role' => $role,
            'notifications' => $notifications,
            'message' => 'Request for Transport sent successfully',
            'wo' => WorkOrder::where('id', $id)->first()
        ]);
    }
	
	
	
    public function assigntechnicianforwork(Request $request, $id)
    {

        if ($request['technician_work'] == 'Choose...') {
            return redirect()->back()->withErrors(['message' => 'Technician for work order is required']);
        }
		
		$checkstaff = WorkOrderStaff::where('staff_id', $request['technician_work'])->where('work_order_id', $id)->first();
		
		
		if (empty($checkstaff)) {
           
        
		
		

        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $work_order_staff = new  WorkOrderStaff();
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        
            $work_order_staff->staff_id = $request['technician_work'];
			 $work_order_staff->status =0;
             $work_order_staff->work_order_id = $id;
            $work_order_staff->save();
			
			
			$mForm = WorkOrder::where('id', $id)->first();
             $mForm->status =3;
			
             $mForm->save();
       
        
        return redirect()->route('workOrder.edit.view', [$id])->with([
            'role' => $role,
            'notifications' => $notifications,
            'message' => 'Technician assigned successfully',
            'wo' => WorkOrder::where('id', $id)->first()
        ]);
    
	
		}  else { return redirect()->back()->withErrors(['message' => 'Technician Selected has already been assigned for this  work order,You can not assign him repeatedly']);}
	}
	
	
	
	
	public function materialaddforwork(Request $request,$id)
    {
		$y=1;
		$totmat=$request['totalmaterials']/2;
		
		/*
		for ($x = 1; $x <= $totmat; $x++) {
   
   $materialreq=Material::where('id',$request[$y])->first();
	$limit=$materialreq->stock;
	$mname=$materialreq->name;
	$mdesc=$materialreq->description;
	
	$y=$y+1;
        if ($request[$y] > $limit) {
			
			
            return redirect()->back()->withErrors(['message' => 'MATERIAL LIMIT EXCEEDED IN STOCK '.$mname.' ,   '.$mdesc.'   ,MAXIMUM LIMIT : '.$limit]);
        }
		$y=$y+1;
   
		} 
		
		
	*/

        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        
			$z=1;
			for ($x = 1; $x <= $totmat; $x++) {
				
			$work_order_material = new  WorkOrderMaterial();
            $work_order_material->work_order_id = $id;
            $work_order_material->material_id = $request[$z];
			$z=$z+1;
			$work_order_material->quantity = $request[$z];
			$z=$z+1;
			$work_order_material->status = 20; //status for HOS to view material before sent to IoW
			$work_order_material->hos_id = auth()->user()->id;
            $work_order_material->staff_id = auth()->user()->id;
            $work_order_material->save();
} 
			
			
			
		
       
		
		
        return redirect()->route('workOrder.edit.view', [$id])->with([
            'role' => $role,
            'notifications' => $notifications,
          'message' => 'Material request for Work order is submitted, Please crosscheck the list if successfully then send again to Store Manager. ',

            'wo' => WorkOrder::where('id', $id)->first()
        ]);
    }
	
	
        Public function editmaterialforwork(request $request, $id){
            
           $mat = material::find($id);
           $mat->quantity = $request['quantity'];
           $mat->status = 0 ;
           $mat->save();
  
        return redirect()->route('register.house')->with(['message' => 'Material Sent again successfully']);

        }   

  
            public function editmaterial(Request $request, $id )
    {
       $p=$request['edit_mat'];
       $matir = WorkOrderMaterial::where('id',$p)->first();
       $matir->material_id = $request['material'];
       $matir->quantity = $request['quantity'];
       $matir->status = 23; //status for material where HoS will send material again to store
       $matir->save();
  
        return redirect()->bacK()->with(['message' => 'Respective material edited successifully, Please edit all materials and send back to Inspector of work']);
    }




           public function editmaterialhos(Request $request, $id )
    {
       $p=$request['edit_mat'];
       $matir = WorkOrderMaterial::where('id',$p)->first();
       $matir->material_id = $request['material'];
       $matir->quantity = $request['quantity'];
       $matir->status = 20;
       $matir->save();
  
        return redirect()->bacK()->with(['message' => 'Respective material edited successfully']);
    }
  

	public function purchasingorder(Request $request,$id)
    {
		$y=1;
		$totmat=$request['totalmaterials']/2;
	
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        
			$z=1;
			for ($x = 1; $x <= $totmat; $x++) {
				
			$purchasing_order = new  PurchasingOrder();
            $purchasing_order->work_order_id = $id;
             $purchasing_order->material_list_id = $request[$z];
			 $z=$z+1;
			 $purchasing_order->quantity = $request[$z];
			 $z=$z+1;
			 $purchasing_order->status = 0;
			 
            $purchasing_order->save();
} 
			
			
			
			
        //status field of work order
			$mForm = WorkOrder::where('id', $id)->first();
             $mForm->status =8;
			
             $mForm->save();
       
		
		
        return redirect()->route('workOrder.edit.view', [$id])->with([
            'role' => $role,
            'notifications' => $notifications,
            'message' => 'Purchasing Order is create Successfully',
            'wo' => WorkOrder::where('id', $id)->first()
        ]);
    }
	
	
    public function deletedWOView()
    {
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();

        if ($role['user_role']['role_id'] == 1) {
            return view('deleted_work_orders', [
                'role' => $role,
                'notifications' => $notifications,
                'wo' => WorkOrder::where('status', 0)->get()
            ]);
        } else
            if (strpos(auth()->user()->type, "HOS") !== false) {
                return view('deleted_work_orders', [
                    'role' => $role,
                    'notifications' => $notifications,
                    'wo' => WorkOrder::where('problem_type', substr(strstr(auth()->user()->type, " "), 1))->where('status', 0)->get()
                ]);
            }
        return view('deleted_work_orders', [
            'role' => $role,
            'notifications' => $notifications,
            'wo' => WorkOrder::where('client_id', auth()->user()->id)->where('status', 0)->get()
        ]);
    } 



       public function rejectedmaterialview($id)
    {
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();

        if ($role['user_role']['role_id'] == 1) {
            return view('rejected_materials_view', [
                'role' => $role,
                'notifications' => $notifications,
                   'wo' => WorkOrder::where('id', $id)->first(),
                'items' =>WorkOrderMaterial::
                    
                     where('work_order_id',$id)->where('status',-1)
                     
            
                     ->get()
            ]);
        } else
           
        return view('rejected_materials_view', [
            'role' => $role,
            'wo' => WorkOrder::where('id', $id)->first(),
            'notifications' => $notifications,
            'items' => WorkOrderMaterial::where('staff_id', auth()->user()->id)->where('status', -1)->get()
        ]);
    }




     public function receivedmaterialview($id)
    {
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();

        if ($role['user_role']['role_id'] == 1) {
            return view('received_materials_view', [
                'role' => $role,
                'notifications' => $notifications,
                'items' => WorkOrderMaterial::where('work_order_id',$id)->where('status', 3)->get()
            ]);
        } elseif(auth()->user()->type == 'STORE'){

             return view('received_materials_view', [
                'role' => $role,
                'notifications' => $notifications,
                'items' => WorkOrderMaterial::where('work_order_id',$id)->where('status', 3)->get()
            ]);


        }
           
        return view('received_materials_view', [
            'role' => $role,
            'notifications' => $notifications,
            'items' => WorkOrderMaterial::where('staff_id', auth()->user()->id)->where('status', 3)->get()
        ]);
    }




                public function tickmaterial($id)
    {
         $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
    
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $wo_materials =WorkOrderMaterial::where('work_order_id', $id)->where('status',3)->get();

         foreach($wo_materials as $wo_material) {
        $wo_m =WorkOrderMaterial::where('id', $wo_material->id)->first();    
         $wo_m->status = 3; //status for material ticked after placing sign for both sides
         $wo_m->secondstatus = 1;
          $wo_m->save();
         }

       

       $mForm = WorkOrder::where('id', $id)->first();
       $mForm->status = 40;  //status for Hos approval for receiving material
       $mForm->save();

       
         return redirect()->back()->with(['message' => 'Material Approved and  Received Successfully From Store']);

        
}






     public function redirectToSecretary($id)
    {
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $wo = WorkOrder::where('id', $id)->first();
        $wo->problem_type = 'Others';
        $wo->save();
        return redirect()->route('work_order')->with([
            'role' => $role,
            'notifications' => $notifications,
            'message' => 'Work order successfully sent to Maintenance coordinator',
            'wo' => WorkOrder::where('problem_type', substr(strstr(auth()->user()->type, " "), 1))->where('status', '<>', 0)->get()
        ]);
    }


    public function redirectToHoS(request $request, $id)
    {
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $wo = WorkOrder::where('id', $id)->first();
        $wo->problem_type = $request['p_type'];
        $wo->save(); 
        return redirect()->back()->with([
           
            'message' => 'Work order successfully sent to Respective Head of Section'
        ]);
    }



    public function trackWO($id)
    {
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
//        return response()->json(WorkOrderProgress::with('user')->with('work_order.room.block')->where('work_order_id', $id)->first());
        return view('track_work_order', [
            'role' => $role,
            'notifications' => $notifications,
            'wo' => WorkOrder::where('id', $id)->with('work_order_inspection')->first()
        ]);
    }

    public function closeWorkOrder($id, $receiver_id)
    {
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();

        $wo = WorkOrder::find($id);
        $wo->status = 2; //tempolary closed
        $wo->save();

        $notify = new Notification();
        $notify->sender_id = auth()->user()->id;
        $notify->receiver_id = $receiver_id;
        $notify->type = 'wo_closed';
        $notify->message = 'Your work order of ' . $wo->created_at . ' about ' . $wo->problem_type . ' has been closed!.';
        $notify->save();

    
    
    
    
    $work = WorkOrder::where('id', $id)->first();
  $cfirstname= $work['user']->fname;
  $clastname=$work['user']->lname;
  $cmobile=$work['user']->phone;
 
    $msg='Dear  '. $cfirstname.'  '.$clastname.' Your work order No '.$wo->id.' sent to Estate Directorate on  ' . $wo->created_at . ' of  Problem Type' . $wo->problem_type . 'about '.$wo->details.' has been Closed. 
 Please Visit the system for more informations. Thanks   
    
    Directorate of Estates.';
    
    
    
    

      /*   $basic  = new \Nexmo\Client\Credentials\Basic('8f1c6b0f', 'NQSwu3iPSjgw275c');
$client = new \Nexmo\Client($basic);

$message = $client->message()->send([
    'to' => '255762391602',
    'from' => 'ESTATE STAFF',
    'text' => ' Your workorder have been closed successfully'
]);

session::flash('message', ' Your workorder have been closed successfully');


*/

        return redirect()->route('workOrder.track', [$id])->with([
            'role' => $role,
            'notifications' => $notifications,
            'message' => 'Work order is tempolarally closed successfully',
            'wo' => WorkOrder::where('id', $id)->with('work_order_progress')->first()
        ]);
    }
	
    public function closeWorkOrdercomplete($id, $receiver_id)
    {
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();

        $wo = WorkOrder::find($id);
        $wo->status = 30; // complete closed
        $wo->save();

        $notify = new Notification();
        $notify->sender_id = auth()->user()->id;
        $notify->receiver_id = $receiver_id;
        $notify->type = 'wo_closed';
        $notify->message = 'Your work order of ' . $wo->created_at . ' about ' . $wo->problem_type . ' has been closed!.';
        $notify->save();

    
    
    
    
    $work = WorkOrder::where('id', $id)->first();
  $cfirstname= $work['user']->fname;
  $clastname=$work['user']->lname;
  $cmobile=$work['user']->phone;
 
    $msg='Dear  '. $cfirstname.'  '.$clastname.' Your work order No '.$wo->id.' sent to Estate Directorate on  ' . $wo->created_at . ' of  Problem Type' . $wo->problem_type . 'about '.$wo->details.' has been Closed. 
 Please Visit the system for more informations. Thanks   
    
    Directorate of Estates.';
    
    
    
    

      /*   $basic  = new \Nexmo\Client\Credentials\Basic('8f1c6b0f', 'NQSwu3iPSjgw275c');
$client = new \Nexmo\Client($basic);

$message = $client->message()->send([
    'to' => '255762391602',
    'from' => 'ESTATE STAFF',
    'text' => ' Your workorder have been closed successfully'
]);

session::flash('message', ' Your workorder have been closed successfully');


*/

        return redirect()->route('workOrder.track', [$id])->with([
            'role' => $role,
            'notifications' => $notifications,
            'message' => 'Work order is completely closed successfully',
            'wo' => WorkOrder::where('id', $id)->with('work_order_progress')->first()
        ]);
    }
    
    
    
    
    
    
	
	
	
	
	
	
	
	
	
	public function closeWOSatisfied($id)
    {
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();

        $wo = WorkOrder::find($id);
        $wo->status = 9;
		$p_type= $wo->problem_type;
        $wo->save();
		
		$notuser='HOS '.$p_type;
		 $us=User::where('type',$notuser)->first();
		
        $notify = new Notification();
        $notify->sender_id = auth()->user()->id;
        $notify->receiver_id = $us->id;
        $notify->type = 'wo_closed';
        $notify->message = 'Your work order of ' . $wo->created_at . ' about ' . $wo->problem_type . ' is satisfied by client!.';
        $notify->save();

	
	
	
	
	


        return redirect()->route('workOrder.track', [$id])->with([
            'role' => $role,
            'notifications' => $notifications,
            'message' => 'Work order Status is Changed to Satisfied Successfully',
            'wo' => WorkOrder::where('id', $id)->with('work_order_progress')->first()
        ]);
    }
	
	
	
    public function closeWONotSatisfied(Request $request, $id)
    {
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();

        $wo = WorkOrder::find($id);
        $wo->status = 12;
        $p_type= $wo->problem_type;
        $wo->unsatisfiedreason = $request['unsatisfiedreason'];
        $wo->save();
        
     

        
        $notuser='HOS '.$p_type;
        $us=User::where('type',$notuser)->first();
        
        $notify = new Notification();
        $notify->sender_id = auth()->user()->id;
        $notify->receiver_id = $us->id;
        $notify->type = 'wo_closed';
        $notify->message = 'Your work order of ' . $wo->created_at . ' about ' . $wo->problem_type . ' is not satisfied by client!.';
        $notify->save();

    
    
    
    
    


        return redirect()->route('workOrder.track', [$id])->with([
            'role' => $role,
            'notifications' => $notifications,
            'message' => 'Work order Status is Changed to non-satisfied Successfully',
            'wo' => WorkOrder::where('id', $id)->with('work_order_progress')->first()
        ]);
    }
    
    
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	



	public function transport_request_accept(Request $request)
    {
       
	 
        $wo_transport =WorkOrderTransport::where('id',$request['transportid'] )->first();

		  $wo_transport->details = $request['details'];
		 $wo_transport->status = $request['status'];
        $wo_transport->save();
		if($request['status']==1){
        return redirect()->back()->with(['message' => 'Transport Request Accepted successfully ']);
		}
		else{
			return redirect()->back()->with(['message' => 'Transport Request is Rejected successfully ']);
		
		}
           }	
	
	
	public function transport_request_reject($id)
    {
       
        $wo_transport =WorkOrderTransport::where('id', $id)->first();

		
		 $wo_transport->status = -1;
        $wo_transport->save();
        
        return redirect()->route('wo_transport_request')->with(['message' => 'Transport Request Rejected successfully ']);
    }	
	
	
	public function woTechnicianComplete($id)
    {
       
        $wo_staff =WorkOrderStaff::where('id', $id)->first();

		
		 $wo_staff->status = 1;
        $wo_staff->save();
         return redirect()->back()->with(['message' => 'STATUS OF TECHNICIAN IS CHANGED SUCCESSFULLY']);
         }	
		 
		 
		 
	public function woChangeTypeView($id)
    {
       
        $wo =WorkOrder::where('id', $id)->first();

				
		 $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('changewotype', ['role' => $role, 'wo' =>$wo ,'notifications' => $notifications]);
         }	
		 
		 
		 
		 public function changewoType(Request $request)
    {
		$id=$request['wo_id'];
		$idp=intval($id);
       
        $work =WorkOrder::where('id', $idp)->first();
		 $work->problem_type = $request['p_type'];
		 
        $work->save();
         return redirect()->back()->with(['message' => 'STATUS OF WORK-ORDER IS CHANGED SUCCESSFULLY']);
         }

 
		 
	
	
	
}
