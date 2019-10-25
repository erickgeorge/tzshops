<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Role;
use App\Notification;
use App\User;
use App\Material;
use App\WorkOrderStaff;
use App\Technician;
use App\WorkOrder;

use App\WorkOrderMaterial;

class StoreController extends Controller
{
    //
	
	public function addmaterialView()
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();

        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        
        return view('addmaterial', [
           
            'role' => $role,
            'notifications' => $notifications
        ]);
    }
	
	public function incrementmaterialView($id)
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();

        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
		$item= Material::where('id',$id)->first();
        
        return view('incrementmaterial', [
           
            'role' => $role,
            'notifications' => $notifications,
			'item' => $item
        ]);
    }
	
	
	
	public function incrementmaterial(Request $request)
    {
 
        $material =Material::where('id', $request['nameid'])->first();;

		
		 $material->stock = $request['tstock'];
        $material->save();

        return redirect()->route('storeIncrement.view', $request['nameid'])->with(['message' => 'Material is added succesfully']);
    }
	
	 public function addnewmaterail(Request $request)
    {
        //$request->validate([
          //  'description' => 'required|unique:materials',
			
        //]);


       

        if ($request['m_type'] == 'Choose...') {
            return redirect()->back()->withErrors(['message' => 'Material type required ']);
        }
        $material = new Material();


      


        $material->name = $request['name'];
        $material->description = $request['description'];
        $material->brand = $request['brand'];
        $material->type = $request['m_type'];
		
		 $material->stock = $request['stock'];
        $material->save();

        return redirect()->route('add_material')->with(['message' => 'New material successfully added']);
    }

	public function acceptMaterial($id)
    {
       
        $wo_materials =WorkOrderMaterial::where('work_order_id', $id)->where('status',0)->get();

		 foreach($wo_materials as $wo_material) {
		$wo_m =WorkOrderMaterial::where('id', $wo_material->id)->first();	 
		 $wo_m->status = 1;
		  $wo_m->save();
		 }
		 
		 //status field of work order
			$mForm = WorkOrder::where('id', $id)->first();
             $mForm->status =15;
			
             $mForm->save();


        return redirect()->route('wo.materialneededy')->with(['message' => 'Material Accepted successfully ']);
    }



	public function acceptMaterialonebyone($id)
    {
       
        $wo_materials =WorkOrderMaterial::where('material_id', $id)->where('status',0)->get();

		 foreach($wo_materials as $wo_material) {
		 $wo_m =WorkOrderMaterial::where('id', $wo_material->id)->first();	 
		 $wo_m->status = 1;
		 $wo_m->save();
		 }
		 
		 //status field of work order
			

        return redirect()->route('wo.materialneededy')->with(['message' => 'Respective material Accepted successfully ']);
    }


	
	public function rejectMaterial(request $request, $id)
    {
       
          $wo_materials =WorkOrderMaterial::where('work_order_id', $id)->where('status',0)->get();

		 foreach($wo_materials as $wo_material) {
		$wo_m =WorkOrderMaterial::where('id', $wo_material->id)->first();	 
		$wo_m->status = -1;
		$wo_m->reason = $request['reason'];
		$wo_m->save();
		 }  

		 //status field of work order
			$mForm = WorkOrder::where('id', $id)->first();
             $mForm->status = 16;
			
             $mForm->save();
        return redirect()->route('wo.materialneededy')->with(['message' => 'Material Rejected successfully ']);
    }
	
	

	public function rejectMaterialonebyone(request $request, $id)
    {
       
          $wo_materials =WorkOrderMaterial::where('material_id', $id)->where('status',0)->get();

		 foreach($wo_materials as $wo_material) {
		$wo_m =WorkOrderMaterial::where('id', $wo_material->id)->first();	 
		$wo_m->status = -1;
		$wo_m->reason = $request['reason'];
		$wo_m->save();
		 }  

		 //status field of work order
			
        return redirect()->route('wo.materialneededy')->with(['message' => 'Respective material Rejected successfully ']);
    }
	
	
	
	
	
		public function material_request_hos($id)
    {
         $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
	
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
          $wo_materials =WorkOrderMaterial::where('work_order_id', $id)->where('status',1)->get();

		 foreach($wo_materials as $wo_material) {
		$wo_m =WorkOrderMaterial::where('id', $wo_material->id)->first();	 
		 $wo_m->status = 3;//status for material available in store
		  $wo_m->save();
		 }
		 
       $staff=WorkOrderStaff::where('work_order_id', $id)->get();
		
		
        return redirect()->route('workOrder.edit.view', [$id])->with(['message' => 'Material is Requested from Store Successfully.']);
 
		}
	

		public function ReserveMaterial($id)
    {
         $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
	
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
          $wo_materials =WorkOrderMaterial::where('work_order_id', $id)->where('status',1)->get();

		 foreach($wo_materials as $wo_material) {
		$wo_m =WorkOrderMaterial::where('id', $wo_material->id)->first();	 
		 $wo_m->status = 5; //status for material missing
		  $wo_m->save();
		 }
		 
       $staff=WorkOrderStaff::where('work_order_id', $id)->get();
		
		
        return redirect()->route('workOrder.edit.view', [$id])->with(['message' => 'Material reserved and  sent to be purchased Successfully.']);

 
		}
	
	

	public function releaseMaterial($id)
    {
       
        $wochange_status =WorkOrderMaterial::where('work_order_id', $id)->where('status', 3)->get();
		
		$wo_materials = WorkOrderMaterial::
                     select(DB::raw('work_order_id,material_id,sum(quantity) as quantity'))
                     ->where('status',3)
					 ->where('work_order_id',$id)
                     ->groupBy('material_id')
					 ->groupBy('work_order_id')
                     ->get();
		   foreach($wo_materials as $wo_material){
		   
		$material_id=$wo_material->material_id;
		$material_quantity=$wo_material->quantity;
		$material=Material::where('id', $material_id)->first();
		$stock=$material->stock;
		$rem=$stock-$material_quantity;
		$material->stock=$rem;
		 $material->save();
			}
			
		foreach($wochange_status as $wochange_state){
			 $wochange =WorkOrderMaterial::where('id', $wochange_state->id)->first();
		$wochange->status=2;
		$wochange->save();
		
		}
       
        return redirect()->route('work_order_approved_material')->with(['message' => 'Material has been released successfully ']);
    }
  



	public function releaseMaterialafterpurchased($id)
    {
       
        $wochange_status =WorkOrderMaterial::where('work_order_id', $id)->where('status', 5)->get();
		
		$wo_materials = WorkOrderMaterial::
                     select(DB::raw('work_order_id,material_id,sum(quantity) as quantity'))
                     ->where('status',5)
					 ->where('work_order_id',$id)
                     ->groupBy('material_id')
					 ->groupBy('work_order_id')
                     ->get();
		
		foreach($wochange_status as $wochange_state){
			 $wochange =WorkOrderMaterial::where('id', $wochange_state->id)->first();
		     $wochange->status=15; //status after release material from head of procurement
		     $wochange->save();
		
		}
       
        return redirect()->route('work_order_approved_material')->with(['message' => 'notification sent to Store Manager so as to add material in store ']);
    }



    public function insufficientmaterial($id)
    {
       
        $wochange_status =WorkOrderMaterial::where('work_order_id', $id)->where('status', 3)->get();
			



		foreach($wochange_status as $wochange_state){
			 $wochange =WorkOrderMaterial::where('id', $wochange_state->id)->first();
		$wochange->status=10;
		$wochange->save();
		
		}
       




		
		 
		 
        
        return redirect()->route('work_order_approved_material')->with(['message' => 'Message has been sent successfully ']);
    }
	
	
	
	
	
	
}