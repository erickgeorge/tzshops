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
use App\landscapinginspectionform;
use App\company;
use App\cleaningarea;
use App\landassessmentform;
use App\landassessmentactivityform;
use App\landmaintainancesection;
use App\landcrosschecklandassessmentactivity;
use Carbon\Carbon;
use App\companywitharea;



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

        return redirect()->route('Land_work_order')->with(['message' => 'Works order for ladscaping is successfully created']);
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


         if (strpos(auth()->user()->type, "Supervisor ") !== false) {
                return view('land_work_orders', [
                    'role' => $role,
                     'wo' => landworkorders::where('maintenance_section', substr(strstr(auth()->user()->type, " "), 1))->whereBetween('created_at', [$from, $to])->where('status', '<>', 0)->OrderBy('created_at', 'DESC')->get(),
                    'notifications' => $notifications
                ]);
            } 

            else {
        
            return view('land_work_orders', [
                'role' => $role,
                'notifications' => $notifications,
                'wo' => landworkorders::whereBetween('created_at', [$from, $to])->OrderBy('created_at', 'DESC')->get()
            ]);
        
           } }




            else
            
        {
             if (strpos(auth()->user()->type, "Supervisor") !== false) {
                return view('land_work_orders', ['role' => $role, 'notifications' => $notifications,'wo' => landworkorders::where('maintenance_section', substr(strstr(auth()->user()->type, " "), 1))->where('status', '<>', 0)->orwhere('client_id', auth()->user()->id, " ")->OrderBy('created_at', 'DESC')->get()]); }
                else{

        return view('land_work_orders', [
            'role' => $role,
            'notifications' => $notifications,
            'wo' => landworkorders::OrderBy('created_at', 'DESC')->get()
        ]); }
   
        
        
    }//




}

      public function trackwoland($id)
    {
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        return view('track_work_order_landscaping', [
            'notifications' => $notifications,
            
            'role' => $role, 
            'wo' => landworkorders::where('id', $id)->first(),
            'slecc' =>User::where('type', 'Supervisor Landscaping')->get(),
            'company' =>company::all(),
            'carea' =>cleaningarea::all(),
           
            'assessmmentcompany' => landassessmentform::where('id', $id)->get(),
            'assessmmentactivity' => landassessmentactivityform::where('assessment_id', $id)->get(),
            'crosscheckassessmmentactivity' => landcrosschecklandassessmentactivity::where('assessment_id', $id)->get(), 
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
        $wO->status = 2; //accepted
        $wO->save();



        $notify = new Notification();
        $notify->sender_id = auth()->user()->id;
        $notify->receiver_id = $wO->client_id;
        $notify->type = 'wo_accepted';
        $notify->status = 0;
        $time = strtotime($wO->created_at);
        $timed = date('d/m/Y',$time);
        $notify->message = 'Your work order for Landscaping of ' .  $timed  . ' about ' . $wO->maintenance_section . ' has been accepted.';
        $notify->save();




        $work = landworkorders::where('id', $id)->first();
        $cfirstname= $work['user']->fname;
        $clastname=$work['user']->lname;
        $cmobile=$work['user']->phone;
        $time = strtotime($wO->created_at);
        $timed = date('d/m/Y',$time);
        $msg='Dear  '. $cfirstname.'  '.$clastname.'. Your landscaping work order with Ref No: WO-'.$wO->id.' sent to Estate Directorate on  ' . $timed . ' of  maintenance section :' . $wO->maintenance_section . '  about '.$wO->details.' has been ACCEPTED .              Thanks   Directorate of Estates Services.';
  

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


    

        $data = array('name'=>$userName, "body" => "Your Landscaping Work-Order No : $wO->id sent to Directorate of Estates on : ".$timed.", of  maintenance section : $wO->maintenance_section has been ACCEPTED.Please login in the system for further information .",

                     "footer"=>"Thanks", "footer1"=>" $sender" , "footer3"=>" $section ", "footer2"=>"Directorate  of Estates Services"
                );
    
       Mail::send('email', $data, function($message) use ($toEmail,$sender,$userName) {
       
       $message->to($toEmail,$userName)
            ->subject('LANDSCAPING WORK ORDER ACCEPTANCE.');
       $message->from('udsmestates@gmail.com',$sender);
       });
        
    

        return redirect()->route('workOrder.edit.landscaping', [$wO->id])->with([
            'role' => $role,
            'notifications' => $notifications,
            'techs' => User::where('type', 'TECHNICIAN')->get(),
            'message' => 'Landscaping work order accepted succesifully. You can now edit it!',
            'wo' => landworkorders::where('id', $id)->first()
        ]);
    }


      public function editwolandscaping($id)
    {
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();


        return view('edit_work_order_landscaping', [
           
            'notifications' => $notifications,
            
            'role' => $role, 
            'wo' => landworkorders::where('id', $id)->first(),
            'slecc' =>User::where('type', 'Supervisor Landscaping')->get(),
            'company' =>company::all(),
            'carea' =>cleaningarea::all(),
           
            'assessmmentcompany' => landassessmentform::where('id', $id)->get(),
            'assessmmentactivity' => landassessmentactivityform::where('assessment_id', $id)->get(),
            'crosscheckassessmmentactivity' => landcrosschecklandassessmentactivity::where('assessment_id', $id)->get(), 

        ]);
    }



         public function landinspectionForm(Request $request, $id)
    {


            $role = User::where('id', auth()->user()->id)->with('user_role')->first();
            $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
   
           
 
            $form = new landscapinginspectionform();
            $form->status = $request['status'];
            $form->date = $request['inspectiondate'];
            $form->description = $request['details'];
            $form->supervisor = $request['supervisor'];
            $form->work_order_id = $id;
            $form->save();


            $inspectionForm = landworkorders::where('id', $id)->first();
            $inspectionForm->status =3;
            $inspectionForm->save();
        

        return redirect()->route('workOrder.edit.landscaping', [$id])->with([
            'role' => $role,
            'notifications' => $notifications,  
            'message' => 'Inspection form successfully updated',
            'wo' => landworkorders::where('id', $id)->first()
        ]);
    }





         public function landassessmentForm(Request $request , $id , $date , $status , $nextmonth)
    {


            $role = User::where('id', auth()->user()->id)->with('user_role')->first();
            $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
   
            $areas =  $request['area'];
 

             //  First Store data in $arr
             $arr = array();
                  foreach ($areas as $are) {
                   $arr[] = $are;
             }
            $unique_data = array_unique($arr);
            // now use foreach loop on unique data
            foreach($unique_data as $a => $b) {
 
  
            $form = new landassessmentform();
            $form->company_id = $id;
            $form->area_id = $areas[ $a ];
            $form->status = 1;
            $form->assessment_month = $request['assessmment'];




            if ($status == 1) {
              
            $comp = company::where('id',  $id)->first();
           
            $ddate = strtotime($nextmonth);
            $newDate = date("Y-m-d", strtotime("+1 month", $ddate));

            $comp->nextmonth = $newDate;   
            $comp->save();
          


            }

            else{

            $comp = company::where('id',  $id)->first();
            $comp->status =  1 ;
            $ddate = strtotime($date);
            $newDate = date("Y-m-d", strtotime("+1 month", $ddate));

            $comp->nextmonth = $newDate;   
            $comp->save();

            }

            $form->save();  }

         

            return redirect()->route('assessmentform.view')->with([
            'role' => $role,
            'notifications' => $notifications,  
            'message' => 'Company with area to assess added successfully',
           
        ]);
    }








          public function crosschecklandassessmentForm(Request $request, $id , $asid)
    {

            $role = User::where('id', auth()->user()->id)->with('user_role')->first();
            $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
   
           
 
            $form = landassessmentform::where('id' , $asid)->first();
            $form->company_id = $request['company'];
            $form->area_id = $request['area'];
            $form->status = 2;
            $form->assessment_month = $request['assessmment'];
            $form->work_order_id = $id;
            $form->save();

            $inspectionForm = landworkorders::where('id', $id)->first();
            $inspectionForm->status =4;
            $inspectionForm->save();


        return redirect()->route('workOrder.edit.landscaping', [$id])->with([
            'role' => $role,
            'notifications' => $notifications,  
            'message' => 'Assessment company form successfully updated',
            'wo' => landworkorders::where('id', $id)->first()
        ]);
    }



         public function landassessmentactivityForm(Request $request, $id)
    {

         $role = User::where('id', auth()->user()->id)->with('user_role')->first();
         $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
          
      
            $txtbox = $request['activity'];
            $perce = $request['percentage'];
            $scor = $request['score'];
            $remar = $request['remark'];
            $sum = 0;
  
           foreach($txtbox as $a => $b){
            
             $sum += $perce[$a];
         
            $matr = new landassessmentactivityform();
            $matr->activity = $txtbox[$a] ;
            $matr->percentage = $perce[$a] ;
            $matr->score = $scor[$a] ;
            $matr->remark = $remar[$a] ;
            $matr->assessment_id = $id ;
            $matr->tottal_percent = $sum;
            $matr->status = 1;
            $matr->save();
              }    

            $company = landassessmentform::where('id', $id)->first();
            $company->status =2;
            $company->save();



              if( $sum > 100) {

                return redirect()->back()->withErrors(['message' => 'You have entered the total percentage of '.$sum.' which is greater than 100 please crosscheck again the assessment form for last submission.. ']);

             }

             else {

           


        return redirect()->route('workOrder.edit.landscaping', [$id])->with([
            'role' => $role,
            'notifications' => $notifications,  
            'message' => ' You have entered the correct value successfully please crosscheck the assessment form and submitt again',
            'wo' => landworkorders::where('id', $id)->first()
        ]); }
             }




         public function crosschecklandassessmentactivity(Request $request, $id )
    {

         $role = User::where('id', auth()->user()->id)->with('user_role')->first();
         $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
          
      
            $txtbox = $request['activity'];
            $perce = $request['percentage'];
            $scor = $request['score'];
            $remar = $request['remark'];
            $sum = 0;
            $summ = 0;
  
           foreach($txtbox as $a => $b){
            
             $sum += $perce[$a];
             $summ += $scor[$a];


         
            $matr =new landcrosschecklandassessmentactivity();
            $matr->activity = $txtbox[$a] ;
            $matr->percentage = $perce[$a] ;
            $matr->score = $scor[$a] ;
            $matr->remark = $remar[$a] ;
            $matr->assessment_id = $id ;
            $matr->tottal_percent = $sum;
            $matr->status = 1;
             
            $matr->save(); } 


            $company = landassessmentform::where('id', $id)->first();
            $company->status =3;
            $company->score =  $summ;
            $company->save();

       
        return redirect()->route('workOrder.edit.landscaping', [$id])->with([
            'role' => $role,
            'notifications' => $notifications,  
            'message' => 'Assessment activity form is successfully updated',
            'wo' => landworkorders::where('id', $id)->first()
        ]); 
             }



    public function editedlandassessmentactivity(Request $request, $id )
    {

         $role = User::where('id', auth()->user()->id)->with('user_role')->first();
         $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
          
        

       
           
           

            $txtbox = $request['activity'];
            $perce = $request['percentage'];
            $scor = $request['score'];
            $remar = $request['remark'];
            $sum = 0;
            $summ = 0;
  
           foreach($txtbox as $a => $b){
            
             $sum += $perce[$a];
             $summ += $scor[$a];


              $assessment_edit =landcrosschecklandassessmentactivity::where('assessment_id', $id)->where('status',10)->orwhere('status',11)->orwhere('status',12)->get();
               foreach($assessment_edit as $edit_assessment) {
 
            $matr =landcrosschecklandassessmentactivity::where('id', $edit_assessment->id)->first();
            $matr->activity = $txtbox[$a] ;
            $matr->percentage = $perce[$a] ;
            $matr->score = $scor[$a] ;
            $matr->remark = $remar[$a] ;
            $matr->assessment_id = $id ;
            $matr->payment = $request['payment'];
            $matr->tottal_percent = $sum;
            $matr->status = 1; }
             
            $matr->save(); 

         } 


            $company = landassessmentform::where('id', $id)->first();
            $company->status =6;
            $company->score =  $summ;
            $company->save();

            
              
        return redirect()->route('workOrder.edit.landscaping', [$id])->with([
            'role' => $role,
            'notifications' => $notifications,  
            'message' => 'Assessment activity form is successfully updated',
            'wo' => landworkorders::where('id', $id)->first()
        ]); 
             }







      

    
      public function approveassessment($id)
    {
     $assessment_approve =landcrosschecklandassessmentactivity::where('assessment_id', $id)->where('status',1)->get();

     foreach($assessment_approve as $wo_assessment) {
     $assessment =landcrosschecklandassessmentactivity::where('id', $wo_assessment->id)->first();   
     $assessment->status = 2;
     $assessment->accepted_by = auth()->user()->id;
     $assessment->accepted_on = $assessment->updated_at;
     $assessment->save();
     }


     $company = landassessmentform::where('id', $id)->first();
     $company->status =4;
     $company->save();


     
       return redirect()->back()->with(['message' => 'Assessment form approved succesifully ']);
    }



      public function approveassessmentforpayment($id)
    {
     $assessment_approve =landcrosschecklandassessmentactivity::where('assessment_id', $id)->where('status',2)->get();

     foreach($assessment_approve as $wo_assessment) {
     $assessment =landcrosschecklandassessmentactivity::where('id', $wo_assessment->id)->first();   
     $assessment->status = 3;
     $assessment->approved_by = auth()->user()->id;
     $assessment->approved_on = $assessment->updated_at;
     $assessment->save();
     }


     $company = landassessmentform::where('id', $id)->first();
     $company->status =5;
     $company->save();


         
     
       return redirect()->back()->with(['message' => 'Assessment form for payment approved succesifully ']);
    }



     public function apdatepayment(Request $request,$id)
    {

     $assessment_approve =landcrosschecklandassessmentactivity::where('assessment_id', $id)->where('status',1)->get();

     foreach($assessment_approve as $wo_assessment) {
     $assessment =landcrosschecklandassessmentactivity::where('id', $wo_assessment->id)->first();   
     $assessment->status = 4;
     $assessment->payment_by = auth()->user()->id;
     $assessment->payment_on = $assessment->updated_at;
     $assessment->payment = $request['payment'];
     $assessment->save();
        }



     $company = landassessmentform::where('id', $id)->first();
     $company->status =6;
     $company->save();

       return redirect()->back()->with(['message' => 'Payment appdated succesifully ']);
    }  



    public function rejectassessmentwithreason(Request $request,$id)
    {

     $assessment_approve =landcrosschecklandassessmentactivity::where('assessment_id', $id)->where('status',1)->orwhere('status', 2)->get();

     foreach($assessment_approve as $wo_assessment) {
     $assessment =landcrosschecklandassessmentactivity::where('id', $wo_assessment->id)->first();   
     $assessment->status = 10;
     $assessment->a_rejected_by = auth()->user()->id;
     $assessment->rejected_on = $assessment->updated_at;
     $assessment->reason = $request['reason'];
     $assessment->save();
        }



     $company = landassessmentform::where('id', $id)->first();
     $company->status = 10;
     $company->save();

       return redirect()->back()->with(['message' => 'Assessment rejected succesifully ']);
    }  



        public function rejectassessmentwithreasonestate(Request $request,$id)
    {

     $assessment_approve =landcrosschecklandassessmentactivity::where('assessment_id', $id)->where('status',4)->orwhere('status', 2)->get();

     foreach($assessment_approve as $wo_assessment) {
     $assessment =landcrosschecklandassessmentactivity::where('id', $wo_assessment->id)->first();   
     $assessment->status = 11;
     $assessment->es_rejected_by = auth()->user()->id;
     $assessment->esrejected_on = $assessment->updated_at;
     $assessment->reasonestate = $request['reason'];
     $assessment->save();
        }



     $company = landassessmentform::where('id', $id)->first();
     $company->status = 11;
     $company->save();

       return redirect()->back()->with(['message' => 'Assessment rejected succesifully ']);
    }  


   


        public function rejectassessmentwithreasondvcadmin(Request $request,$id)
    {

     $assessment_approve =landcrosschecklandassessmentactivity::where('assessment_id', $id)->where('status',3)->orwhere('status', 2)->get();

     foreach($assessment_approve as $wo_assessment) {
     $assessment =landcrosschecklandassessmentactivity::where('id', $wo_assessment->id)->first();   
     $assessment->status = 12;
     $assessment->dvc_rejected_by = auth()->user()->id;
     $assessment->dvcrejected_on = $assessment->updated_at;
     $assessment->reasondvc = $request['reason'];
     $assessment->save();
        }



     $company = landassessmentform::where('id', $id)->first();
     $company->status = 12;
     $company->save();

       return redirect()->back()->with(['message' => 'Assessment rejected succesifully ']);
    }  




    




     public function maintainancesection(){

        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();

     return view('Maintainancesection', [
            'role' => $role,
            'notifications' => $notifications,
            'worksec' => landmaintainancesection::OrderBy('section', 'ASC')->get()
        ]);
    }




    public function assessmentformview(){

        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();

     return view('assessmentformview', [
            'role' => $role,
            'notifications' => $notifications,
            'worksec' => landmaintainancesection::OrderBy('section', 'ASC')->get(),
            'assessmmentcompany' => landassessmentform::OrderBy('company_id', 'ASC')->get(),
        ]);
    }



       public function addsection(){
          $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();

        return view('add_maintainancesection', [
            'role' => $role,
            'notifications' => $notifications
           
        ]);


     }


            public function addcompanyforassessment($id ){
          $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $idtoname = company::where('id', $id)->first();

        return view('addcompanyforassessment', [
            'role' => $role,
            'notifications' => $notifications,
            'company' =>company::where('id', $id)->first(),
            'carea' =>companywitharea::where('company_name', $idtoname->company_name)->get()
           
        ]);


     }

         public function createmaintainancesection(Request $request)
    {
        
         if (!empty(landmaintainancesection::where('section',$request['section_name'])->first())){
            return redirect()->back()->withErrors(['message' => 'Maitainance Section already exist']);
        }

        $wsection = new landmaintainancesection();
        $wsection->section = $request['section_name' ];
       
        $wsection->save();

        return redirect()->route('section.maintenance')->with(['message' => 'Maintainance section added successfully']);
    }


        public function deletemaintainanceSection($id)
    {

          $sec=landmaintainancesection::where('id', $id)->first();
        
          $sec->delete();
          
          
          return redirect()->route('section.maintenance')->with(['message' => 'Maintainance section deleted successfully']);
      
    }


         public function trackcompanyview($id){
         $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
         $role = User::where('id', auth()->user()->id)->with('user_role')->first();
         $companywo = landassessmentform::where('company_id' , $id)->get();

            
         return view('trackcompany', [
            'role' => $role,
            'notifications' => $notifications, 'company' => $companywo ]);
         }


          public function companywithmonth(){
         $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
         $role = User::where('id', auth()->user()->id)->with('user_role')->first();
         

         $companyi = landassessmentform::select(DB::raw('assessment_month'))
                    ->groupBy('assessment_month')->get();

            
         return view('company_with_month', [
            'role' => $role,
            'notifications' => $notifications, 'company' => $companyi ]);
         }



        
        public function trackcompanyassessmentview($id){
         $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
         $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        
            
         return view('trackcompanyassessment', [
            'role' => $role,
            'notifications' => $notifications,           
         'assessmmentcompany' => landassessmentform::where('id', $id)->get(),
         'assessmmentactivity' => landcrosschecklandassessmentactivity::where('assessment_id', $id)->get(),
         'crosscheckassessmmentactivity' => landcrosschecklandassessmentactivity::where('assessment_id', $id)->get(),  ]);
         }


         public function companyreport($id){
         $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
         $role = User::where('id', auth()->user()->id)->with('user_role')->first();
               
               return view('companyreport', [
            'role' => $role,
            'notifications' => $notifications,           
         'assessmmentcompany' => landassessmentform::where('assessment_month', $id)->get()
       
        ]);
         }

         public function viewcompanyreport($id){
         $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
         $role = User::where('id', auth()->user()->id)->with('user_role')->first();
               
               return view('viewcompanyreport', [
            'role' => $role,
            'notifications' => $notifications,           
         'assessmmentcompany' => landassessmentform::where('company_id', $id)->select(DB::raw('sum(score) as erick , assessment_month'))
                    ->groupBy('assessment_month')->get()
       
        ]);
         }


         public function companyeditreport($id){
         $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
         $role = User::where('id', auth()->user()->id)->with('user_role')->first();
               
               return view('companyeditreport', [
            'role' => $role,
            'notifications' => $notifications,           
         'assessmmentcompany' => landassessmentform::where('assessment_month', $id)->OrderBy('company_id')->get(),
          
         'companygroup' => landassessmentform::where('assessment_month', $id)->select(DB::raw('sum(score) as erick , count(company_id) as pnd , company_id'))
                    ->groupBy('company_id')->get()

       
        ]);
         }


         public function updatecomments(request $request , $id){
               $commentall = landassessmentform::where('assessment_month', $id)->get();
               foreach ($commentall as $comm) {
                   
               
                  $comment = landassessmentform::where('id', $comm->id)->first();
                  $comment->comment = $request['comment'];
                  $comment->assessor = auth()->user()->id;
                  $comment->status2 = 1;
                  $comment->save(); }

           return  redirect()->back()->with(['message'=>'Comment updated succesifully']);
         }


        public function fowardtodvc($id){
               $commentall = landassessmentform::where('assessment_month', $id)->get();
               foreach ($commentall as $comm) {
                   
               
                  $comment = landassessmentform::where('id', $comm->id)->first();
                 
                  $comment->status2 = 2;
                  $comment->save(); }

           return  redirect()->back()->with(['message'=>'Monthly company report sent successiully to DVC admin']);
         }


       



          
 
}

