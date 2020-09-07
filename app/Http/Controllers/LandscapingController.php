<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
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
use App\assessmentsheet;
use App\landassessmentbeforesignature;



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


      public function editwolandscaping($id ,  $company , $month)
    {
        $company = Crypt::decrypt($company);
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();


        return view('edit_work_order_landscaping', [

            'notifications' => $notifications,

            'role' => $role,

            'company' =>company::all(),
            'carea' =>cleaningarea::all(),

            'assessmmentcompany' => landassessmentform::where('id', $id)->get(),
             'assessmmentcompanyname' => landassessmentform::where('company', $company)->where('assessment_month', $month)->get(),




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





         public function landassessmentForm(Request $request , $id , $comp , $date , $status , $nextmonth)
    {
           $comp = Crypt::decrypt($comp);

            $role = User::where('id', auth()->user()->id)->with('user_role')->first();
            $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
            $tenderfetch = company::where('tender', $comp)->get();



            $areas = $request['area'];
            $sheet = $request['sheet'];
            $tenders = $request['tendernumber'];

             foreach($areas as $a => $b){

       $checkforempty = landassessmentform::where('company', $tenders[$a])->where('area_id', $areas[$a])->where('company_id', $id)->where('assessment_month', $request['assessmment'])->first();

       if (empty($checkforempty)) {


            $form = new landassessmentform();
            $form->area_id = $areas[$a];
            $form->company_id = $id;
            $form->company = $tenders[$a];
            $form->assessment_name = $sheet[$a];
            $form->status =  1;
            $form->assessment_month = $request['assessmment'];

            $monthh = strtotime($form->assessment_month );
            $lessmonthh = date("Y-m", strtotime("+1 month",  $monthh));

            $form->lessmonth = $lessmonthh;
            $form->startdate = $date;
            $form->enddate = $nextmonth;



             foreach ($tenderfetch as $tender) {


                 if ($status == 1) {

           $comp = company::where('id',  $tender->id)->first();

            $ddate = strtotime($nextmonth);
            $newDate = date("Y-m-d", strtotime("+1 month", $ddate));

            $comp->nextmonth = $newDate;
             $comp->status =  1 ;
            $comp->save();



            }

            else{

           $comp = company::where('id',  $tender->id)->first();
            $comp->status =  1 ;
            $ddate = strtotime($date);
            $newDate = date("Y-m-d", strtotime("+2 month", $ddate));

            $comp->nextmonth = $newDate;
            $comp->save();

            }




            $comp->save(); }

            $form->save();
              }
                   else {

        return redirect()->back()->withErrors(['message' => 'The selected month already exists please select another month']);
       }


             }



            return redirect()->route('assessmentform.view')->with([
            'role' => $role,
            'notifications' => $notifications,
            'message' => 'Area for assessment added successfully',

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



         public function landassessmentactivityForm(Request $request, $id , $companys )
    {
         $companysd = Crypt::decrypt($companys);
         $role = User::where('id', auth()->user()->id)->with('user_role')->first();
         $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();




            $score = $request['score'];
            $remark = $request['remark'];
            $sheet = $request['assessment_sheet'];
            $area = $request['area'];
            $activity = $request['activity'];
            $percentage = $request['percentage'];


           foreach($score as $a => $b){


            $matr = new landassessmentbeforesignature();

            $matr->activity = $activity[$a];
            $matr->percentage = $percentage[$a];
            $matr->score = $score[$a];
            $matr->remark = $remark[$a];
            $matr->assessment_id = $id ;
            $matr->assessment_sheet = $sheet[$a] ;
            $matr->area = $area[$a] ;
            $matr->month = $request['assessmment'];
            $matr->companynew = $companysd;

            $matr->status = 1;
            $matr->save();
            }




        return redirect()->back()->with([
            'role' => $role,
            'notifications' => $notifications,
            'message' => 'Please crosscheck the assessment form and submitt again',
            'wo' => landworkorders::where('id', $id)->first()
        ]);
    }




        public function editassessmentsheet(Request $request, $id)
    {

         $role = User::where('id', auth()->user()->id)->with('user_role')->first();
         $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();


            $activityi = $request['activity'];
            $percent = $request['percentage'];


           foreach($activityi as $a => $b){

           $assessment_edit = assessmentsheet::where('name', $id)->get();

               foreach($assessment_edit as $edit_assessment) {

            $matr = assessmentsheet::where('name', $edit_assessment->name)->first();
            $matr->activity = $activityi[$a] ;
            $matr->percentage = $percent[$a] ;   }

            $matr->save();
             }



        return redirect()->back()->with([
            'role' => $role,
            'notifications' => $notifications,
            'message' => ' Assessment sheet edited successifully'

        ]);
             }



           public function editassessmentsheetproceeding(Request $request, $id , $type)
    {

         $role = User::where('id', auth()->user()->id)->with('user_role')->first();
         $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();


            $activityi = $request['activity'];
            $percent = $request['percentage'];


           foreach($activityi as $a => $b){

            $matr = new assessmentsheet();
            $matr->name = $id;
            $matr->type = $type;
            $matr->status = 1;
            $matr->activity = $activityi[$a] ;
            $matr->percentage = $percent[$a] ;

            $matr->save();
             }



        return redirect()->back()->with([
            'role' => $role,
            'notifications' => $notifications,
            'message' => ' Assessment sheet updated successifully'

        ]);
             }




           public function editassessmentsheetproceedingtwo(Request $request, $id , $type)
    {

         $role = User::where('id', auth()->user()->id)->with('user_role')->first();
         $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();


            $activityi = $request['activity'];
            $percent = $request['percentage'];


           foreach($activityi as $a => $b){

            $matr = new assessmentsheet();
            $matr->name = $id;
            $matr->type = $type;
            $matr->status = 2;
            $matr->activity = $activityi[$a] ;
            $matr->percentage = $percent[$a] ;

            $matr->save();
             }



        return redirect()->back()->with([
            'role' => $role,
            'notifications' => $notifications,
            'message' => ' Assessment sheet updated successifully'

        ]);
             }




           public function finalsave_sheet($name)
    {

         $role = User::where('id', auth()->user()->id)->with('user_role')->first();
         $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();


         $finalsave = assessmentsheet::where('name', $name)->get();

           foreach($finalsave as $final){

            $matr = assessmentsheet::where('id',$final->id)->first();

            $matr->status = 2;

            $matr->save();
             }



        return redirect()->route('assessment_sheet')->with([
            'role' => $role,
            'notifications' => $notifications,
            'message' => ' Assessment sheet updated successifully'

        ]);
             }







      public function deleteassessmentsheet($id , $name)
       {
           $checkforemptysheet=assessmentsheet::where('name', $name)->get();

            if (count($checkforemptysheet) == 1) {

           $cleanareaa=assessmentsheet::where('id', $id)->first();
           $cleanareaa->delete();


           return redirect()->route('add_new_sheet')->with(['message' => 'Respective assesment sheet deleted successfully']);
          }

          else {

        $cleanareaa=assessmentsheet::where('id', $id)->first();
        $cleanareaa->delete();


        return redirect()->back()->with(['message' => 'Respective activity and percentage successfully']);

       }

     }


            public function editassessmentsheeeet(Request $request)
    {
           $p=$request['activity_id'];
           $company = assessmentsheet::where('id',$p)->first();
           $company->activity = $request['activity'];
           $company->percentage = $request['percentage'];
           $company->save();

        return redirect()->back()->with(['message' => 'Assessment sheet edited successfully']);
    }







  public function supervisorsatisfied(Request $request, $id , $company ,$sheet , $month  )
    {
         $company = Crypt::decrypt($company);
         $role = User::where('id', auth()->user()->id)->with('user_role')->first();
         $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();






            $satisfied = landassessmentactivityform::where('assessment_id', $id)->where('companynew',$company)->where('assessment_sheet' , $sheet)->where('month' , $month)->get();

            foreach ($satisfied as  $sat) {

              $satify = landassessmentactivityform::where('id', $sat->id)->first();

            $satify->status2 = 2;

            $satify->save();

              }



        return redirect()->back()->with([
            'role' => $role,
            'notifications' => $notifications,
            'message' => 'Assessment activity form is successfully updated also Company supevisor is satisfied with the scores given.  ',

        ]);
             }






  public function crosschecklandassessmentactivityforsignature(Request $request, $id , $type , $company ,$date ,$status , $nextmonth )
    {
         $company = Crypt::decrypt($company);
         $role = User::where('id', auth()->user()->id)->with('user_role')->first();
         $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();


            $txtbox = $request['activity'];
            $perce = $request['percentage'];
            $scor = $request['score'];
            $remar = $request['remark'];
            $assessment = $request['assessment_sheet'];
            $area = $request['area'];

            $sum = 0;
            $summ = 0;
                       $summm = 0;

           foreach($txtbox as $a => $b){

             $sum += $perce[$a];
             $summ += $scor[$a];



            $matr =new landassessmentactivityform();
            $matr->activity = $txtbox[$a] ;
            $matr->percentage = $perce[$a] ;
            $matr->score = $scor[$a] ;
            $matr->remark = $remar[$a] ;
            $matr->assessment_sheet = $assessment[$a] ;
            $matr->area = $area[$a] ;
            $matr->month = $request['assessmment'];

            $matr->companynew = $company ;
            $matr->assessment_id = $id ;
          //  $matr->tottal_percent = $sum;
           // $matr->initiated_by = auth()->user()->id;

           // $matr->tottal_score = $summ;
            $matr->status = 1;

            $matr->save(); }




        return redirect()->back()->with([
            'role' => $role,
            'notifications' => $notifications,
            'message' => 'Assessment activity form is successfully created , please print out the document so as company supervisor to sign and proceed with the further steps',
            'wo' => landworkorders::where('id', $id)->first()
        ]);
             }







         public function crosschecklandassessmentactivitysupervisor(Request $request, $id , $type , $company ,$date ,$status , $nextmonth )
    {
         $company = Crypt::decrypt($company);
         $role = User::where('id', auth()->user()->id)->with('user_role')->first();
         $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();

      //forfirstadding month
         $tenderfetch = company::where('tender', $company)->get();



            $areas = $request['myarea'];
            $sheet = $request['mysheet'];
            $tenders = $request['mytender'];
            $paymentss = $request['payments'];


             foreach($areas as $a => $b){

       $checkforempty = landassessmentform::where('company', $tenders[$a])->where('area_id', $areas[$a])->where('company_id', $id)->where('assessment_month', $request['assessmment'])->where('status','<>',1)->first();

       if (empty($checkforempty)) {


            $form = new landassessmentform();

            $form->area_id = $areas[$a];
            $form->company_id = $id;
            $form->company = $tenders[$a];
            $form->paymentone = $paymentss[$a];
            $form->assessment_name = $sheet[$a];

            $form->type = $type;

            $form->status =  1;
            $form->assessment_month = $request['assessmment'];

            $monthh = strtotime($form->assessment_month );
            $lessmonthh = date("Y-m", strtotime("+1 month",  $monthh));

            $form->lessmonth = $lessmonthh;
            $form->startdate = $date;
            $form->enddate = $nextmonth;



             foreach ($tenderfetch as $tender) {


                 if ($status == 1) {

           $comp = company::where('id',  $tender->id)->first();

            $ddate = strtotime($nextmonth);
            $newDate = date("Y-m-d", strtotime("+1 month", $ddate));

            $comp->nextmonth = $newDate;
             $comp->status =  1 ;
            $comp->save();



            }

            else{

           $comp = company::where('id',  $tender->id)->first();
            $comp->status =  1 ;
            $ddate = strtotime($date);
            $newDate = date("Y-m-d", strtotime("+2 month", $ddate));

            $comp->nextmonth = $newDate;
            $comp->save();

            }




            $comp->save(); }

            $form->save();
              }
                   else {

        return redirect()->back()->withErrors(['message' => 'The selected month already exists please select another month']);
       }


             }

    //endaddingmonth
            $txtbox = $request['activity'];
            $perce = $request['percentage'];
            $scor = $request['score'];
            $remar = $request['remark'];
            $assessment = $request['assessment_sheet'];
            $area = $request['area'];
            $areas = $request['areaid'];

            $sum = 0;
            $summ = 0;
                       $summm = 0;

           foreach($txtbox as $a => $b){

             $sum += $perce[$a];
             $summ += $scor[$a];



            $matr = new landcrosschecklandassessmentactivity();


            $matr->activity = $txtbox[$a] ;
            $matr->percentage = $perce[$a] ;
            $matr->score = $scor[$a] ;
            $matr->remark = $remar[$a] ;
            $matr->assessment_sheet = $assessment[$a] ;
            $matr->area = $area[$a] ;
            $matr->month = $request['assessmment'];
            $matr->area_id = $areas[$a] ;
            $matr->company = $company ;
            $matr->assessment_id = $id ;
            $matr->tottal_percent = $sum;
            $matr->initiated_by = auth()->user()->id;

           // $matr->tottal_score = $summ;
            $matr->status = 1;

            $matr->save(); }




           $erick =landassessmentform::where('company', $company)->get();

           foreach($erick as $asympt) {
           $pndo =landassessmentform::where('id', $asympt->id)->first();
           $pndo->status = 3;
           $pndo->save();
            }



           $erick =landassessmentactivityform::where('companynew', $company)->get();

           foreach($erick as $asympt) {
           $pndo =landassessmentactivityform::where('id', $asympt->id)->first();
           $pndo->status = 2;
           $pndo->save();
            }



        return redirect()->route('assessmentform.view')->with([
            'role' => $role,
            'notifications' => $notifications,
            'message' => 'Assessment activity form is successfully created',
            'wo' => landworkorders::where('id', $id)->first()
        ]);
             }







         public function crosschecklandassessmentactivityusab(Request $request, $id , $type , $company ,$date ,$status , $nextmonth )
    {
         $company = Crypt::decrypt($company);
         $role = User::where('id', auth()->user()->id)->with('user_role')->first();
         $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();

      //forfirstadding month
         $tenderfetch = company::where('tender', $company)->get();



            $areas = $request['myarea'];
            $sheet = $request['mysheet'];
            $tenders = $request['mytender'];
            $paymentss = $request['payments'];


             foreach($areas as $a => $b){

       $checkforempty = landassessmentform::where('company', $tenders[$a])->where('area_id', $areas[$a])->where('company_id', $id)->where('assessment_month', $request['assessmment'])->where('status','<>',1)->first();

       if (empty($checkforempty)) {


            $form = new landassessmentform();

            $form->area_id = $areas[$a];
            $form->company_id = $id;
            $form->company = $tenders[$a];
            $form->paymentone = $paymentss[$a];
            $form->assessment_name = $sheet[$a];

            $form->type = $type;

            $form->status =  1;
            $form->status5 =  2;
            $form->assessment_month = $request['assessmment'];

            $monthh = strtotime($form->assessment_month );
            $lessmonthh = date("Y-m", strtotime("+1 month",  $monthh));

            $form->lessmonth = $lessmonthh;
            $form->startdate = $date;
            $form->enddate = $nextmonth;



             foreach ($tenderfetch as $tender) {


                 if ($status == 1) {

           $comp = company::where('id',  $tender->id)->first();

            $ddate = strtotime($nextmonth);
            $newDate = date("Y-m-d", strtotime("+1 month", $ddate));

            $comp->nextmonth = $newDate;
             $comp->status =  1 ;
            $comp->save();



            }

            else{

           $comp = company::where('id',  $tender->id)->first();
            $comp->status =  1 ;
            $ddate = strtotime($date);
            $newDate = date("Y-m-d", strtotime("+2 month", $ddate));

            $comp->nextmonth = $newDate;
            $comp->save();

            }




            $comp->save(); }

            $form->save();
              }
                   else {

        return redirect()->back()->withErrors(['message' => 'The selected month already exists please select another month']);
       }


             }

    //endaddingmonth
            $txtbox = $request['activity'];
            $perce = $request['percentage'];
            $scor = $request['score'];
            $remar = $request['remark'];
            $assessment = $request['assessment_sheet'];
            $area = $request['area'];
            $areas = $request['areaid'];

            $sum = 0;
            $summ = 0;
                       $summm = 0;

           foreach($txtbox as $a => $b){

             $sum += $perce[$a];
             $summ += $scor[$a];



            $matr = new landcrosschecklandassessmentactivity();


            $matr->activity = $txtbox[$a] ;
            $matr->percentage = $perce[$a] ;
            $matr->score = $scor[$a] ;
            $matr->remark = $remar[$a] ;
            $matr->assessment_sheet = $assessment[$a] ;
            $matr->area = $area[$a] ;
            $matr->month = $request['assessmment'];
            $matr->area_id = $areas[$a] ;
            $matr->company = $company ;
            $matr->assessment_id = $id ;
            $matr->tottal_percent = $sum;
            $matr->initiated_by = auth()->user()->id;

           // $matr->tottal_score = $summ;
            $matr->status = 1;

            $matr->save(); }




           $erick =landassessmentform::where('company', $company)->get();

           foreach($erick as $asympt) {
           $pndo =landassessmentform::where('id', $asympt->id)->first();
           $pndo->status = 3;
           $pndo->save();
            }



           $erick =landassessmentactivityform::where('companynew', $company)->get();

           foreach($erick as $asympt) {
           $pndo =landassessmentactivityform::where('id', $asympt->id)->first();
           $pndo->status = 2;
           $pndo->save();
            }



        return redirect()->route('assessmentform.view')->with([
            'role' => $role,
            'notifications' => $notifications,
            'message' => 'Assessment activity form is successfully created',
            'wo' => landworkorders::where('id', $id)->first()
        ]);
             }







         public function crosschecklandassessmentactivityadofficer(Request $request, $id , $type , $company ,$date ,$status , $nextmonth )
    {
         $company = Crypt::decrypt($company);
         $role = User::where('id', auth()->user()->id)->with('user_role')->first();
         $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();

      //forfirstadding month
         $tenderfetch = company::where('tender', $company)->get();



            $areas = $request['myarea'];
            $sheet = $request['mysheet'];
            $tenders = $request['mytender'];
            $paymentss = $request['payments'];
            $colleg = $request['college'];


             foreach($areas as $a => $b){

       $checkforempty = landassessmentform::where('company', $tenders[$a])->where('area_id', $areas[$a])->where('company_id', $id)->where('assessment_month', $request['assessmment'])->where('status','<>',1)->first();

       if (empty($checkforempty)) {


            $form = new landassessmentform();

            $form->area_id = $areas[$a];
            $form->college = $colleg[$a];
            $form->company_id = $id;
            $form->company = $tenders[$a];
            $form->paymentone = $paymentss[$a];
            $form->assessment_name = $sheet[$a];

            $form->type = $type;

            $form->status =  1;
            $form->status5 =  3;
            $form->assessment_month = $request['assessmment'];

            $monthh = strtotime($form->assessment_month );
            $lessmonthh = date("Y-m", strtotime("+1 month",  $monthh));

            $form->lessmonth = $lessmonthh;
            $form->startdate = $date;
            $form->enddate = $nextmonth;



             foreach ($tenderfetch as $tender) {


                 if ($status == 1) {

           $comp = company::where('id',  $tender->id)->first();

            $ddate = strtotime($nextmonth);
            $newDate = date("Y-m-d", strtotime("+1 month", $ddate));

            $comp->nextmonth = $newDate;
             $comp->status =  1 ;
            $comp->save();



            }

            else{

           $comp = company::where('id',  $tender->id)->first();
            $comp->status =  1 ;
            $ddate = strtotime($date);
            $newDate = date("Y-m-d", strtotime("+2 month", $ddate));

            $comp->nextmonth = $newDate;
            $comp->save();

            }




            $comp->save(); }

            $form->save();
              }
                   else {

        return redirect()->back()->withErrors(['message' => 'The selected month already exists please select another month']);
       }


             }

    //endaddingmonth
            $txtbox = $request['activity'];
            $perce = $request['percentage'];
            $scor = $request['score'];
            $remar = $request['remark'];
            $assessment = $request['assessment_sheet'];
            $area = $request['area'];
            $areas = $request['areaid'];

            $sum = 0;
            $summ = 0;
                       $summm = 0;

           foreach($txtbox as $a => $b){

             $sum += $perce[$a];
             $summ += $scor[$a];



            $matr = new landcrosschecklandassessmentactivity();


            $matr->activity = $txtbox[$a] ;
            $matr->percentage = $perce[$a] ;
            $matr->score = $scor[$a] ;
            $matr->remark = $remar[$a] ;
            $matr->assessment_sheet = $assessment[$a] ;
            $matr->area = $area[$a] ;
            $matr->month = $request['assessmment'];
            $matr->area_id = $areas[$a] ;
            $matr->company = $company ;
            $matr->assessment_id = $id ;
            $matr->tottal_percent = $sum;
            $matr->initiated_by = auth()->user()->id;

           // $matr->tottal_score = $summ;
            $matr->status = 1;
             $matr->status2 = 3;

            $matr->save(); }




           $erick =landassessmentform::where('company', $company)->get();

           foreach($erick as $asympt) {
           $pndo =landassessmentform::where('id', $asympt->id)->first();
           $pndo->status = 3;
           $pndo->save();
            }



           $erick =landassessmentactivityform::where('companynew', $company)->get();

           foreach($erick as $asympt) {
           $pndo =landassessmentactivityform::where('id', $asympt->id)->first();
           $pndo->status = 2;
           $pndo->save();
            }



        return redirect()->route('assessmentform.view')->with([
            'role' => $role,
            'notifications' => $notifications,
            'message' => 'Assessment activity form is successfully created',
            'wo' => landworkorders::where('id', $id)->first()
        ]);
             }










         public function crosschecklandassessmentactivitysecond(Request $request, $id , $company ,$month )
    {
         $company = Crypt::decrypt($company);
         $role = User::where('id', auth()->user()->id)->with('user_role')->first();
         $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();


            $txtbox = $request['activity'];
            $perce = $request['percentage'];
            $scor = $request['score'];
            $remar = $request['remark'];
            $assessment = $request['assessment_sheet'];
            $area = $request['area'];
            $areas = $request['areaid'];
            $sum = 0;
            $summ = 0;
                       $summm = 0;

           foreach($txtbox as $a => $b){

             $sum += $perce[$a];
             $summ += $scor[$a];



            $matr =new landcrosschecklandassessmentactivity();
            $matr->activity = $txtbox[$a] ;
            $matr->percentage = $perce[$a] ;
            $matr->score = $scor[$a] ;
            $matr->remark = $remar[$a] ;
            $matr->assessment_sheet = $assessment[$a] ;
            $matr->area = $area[$a] ;
            $matr->month = $request['assessment'];
            $matr->area_id = $areas[$a] ;
            $matr->company = $company ;
            $matr->assessment_id = $id ;
            $matr->tottal_percent = $sum;
           // $matr->tottal_score = $summ;
            $matr->status = 1;

            $matr->save(); }




           $erick =landassessmentform::where('company', $company)->where('assessment_month',$month)->get();

           foreach($erick as $asympt) {
           $pndo =landassessmentform::where('id', $asympt->id)->first();
           $pndo->status = 3;
           $pndo->save();
            }



           $erick =landassessmentactivityform::where('companynew', $company)->where('assessment_month',$month)->get();

           foreach($erick as $asympt) {
           $pndo =landassessmentactivityform::where('id', $asympt->id)->first();
           $pndo->status = 2;
           $pndo->save();
            }



        return redirect()->route('assessmentform.view')->with([
            'role' => $role,
            'notifications' => $notifications,
            'message' => 'Assessment activity form is successfully created',
            'wo' => landworkorders::where('id', $id)->first()
        ]);
             }




    public function editedlandassessmentactivity(Request $request, $id, $tender , $month)
    {


         $tender = Crypt::decrypt($tender);
         $role = User::where('id', auth()->user()->id)->with('user_role')->first();
         $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();


            $txtbox = $request['activity'];
            $perce = $request['percentage'];
            $scor = $request['score'];
            $remar = $request['remark'];
            $assessment = $request['assessment_sheet'];
            $area = $request['area'];
            $areas = $request['areaid'];
            $sum = 0;
            $summ = 0;
            $erick = 0;

           foreach($txtbox as $a => $b){

             $sum += $perce[$a];
             $summ += $scor[$a];


              $assessment_edit =landcrosschecklandassessmentactivity::where('month', $month)->where('company', $tender)->where('assessment_id', $id)->where('status',10)->orwhere('status',11)->orwhere('status',12)->orwhere('status',30)->get();
               foreach($assessment_edit as $edit_assessment) {

            $matr =landcrosschecklandassessmentactivity::where('id', $edit_assessment->id)->first();
            $matr->activity = $txtbox[$a] ;
            $matr->percentage = $perce[$a] ;
            $matr->score = $scor[$a] ;
            $matr->remark = $remar[$a] ;
            $matr->area = $area[$a] ;
            $matr->area_id = $areas[$a] ;
            $matr->assessment_sheet = $assessment[$a] ;
            $matr->tottal_percent = $sum;
             $erick = $summ;
            //$matr->tottal_score = $erick;
            $matr->status = 1; }

            $matr->save();

         }



             $erick =landassessmentform::where('company', $tender)->where('assessment_month', $month)->get();

           foreach($erick as $asympt) {
           $pndo =landassessmentform::where('id', $asympt->id)->first();
           $pndo->status = 6;
           $pndo->score =  $summ;
           $pndo->save();
            }


        return redirect()->back()->with([
            'role' => $role,
            'notifications' => $notifications,
            'message' => 'Assessment activity form is successfully edited and updated',
            'wo' => landworkorders::where('id', $id)->first()
        ]);
             }





      public function approveassessment($id , $tender , $month)
    {

     $tenders = Crypt::decrypt($tender);
     $assessment_approve =landcrosschecklandassessmentactivity::where('assessment_id', $id)->where('status',1)->get();

     foreach($assessment_approve as $wo_assessment) {
     $assessment =landcrosschecklandassessmentactivity::where('id', $wo_assessment->id)->first();
     $assessment->status = 2;
     $assessment->accepted_by = auth()->user()->id;
     $assessment->accepted_on =Carbon::now();
     $assessment->save();
     }



           $erick =landassessmentform::where('company', $tenders)->where('assessment_month', $month)->get();
           foreach($erick as $asympt) {
           $pndo =landassessmentform::where('id', $asympt->id)->first();
           $pndo->status = 4;
           $pndo->save();
            }


       return redirect()->back()->with(['message' => 'Assessment form approved succesifully ']);
    }





      public function approveassessmentdean($id , $tender , $month)
    {

     $tenders = Crypt::decrypt($tender);
     $assessment_approve =landcrosschecklandassessmentactivity::where('assessment_id', $id)->where('status',1)->get();

     foreach($assessment_approve as $wo_assessment) {
     $assessment =landcrosschecklandassessmentactivity::where('id', $wo_assessment->id)->first();
     $assessment->status = 1;
     $assessment->status2 = 2;
     $assessment->dean = auth()->user()->id;
     $assessment->dean_date = Carbon::now();
     $assessment->save();
     }



           $erick =landassessmentform::where('company', $tenders)->where('assessment_month', $month)->get();
           foreach($erick as $asympt) {
           $pndo =landassessmentform::where('id', $asympt->id)->first();
           $pndo->status = 3;
           $pndo->status5 = 1;
           $pndo->status6 = 2;
           $pndo->save();
            }


       return redirect()->back()->with(['message' => 'Assessment form approved succesifully ']);
    }



          public function approveassessmentprinciple($id , $tender , $month)
    {

     $tenders = Crypt::decrypt($tender);
     $assessment_approve =landcrosschecklandassessmentactivity::where('assessment_id', $id)->where('status',1)->get();

     foreach($assessment_approve as $wo_assessment) {
     $assessment =landcrosschecklandassessmentactivity::where('id', $wo_assessment->id)->first();
     $assessment->status = 1;
     $assessment->status2 = 4;
     $assessment->principle = auth()->user()->id;
     $assessment->principle_date = Carbon::now();
     $assessment->save();
     }



           $erick =landassessmentform::where('company', $tenders)->where('assessment_month', $month)->get();
           foreach($erick as $asympt) {
           $pndo =landassessmentform::where('id', $asympt->id)->first();
           $pndo->status = 3;
           $pndo->status5 = 1;
           $pndo->status6 = 3;
           $pndo->save();
            }


       return redirect()->back()->with(['message' => 'Assessment form approved succesifully ']);
    }





      public function approveassessmentforpayment($id , $tender ,$month)
    {
     $tender = Crypt::decrypt($tender);
     $assessment_approve =landcrosschecklandassessmentactivity::where('assessment_id', $id)->where('status',2)->get();

     foreach($assessment_approve as $wo_assessment) {
     $assessment =landcrosschecklandassessmentactivity::where('id', $wo_assessment->id)->first();
     $assessment->status = 3;
     $assessment->approved_by = auth()->user()->id;
     $assessment->approved_on = Carbon::now();
     $assessment->save();
     }


           $erick =landassessmentform::where('company', $tender)->where('assessment_month', $month)->get();
           foreach($erick as $asympt) {
           $pndo =landassessmentform::where('id', $asympt->id)->first();
           $pndo->status = 5;
           $pndo->save();
            }




       return redirect()->back()->with(['message' => 'Assessment form approved succesifully ']);
    }




      public function approveassessmentifpaid($id , $tender , $month)
    {
     $tender = Crypt::decrypt($tender);
     $assessment_approve =landcrosschecklandassessmentactivity::where('assessment_id', $id)->where('status',3)->get();

     foreach($assessment_approve as $wo_assessment) {
     $assessment =landcrosschecklandassessmentactivity::where('id', $wo_assessment->id)->first();
     $assessment->status = 5;
     $assessment->payment_by = auth()->user()->id;
     $assessment->payment_on = Carbon::now();
     $assessment->save();
     }


           $erick =landassessmentform::where('company', $tender)->where('assessment_month', $month)->get();
           foreach($erick as $asympt) {
           $pndo =landassessmentform::where('id', $asympt->id)->first();
           $pndo->status = 25;
           $pndo->save();
            }




       return redirect()->back()->with(['message' => 'Assessment for payment updated succesifully ']);
    }




      public function approveassessmentformbydvc($id , $tender , $month)
    {
     $tender = Crypt::decrypt($tender);
     $assessment_approve =landcrosschecklandassessmentactivity::where('assessment_id', $id)->where('status',3)->get();

     foreach($assessment_approve as $wo_assessment) {
     $assessment =landcrosschecklandassessmentactivity::where('id', $wo_assessment->id)->first();
     $assessment->status = 4;
     $assessment->dvc_accepted_by = auth()->user()->id;
     $assessment->dvaccepted_on = Carbon::now();
     $assessment->save();
     }


           $erick =landassessmentform::where('company', $tender)->where('assessment_month', $month)->get();
           foreach($erick as $asympt) {
           $pndo =landassessmentform::where('id', $asympt->id)->first();
           $pndo->status = 13;
           $pndo->save();
            }




       return redirect()->back()->with(['message' => 'Assessment form approved succesifully ']);
    }



     public function apdatepayment(Request $request,$id)
    {

     $assessment_approve =landcrosschecklandassessmentactivity::where('assessment_id', $id)->where('status',1)->get();

     foreach($assessment_approve as $wo_assessment) {
     $assessment =landcrosschecklandassessmentactivity::where('id', $wo_assessment->id)->first();
     $assessment->status = 4;
     $assessment->payment_by = auth()->user()->id;
     $assessment->payment_on = Carbon::now();
     $assessment->payment = $request['payment'];
     $assessment->save();
        }



     $company = landassessmentform::where('id', $id)->first();
     $company->status =6;
     $company->save();

       return redirect()->back()->with(['message' => 'Payment appdated succesifully ']);
    }



    public function rejectassessmentwithreason(Request $request , $id , $tender , $month)
    {
      $tender = Crypt::decrypt($tender);
     $assessment_approve =landcrosschecklandassessmentactivity::where('assessment_id', $id)->where('status',1)->orwhere('status', 2)->get();

     foreach($assessment_approve as $wo_assessment) {
     $assessment =landcrosschecklandassessmentactivity::where('id', $wo_assessment->id)->first();
     $assessment->status = 10;
     $assessment->a_rejected_by = auth()->user()->id;
     $assessment->rejected_on = Carbon::now();
     $assessment->reason = $request['reason'];
     $assessment->save();
        }

     $erick =landassessmentform::where('company', $tender)->where('assessment_month', $month)->get();
     foreach($erick as $asympt) {
     $pndo =landassessmentform::where('id', $asympt->id)->first();
     $pndo->status = 10;
     $pndo->save();
            }





       return redirect()->back()->with(['message' => 'Assessment rejected succesifully ']);
    }



        public function rejectassessmentwithreasonestate(Request $request,$id , $tender , $month)
    {

      $tender = Crypt::decrypt($tender);
     $assessment_approve =landcrosschecklandassessmentactivity::where('assessment_id', $id)->where('status',4)->orwhere('status', 2)->get();

     foreach($assessment_approve as $wo_assessment) {
     $assessment =landcrosschecklandassessmentactivity::where('id', $wo_assessment->id)->first();
     $assessment->status = 11;
     $assessment->es_rejected_by = auth()->user()->id;
     $assessment->esrejected_on = Carbon::now();
     $assessment->reasonestate = $request['reason'];
     $assessment->save();
        }


     $erick =landassessmentform::where('company', $tender)->where('assessment_month', $month)->get();
     foreach($erick as $asympt) {
     $pndo =landassessmentform::where('id', $asympt->id)->first();
     $pndo->status = 11;
     $pndo->save();
            }

       return redirect()->back()->with(['message' => 'Assessment rejected succesifully ']);
    }






        public function rejectassessmentwithreasondean(Request $request, $id , $tender , $month)
    {

     $tender = Crypt::decrypt($tender);
     $assessment_approve =landcrosschecklandassessmentactivity::where('assessment_id', $id)->where('status',1)->orwhere('status', 2)->get();

     foreach($assessment_approve as $wo_assessment) {
     $assessment =landcrosschecklandassessmentactivity::where('id', $wo_assessment->id)->first();
     $assessment->status = 12;
     $assessment->dvc_rejected_by = auth()->user()->id;
     $assessment->dvcrejected_on = Carbon::now();
     $assessment->reasondvc = $request['reason'];
     $assessment->save();
        }



     $erick =landassessmentform::where('company', $tender)->where('assessment_month', $month)->get();
     foreach($erick as $asympt) {
     $pndo =landassessmentform::where('id', $asympt->id)->first();
     $pndo->status = 12;
     $pndo->save();
            }

       return redirect()->back()->with(['message' => 'Assessment form rejected succesifully ']);
    }





        public function rejectassessmentwithreasondeanonly(Request $request, $id , $tender , $month)
    {

     $tender = Crypt::decrypt($tender);
     $assessment_approve =landcrosschecklandassessmentactivity::where('assessment_id', $id)->where('status',1)->orwhere('status', 2)->get();

     foreach($assessment_approve as $wo_assessment) {
     $assessment =landcrosschecklandassessmentactivity::where('id', $wo_assessment->id)->first();
     $assessment->status = 30;
     $assessment->dean_rejected_by = auth()->user()->id;
     $assessment->deanrejected_on = Carbon::now();
     $assessment->reasondean = $request['reason'];
     $assessment->save();
        }



     $erick =landassessmentform::where('company', $tender)->where('assessment_month', $month)->get();
     foreach($erick as $asympt) {
     $pndo =landassessmentform::where('id', $asympt->id)->first();
     $pndo->status = 30;
     $pndo->save();
            }

       return redirect()->back()->with(['message' => 'Assessment form rejected succesifully ']);
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
    if(request()->has('start'))  { //date filter


        $from=request('start');
        $to=request('end');


        $nextday = date("Y-m-d", strtotime("$to +1 day"));

        $to=$nextday;
        if(request('start')>request('end')){
            $to=request('start');
        $from=request('end');
        }// start> end



                 return view('assessmentformview', [
            'role' => $role,
            'notifications' => $notifications,
             'type' => landassessmentform::select(DB::raw('type'))
                    ->groupBy('type')->get(),

           'assessmmentsheet' => landassessmentform::select(DB::raw('assessment_name'))
                    ->groupBy('assessment_name')->get(),


           'assessmmentcompanygr' => landassessmentform::select(DB::raw('company_id'))
                    ->groupBy('company_id')->get(),

            'assessmmenttender' => landassessmentform::select(DB::raw('company'))
                    ->groupBy('company')->get(),

            'assessmmentareass' => landassessmentform::select(DB::raw('area_id'))
                    ->groupBy('area_id')->get(),


            'assessmmentcompanylandscaping' => landassessmentform::whereBetween('created_at', [$from, $to])->where('type', 'Exterior')->OrderBy('created_at', 'DESC')->get(),
             'assessmmentcompanyusab' => landassessmentform::whereBetween('created_at', [$from, $to])->where('type', 'Interior')->OrderBy('created_at', 'DESC')->get(),

              'assessmmentcompanyestateofficer' => landassessmentform::whereBetween('created_at', [$from, $to])->where('status5', 1)->OrderBy('created_at', 'ASC')->get(),

            'assessmmentcompanydean' => landassessmentform::whereBetween('created_at', [$from, $to])->where('status5', 2)->orwhere('status6', 2)->OrderBy('created_at', 'DESC')->get(),

            'assessmmentcompanyadofficer' => landassessmentform::whereBetween('created_at', [$from, $to])->where('type', 'Interior')->where('college', auth()->user()->college)->where('status5', 3)->orwhere('status6', 3)->OrderBy('created_at', 'DESC')->get(),

            'assessmmentcompanyprincipal' => landassessmentform::whereBetween('created_at', [$from, $to])->where('type', 'Interior')->where('college', auth()->user()->college)->where('status5', 3)->orwhere('status6', 3)->OrderBy('created_at', 'DESC')->get(),

            'assessmmentcompanyestatedirector' => landassessmentform::whereBetween('created_at', [$from, $to])->OrderBy('created_at', 'ASC')->get(),
          
            'assessmmentcompanydvcaccountant' => landassessmentform::whereBetween('created_at', [$from, $to])->OrderBy('created_at', 'ASC')->get(),

             'dean' => landassessmentform::whereBetween('created_at', [$from, $to])->where('status5', 3)->orwhere('status6', 3)->where('type', 'Interior')->OrderBy('created_at', 'DESC')->get(),



        ]);

            }

      else {

     return view('assessmentformview', [
            'role' => $role,
            'notifications' => $notifications,
             'type' => landassessmentform::select(DB::raw('type'))
                    ->groupBy('type')->get(),

           'assessmmentsheet' => landassessmentform::select(DB::raw('assessment_name'))
                    ->groupBy('assessment_name')->get(),

           'assessmmentcompanygr' => landassessmentform::select(DB::raw('company_id'))
                    ->groupBy('company_id')->get(),
            'assessmmenttender' => landassessmentform::select(DB::raw('company'))
                    ->groupBy('company')->get(),

            'assessmmentareass' => landassessmentform::select(DB::raw('area_id'))
                    ->groupBy('area_id')->get(),


            'assessmmentcompanylandscaping' => landassessmentform::where('type', 'Exterior')->OrderBy('created_at', 'DESC')->get(),

            'assessmmentcompanyusab' => landassessmentform::where('type', 'Interior')->OrderBy('created_at', 'DESC')->get(),

            'assessmmentcompanyestateofficer' => landassessmentform::where('status5', 1)->OrderBy('created_at', 'ASC')->get(),

            'assessmmentcompanydean' => landassessmentform::where('status5', 2)->orwhere('status6', 2)->OrderBy('created_at', 'DESC')->get(),

            'assessmmentcompanyadofficer' => landassessmentform::where('status5', 3)->orwhere('status6', 3)->where('type', 'Interior')->where('college', auth()->user()->college)->OrderBy('created_at', 'DESC')->get(),


            'assessmmentcompanyestatedirector' => landassessmentform::OrderBy('created_at', 'ASC')->get(),


            'assessmmentcompanydvcaccountant' => landassessmentform::OrderBy('created_at', 'ASC')->get(),


            'assessmmentcompanyprincipal' => landassessmentform::where('status5', 3)->orwhere('status6', 3)->where('type', 'Interior')->where('college', auth()->user()->college)->OrderBy('created_at', 'DESC')->get(),

                'dean' => landassessmentform::where('status5', 3)->orwhere('status6', 3)->where('type', 'Interior')->OrderBy('created_at', 'DESC')->get(),


            
        ]);
    } }





    public function assessmentformviewsecond(){

        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
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



                 return view('assessmentformviewsecond', [
            'role' => $role,
            'notifications' => $notifications,
            'type' => landassessmentform::select(DB::raw('type'))
                    ->groupBy('type')->get(),
           'assessmmentsheet' => landassessmentform::select(DB::raw('assessment_name'))
                    ->groupBy('assessment_name')->get(),


           'assessmmentcompanygr' => landassessmentform::select(DB::raw('company_id'))
                    ->groupBy('company_id')->get(),

            'assessmmenttender' => landassessmentform::select(DB::raw('company'))
                    ->groupBy('company')->get(),

            'assessmmentareass' => landassessmentform::select(DB::raw('area_id'))
                    ->groupBy('area_id')->get(),



            'assessmmentcompanylandscaping' => landassessmentform::whereBetween('created_at', [$from, $to])->where('type', 'Exterior')->OrderBy('created_at', 'DESC')->get(),
             'assessmmentcompanyusab' => landassessmentform::whereBetween('created_at', [$from, $to])->where('type', 'Interior')->OrderBy('created_at', 'DESC')->get(),
               'assessmmentcompanyestateofficer' => landassessmentform::whereBetween('created_at', [$from, $to])->where('status5', 1)->OrderBy('created_at', 'DESC')->get(),

                'assessmmentcompanyestatedirector' => landassessmentform::whereBetween('created_at', [$from, $to])->OrderBy('created_at', 'DESC')->get(),

               'assessmmentcompanydvcaccountant' => landassessmentform::whereBetween('created_at', [$from, $to])->OrderBy('created_at', 'DESC')->get(),

                 'assessmmentcompanyprincipal' => landassessmentform::whereBetween('created_at', [$from, $to])->where('status5', 3)->orwhere('status6', 3)->where('type', 'Interior')->where('college', auth()->user()->college)->OrderBy('created_at', 'DESC')->get(),

              
            'assessmmentcompanyadofficer' => landassessmentform::whereBetween('created_at', [$from, $to])->where('status5', 3)->orwhere('status6', 3)->where('type', 'Interior')->where('college', auth()->user()->college)->OrderBy('created_at', 'DESC')->get(),


            'dean' => landassessmentform::whereBetween('created_at', [$from, $to])->where('status5', 3)->orwhere('status6', 3)->where('type', 'Interior')->OrderBy('created_at', 'DESC')->get(),

              'assessmmentcompanydean' => landassessmentform::whereBetween('created_at', [$from, $to])->where('status5', 2)->orwhere('status6', 2)->OrderBy('created_at', 'DESC')->get(),


        ]);

            }

      else {

     return view('assessmentformviewsecond', [
            'role' => $role,
            'notifications' => $notifications,
              'type' => landassessmentform::select(DB::raw('type'))
                    ->groupBy('type')->get(),
           'assessmmentsheet' => landassessmentform::select(DB::raw('assessment_name'))
                    ->groupBy('assessment_name')->get(),

           'assessmmentcompanygr' => landassessmentform::select(DB::raw('company_id'))
                    ->groupBy('company_id')->get(),
            'assessmmenttender' => landassessmentform::select(DB::raw('company'))
                    ->groupBy('company')->get(),

            'assessmmentareass' => landassessmentform::select(DB::raw('area_id'))
                    ->groupBy('area_id')->get(),

            'assessmmentcompanylandscaping' => landassessmentform::where('type', 'Exterior')->OrderBy('created_at', 'DESC')->get(),

            'assessmmentcompanyusab' => landassessmentform::where('type', 'Interior')->OrderBy('created_at', 'DESC')->get(),

              'assessmmentcompanyestatedirector' => landassessmentform::OrderBy('created_at', 'DESC')->get(),

               'assessmmentcompanydvcaccountant' => landassessmentform::OrderBy('created_at', 'DESC')->get(),

            'assessmmentcompanyestateofficer' => landassessmentform::where('status5', 1)->OrderBy('created_at', 'DESC')->get(),

              'assessmmentcompanyprincipal' => landassessmentform::where('status5', 3)->orwhere('status6', 3)->where('type', 'Interior')->where('college', auth()->user()->college)->OrderBy('created_at', 'DESC')->get(),


            'assessmmentcompanyadofficer' => landassessmentform::where('status5', 3)->orwhere('status6', 3)->where('type', 'Interior')->where('college', auth()->user()->college)->OrderBy('created_at', 'DESC')->get(),


            'dean' => landassessmentform::where('status5', 3)->orwhere('status6', 3)->where('type', 'Interior')->OrderBy('created_at', 'DESC')->get(),

                 'assessmmentcompanydean' => landassessmentform::where('status5', 2)->orwhere('status6', 2)->OrderBy('created_at', 'DESC')->get(),



        ]);
    } }




       public function addsection(){
          $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();

        return view('add_maintainancesection', [
            'role' => $role,
            'notifications' => $notifications

        ]);


     }


        public function addcompanyforassessment($id , $tender){

        $tender = Crypt::decrypt($tender);
        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();


        return view('addcompanyforassessment', [
            'role' => $role,
            'notifications' => $notifications,
            'company' =>company::where('tender', $tender)->get(),
            'companyname' =>company::where('id', $id)->first(),


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
                    ->groupBy('assessment_month')->OrderBy('assessment_month','DESC')->get();


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


         public function companylinereport($tender , $company , $area){

         $tender = Crypt::decrypt($tender);
         $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
         $role = User::where('id', auth()->user()->id)->with('user_role')->first();

               return view('companylinereport', [
            'role' => $role,
            'notifications' => $notifications,
            'crosscheckassessmmentactivity' => landcrosschecklandassessmentactivity::where('company', $tender)->select(DB::raw('sum(score) as erick  , month'))
                    ->groupBy('month')->orderby('month','DESC')->get() ,

             'crosscheckassessmmentactivitygroupbyarea' => landcrosschecklandassessmentactivity::where('company', $tender)->select(DB::raw('area'))
                    ->groupBy('area')->get()


        // 'assessmmentcompany' => landassessmentform::where('company_id', $id)->select(DB::raw('sum(score) as erick , assessment_month'))
                    //->groupBy('assessment_month')->get()

        ])->with(['tender'=>$tender , 'compa'=>$company]);
         }






     public function viewcompanyreportfor_company($tender , $company ){

         $tender = Crypt::decrypt($tender);
         $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
         $role = User::where('id', auth()->user()->id)->with('user_role')->first();

               return view('view_companyreport_for_company', [
            'role' => $role,
            'notifications' => $notifications,
            'crosscheckassessmmentactivity' => landcrosschecklandassessmentactivity::where('company', $tender)->select(DB::raw('sum(score) as erick  , month'))
                    ->groupBy('month')->orderby('month','DESC')->get() ,

             'crosscheckassessmmentactivitygroupbyarea' => landcrosschecklandassessmentactivity::where('company', $tender)->select(DB::raw('area'))
                    ->groupBy('area')->get()


        // 'assessmmentcompany' => landassessmentform::where('company_id', $id)->select(DB::raw('sum(score) as erick , assessment_month'))
                    //->groupBy('assessment_month')->get()

        ])->with(['tender'=>$tender , 'compa'=>$company]);
         }



         public function viewcompanyreport($tender , $company , $area){

         $tender = Crypt::decrypt($tender);
         $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
         $role = User::where('id', auth()->user()->id)->with('user_role')->first();

               return view('viewcompanyreport', [
            'role' => $role,
            'notifications' => $notifications,
            'crosscheckassessmmentactivity' => landcrosschecklandassessmentactivity::where('company', $tender)->select(DB::raw('sum(score) as erick  , month'))
                    ->groupBy('month')->orderby('month','DESC')->get() ,

             'crosscheckassessmmentactivitygroupbyarea' => landcrosschecklandassessmentactivity::where('company', $tender)->select(DB::raw('area'))
                    ->groupBy('area')->get()


        // 'assessmmentcompany' => landassessmentform::where('company_id', $id)->select(DB::raw('sum(score) as erick , assessment_month'))
                    //->groupBy('assessment_month')->get()

        ])->with(['tender'=>$tender , 'compa'=>$company]);
         }


         public function viewassessmentsheet($id){
         $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
         $role = User::where('id', auth()->user()->id)->with('user_role')->first();

               return view('viewassessmentsheet', [
            'role' => $role,
            'notifications' => $notifications,
         'assessmmentcompany' => assessmentsheet::where('name', $id)->first(),
         'assessmmentactivity' => assessmentsheet::where('name', $id)->get()
        ]);
         }



         public function viewsheetbeforeproceeding($id){
         $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
         $role = User::where('id', auth()->user()->id)->with('user_role')->first();

               return view('viewsheetbeforeproceed', [
            'role' => $role,
            'notifications' => $notifications,
         'assessmmentcompany' => assessmentsheet::where('name', $id)->where('status',2)->first(),
         'assessmmentactivity' => assessmentsheet::where('name', $id)->where('status',2)->get()
        ]);
         }



         public function companyeditreport($id){
         $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
         $role = User::where('id', auth()->user()->id)->with('user_role')->first();

               return view('companyeditreport', [
            'role' => $role,
            'notifications' => $notifications,
         'assessmmentcompany' => landassessmentform::where('assessment_month', $id)->OrderBy('company_id')->get(),
          'assessmmentgrouptender' => landassessmentform::where('assessment_month', $id)->select(DB::raw('company'))
                    ->groupBy('company')->get(),
           'assessmmentgroupcompany' => landassessmentform::where('assessment_month', $id)->select(DB::raw('company_id'))
                    ->groupBy('company_id')->get(),
          'assessmmentgrouparea' => landassessmentform::where('assessment_month', $id)->select(DB::raw('area_id'))
                    ->groupBy('area_id')->get(),
        'assessmmentgroupsheets' => landassessmentform::where('assessment_month', $id)->select(DB::raw('assessment_name'))
                    ->groupBy('assessment_name')->get(),


        // 'companygroup' => landassessmentform::where('assessment_month', $id)->select(DB::raw('sum(score) as erick , count(company_id) as pnd , company_id'))
                   // ->groupBy('company_id')->get(),

        'assessmmentcompanyname' => landassessmentform::where('assessment_month', $id)->get()


        ]);
         }



      public function companytenderformonthreport($id , $tender){
         $tender = Crypt::decrypt($tender);
         $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
         $role = User::where('id', auth()->user()->id)->with('user_role')->first();

               return view('companymonthtrending', [
            'role' => $role,
            'notifications' => $notifications,
         'assessmmentcompany' => landassessmentform::where('assessment_month', $id)->where('company', $tender)->OrderBy('company_id')->get(),

        // 'companygroup' => landassessmentform::where('assessment_month', $id)->select(DB::raw('sum(score) as erick , count(company_id) as pnd , company_id'))
                   // ->groupBy('company_id')->get(),

        'assessmmentcompanyname' => landassessmentform::where('assessment_month', $id)->where('company', $tender)->get()


        ]);
         }



         public function updatecomments(request $request){


           $p=$request['edit_id'];
           $comment = landcrosschecklandassessmentactivity::where('id',$p)->first();
           $comment->comment = $request['comment'];

           $comment->save();



           return  redirect()->back()->with(['message'=>'Comment updated succesifully']);
         }





        public function fowardtodvc($id){
               $commentall = landassessmentform::where('assessment_month', $id)->get();
               foreach ($commentall as $comm) {


                  $comment = landassessmentform::where('id', $comm->id)->first();
                  $comment->assessor = auth()->user()->id;
                  $comment->assessordate = $comment->updated_at;
                  $comment->status2 = 2;
                  $comment->save(); }

           return  redirect()->back()->with(['message'=>'Monthly company report sent successiully to DVC admin']);
         }








}

