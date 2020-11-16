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
use App\Procurement;
use App\WorkOrderMaterial;
use App\Storehistory;
use App\zoneinspector;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

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





     public function incrementmaterialmodal(Request $request, $id )
    {



       $p=$request['istock'];
       $matir = WorkOrderMaterial::where('id',$p)->first();
      // $matir->checkreserve = 1;
       $matir->currentaddedmat = 2;
       $matir->newstock = $request['tstock'];


        if ( ($matir->newstock) > ($matir->quantity - $matir->reserved_material) ) {
            return redirect()->back()->withErrors(['message' => ' Quantity Purchased for  '.$matir['material']->name. '  is: '.($matir->quantity - $matir->reserved_material).' .Please add '.$matir['material']->name. ' up to total Purchased, If Purchased '.$matir['material']->name. ' is greater than Requested '.$matir['material']->name. ' Please go to Store add excessed  '.$matir['material']->name. ' for the other worksorders, Thanks   '  ]);
        }

        else{
          $matir->save();
          return redirect()->back()->with(['message' => 'Respective Material added succefully in store']);

        }

        }





        public function incrementmaterialmodal2(Request $request, $id )
    {
       $p=$request['estock'];
       $matir = WorkOrderMaterial::where('id',$p)->first();
      // $matir->checkreserve = 1;

       $matir->newstock = $request['pstock'];


        if ( ($matir->newstock) > ($matir->quantity - $matir->reserved_material) ) {
            return redirect()->back()->withErrors(['message' => ' Quantity Purchased for  '.$matir['material']->name. '  is: '.($matir->quantity - $matir->reserved_material).' .Please add '.$matir['material']->name. ' up to total Purchased, If Purchased '.$matir['material']->name. ' is greater than Requested '.$matir['material']->name. ' Please go to Store add excessed  '.$matir['material']->name. ' for the other worksorders, Thanks   '   ]);
        }
        else{
          $matir->save();
          return redirect()->back()->with(['message' => 'Respective Material added succefully in store']);

        }



        }








	public function incrementmaterial(Request $request)
    {

    	   $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();

           $role = User::where('id', auth()->user()->id)->with('user_role')->first();
           $material =Material::where('id', $request['nameid'])->first();;


		 $material->stock = $request['tstock'];
        $material->save();


          $historysave = new Storehistory();
          $historysave->material_name = $material->name;
          $historysave->material_description = $material->description;
          $historysave->total_input = $request['istock'];
          $historysave->type = $material->type;
          $historysave->unit_measure = $material->brand;
          $historysave->tag_ = now();
          $historysave->added_by = auth()->user()->id;
          $historysave->incremented = 'incremented';
          $historysave->save();



         return redirect()->route('store')->with(['role' => $role, 'notifications' => $notifications,
            'notifications' => $notifications,'role' => $role,
			 'message' => 'Materials succesfully added in Store'] );

    }




	 public function addnewmaterail(Request $request)
    {

//here

      $y=1;
    $totmat=$request['totalinputs']/5;

        $role = User::where('id', auth()->user()->id)->with('user_role')->first();

        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();

      $z=1;
      $tag = date("Y-m-d H:i:s");
      for ($x = 1; $x <= $totmat; $x++) {

      $_material = new  Storehistory();
      $material = new Material();

            $_material->material_name = $request[$z];
            $material->name = $request[$z];

              $z=$z+1;
            $_material->material_description = $request[$z];
            $material->description = $request[$z];

            $z=$z+1;
            $_material->type = $request[$z];
            $material->type = $request[$z];

              $z=$z+1;
            $_material->unit_measure = $request[$z];
            $material->brand = $request[$z];

              $z=$z+1;
            $_material->total_input = $request[$z];
             $material->stock = $request[$z];


            $_material->tag_ = $tag; //differentiating from different inputs
            $_material->added_by = auth()->user()->id;
              $z++;
            $_material->save();
             $material->save();

    }

     return redirect()->route('store')->with(['message' => 'New material successfully added']);

  }






     public function Materialacceptedwithrejected($id , $hosid)
    {
        $wo_materials =WorkOrderMaterial::where('work_order_id', $id)->where('status',0)->orwhere('status',9)->get();

		   foreach($wo_materials as $wo_material) {
		   $wo_m =WorkOrderMaterial::where('id', $wo_material->id)->first();
		   $wo_m->status = 17;
		   $wo_m->save();
		    }


             //emailandnotification

      $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();

         $emailReceiver = User::where('id', $hosid)->first();

        $toEmail = $emailReceiver->email;
        $fuserName=$emailReceiver->fname;
        $luserName=$emailReceiver->lname;
        $userName=$fuserName.' '.$luserName;

        $senderf=auth()->user()->fname;
        $senderl=auth()->user()->lname;
        $sender=$senderf.' '.$senderl;
        $section=auth()->user()->type;

     $datenow = Carbon::now();
     $createddate = date('d F Y', strtotime($datenow));

     $data = array('name'=>$userName, "body" => "Your materials sent to Inspector of Works on  $createddate has been REJECTED. Please login in the system so as to resubmit your materials request.",

                  "footer"=>"Thanks", "footer1"=>" $sender" , "footer3"=>" $section ", "footer2"=>"Directorate  of Estates Services"
                );

       Mail::send('email', $data, function($message) use ($toEmail,$sender,$userName) {

       $message->to($toEmail,$userName)
            ->subject('MATERIAL(S) REJECTION.');
       $message->from('udsmestates@gmail.com',$sender);
       });



        $notify = new Notification();
        $notify->sender_id = auth()->user()->id;
        $notify->receiver_id = $hosid;
        $notify->type = 'mat_rejected';
        $notify->status = 0;
        $notify->message = 'Your Materials sent to Inspector of Works has been rejected on ' . $createddate . ' Please login in the system so as to resubmit your materials request.';
        $notify->save();


     //emailandnotification


		 //status field of work order
			$mForm = WorkOrder::where('id', $id)->first();
             $mForm->status = 55;

             $mForm->save();
       return redirect()->route('wo.materialneededyi')->with(['message' => 'Material Rejected successfully with others Accepted']);
    }





    public function materialtoreserveonebyone( $id )
    {

			$mat = WorkOrderMaterial::where('id', $id)->first();
            $mat->status = 5 ;
            $mat->newstock = 0;
            $mat->copyforeaccepted = 1;

            $material_id=$mat->material_id;

		        $material=Material::where('id', $material_id)->first();
		        $mat->reserved_material = $material->stock;

		        $material->stock= 0;

		        $material->save();
            $mat->save();


       return redirect()->back()->with(['message' => 'Material Reserved and Sent Succesifully to Head of Procurement']);
    }




   	public function materialafterpurchase( $id )
    {

			$mat = WorkOrderMaterial::where('id', $id)->first();
            $mat->status = 3;


            $mat->save();


       return redirect()->back()->with(['message' => 'Material Sent  successfully to Head of Section']);
    }






 	public function materialnotreserve( $id )
    {

			$mat = WorkOrderMaterial::where('id', $id)->first();
            $mat->status = 3;
            $mat->copyforeaccepted = 1;

            $material_id=$mat->material_id;
		    $material_quantity=$mat->quantity;
		    $material=Material::where('id', $material_id)->first();
		    $stock=$material->stock;
		    $rem=$stock-$material_quantity;
		    $material->stock=$rem;
		    $material->save();
            $mat->save();


       return redirect()->back()->with(['message' => 'Material Sent  successfully to Head of Section']);
    }







	public function acceptMaterial($id)
    {

      $iozone =  zoneinspector::where('inspector',auth()->user()->id)->first();

     $wo_materials =WorkOrderMaterial::where('work_order_id', $id)->where('status',0)->where('zone', $iozone->zone)->get();

		 foreach($wo_materials as $wo_material) {
		 $wo_m =WorkOrderMaterial::where('id', $wo_material->id)->first();
		 $wo_m->status = 1;
     $wo_m->accepted_by = auth()->user()->id;
	   $wo_m->save();
		 }

		 //status field of work order
			$mForm = WorkOrder::where('id', $id)->first();
             $mForm->status = 15;

             $mForm->save();
       return redirect()->route('wo.materialneededyi')->with(['message' => 'Material Accepted successfully ']);
    }





  public function acceptMaterialiow($id , $zoneid)
    {
     $wo_materials =WorkOrderMaterial::where('work_order_id', $id)->where('zone', $zoneid)->where('status',0)->get();

     foreach($wo_materials as $wo_material) {
     $wo_m =WorkOrderMaterial::where('id', $wo_material->id)->first();
     $wo_m->status = 1;
     $wo_m->accepted_by = auth()->user()->id;
     $wo_m->save();
     }

     //status field of work order
      $mForm = WorkOrder::where('id', $id)->first();
             $mForm->status = 15;

             $mForm->save();
       return redirect()->route('wo.materialneededyi')->with(['message' => 'Material Accepted successfully ']);
    }






             public function MaterialrequestView($id){

        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('requestedmaterialinstore', [
            'role' => $role,
            'notifications' => $notifications,
            'wo_materials' =>WorkOrderMaterial::where('work_order_id', $id)->where('status',1)->get(),
            'wo' => WorkOrder::where('id', $id)->first()



          ]);
     }










	public function rejectMaterial(request $request, $id , $hosid)
    {

      $wo_status_check_return =WorkOrderMaterial::where('work_order_id', $id)->where('status', 0)->update(array('check_return' =>1));

          $wo_materials =WorkOrderMaterial::where('work_order_id', $id)->where('status',0)->orwhere('work_order_id', $id)->where('status',9)->get();

		 foreach($wo_materials as $wo_material) {
		$wo_m =WorkOrderMaterial::where('id', $wo_material->id)->first();
		$wo_m->status = -1;
    $wo_m->accepted_by = auth()->user()->id;
		$wo_m->reason = $request['reason'];
		$wo_m->save();
		 }

     //emailandnotification

      $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();

         $emailReceiver = User::where('id', $hosid)->first();

        $toEmail = $emailReceiver->email;
        $fuserName=$emailReceiver->fname;
        $luserName=$emailReceiver->lname;
        $userName=$fuserName.' '.$luserName;

        $senderf=auth()->user()->fname;
        $senderl=auth()->user()->lname;
        $sender=$senderf.' '.$senderl;
        $section=auth()->user()->type;

     $datenow = Carbon::now();
     $createddate = date('d F Y', strtotime($datenow));

     $data = array('name'=>$userName, "body" => "Your materials sent to Inspector of Works on  $createddate has been REJECTED. Please login in the system so as to resubmit your materials request.",

                  "footer"=>"Thanks", "footer1"=>" $sender" , "footer3"=>" $section ", "footer2"=>"Directorate  of Estates Services"
                );

       Mail::send('email', $data, function($message) use ($toEmail,$sender,$userName) {

       $message->to($toEmail,$userName)
            ->subject('MATERIAL(S) REJECTION.');
       $message->from('udsmestates@gmail.com',$sender);
       });



        $notify = new Notification();
        $notify->sender_id = auth()->user()->id;
        $notify->receiver_id = $hosid;
        $notify->type = 'mat_rejected';
        $notify->status = 0;
        $notify->message = 'Your Materials sent to Inspector of Works has been rejected on ' . $createddate . ' Please login in the system so as to resubmit your materials request.';
        $notify->save();


     //emailandnotification

		 //status field of work order
			$mForm = WorkOrder::where('id', $id)->first();
             $mForm->status = 16;

             $mForm->save();
        return redirect()->route('wo.materialneededyi')->with(['message' => 'All materials Rejected successfully ']);
    }




      public function redirecttohos(Request $request, $id )
    {

       $role = User::where('id', auth()->user()->id)->with('user_role')->first();
       $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();

       $p=$request['edit_mat'];
       $matir = WorkOrder::where('id',$p)->first();

       $matir->problem_type = $request['p_type'];

       $matir->save();

        return redirect()->back()->with(['message' => 'Respective material Rejected successfully ']);
    }




     public function redirectworkordertohos(Request $request ,$id )
    {

       $matir = WorkOrder::where('id',$id)->first();
       $matir->problem_type = $request['p_type'];
       $matir->redirectwo = 1 ;
       //$matir->details = $request['details'];
       $matir->save();

        return redirect()->back()->with(['message' => 'Respective Workorder Redirected successfully ']);
    }





      public function materialrejectonebyone(Request $request, $id )
    {
       $wo_status_check_return =WorkOrderMaterial::where('work_order_id', $id)->where('status', 0)->update(array('check_return' =>1));

       $p=$request['edit_mat'];
       $matir = WorkOrderMaterial::where('id',$p)->first();

       $matir->reason = $request['reason'];
       $matir->status = 9;
       $matir->save();



        return redirect()->back()->with(['message' => 'Respective material Rejected successfully ']);
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

		 foreach($wo_materials as $wo_material){

		$material_id=$wo_material->material_id;
		$material_quantity=$wo_material->quantity;
		$material=Material::where('id', $material_id)->first();
		$stock=$material->stock;
		$rem=$stock-$material_quantity;
		$material->stock=$rem;
		 $material->save();
			}


         foreach($wo_materials as $wo_material){
        $item = WorkOrderMaterial::where('id', $wo_material->id)->first();
		$notify = new Notification();
		$u = auth()->user();;
        $notify->sender_id = $u->id;
        $notify->receiver_id = $item->hos_id;
        $notify->type = 'mat_received';
        $notify->status = 5;
        $notify->message = 'Your material named:' . $item['material']->name . ' requested for Works order No:00' . $item->work_order_id . ' with quantity of: ' . $item->quantity. ' has been released by Store Manager:' . $u->fname.' '.$u->lname . '' ;
        $notify->save();

        }

		     $mForm = WorkOrder::where('id', $id)->first();
             $mForm->status = 18;  //material available in store then status change for workorder
			 $mForm->save();


         $staff=WorkOrderStaff::where('work_order_id', $id)->get();
         return redirect()->route('wo_material_accepted_by_iow')->with([

         	'message' => 'Material Released from store to HoS and Notication sent successfully to HoS.'

         ]);

		}



		public function ReserveMaterial($id)
    {
         $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();

        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
          $wo_materials =WorkOrderMaterial::where('work_order_id', $id)->where('status',1)->get();

		 foreach($wo_materials as $wo_material) {
		  $wo_m =WorkOrderMaterial::where('id', $wo_material->id)->first();
		  $wo_m->status = 5; //status for material missing
      $wo_m->newstock =0;
      $wo_m->copyforeaccepted = 1;
		       $material_id=$wo_m->material_id;
		       $material=Material::where('id', $material_id)->first();
		  $wo_m->reserved_material = $material->stock;
		       $material->stock= 0;

		       $material->save();
		  $wo_m->save();
		 }



         $mForm = WorkOrder::where('id', $id)->first();
         $mForm->status = 19;  //material missing in store then status change for workorder
	     $mForm->save();

       $staff=WorkOrderStaff::where('work_order_id', $id)->get();
		 return redirect()->route('wo_material_accepted_by_iow')->with(['message' => 'Material reserved and  sent to Director of Estate be purchased Successfully.']);

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
         $wochange->reservestatus = 1;
		     $wochange->sender_id = auth()->user()->id;
         $wochange->currentaddedmat = 1;
		     $wochange->save();

		}

        return redirect()->route('work_order_with_missing_material')->with(['message' => 'notification sent to Store Manager so as to assign Good Receiving Note ']);
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



public function deletematerial($id , $woid)
       {
          $wo_status_check_return =WorkOrderMaterial::where('work_order_id', $woid)->where('status', 17)->update(array('check_return' =>null));

           $matrialdelete=WorkOrderMaterial::where('id', $id)->first();
           $matrialdelete->delete();
           return redirect()->back()->with(['message' => 'Respective material deleted successfully']);
       }



       	public function materialaddagain($id)
    {
         $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();

        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $wo_materials =WorkOrderMaterial::where('work_order_id', $id)->where('status',20)->get();

		 foreach($wo_materials as $wo_material) {
		  $wo_m =WorkOrderMaterial::where('id', $wo_material->id)->first();
		  $wo_m->status = 0; //status for material correct sent again to IoW
		  $wo_m->receiver_id = auth()->User()->id;
		  $wo_m->save();
		 }



       $mForm = WorkOrder::where('id', $id)->first();
       $mForm->status = 7;  //material requested status
	   $mForm->save();


		 return redirect()->back()->with(['message' => 'Materials sent successfully to Inspector of Works']);


}





       	public function materialrejectedaddagain($id)
    {
         $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();

        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $wo_materials =WorkOrderMaterial::where('work_order_id', $id)->where('status',-1)->orwhere('work_order_id', $id)->where('status',44)->orwhere('work_order_id', $id)->where('status',17)->get();

		 foreach($wo_materials as $wo_material) {
		$wo_m =WorkOrderMaterial::where('id', $wo_material->id)->first();
		 $wo_m->status = 0; //status for material correct sent again to IoW
		  $wo_m->save();
		 }



       $mForm = WorkOrder::where('id', $id)->first();
       $mForm->status = 57;  //material requested status
	     $mForm->save();


		 return redirect()->back()->with(['message' => 'Materials sent again successfully to Inspector of Work']);

}
    public function procurementAddMaterial()
    {

         $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
 return view('procurementstostore', [ 'notifications' => $notifications, 'role' => $role ]);

    }

    public function procuredmaterialsadding(Request $request)
    {
        $y=1;
        $totmat=$request['totalinputs']/6;

        $role = User::where('id', auth()->user()->id)->with('user_role')->first();

        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();

      $z=1;
      $tag = date("Y-m-d H:i:s");
      for ($x = 1; $x <= $totmat; $x++) {

      $procure_material = new  Procurement();

            $procure_material->material_name = $request[$z];
              $z=$z+1;
            $procure_material->material_description = $request[$z];
            $z=$z+1;
            $procure_material->type = $request[$z];
              $z=$z+1;
            $procure_material->unit_measure = $request[$z];

              $z=$z+1;
            $procure_material->total_input = $request[$z];
              $z=$z+1;
            $procure_material->price_tag = $request[$z];


            $procure_material->tag_ = $tag; //differentiating from different inputs
            $procure_material->procured_by = auth()->user()->id;
            $procure_material->store_received = 0;
              $z++;
            $procure_material->save();
    }

    return redirect()->route('ProcurementHistory')->with(['message' => 'Procured Materials Saved Successfully!. ']);
  }

  public function ProcurementHistory()
  {
     $role = User::where('id', auth()->user()->id)->with('user_role')->first();
      $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();

     if(request()->has('start'))  { //date filter


        $from=request('start');
        $to=request('end');


        $nextday = date("Y-m-d", strtotime("$to +1 day"));

        $to=$nextday;
        if(request('start')>request('end')){
            $to=request('start');
        $from=request('end');
        }// start> end

$procured = Procurement::
            select(DB::raw('count(id) as total_materials, tag_,procured_by,store_received,stored'))
            ->whereBetween('created_at', [$from, $to])
            ->groupBy('tag_')
            ->groupBy('stored')
            ->groupBy('procured_by')
            ->groupBy('store_received')
            ->orderBy('created_at','Desc')
            ->get();
}else{
      $procured = Procurement::
            select(DB::raw('count(id) as total_materials, tag_,procured_by,store_received,stored'))
            ->groupBy('tag_')
            ->groupBy('procured_by')
            ->groupBy('stored')
            ->groupBy('store_received')
            ->orderBy('created_at','Desc')
            ->get();


}

      return view('procurementhistory', [ 'notifications' => $notifications, 'role' => $role ,'procured'=>$procured]);
  }

  public function procuredMaterials($id)
  {
    $role = User::where('id', auth()->user()->id)->with('user_role')->first();
      $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
      $material = Procurement::where('tag_',$id)->orderBy('material_name','Asc')->OrderBy('type','Asc')->get();

return view('procuredmaterial', [ 'notifications' => $notifications, 'role' => $role ,'procured'=>$material]);
  }

  public function AcceptProcuredMaterial(Request $request)
  {

    $catch_materials = Procurement::
    where('procured_by',$request['added_by'])->
    where('tag_',$request['tag_'])->
    where('store_received',$request['store_received'])->get();

    foreach ($catch_materials as $check_material)
    {
      $fetch_store = Material::
      where('name','LIKE','%'.$check_material->material_name.'%')->
      where('description','LIKE','%'.$check_material->material_description.'%')->
      where('brand','LIKE','%'.$check_material->unit_measure.'%')->
      where('type','LIKE','%'.$check_material->type.'%')->get();

      if(count($fetch_store)<1)
      {
        $material = new Material();

        $material->name = $check_material->material_name;
        $material->description = $check_material->material_description;
        $material->brand = $check_material->unit_measure;
        $material->type = $check_material->type;

        $material->stock = $check_material->total_input;
        $material->save();

            $update_procurement = Procurement::where('id',$check_material->id)->first();
            $update_procurement->stored = auth()->user()->id;
            $update_procurement->save();

      }
      else
      {
        foreach($fetch_store as $carry_store)
        {
            $update_material = Material::where('id',$carry_store->id)->first();
            $update_material->stock = $carry_store->stock + $check_material->total_input;
            $update_material->save();

            $update_procurement = Procurement::where('id',$check_material->id)->first();
            $update_procurement->stored = auth()->user()->id;
            $update_procurement->save();
        }
      }


    }

  return redirect()->back()->with(['message' => 'Material successfully added in the stock!']);

  }

  public function ReceivedProcurement(Request $request)
  {
   $catch_materials = Procurement::select('id')->
    where('procured_by',$request['added_by'])->
    where('tag_',$request['tag_'])->
    where('store_received',$request['store_received'])->get();

    foreach($catch_materials as $procured_stored)
    {
            $update_procurement = Procurement::where('id',$procured_stored->id)->first();
            $update_procurement->store_received = auth()->user()->id;
            $update_procurement->save();
    }

   return redirect()->back()->with(['message' => 'Material Accepted Successfully!']);
  }

  public function materialEntryHistory()
  {

    $role = User::where('id', auth()->user()->id)->with('user_role')->first();
      $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
      $material = Storehistory::
      select(DB::raw('count(id) as total_materials, tag_,added_by,incremented'))
            ->groupBy('tag_')
            ->groupBy('added_by')
            ->groupBy('incremented')
            ->orderBy('created_at','Desc')
            ->get();

return view('materialEntryHistory', [ 'notifications' => $notifications, 'role' => $role ,'procured'=>$material]);
  }

  public function materialEntry($id)
  {
    $role = User::where('id', auth()->user()->id)->with('user_role')->first();
      $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
      $material = Storehistory::where('tag_',$id)->orderBy('material_name','Asc')->OrderBy('type','Asc')->get();

return view('materialEntry', [ 'notifications' => $notifications, 'role' => $role ,'procured'=>$material]);
  }



    public function materialtoreserveinstore( $id , $woid)
    {


      $wo_status_check_return =WorkOrderMaterial::where('work_order_id', $woid)->update(array('status2' =>2));


      $mat = WorkOrderMaterial::where('id', $id)->first();
      $mat->status = 100;
        $material_id=$mat->material_id;
        $material_quantity=$mat->quantity;
        $material=Material::where('id', $material_id)->first();
        $stock=$material->stock;
        $rem=$stock-$material_quantity;
        $material->stock=$rem;
        $material->save();

      $mat->reserved_material = $mat->quantity;
      $mat->save();

       return redirect()->back()->with(['message' => 'Material Reserved Succesifully']);
    }

    public function getnameMAT(Request $request)
{
    return response()->json(['description' => Material::where('name','like',$request->get('id'))->orderby('description','ASC')->get()]);

}

public function getdescriptionMAT(Request $request)
{
    return response()->json(['description' => Material::where('description','like',$request->get('id'))->orderby('description','ASC')->get()]);

}

public function getbrandMAT(Request $request)
{

}

}

