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
use App\grn;
use Illuminate\Support\Facades\Mail;


class PurchasingOrderController extends Controller
{  
public function __construct()
    {
        $this->middleware('auth');
    }

   
   public function purchasingOrderAccept($id){
         
		$wo_procurement = PurchasingOrder::where('id', $id)
                     ->where('status',0)->get();
		     
					 
					 
		   foreach($wo_procurement as $wo_procurementt){

		$wo_procurementt->status=1;
		 $wo_procurementt->save();
			
			}
			
		
	
		
		 
		 
        return redirect()->route('work_order_purchasing_request','$id')->with(['message' => 'Purchasing Order is accepted successfully']);
 
       
    }		 
	
	
	public function work_order_procurement_requestView()
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
		
		$wo_material= 	PurchasingOrder::
                     select(DB::raw('work_order_id'))
                     ->where('status',1)
					
                     ->groupBy('work_order_id')
					 
                     ->get();
			
			
		
			
			
        return view('wo_procurement_request', ['role' => $role, 'items' => $wo_material,'notifications' => $notifications]);
    }
	
	
	
	public function procurematerial()
    {
    
		   $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
		
			
			
        return view('procurematerial
	', ['role' => $role,'notifications' => $notifications]);
    }
	
	
	
	 public function purchasingOrderReject($id){
         
		$wo_procurement = PurchasingOrder::where('id', $id)
                     ->where('status',0)->get();
		     
					 
					 
		   foreach($wo_procurement as $wo_procurementt){

		$wo_procurementt->status=-1;
		 $wo_procurementt->save();
			
			}
			
			     return redirect()->route('work_order_purchasing_request','$id')->with(['message' => 'Purchasing Order is REJECTED successfully']);

	 }
	 
	 
			
			
			 public function procurement_release($id){
         
		$wo_procurement = PurchasingOrder::where('id', $id)
                     ->where('status',2)->get();
		     
					 
					 
		   foreach($wo_procurement as $wo_procurementt){

		$wo_procurementt->status=3;
		 $wo_procurementt->save();
			
			}
			     return redirect()->route('wo_release_grn')->with(['message' => 'Purchasing Order is accepted successfully']);

			
			
	 }
			
			 public function signGRN (Request $request,$id){
         
		$wo_grn = new grn();
		     $supplier=$request['supplier'];
			 $dates=$request['date'];
			 
			 
					 
					 
		
			$wo_grn->supplied_by=$supplier;
			$wo_grn->date_supplied=$dates;
				$wo_grn->purchasing_order_id=$id;
				$wo_grn->approved_by= auth()->user()->id;
				
		 $wo_grn->save();
			
				$wo_procurement = PurchasingOrder::where('id', $id)
                     ->where('status',1)->get();
		     
					 
					 
		   foreach($wo_procurement as $wo_procurementt){

		$wo_procurementt->status=2;
		 $wo_procurementt->save();
			
			}
			
			
		
	
		
		 
		 
        return redirect()->route('work_order_grn','$id')->with(['message' => 'GRN IS SIGNED SUCCESSFULLY']);
 
       
    }		 



public function grn_release_list($id)
   
    {
		
		
		
		$wo_material = PurchasingOrder::
                     select(DB::raw('work_order_id,material_list_id,sum(quantity) as quantity'))
                     ->where('status',2)
					 ->where('work_order_id',$id)
                     ->groupBy('material_list_id')
					 ->groupBy('work_order_id')
					 
                     ->get();
		
		
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 2)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('grn_release_list', ['role' => $role, 'items' => $wo_material,'notifications' => $notifications]);
    }
   
   
	
}
