<?php

namespace App\Http\Controllers;

use Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\house;
use App\hall;
use App\Notification;
use App\user;
use App\Campus;
use App\zone;
use App\cleaningarea;
use App\NonBuildingAsset;
use App\Area;
use App\Room;
use App\Block;
use App\Location;
use App\company;
use App\assetsland;
use App\assetsbuilding;
use App\assetscomputerequipment;
use App\assetsequipment;
use App\assetsfurniture;
use App\assetsintangible;
use App\assetsmotorvehicle;
use App\assetsplantandmachinery;
use App\assetsworkinprogress;

use App\assetsassesbuilding;
use App\assetsassescomputerequipment;
use App\assetsassesequipment;
use App\assetsassesfurniture;
use App\assetsassesintangible;
use App\assetsassesland;
use App\assetsassesmotorvehicle;
use App\assetsassesplantandmachinery;
use Illuminate\Support\Carbon;

use PDF;

use App\landassessmentform;
use App\iowzone;
use App\companywitharea;
use App\assessmentsheet;
use App\areacompany;
use App\Directorate;
use App\tendernumber;

class AssetsController extends Controller
{
    //

     public function RegisterHouse(Request $request)
    {


        if ($request['campus'] == 'Choose...') {
            return redirect()->back()->withErrors(['message' => 'campus is required']);
        }


        $staffhouse = new House();
        $staffhouse->name_of_house = $request['name_of_house'];
        $staffhouse->location = $request['location'];
        $staffhouse->type = $request['type'];
        $staffhouse->no_room = $request['no_room'];
        $staffhouse->campus_id = $request['campus'];
        $staffhouse->save();
        return redirect()->route('register.house')->with(['message' => 'New house registered successfully']);
    }



      public function Registercompany(Request $request)
    {


    $checktender = company::where('tender', $request['tendern'])->where('company_name', $request['companyid'])->first();

    if (empty($checktender)) {

            $area = $request['area'];
            $sheet = $request['sheets'];
            $payments = $request['payment'];



          //  First Store data in $arr
             $arr = array();
                  foreach ($area as $address) {
                   $arr[] = $address;
             }
            $unique_data = array_unique($arr);
            // now use foreach loop on unique data
            foreach($unique_data as $a => $b) {


        $company = new company();
        $company->sheet = $sheet[$a];
        $company->area = $area[$a];

        $assesssheet = assessmentsheet::where('name' , $sheet[$a])->get();
        foreach ($assesssheet as $as) {

             $company->type = $as->type;

        }

        $company->company_name = $request['companyid'];
        $company->tender = $request['tendern'];
        $company->hostel = $request['hostel'];
        $company->status = 2;
        $company->payment = $payments[$a];
        $company->datecontract = $request['datecontract'];
        $company->nextmonth = $request['datecontract'];



        $durass = strtotime($company->datecontract);
        $dura = $request['duration'];
        $company->endcontract = date('Y-m-d' , strtotime("+$dura year" , $durass));


     if ($company->datecontract >= $company->endcontract) {

         return redirect()->back()->withErrors(['message' => 'Please enter the valid end of contract , End of contract must be greater than start of the contract']);

     }

     $enddate = Carbon::parse($company->endcontract);
     $startdate = Carbon::parse($company->datecontract);
     $diff = $startdate->diffInDays($enddate);

     if ( $diff < 365 ) {

         return redirect()->back()->withErrors(['message' => 'The contract duration must be greater than or equal to one year']);

     }



     $companynew =  tendernumber::where('company' , $company->company_name)->where('tender' ,  $company->tender)->first();
   //  $companynew->payment = $request['payment'];
     $companynew->datecontract = $request['datecontract'];
     $durass = strtotime($companynew->datecontract);
     $dura = $request['duration'];
     $companynew->endcontract =  date('Y-m-d' , strtotime("+$dura year" , $durass));
     $companynew->status = 1;
     $companynew->save();






      $company->save();
         }

           return redirect()->route('cleaningcompany')->with(['message' => 'New tender registered successfully']);


}



   else {

        return redirect()->back()->withErrors(['message' => 'The tender number selected has already been assigned for another company, Please select another tender number']);
       }


       }





      public function Renewcompany(Request $request )
    {




        $company = new companywitharea();
        $company->company_name = $request['company_name'];
        $company->type = $request['type'];
        $company->save();


       $tendernu = $request['tender'];

             //  First Store data in $arr
             $arr = array();
                  foreach ($tendernu as $address) {
                   $arr[] = $address;
             }
            $unique_data = array_unique($arr);
            // now use foreach loop on unique data
            foreach($unique_data as $a => $b) {

          $checktender = tendernumber::where('tender', $tendernu[$a])->first();

       if (empty($checktender)) {

        $tender = new tendernumber();
        $tender->tender = $tendernu[$a];
        $tender->company = $company->id;
        $tender->save(); }
           else {

        return redirect()->back()->withErrors(['message' => 'The tender number selected has already been assigned for another company, Please select another tender number']);
       }

         }

        return redirect()->route('cleaning_company')->with(['message' => 'Company registered successfully']);

      }







         public function addnewsheetc(Request $request )
    {


      $checkforempty = assessmentsheet::where('name', $request['name'])->first();

         if (empty($checkforempty)) {

            $activityi = $request['activity'];
            $percentagee = $request['percentage'];
            $summ = 0;

            foreach($activityi as $a => $b){
            $summ += $percentagee[$a];

        $company = new assessmentsheet();
        $company->activity = $activityi[$a];
        $company->percentage = $percentagee[$a];
        $company->type = $request['type'];
        $company->name = $request['name'];
        $company->status = 2;

        $company->save();  }

          if($summ != 100) {

              return redirect()->route('view_sheet_before_proceeding' , [$company->name])->withErrors(['message' => 'Value must be greater than zero and less or equal to 100']);
           }

           else{

             return redirect()->route('assessment_sheet')->with(['message' => 'New assessment sheet registered successfully']);

           }

         }

         else {

            return redirect()->back()->withErrors(['message' => 'The assessment sheet name already exist.']);

         }
       }










 public function TecnicianView(Request $request)
    {

       $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();



       return view('technicianreport', [
            'role' => $role,
            'notifications' => $notifications,



          ]);
    }



       public function HousesView(){
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('houses', [
            'role' => $role,
            'notifications' => $notifications,
            'staffhouses' => House::all(),
            'HallofResdence' => Hall::all(),
             'campuses' => Campus::all(),
               'newzone' => zone::all(),
               'cleanarea' => cleaningarea::all(),

          ]);
         }


         public function managecampus(){
         $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
         $role = User::where('id', auth()->user()->id)->with('user_role')->first();

         return view('managecampus', [
            'role' => $role,
            'notifications' => $notifications,
            'staffhouses' => House::all(),
            'HallofResdence' => Hall::all(),
             'campuses' => Campus::all(),
               'newzone' => zone::all(),
               'cleanarea' => cleaningarea::all(),

          ]);

         }




       public function cleaningcompany(){
         $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
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


         return view('cleaningcompany', [
            'role' => $role,
            'notifications' => $notifications,

             'cleangcompanylandscaping' => company::where('type','Exterior')->whereBetween('created_at', [$from, $to])->orderby('created_at','DESC')->get(),

             'cleangcompanyusab' => company::where('type','Interior')->whereBetween('created_at', [$from, $to])->orderby('created_at','DESC')->get(),

            'cleangcompanyadmin' => company::whereBetween('created_at', [$from, $to])->orderby('created_at','DESC')->get(),


             'assessmmentcompany' => company::select(DB::raw('company_name'))
                    ->groupBy('company_name')->get(),
            'assessmmenttender' => company::select(DB::raw('tender'))
                    ->groupBy('tender')->get(),

            'assessmmentareas' => company::select(DB::raw('area'))
                    ->groupBy('area')->get(),

          ]);

         

         }
         else{

             return view('cleaningcompany', [
            'role' => $role,
            'notifications' => $notifications,

             'cleangcompanylandscaping' => company::where('type','Exterior')->orderby('created_at','DESC')->get(),

             'cleangcompanyusab' => company::where('type','Interior')->orderby('created_at','DESC')->get(),

             'cleangcompanyadmin' => company::orderby('created_at','DESC')->get(),

             'assessmmentcompany' => company::select(DB::raw('company_name'))
                    ->groupBy('company_name')->get(),
            'assessmmenttender' => company::select(DB::raw('tender'))
                    ->groupBy('tender')->get(),

            'assessmmentareas' => company::select(DB::raw('area'))
                    ->groupBy('area')->get(),

          ]);

         }

       }





       public function cleaningcompanywithexpirecontract(){
         $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
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


         return view('cleaningcompanyexpired', [
            'role' => $role,
            'notifications' => $notifications,

             'cleangcompanylandscaping' => company::where('type','Exterior')->whereBetween('created_at', [$from, $to])->orderby('created_at','DESC')->get(),

             'cleangcompanyusab' => company::where('type','Interior')->whereBetween('created_at', [$from, $to])->orderby('created_at','DESC')->get(),

            'cleangcompanyadmin' => company::whereBetween('created_at', [$from, $to])->orderby('created_at','DESC')->get(),


             'assessmmentcompany' => company::select(DB::raw('company_name'))
                    ->groupBy('company_name')->get(),
            'assessmmenttender' => company::select(DB::raw('tender'))
                    ->groupBy('tender')->get(),

            'assessmmentareas' => company::select(DB::raw('area'))
                    ->groupBy('area')->get(),

          ]);

         }
         else{

             return view('cleaningcompanyexpired', [
            'role' => $role,
            'notifications' => $notifications,

             'cleangcompanylandscaping' => company::where('type','Exterior')->orderby('created_at','DESC')->get(),

             'cleangcompanyusab' => company::where('type','Interior')->orderby('created_at','DESC')->get(),

             'cleangcompanyadmin' => company::orderby('created_at','DESC')->get(),

             'assessmmentcompany' => company::select(DB::raw('company_name'))
                    ->groupBy('company_name')->get(),
            'assessmmenttender' => company::select(DB::raw('tender'))
                    ->groupBy('tender')->get(),

            'assessmmentareas' => company::select(DB::raw('area'))
                    ->groupBy('area')->get(),

          ]);

         }

       }







       public function cleaningcompanyreached(){
         $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
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


         return view('cleaningcompanyreached', [
            'role' => $role,
            'notifications' => $notifications,

            'cleangcompanylandscaping' => company::where('type','Exterior')->whereBetween('created_at', [$from, $to])->orderby('created_at','DESC')->get(),

             'cleangcompanyusab' => company::where('type','Interior')->whereBetween('created_at', [$from, $to])->orderby('created_at','DESC')->get(),

            'cleangcompanyadmin' => company::whereBetween('created_at', [$from, $to])->orderby('created_at','DESC')->get(),

             'assessmmentcompany' => company::select(DB::raw('company_name'))
                    ->groupBy('company_name')->get(),
            'assessmmenttender' => company::select(DB::raw('tender'))
                    ->groupBy('tender')->get(),

            'assessmmentareas' => company::select(DB::raw('area'))
                    ->groupBy('area')->get(),

          ]);

         }
         else{

             return view('cleaningcompanyreached', [
            'role' => $role,
            'notifications' => $notifications,

            'cleangcompanylandscaping' => company::where('type','Exterior')->orderby('created_at','DESC')->get(),

             'cleangcompanyusab' => company::where('type','Interior')->orderby('created_at','DESC')->get(),

             'cleangcompanyadmin' => company::orderby('created_at','DESC')->get(),

             'assessmmentcompany' => company::select(DB::raw('company_name'))
                    ->groupBy('company_name')->get(),
            'assessmmenttender' => company::select(DB::raw('tender'))
                    ->groupBy('tender')->get(),

            'assessmmentareas' => company::select(DB::raw('area'))
                    ->groupBy('area')->get(),

          ]);

         }

       }



             public function cleaningcompanyexpired(){
         $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
         $role = User::where('id', auth()->user()->id)->with('user_role')->first();

         return view('cleaningcompanynewexpired', [
            'role' => $role,
            'notifications' => $notifications,

             'cleangcompany' => tendernumber::all()

          ]);

         }



        public function cleaningcompanynew(){
         $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
         $role = User::where('id', auth()->user()->id)->with('user_role')->first();

         return view('cleaningcompanynew', [
            'role' => $role,
            'notifications' => $notifications,

             'cleangcompany' => tendernumber::all()

          ]);

         }



        public function cleaningcompanyreport(){
         $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
         $role = User::where('id', auth()->user()->id)->with('user_role')->first();

         return view('cleaningcompanyreport', [
            'role' => $role,
            'notifications' => $notifications,

             'cleangcompany' => company::where('status','<>',2)->get()

          ]);

         }



             public function incompleteassessmentsheet(){
         $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
         $role = User::where('id', auth()->user()->id)->with('user_role')->first();

         return view('incompleteassessmentsheet', [
            'role' => $role,
            'notifications' => $notifications,

             'cleangcompany' => assessmentsheet::select(DB::raw('name , type ,sum(percentage) as percentage')) ->where('status',2)->OrderBy('name','ASC')
              ->groupBy('name')->groupBy('type')
             ->get()

          ]);

         }




             public function assessmentsheet(){
         $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
         $role = User::where('id', auth()->user()->id)->with('user_role')->first();

         return view('assessmentsheet', [
            'role' => $role,
            'notifications' => $notifications,

             'cleangcompany' => assessmentsheet::select(DB::raw('name , type ,sum(percentage) as percentage')) ->where('status',2)->OrderBy('name','ASC')
              ->groupBy('name')->groupBy('type')
             ->get()

          ]);

         }








       public function Hallofresdence(){
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('hallofresdence', [
            'role' => $role,
            'notifications' => $notifications,
            'staffhouses' => House::all(),
            'HallofResdence' => Hall::all(),
             'campuses' => Campus::all(),
               'newzone' => zone::all(),
               'cleanarea' => cleaningarea::all(),

          ]);
         }

           public function Cleaningarea(){
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('cleaningarea', [
            'role' => $role,
            'notifications' => $notifications,
            'staffhouses' => House::all(),
            'HallofResdence' => Hall::all(),
             'campuses' => Campus::all(),
               'newzone' => iowzone::OrderBy('zonename', 'ASC')->get(),
               'cleanarea' => cleaningarea::OrderBy('cleaning_name', 'ASC')->get(),
                'cleanareainterior' => cleaningarea::where('type', 'Interior')->where('college',auth()->user()->college)->where('hostel', 2)->OrderBy('cleaning_name', 'ASC')->get(),
                 'cleanareaexterial' => cleaningarea::where('type', 'Exterior')->OrderBy('cleaning_name', 'ASC')->get(),
                  'cleanareausab' => cleaningarea::where('hostel', 1)->OrderBy('cleaning_name', 'ASC')->get()

          ]);
         }

           public function cleaningzone(){
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('cleaningzone', [
            'role' => $role,
            'notifications' => $notifications,
            'staffhouses' => House::all(),
            'HallofResdence' => Hall::all(),
             'campuses' => Campus::all(),
               'newzone' => zone::all(),
               'cleanarea' => cleaningarea::all(),

          ]);
         }




          public function deleteHouse($id)
       {
           $House=House::where('id', $id)->first();
           $House->delete();
           return redirect()->route('register.house')->with(['message' => 'Respective house deleted successfully']);
       }



           public function editHouse(Request $request)
    {
           $p=$request['edit_id'];
           $House = House::where('id',$p)->first();
           $House->name_of_house = $request['name_of_house'];

           $House->location = $request['location'];
           $House->type = $request['type'];
           $House->no_room = $request['no_room'];
           $House->campus_id = $request['campus'];
           $House->save();

        return redirect()->route('register.house')->with(['message' => 'House Edited successfully']);
    }




      public function editcompany(Request $request)
    {
           $p=$request['edit_id'];
           $company = tendernumber::where('id',$p)->first();
           $company->tender = $request['tender'];

          $checktender = tendernumber::where('tender', $company->tender)->first();

         if (empty($checktender)) {
           $company->save();

            return redirect()->back()->with(['message' => 'Company Edited successfully']);
         }
         else {

             return redirect()->back()->withErrors(['message' => 'selected tender number already exists']);
         }


    }



     public function RegisterHalls(Request $request)
    {

        $HallofResdence = new Hall();
        $HallofResdence->hall_name = $request['hall_name'];
        $HallofResdence->campus_id = $request['campus'];
        $HallofResdence->area_name = $request['area_name'];
        $HallofResdence->type = $request['type'];
        $HallofResdence->location = $request['location'];
        $HallofResdence->save();

        return redirect()->route('register.hallofres')->with(['message' => 'New Hall of Residence registered successfully']);
    }




          public function deleteHall($id)
       {
           $HallofRes=Hall::where('id', $id)->first();
           $HallofRes->delete();
           return redirect()->route('register.hallofres')->with(['message' => 'Respective hall of Residence deleted successfully']);
       }



          public function deletecompany($id)
       {
           $comp=tendernumber::where('id', $id)->first();
           $comp->delete();
           return redirect()->back()->with(['message' => 'Respective company deleted successfully']);
       }



          public function deletecleaningcompany($id)
       {
           $comp=company::where('id', $id)->first();
           $comp->delete();
           return redirect()->back()->with(['message' => 'Respective tender deleted successfully']);
       }




            public function editHall(Request $request)
    {
       $p=$request['edit_hallid'];
       $hall = Hall::where('id',$p)->first();
       $hall->hall_name = $request['hall_name'];
       $hall->campus_id = $request['campus'];
       $hall->area_name = $request['area_name'];
       $hall->type = $request['type'];
       $hall->location = $request['location'];
       $hall->save();

        return redirect()->route('register.hallofres')->with(['message' => 'Respective Hall Edited successfully']);
    }





     public function RegisteCampus(Request $request)
    {

        if (!empty(Campus::where('campus_name',$request['campus_name'])->first())){
            return redirect()->back()->withErrors(['message' => 'Campus name already exist']);
        }

        $campuses = new Campus();
        $campuses->campus_name = $request['campus_name'];
        $campuses->location = $request['location'];
        $campuses->save();
        return redirect()->route('register.campus')->with(['message' => 'New campus registered successfully']);

    }


     public function editcampus(Request $request)
    {
           $p=$request['edit_cid'];
           $campus = Campus::where('id',$p)->first();
           $campus->campus_name = $request['campus_name'];
           $campus->location = $request['location'];
           $campus->save();

        return redirect()->route('register.campus')->with(['message' => 'Respective campus Edited successfully']);
    }


      public function deletecampus($id)
       {
           $HallofRes=Campus::where('id', $id)->first();
           $HallofRes->delete();
           return redirect()->route('register.campus')->with(['message' => 'Respective campus deleted successfully']);
       }



       public function Registerzone(Request $request)
    {

        $newzone = new zone();
        $newzone->zone_name = $request['zone_name'];
        $newzone->campus_id = $request['campus'];
        $newzone->type = $request['type'];
        $newzone->save();
        return redirect()->route('register.cleanningzone')->with(['message' => 'New Zones registered successfully']);
    }


      public function deletezone($id)
       {
           $newzone=zone::where('id', $id)->first();
           $newzone->delete();
           return redirect()->route('register.cleanningzone')->with(['message' => 'Respective Zone deleted successfully']);
       }


      public function editzone(Request $request)
    {
        $p=$request['editzone_id'];
        $editnewzone = zone::where('id',$p)->first();
        $editnewzone->zone_name = $request['zone_name'];
        $editnewzone->campus_id = $request['campus'];
        $editnewzone->type = $request['type'];
        $editnewzone->save();

        return redirect()->route('register.cleanningzone')->with(['message' => 'Respective zone Edited successfully']);
    }



  public function RegisterCleaningArea(Request $request)
    {

        $cleanarea = new cleaningarea();
        $cleanarea->cleaning_name = $request['cleaning_name'];
        $cleanarea->zone_id = $request['zone'];
        $cleanarea->college = $request['college'];
        $cleanarea->hostel = $request['hostel'];
        $cleanarea->type = $request['areatype'];
        $cleanarea->save();
        return redirect()->route('register.cleaningareas')->with(['message' => 'New Cleaning Area registered successfully']);
    }



  public function deletecleanarea($id)
       {
           $cleanareaa=cleaningarea::where('id', $id)->first();
           $cleanareaa->delete();
           return redirect()->route('register.cleaningareas')->with(['message' => 'Respective Clean area  deleted successfully']);
       }


  public function editcleanarea(Request $request)
    {
        $p=$request['editarea_id'];
        $editcleanarea = cleaningarea::where('id',$p)->first();
        $editcleanarea->cleaning_name = $request['cleaning_name'];
        $editcleanarea->zone_id = $request['zone'];
        $editcleanarea->save();
        return redirect()->route('register.cleaningareas')->with(['message' => 'Respective Clean Area Edited successfully']);
    }


   public function Registercampusview(){
         $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('registercampus', [
            'role' => $role,
            'notifications' => $notifications,
          ]);
     }

   public function Registerstaffhouseview(){
       $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('registerstaffhouse', [
            'role' => $role,
            'notifications' => $notifications,
            'campuses' => Campus::all(),
          ]);
     }


    public function Registercompanyview(){
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('registercompany', [
            'role' => $role,
            'notifications' => $notifications,
            'campuses' => Campus::all(),
             'careainterior' =>cleaningarea::where('type','Interior')->where('college',auth()->user()->college)->where('hostel',2)->get(),
              'careainteriorusab' =>cleaningarea::where('type','Interior')->where('hostel',1)->get(),

              'careaadmin' =>cleaningarea::all(),

              'careaexterior' =>cleaningarea::where('type','Exterior')->get(),
              'sheets' =>assessmentsheet::select(DB::raw('name , type , sum(percentage) as percentage'))
                    ->where('status', 2)->groupBy('name')->groupBy('type')->OrderBy('name')->get(),

                      'companyinterior' => companywitharea::where('type','Interior')->OrderBy('company_name', 'ASC')->get(),

                        'companyexterior' => companywitharea::where('type','Exterior')->OrderBy('company_name', 'ASC')->get(),

                          'companyall' => companywitharea::all()

          ]);
     }


    public function Renewcompanycontract(){
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('renewcompanycontract', [
            'role' => $role,
            'notifications' => $notifications,
             'carea' =>cleaningarea::all()
          ]);
     }


         public function addnewsheet(){
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('addnewassesssheet', [
            'role' => $role,
            'notifications' => $notifications,


          ]);
     }




   public function Registerhallview(){
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('registerhall', [
            'role' => $role,
            'notifications' => $notifications,
            'campuses' => Campus::all(),
          ]);
     }



     public function Registercleanzoneview(){
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('registercleaningzone', [
            'role' => $role,
            'notifications' => $notifications,
            'campuses' => Campus::all(),
          ]);
     }



    public function Registercleaningareaview(){
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('registercleaningarea', [
                'role' => $role,
                'notifications' => $notifications,
                'campuses' => Campus::all(),
                'newzone' => iowzone::OrderBy('zonename', 'ASC')->get(),
                'directorates' => Directorate::where('name','<>',null)->OrderBy('name','ASC')->get(),
                'directoratesadofficer' => Directorate::where('id', auth()->user()->college)->where('name','<>',null)->OrderBy('name','ASC')->get(),
          ]);
     }

     public function nonbuildingasset(){

      $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();

        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $assets = NonBuildingAsset:: select(DB::raw('count(id) as total_asset,name_of_asset')) ->OrderBy('name_of_asset','ASC')
        ->groupBy('name_of_asset')->get();

        return view('Nonbuildingasset', [
            'role' => $role,
            'notifications' => $notifications,
            'NonAsset' => $assets,'newzone' => zone::all(),'campuses' => Campus::all(),

          ]);
     }

     public function registernonbuildingasset(){
      $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('registernonbuildingasset', ['role' => $role,'notifications' => $notifications]);

       $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return redirect()->route('nonbuildingasset')->with(['message' => 'Asset Added Succesfully']);


     }



     public function submitnonAsset(Request $request){
      $request->validate([
            'assetname' => 'required',
            'assettype'=>'required',
            'assetmdate'=>'required',
            'assetspan'=>'required',
            'quantity'=>'required',
        ]);




        if ($request['location'] == 'Choose...') {
            return redirect()->back()->withErrors(['message' => 'Location required required ']);
        }
        $non_building_asset = new NonBuildingAsset();


        if ($request['checkdiv'] == 'yesmanual') {

            $non_building_asset->location = $request['manual'];

        } else {

            $non_building_asset->room_located = $request['room'];
            $non_building_asset->block_id = $request['block'];
            $non_building_asset->area_id = $request['area'];
            $non_building_asset->loc_id = $request['location'];

        }


        $non_building_asset->name_of_asset = $request['assetname'];
        $non_building_asset->type = $request['assettype'];
        $non_building_asset->manufactured_date = $request['assetmdate'];
        $non_building_asset->life_span = $request['assetspan'];
        $non_building_asset->quantity = $request['quantity'];
        $non_building_asset->save();

        return redirect()->route('nonbuildingasset')->with(['message' => 'Asset Added Succesfully']);
     }

     public function NonBuildAsset()
     {


       $assets = NonBuildingAsset::
                     select(DB::raw('count(id) as total_asset, location,area_id'))
                     ->where('name_of_asset',$_GET['asset'])
                     ->groupBy('area_id')
                     ->groupBy('location')
                     ->get();

  $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();

        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
 return view('Nonbuildingasset1', [
            'role' => $role,
            'notifications' => $notifications,
            'NonAsset' => $assets,

          ]);
     }

     public function NonassetIn()
     {
    $areaaa = Area::select('name_of_area')->where('id',$_GET['location'])->get();
    $assets = NonBuildingAsset::
                     select(DB::raw('count(id) as total_asset,block_id'))
                     ->where('name_of_asset',$_GET['asset'])
                     ->Where('area_id',$_GET['location'])
                     ->groupBy('block_id')
                     ->get();

  $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();

        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
 return view('Nonbuildingasset2', [
            'role' => $role,
            'notifications' => $notifications,
            'NonAsset' => $assets,
            'aariya'=>$areaaa,

          ]);
     }

     public function NonassetAt()
     {

$assets = NonBuildingAsset::where('name_of_asset',$_GET['asset'])->where('block_id',$_GET['location'])->get();

$coll = NonBuildingAsset::select('area_id')->distinct()->where('name_of_asset',$_GET['asset'])->where('block_id',$_GET['location'])->get();



$areaaa = Block::select('name_of_block')->where('id',$_GET['location'])->get();
  $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();

        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
 return view('Nonbuildingasset3', [
            'role' => $role,
            'notifications' => $notifications,
            'NonAsset' => $assets,
  'aariya'=>$areaaa,'arcol'=>$coll,
          ]);
     }

     public function assetsManager()
     {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();

        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('assetsMain',['role'=>$role,'notifications'=>$notifications]);
     }

     public function assetsNewLand()
     {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();

        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('assetsNewLand',['role'=>$role,'notifications'=>$notifications]);
     }

     public function assetsNewLandSave(Request $request)
     {
        $request->validate([
            'SiteLocation'=>'required',
            'Quantity'=>'required',
        ]);


        if( $request['DateofAcquisition'] > $request['DateinUse'] )
        {
            return redirect()->back()->withErrors(['message' => 'Date in use should be greater than or equal to date of acquisition ']);
        }
        $assetland = new assetsland();
        $assetland->_condition = $request['AssetCondition'];
        $assetland->depreciationRate = 100/$request['AssetUsefulLife'];
        $assetland->usefulLife = $request['AssetUsefulLife'];

        $assetland->assetNumber = $request['AssetNumber'];
        $assetland->assetLocation = $request['SiteLocation'];


        $assetland->assetDescription = $request['AssetDescription'];
        $assetland->assetAcquisitionDate = $request['DateofAcquisition'];
        $assetland->assetQuantity = $request['Quantity'];
        $assetland->assetDateinUse = $request['DateinUse'];
        $assetland->Cost = $request['cost'];

            $end = $request['DateinUse'];

        $assetland->assetEndingDepreciationDate = date('Y-m-d',strtotime($end.'+25 Years'));
        $assetland->addedBy = auth()->user()->id;
        $assetland->save();

        return redirect()->route('assetsLand')->with(['message' => 'New Asset Added Succesfully']);
     }

     public function assetsLand()
     {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $land = assetsland::get();

        return view('assetsLand',['land'=>$land,'role'=>$role,'notifications'=>$notifications]);
     }
     public function assetsLandView($id)
     {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $land = assetsland::where('id',$id)->get();
        $asses = assetsassesland::where('assetID',$id)->get();
        return view('assetsLandView',['asses'=>$asses,'land'=>$land,'role'=>$role,'notifications'=>$notifications]);
     }

     public function assetsLandEdit($id)
     {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $land = assetsland::where('id',$id)->get();
        return view('assetsLandEdit',['land'=>$land,'role'=>$role,'notifications'=>$notifications]);
     }

     public function assetsLandEditSave(Request $request)
     {
         if( $request['DateofAcquisition'] > $request['DateinUse'] )
            {
                return redirect()->back()->withErrors(['message' => 'Date in use should be greater than or equal to date of acquisition ']);
            }
        $assetland =  assetsland::where('id',$request['id'])->first();
        $assetland->assetNumber = $request['AssetNumber'];
        $assetland->_condition = $request['AssetCondition'];
        $assetland->depreciationRate = 100/$request['AssetUsefulLife'];
        $assetland->usefulLife = $request['AssetUsefulLife'];
        $assetland->assetLocation = $request['SiteLocation'];
        $assetland->assetDescription = $request['AssetDescription'];
        $assetland->assetAcquisitionDate = $request['DateofAcquisition'];
        $assetland->assetQuantity = $request['Quantity'];
        $assetland->assetDateinUse = $request['DateinUse'];
        $assetland->Cost = $request['cost'];

        $end = $request['DateinUse'];

        $assetland->assetEndingDepreciationDate = date('Y-m-d',strtotime($end.'+25 Years'));

        $assetland->addedBy = auth()->user()->id;
        $assetland->save();

        return redirect()->route('assetsLandView',[$request["id"]])->with(['message' => 'Changes Saved Succesfully']);
     }

     //
     public function assetsNewPlantMachinery()
     {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();

        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('assetsNewPlantMachinery',['role'=>$role,'notifications'=>$notifications]);
     }

     public function assetsNewPlantMachinerySave(Request $request)
     {
        $request->validate([
            'SiteLocation'=>'required',
            'Quantity'=>'required',
        ]);
        if( $request['DateofAcquisition'] > $request['DateinUse'] )
        {
            return redirect()->back()->withErrors(['message' => 'Date in use should be greater than or equal to date of acquisition ']);
        }
        $assetland = new assetsplantandmachinery();
        $assetland->_condition = $request['AssetCondition'];
        $assetland->depreciationRate = 100/$request['AssetUsefulLife'];
        $assetland->usefulLife = $request['AssetUsefulLife'];

                    //
                    if($request['SiteLocation']=='CoICT')
                    {

                    $assetland->assetNumber = 'CoICT'.$request['AssetNumber'];
                    $assetland->assetLocation = 'College of Information and Communication Technologies';

                    }else  if($request['SiteLocation']=='CoET')
                    {

                    $assetland->assetNumber = 'CoET'.$request['AssetNumber'];
                    $assetland->assetLocation = 'College of Engineering and Technology';

                    }else if($request['SiteLocation']=='CoAF')
                    {

                    $assetland->assetNumber = 'CoAF'.$request['AssetNumber'];
                    $assetland->assetLocation = 'College of Agricultural Science and Fisheries Technology';

                    }else  if($request['SiteLocation']=='CoSS')
                    {

                    $assetland->assetNumber = 'CoSS'.$request['AssetNumber'];
                    $assetland->assetLocation = 'College of Social science';

                    }else if($request['SiteLocation']=='SJMC')
                    {

                    $assetland->assetNumber = 'SJMC'.$request['AssetNumber'];
                    $assetland->assetLocation = 'School of Journalism and Mass Communication';

                    }else  if($request['SiteLocation']=='UDBS')
                    {

                    $assetland->assetNumber = 'UDBS'.$request['AssetNumber'];
                    $assetland->assetLocation = 'University of Dar es Salaam Business School';

                    }else if($request['SiteLocation']=='CoHU')
                    {

                    $assetland->assetNumber = 'CoHU'.$request['AssetNumber'];
                    $assetland->assetLocation = 'College of Humanities';

                    }else if($request['SiteLocation']=='CONAS')
                    {

                    $assetland->assetNumber = 'CONAS'.$request['AssetNumber'];
                    $assetland->assetLocation = 'College of Natural and Applied Sciences';

                    }else if($request['SiteLocation']=='SoED')
                    {

                    $assetland->assetNumber = 'SoED'.$request['AssetNumber'];
                    $assetland->assetLocation = 'School of Education';

                    }else if($request['SiteLocation']=='UDSoL')
                    {

                    $assetland->assetNumber = 'UDSoL'.$request['AssetNumber'];
                    $assetland->assetLocation = 'University of Dar es salaam School of Law';

                    }else if($request['SiteLocation']=='IDS')
                    {

                    $assetland->assetNumber = 'IDS'.$request['AssetNumber'];
                    $assetland->assetLocation = 'Institute of Development Studies';

                    }else if($request['SiteLocation']=='IKS')
                    {

                    $assetland->assetNumber = 'IKS'.$request['AssetNumber'];
                    $assetland->assetLocation = 'Institute of Kiswahili Studies';

                    }else if($request['SiteLocation']=='IRA')
                    {

                    $assetland->assetNumber = 'IRA'.$request['AssetNumber'];
                    $assetland->assetLocation = 'Institute of Resource Assesment';

                    }else if($request['SiteLocation']=='IMS')
                    {

                    $assetland->assetNumber = 'IMS'.$request['AssetNumber'];
                    $assetland->assetLocation = 'Institute of Marine Sciences';

                    }else if($request['SiteLocation']=='CIUDSM')
                    {

                    $assetland->assetNumber = 'CIUDSM'.$request['AssetNumber'];
                    $assetland->assetLocation = 'Confucius Institute';

                    }else if($request['SiteLocation']=='IGS')
                    {

                    $assetland->assetNumber = 'IGS'.$request['AssetNumber'];
                    $assetland->assetLocation = 'Institute of Gender Studies';

                    }else if($request['SiteLocation']=='MCHS')
                    {

                    $assetland->assetNumber = 'MCHS'.$request['AssetNumber'];
                    $assetland->assetLocation = 'Mbeya college of health and allied sciences';

                    }else if($request['SiteLocation']=='DES')
                    {

                    $assetland->assetNumber = 'DES'.$request['AssetNumber'];
                    $assetland->assetLocation = 'Directorate of Estates Services';

                    }else if($request['SiteLocation']=='ULB')
                    {

                    $assetland->assetNumber = 'ULB'.$request['AssetNumber'];
                    $assetland->assetLocation = 'University Library';

                    }else if($request['SiteLocation']=='VC')
                    {

                    $assetland->assetNumber = 'VC'.$request['AssetNumber'];
                    $assetland->assetLocation = 'Vice Chancelor\'s Office';

                    }else if($request['SiteLocation']=='CCC')
                    {

                    $assetland->assetNumber = 'CCC'.$request['AssetNumber'];
                    $assetland->assetLocation = 'Center for Climate Change Studies';

                    }else if($request['SiteLocation']=='MHL')
                    {

                    $assetland->assetNumber = 'MHL'.$request['AssetNumber'];
                    $assetland->assetLocation = 'Mabibo Hostel';

                    }else if($request['SiteLocation']=='MNS')
                    {

                    $assetland->assetNumber = 'MNS'.$request['AssetNumber'];
                    $assetland->assetLocation = 'Mlimani Nursery School';

                    }else if($request['SiteLocation']=='ADM')
                    {

                    $assetland->assetNumber = 'ADM'.$request['AssetNumber'];
                    $assetland->assetLocation = 'Administration Block';

                    }else if($request['SiteLocation']=='DRP')
                    {

                    $assetland->assetNumber = 'DRP'.$request['AssetNumber'];
                    $assetland->assetLocation = 'Directorate of Research and Publication';

                    }else if($request['SiteLocation']=='CoICT')
                    {

                    $assetland->assetNumber = 'KHL'.$request['AssetNumber'];
                    $assetland->assetLocation = 'Kijitonyama Hostel';

                    }else if($request['SiteLocation']=='CoICT')
                    {

                    $assetland->assetNumber = 'LCR'.$request['AssetNumber'];
                    $assetland->assetLocation = 'Lecture Room';

                    }else if($request['SiteLocation']=='CoICT')
                    {

                    $assetland->assetNumber = 'MSH'.$request['AssetNumber'];
                    $assetland->assetLocation = 'Magufuli Hostel';

                    }else if($request['SiteLocation']=='CoICT')
                    {

                    $assetland->assetNumber = 'HL1'.$request['AssetNumber'];
                    $assetland->assetLocation = 'Hall 1 Hostel';

                    }else if($request['SiteLocation']=='CoICT')
                    {

                    $assetland->assetNumber = 'HL2'.$request['AssetNumber'];
                    $assetland->assetLocation = 'Hall 2 Hostel';

                    }else if($request['SiteLocation']=='CoICT')
                    {

                    $assetland->assetNumber = 'HL3'.$request['AssetNumber'];
                    $assetland->assetLocation = 'Hall 3 Hostel';

                    }else if($request['SiteLocation']=='CoICT')
                    {

                    $assetland->assetNumber = 'HL4'.$request['AssetNumber'];
                    $assetland->assetLocation = 'Hall 4 Hostel';

                    }else if($request['SiteLocation']=='CoICT')
                    {

                    $assetland->assetNumber = 'HL5'.$request['AssetNumber'];
                    $assetland->assetLocation = 'Hall 5 Hostel';

                    }else if($request['SiteLocation']=='CoICT')
                    {

                    $assetland->assetNumber = 'HL6'.$request['AssetNumber'];
                    $assetland->assetLocation = 'Hall 6 Hostel';

                    }else if($request['SiteLocation']=='CoICT')
                    {

                    $assetland->assetNumber = 'HL7'.$request['AssetNumber'];
                    $assetland->assetLocation = 'Hall 7 Hostel';

                    }else if($request['SiteLocation']=='CoICT')
                    {

                    $assetland->assetNumber = 'MKH'.$request['AssetNumber'];
                    $assetland->assetLocation = 'Mikocheni Hostel';

                    }else if($request['SiteLocation']=='CoICT')
                    {

                    $assetland->assetNumber = 'SMR'.$request['AssetNumber'];
                    $assetland->assetLocation = 'Seminar Room';

                    }else if($request['SiteLocation']=='CoICT')
                    {

                    $assetland->assetNumber = 'THR'.$request['AssetNumber'];
                    $assetland->assetLocation = 'Theater Room';

                    }else if($request['SiteLocation']=='CoICT')
                    {

                    $assetland->assetNumber = 'UBH'.$request['AssetNumber'];
                    $assetland->assetLocation = 'Ubungo Hostel';

                    }else if($request['SiteLocation']=='CoICT')
                    {

                    $assetland->assetNumber = 'DOP'.$request['AssetNumber'];
                    $assetland->assetLocation = 'Directorate of Post Graduate Studies';

                    }else if($request['SiteLocation']=='CoICT')
                    {

                    $assetland->assetNumber = 'MCLB'.$request['AssetNumber'];
                    $assetland->assetLocation = 'Michaud Library';

                    }else if($request['SiteLocation']=='CoICT')
                    {

                    $assetland->assetNumber = 'WHR'.$request['AssetNumber'];
                    $assetland->assetLocation = 'Water Resources Houses';

                    }else
                    {

                    $assetland->assetNumber = $request['AssetNumber'];
                    $assetland->assetLocation = $request['SiteLocation'];
                    }
                    //

        $assetland->location = $request['SiteLocation2'];
        $assetland->assetDescription = $request['AssetDescription'];
        $assetland->assetAcquisitionDate = $request['DateofAcquisition'];
        $assetland->assetQuantity = $request['Quantity'];
        $assetland->assetDateinUse = $request['DateinUse'];
        $assetland->Cost = $request['cost'];

        $end = $request['DateinUse'];

        $assetland->assetEndingDepreciationDate = date('Y-m-d',strtotime($end.'+5 Years'));

        $assetland->addedBy = auth()->user()->id;
        $assetland->save();

        return redirect()->route('assetsPlantMachinery')->with(['message' => 'New Asset Added Succesfully']);
     }

     public function assetsPlantMachinery()
     {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $land = assetsplantandmachinery::get();
        return view('assetsPlantMachinery',['land'=>$land,'role'=>$role,'notifications'=>$notifications]);
     }
     public function assetsPlantMachineryView($id)
     {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $land = assetsplantandmachinery::where('id',$id)->get();
        $asses = assetsassesplantandmachinery::where('assetID',$id)->get();
        return view('assetsPlantMachineryView',['asses'=>$asses,'land'=>$land,'role'=>$role,'notifications'=>$notifications]);
     }

     public function assetsPlantMachineryEdit($id)
     {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $land = assetsplantandmachinery::where('id',$id)->get();
        return view('assetsPlantMachineryEdit',['land'=>$land,'role'=>$role,'notifications'=>$notifications]);
     }

     public function assetsPlantMachineryEditSave(Request $request)
     {if( $request['DateofAcquisition'] > $request['DateinUse'] )
        {
            return redirect()->back()->withErrors(['message' => 'Date in use should be greater than or equal to date of acquisition ']);
        }
        $assetland =  assetsplantandmachinery::where('id',$request['id'])->first();
        $assetland->_condition = $request['AssetCondition'];
        $assetland->depreciationRate = 100/$request['AssetUsefulLife'];
        $assetland->usefulLife = $request['AssetUsefulLife'];

                        //
                        if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'CoICT'.$request['AssetNumber'];
                        $assetland->assetLocation = 'College of Information and Communication Technologies';

                        }else  if($request['SiteLocation']=='CoET')
                        {

                        $assetland->assetNumber = 'CoET'.$request['AssetNumber'];
                        $assetland->assetLocation = 'College of Engineering and Technology';

                        }else if($request['SiteLocation']=='CoAF')
                        {

                        $assetland->assetNumber = 'CoAF'.$request['AssetNumber'];
                        $assetland->assetLocation = 'College of Agricultural Science and Fisheries Technology';

                        }else  if($request['SiteLocation']=='CoSS')
                        {

                        $assetland->assetNumber = 'CoSS'.$request['AssetNumber'];
                        $assetland->assetLocation = 'College of Social science';

                        }else if($request['SiteLocation']=='SJMC')
                        {

                        $assetland->assetNumber = 'SJMC'.$request['AssetNumber'];
                        $assetland->assetLocation = 'School of Journalism and Mass Communication';

                        }else  if($request['SiteLocation']=='UDBS')
                        {

                        $assetland->assetNumber = 'UDBS'.$request['AssetNumber'];
                        $assetland->assetLocation = 'University of Dar es Salaam Business School';

                        }else if($request['SiteLocation']=='CoHU')
                        {

                        $assetland->assetNumber = 'CoHU'.$request['AssetNumber'];
                        $assetland->assetLocation = 'College of Humanities';

                        }else if($request['SiteLocation']=='CONAS')
                        {

                        $assetland->assetNumber = 'CONAS'.$request['AssetNumber'];
                        $assetland->assetLocation = 'College of Natural and Applied Sciences';

                        }else if($request['SiteLocation']=='SoED')
                        {

                        $assetland->assetNumber = 'SoED'.$request['AssetNumber'];
                        $assetland->assetLocation = 'School of Education';

                        }else if($request['SiteLocation']=='UDSoL')
                        {

                        $assetland->assetNumber = 'UDSoL'.$request['AssetNumber'];
                        $assetland->assetLocation = 'University of Dar es salaam School of Law';

                        }else if($request['SiteLocation']=='IDS')
                        {

                        $assetland->assetNumber = 'IDS'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Institute of Development Studies';

                        }else if($request['SiteLocation']=='IKS')
                        {

                        $assetland->assetNumber = 'IKS'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Institute of Kiswahili Studies';

                        }else if($request['SiteLocation']=='IRA')
                        {

                        $assetland->assetNumber = 'IRA'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Institute of Resource Assesment';

                        }else if($request['SiteLocation']=='IMS')
                        {

                        $assetland->assetNumber = 'IMS'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Institute of Marine Sciences';

                        }else if($request['SiteLocation']=='CIUDSM')
                        {

                        $assetland->assetNumber = 'CIUDSM'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Confucius Institute';

                        }else if($request['SiteLocation']=='IGS')
                        {

                        $assetland->assetNumber = 'IGS'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Institute of Gender Studies';

                        }else if($request['SiteLocation']=='MCHS')
                        {

                        $assetland->assetNumber = 'MCHS'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Mbeya college of health and allied sciences';

                        }else if($request['SiteLocation']=='DES')
                        {

                        $assetland->assetNumber = 'DES'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Directorate of Estates Services';

                        }else if($request['SiteLocation']=='ULB')
                        {

                        $assetland->assetNumber = 'ULB'.$request['AssetNumber'];
                        $assetland->assetLocation = 'University Library';

                        }else if($request['SiteLocation']=='VC')
                        {

                        $assetland->assetNumber = 'VC'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Vice Chancelor\'s Office';

                        }else if($request['SiteLocation']=='CCC')
                        {

                        $assetland->assetNumber = 'CCC'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Center for Climate Change Studies';

                        }else if($request['SiteLocation']=='MHL')
                        {

                        $assetland->assetNumber = 'MHL'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Mabibo Hostel';

                        }else if($request['SiteLocation']=='MNS')
                        {

                        $assetland->assetNumber = 'MNS'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Mlimani Nursery School';

                        }else if($request['SiteLocation']=='ADM')
                        {

                        $assetland->assetNumber = 'ADM'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Administration Block';

                        }else if($request['SiteLocation']=='DRP')
                        {

                        $assetland->assetNumber = 'DRP'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Directorate of Research and Publication';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'KHL'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Kijitonyama Hostel';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'LCR'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Lecture Room';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'MSH'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Magufuli Hostel';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'HL1'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Hall 1 Hostel';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'HL2'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Hall 2 Hostel';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'HL3'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Hall 3 Hostel';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'HL4'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Hall 4 Hostel';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'HL5'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Hall 5 Hostel';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'HL6'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Hall 6 Hostel';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'HL7'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Hall 7 Hostel';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'MKH'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Mikocheni Hostel';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'SMR'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Seminar Room';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'THR'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Theater Room';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'UBH'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Ubungo Hostel';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'DOP'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Directorate of Post Graduate Studies';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'MCLB'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Michaud Library';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'WHR'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Water Resources Houses';

                        }else
                        {

                        $assetland->assetNumber = $request['AssetNumber'];
                        $assetland->assetLocation = $request['SiteLocation'];
                        }
                        //

        $assetland->location = $request['SiteLocation2'];
        $assetland->assetDescription = $request['AssetDescription'];
        $assetland->assetAcquisitionDate = $request['DateofAcquisition'];
        $assetland->assetQuantity = $request['Quantity'];
        $assetland->assetDateinUse = $request['DateinUse'];
        $assetland->Cost = $request['cost'];

        $end = $request['DateinUse'];

        $assetland->assetEndingDepreciationDate = date('Y-m-d',strtotime($end.'+5 Years'));

        $assetland->addedBy = auth()->user()->id;
        $assetland->save();

        return redirect()->route('assetsPlantMachineryView',[$request["id"]])->with(['message' => 'Changes Saved Succesfully']);
     }

     //



     public function assetsNewIntangible()
     {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();

        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('assetsNewIntangible',['role'=>$role,'notifications'=>$notifications]);
     }

     public function assetsNewIntangibleSave(Request $request)
     {
        $request->validate([
            'SiteLocation'=>'required',
            'Quantity'=>'required',
        ]);
        if( $request['DateofAcquisition'] > $request['DateinUse'] )
        {
            return redirect()->back()->withErrors(['message' => 'Date in use should be greater than or equal to date of acquisition ']);
        }
        $assetland = new assetsintangible();
        $assetland->assetNumber = $request['AssetNumber'];
        $assetland->_condition = $request['AssetCondition'];
        $assetland->depreciationRate = 100/$request['AssetUsefulLife'];
        $assetland->usefulLife = $request['AssetUsefulLife'];
        $assetland->assetLocation = $request['SiteLocation'];
        $assetland->assetDescription = $request['AssetDescription'];
        $assetland->assetAcquisitionDate = $request['DateofAcquisition'];
        $assetland->assetQuantity = $request['Quantity'];
        $assetland->assetDateinUse = $request['DateinUse'];
        $assetland->Cost = $request['cost'];

        $end = $request['DateinUse'];

        $assetland->assetEndingDepreciationDate = date('Y-m-d',strtotime($end.'+5 Years'));

        $assetland->addedBy = auth()->user()->id;
        $assetland->save();

        return redirect()->route('assetsIntangible')->with(['message' => 'New Asset Added Succesfully']);
     }

     public function assetsIntangible()
     {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $land = assetsintangible::get();
        return view('assetsIntangible',['land'=>$land,'role'=>$role,'notifications'=>$notifications]);
     }
     public function assetsIntangibleView($id)
     {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $land = assetsintangible::where('id',$id)->get();
        $asses = assetsassesintangible::where('assetID',$id)->get();
        return view('assetsIntangibleView',['asses'=>$asses,'land'=>$land,'role'=>$role,'notifications'=>$notifications]);
     }

     public function assetsIntangibleEdit($id)
     {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $land = assetsintangible::where('id',$id)->get();
        return view('assetsIntangibleEdit',['land'=>$land,'role'=>$role,'notifications'=>$notifications]);
     }

     public function assetsIntangibleEditSave(Request $request)
     {if( $request['DateofAcquisition'] > $request['DateinUse'] )
        {
            return redirect()->back()->withErrors(['message' => 'Date in use should be greater than or equal to date of acquisition ']);
        }
        $assetland =  assetsintangible::where('id',$request['id'])->first();
        $assetland->assetNumber = $request['AssetNumber'];
        $assetland->_condition = $request['AssetCondition'];
        $assetland->depreciationRate = 100/$request['AssetUsefulLife'];
        $assetland->usefulLife = $request['AssetUsefulLife'];
        $assetland->assetLocation = $request['SiteLocation'];
        $assetland->assetDescription = $request['AssetDescription'];
        $assetland->assetAcquisitionDate = $request['DateofAcquisition'];
        $assetland->assetQuantity = $request['Quantity'];
        $assetland->Cost = $request['cost'];
        $assetland->assetDateinUse = $request['DateinUse'];

        $end = $request['DateinUse'];

        $assetland->assetEndingDepreciationDate = date('Y-m-d',strtotime($end.'+5 Years'));

        $assetland->addedBy = auth()->user()->id;
        $assetland->save();

        return redirect()->route('assetsIntangibleView',[$request["id"]])->with(['message' => 'Changes Saved Succesfully']);
     }

     //



     public function assetsNewMotorVehicle()
     {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();

        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('assetsNewMotorVehicle',['role'=>$role,'notifications'=>$notifications]);
     }

     public function assetsNewMotorVehicleSave(Request $request)
     {
        $request->validate([
            'SiteLocation'=>'required',
            'Quantity'=>'required',
        ]);
        if( $request['DateofAcquisition'] > $request['DateinUse'] )
        {
            return redirect()->back()->withErrors(['message' => 'Date in use should be greater than or equal to date of acquisition ']);
        }
        $assetland = new assetsmotorvehicle();
        $assetland->assetNumber = $request['AssetNumber'];
        $assetland->_condition = $request['AssetCondition'];
        $assetland->depreciationRate = 100/$request['AssetUsefulLife'];
        $assetland->usefulLife = $request['AssetUsefulLife'];
        $assetland->assetLocation = $request['SiteLocation'];
        $assetland->location = $request['SiteLocation2'];
        $assetland->assetDescription = $request['AssetDescription'];
        $assetland->assetAcquisitionDate = $request['DateofAcquisition'];
        $assetland->assetQuantity = $request['Quantity'];
        $assetland->assetDateinUse = $request['DateinUse'];
        $assetland->Cost = $request['cost'];

        $end = $request['DateinUse'];

        $assetland->assetEndingDepreciationDate = date('Y-m-d',strtotime($end.'+5 Years'));

        $assetland->addedBy = auth()->user()->id;
        $assetland->save();

        return redirect()->route('assetsMotorVehicle')->with(['message' => 'New Asset Added Succesfully']);
     }

     public function assetsMotorVehicle()
     {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $land = assetsmotorvehicle::get();
        return view('assetsMotorVehicle',['land'=>$land,'role'=>$role,'notifications'=>$notifications]);
     }
     public function assetsMotorVehicleView($id)
     {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $land = assetsmotorvehicle::where('id',$id)->get();
        $asses = assetsassesmotorvehicle::where('assetID',$id)->get();
        return view('assetsMotorVehicleView',['asses'=>$asses,'land'=>$land,'role'=>$role,'notifications'=>$notifications]);
     }

     public function assetsMotorVehicleEdit($id)
     {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $land = assetsmotorvehicle::where('id',$id)->get();
        return view('assetsMotorVehicleEdit',['land'=>$land,'role'=>$role,'notifications'=>$notifications]);
     }

     public function assetsMotorVehicleEditSave(Request $request)
     {if( $request['DateofAcquisition'] > $request['DateinUse'] )
        {
            return redirect()->back()->withErrors(['message' => 'Date in use should be greater than or equal to date of acquisition ']);
        }
        $assetland =  assetsmotorvehicle::where('id',$request['id'])->first();
        $assetland->assetNumber = $request['AssetNumber'];
        $assetland->assetLocation = $request['SiteLocation'];
        $assetland->_condition = $request['AssetCondition'];
        $assetland->depreciationRate = 100/$request['AssetUsefulLife'];
        $assetland->usefulLife = $request['AssetUsefulLife'];
        $assetland->location = $request['SiteLocation2'];
        $assetland->assetDescription = $request['AssetDescription'];
        $assetland->assetAcquisitionDate = $request['DateofAcquisition'];
        $assetland->assetQuantity = $request['Quantity'];
        $assetland->assetDateinUse = $request['DateinUse'];
        $assetland->Cost = $request['cost'];

        $end = $request['DateinUse'];

        $assetland->assetEndingDepreciationDate = date('Y-m-d',strtotime($end.'+5 Years'));

        $assetland->addedBy = auth()->user()->id;
        $assetland->save();

        return redirect()->route('assetsMotorVehicleView',[$request["id"]])->with(['message' => 'Changes Saved Succesfully']);
     }

     //



     public function assetsNewFurniture()
     {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();

        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('assetsNewFurniture',['role'=>$role,'notifications'=>$notifications]);
     }

     public function assetsNewFurnitureSave(Request $request)
     {
        $request->validate([
            'SiteLocation'=>'required',
            'Quantity'=>'required',
        ]);
        if( $request['DateofAcquisition'] > $request['DateinUse'] )
        {
            return redirect()->back()->withErrors(['message' => 'Date in use should be greater than or equal to date of acquisition ']);
        }
        $assetland = new assetsfurniture();
        $assetland->_condition = $request['AssetCondition'];
        $assetland->depreciationRate = 100/$request['AssetUsefulLife'];
        $assetland->usefulLife = $request['AssetUsefulLife'];

                        //
                        if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'CoICT'.$request['AssetNumber'];
                        $assetland->assetLocation = 'College of Information and Communication Technologies';

                        }else  if($request['SiteLocation']=='CoET')
                        {

                        $assetland->assetNumber = 'CoET'.$request['AssetNumber'];
                        $assetland->assetLocation = 'College of Engineering and Technology';

                        }else if($request['SiteLocation']=='CoAF')
                        {

                        $assetland->assetNumber = 'CoAF'.$request['AssetNumber'];
                        $assetland->assetLocation = 'College of Agricultural Science and Fisheries Technology';

                        }else  if($request['SiteLocation']=='CoSS')
                        {

                        $assetland->assetNumber = 'CoSS'.$request['AssetNumber'];
                        $assetland->assetLocation = 'College of Social science';

                        }else if($request['SiteLocation']=='SJMC')
                        {

                        $assetland->assetNumber = 'SJMC'.$request['AssetNumber'];
                        $assetland->assetLocation = 'School of Journalism and Mass Communication';

                        }else  if($request['SiteLocation']=='UDBS')
                        {

                        $assetland->assetNumber = 'UDBS'.$request['AssetNumber'];
                        $assetland->assetLocation = 'University of Dar es Salaam Business School';

                        }else if($request['SiteLocation']=='CoHU')
                        {

                        $assetland->assetNumber = 'CoHU'.$request['AssetNumber'];
                        $assetland->assetLocation = 'College of Humanities';

                        }else if($request['SiteLocation']=='CONAS')
                        {

                        $assetland->assetNumber = 'CONAS'.$request['AssetNumber'];
                        $assetland->assetLocation = 'College of Natural and Applied Sciences';

                        }else if($request['SiteLocation']=='SoED')
                        {

                        $assetland->assetNumber = 'SoED'.$request['AssetNumber'];
                        $assetland->assetLocation = 'School of Education';

                        }else if($request['SiteLocation']=='UDSoL')
                        {

                        $assetland->assetNumber = 'UDSoL'.$request['AssetNumber'];
                        $assetland->assetLocation = 'University of Dar es salaam School of Law';

                        }else if($request['SiteLocation']=='IDS')
                        {

                        $assetland->assetNumber = 'IDS'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Institute of Development Studies';

                        }else if($request['SiteLocation']=='IKS')
                        {

                        $assetland->assetNumber = 'IKS'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Institute of Kiswahili Studies';

                        }else if($request['SiteLocation']=='IRA')
                        {

                        $assetland->assetNumber = 'IRA'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Institute of Resource Assesment';

                        }else if($request['SiteLocation']=='IMS')
                        {

                        $assetland->assetNumber = 'IMS'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Institute of Marine Sciences';

                        }else if($request['SiteLocation']=='CIUDSM')
                        {

                        $assetland->assetNumber = 'CIUDSM'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Confucius Institute';

                        }else if($request['SiteLocation']=='IGS')
                        {

                        $assetland->assetNumber = 'IGS'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Institute of Gender Studies';

                        }else if($request['SiteLocation']=='MCHS')
                        {

                        $assetland->assetNumber = 'MCHS'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Mbeya college of health and allied sciences';

                        }else if($request['SiteLocation']=='DES')
                        {

                        $assetland->assetNumber = 'DES'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Directorate of Estates Services';

                        }else if($request['SiteLocation']=='ULB')
                        {

                        $assetland->assetNumber = 'ULB'.$request['AssetNumber'];
                        $assetland->assetLocation = 'University Library';

                        }else if($request['SiteLocation']=='VC')
                        {

                        $assetland->assetNumber = 'VC'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Vice Chancelor\'s Office';

                        }else if($request['SiteLocation']=='CCC')
                        {

                        $assetland->assetNumber = 'CCC'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Center for Climate Change Studies';

                        }else if($request['SiteLocation']=='MHL')
                        {

                        $assetland->assetNumber = 'MHL'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Mabibo Hostel';

                        }else if($request['SiteLocation']=='MNS')
                        {

                        $assetland->assetNumber = 'MNS'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Mlimani Nursery School';

                        }else if($request['SiteLocation']=='ADM')
                        {

                        $assetland->assetNumber = 'ADM'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Administration Block';

                        }else if($request['SiteLocation']=='DRP')
                        {

                        $assetland->assetNumber = 'DRP'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Directorate of Research and Publication';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'KHL'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Kijitonyama Hostel';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'LCR'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Lecture Room';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'MSH'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Magufuli Hostel';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'HL1'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Hall 1 Hostel';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'HL2'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Hall 2 Hostel';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'HL3'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Hall 3 Hostel';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'HL4'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Hall 4 Hostel';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'HL5'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Hall 5 Hostel';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'HL6'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Hall 6 Hostel';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'HL7'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Hall 7 Hostel';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'MKH'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Mikocheni Hostel';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'SMR'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Seminar Room';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'THR'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Theater Room';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'UBH'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Ubungo Hostel';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'DOP'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Directorate of Post Graduate Studies';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'MCLB'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Michaud Library';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'WHR'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Water Resources Houses';

                        }else
                        {

                        $assetland->assetNumber = $request['AssetNumber'];
                        $assetland->assetLocation = $request['SiteLocation'];
                        }
                        //

        $assetland->assetDescription = $request['AssetDescription'];
        $assetland->assetAcquisitionDate = $request['DateofAcquisition'];
        $assetland->assetQuantity = $request['Quantity'];
        $assetland->assetDateinUse = $request['DateinUse'];
        $assetland->Cost = $request['cost'];

        $end = $request['DateinUse'];

        $assetland->assetEndingDepreciationDate = date('Y-m-d',strtotime($end.'+5 Years'));

        $assetland->addedBy = auth()->user()->id;
        $assetland->save();

        return redirect()->route('assetsFurniture')->with(['message' => 'New Asset Added Succesfully']);
     }

     public function assetsFurniture()
     {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $land = assetsfurniture::get();
        return view('assetsFurniture',['land'=>$land,'role'=>$role,'notifications'=>$notifications]);
     }
     public function assetsFurnitureView($id)
     {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $land = assetsfurniture::where('id',$id)->get();
        $asses = assetsassesfurniture::where('assetID',$id)->get();
        return view('assetsFurnitureView',['asses'=>$asses,'land'=>$land,'role'=>$role,'notifications'=>$notifications]);
     }

     public function assetsFurnitureEdit($id)
     {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $land = assetsfurniture::where('id',$id)->get();
        return view('assetsFurnitureEdit',['land'=>$land,'role'=>$role,'notifications'=>$notifications]);
     }

     public function assetsFurnitureEditSave(Request $request)
     {if( $request['DateofAcquisition'] > $request['DateinUse'] )
        {
            return redirect()->back()->withErrors(['message' => 'Date in use should be greater than or equal to date of acquisition ']);
        }
        $assetland =  assetsfurniture::where('id',$request['id'])->first();
        $assetland->assetDescription = $request['AssetDescription'];
        $assetland->assetAcquisitionDate = $request['DateofAcquisition'];
        $assetland->assetQuantity = $request['Quantity'];
        $assetland->_condition = $request['AssetCondition'];

                        //
                        if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'CoICT'.$request['AssetNumber'];
                        $assetland->assetLocation = 'College of Information and Communication Technologies';

                        }else  if($request['SiteLocation']=='CoET')
                        {

                        $assetland->assetNumber = 'CoET'.$request['AssetNumber'];
                        $assetland->assetLocation = 'College of Engineering and Technology';

                        }else if($request['SiteLocation']=='CoAF')
                        {

                        $assetland->assetNumber = 'CoAF'.$request['AssetNumber'];
                        $assetland->assetLocation = 'College of Agricultural Science and Fisheries Technology';

                        }else  if($request['SiteLocation']=='CoSS')
                        {

                        $assetland->assetNumber = 'CoSS'.$request['AssetNumber'];
                        $assetland->assetLocation = 'College of Social science';

                        }else if($request['SiteLocation']=='SJMC')
                        {

                        $assetland->assetNumber = 'SJMC'.$request['AssetNumber'];
                        $assetland->assetLocation = 'School of Journalism and Mass Communication';

                        }else  if($request['SiteLocation']=='UDBS')
                        {

                        $assetland->assetNumber = 'UDBS'.$request['AssetNumber'];
                        $assetland->assetLocation = 'University of Dar es Salaam Business School';

                        }else if($request['SiteLocation']=='CoHU')
                        {

                        $assetland->assetNumber = 'CoHU'.$request['AssetNumber'];
                        $assetland->assetLocation = 'College of Humanities';

                        }else if($request['SiteLocation']=='CONAS')
                        {

                        $assetland->assetNumber = 'CONAS'.$request['AssetNumber'];
                        $assetland->assetLocation = 'College of Natural and Applied Sciences';

                        }else if($request['SiteLocation']=='SoED')
                        {

                        $assetland->assetNumber = 'SoED'.$request['AssetNumber'];
                        $assetland->assetLocation = 'School of Education';

                        }else if($request['SiteLocation']=='UDSoL')
                        {

                        $assetland->assetNumber = 'UDSoL'.$request['AssetNumber'];
                        $assetland->assetLocation = 'University of Dar es salaam School of Law';

                        }else if($request['SiteLocation']=='IDS')
                        {

                        $assetland->assetNumber = 'IDS'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Institute of Development Studies';

                        }else if($request['SiteLocation']=='IKS')
                        {

                        $assetland->assetNumber = 'IKS'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Institute of Kiswahili Studies';

                        }else if($request['SiteLocation']=='IRA')
                        {

                        $assetland->assetNumber = 'IRA'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Institute of Resource Assesment';

                        }else if($request['SiteLocation']=='IMS')
                        {

                        $assetland->assetNumber = 'IMS'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Institute of Marine Sciences';

                        }else if($request['SiteLocation']=='CIUDSM')
                        {

                        $assetland->assetNumber = 'CIUDSM'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Confucius Institute';

                        }else if($request['SiteLocation']=='IGS')
                        {

                        $assetland->assetNumber = 'IGS'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Institute of Gender Studies';

                        }else if($request['SiteLocation']=='MCHS')
                        {

                        $assetland->assetNumber = 'MCHS'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Mbeya college of health and allied sciences';

                        }else if($request['SiteLocation']=='DES')
                        {

                        $assetland->assetNumber = 'DES'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Directorate of Estates Services';

                        }else if($request['SiteLocation']=='ULB')
                        {

                        $assetland->assetNumber = 'ULB'.$request['AssetNumber'];
                        $assetland->assetLocation = 'University Library';

                        }else if($request['SiteLocation']=='VC')
                        {

                        $assetland->assetNumber = 'VC'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Vice Chancelor\'s Office';

                        }else if($request['SiteLocation']=='CCC')
                        {

                        $assetland->assetNumber = 'CCC'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Center for Climate Change Studies';

                        }else if($request['SiteLocation']=='MHL')
                        {

                        $assetland->assetNumber = 'MHL'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Mabibo Hostel';

                        }else if($request['SiteLocation']=='MNS')
                        {

                        $assetland->assetNumber = 'MNS'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Mlimani Nursery School';

                        }else if($request['SiteLocation']=='ADM')
                        {

                        $assetland->assetNumber = 'ADM'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Administration Block';

                        }else if($request['SiteLocation']=='DRP')
                        {

                        $assetland->assetNumber = 'DRP'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Directorate of Research and Publication';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'KHL'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Kijitonyama Hostel';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'LCR'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Lecture Room';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'MSH'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Magufuli Hostel';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'HL1'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Hall 1 Hostel';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'HL2'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Hall 2 Hostel';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'HL3'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Hall 3 Hostel';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'HL4'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Hall 4 Hostel';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'HL5'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Hall 5 Hostel';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'HL6'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Hall 6 Hostel';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'HL7'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Hall 7 Hostel';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'MKH'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Mikocheni Hostel';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'SMR'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Seminar Room';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'THR'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Theater Room';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'UBH'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Ubungo Hostel';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'DOP'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Directorate of Post Graduate Studies';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'MCLB'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Michaud Library';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'WHR'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Water Resources Houses';

                        }else
                        {

                        $assetland->assetNumber = $request['AssetNumber'];
                        $assetland->assetLocation = $request['SiteLocation'];
                        }
                        //

        $assetland->depreciationRate = 100/$request['AssetUsefulLife'];
        $assetland->usefulLife = $request['AssetUsefulLife'];
        $assetland->assetDateinUse = $request['DateinUse'];
        $assetland->Cost = $request['cost'];

        $end = $request['DateinUse'];

        $assetland->assetEndingDepreciationDate = date('Y-m-d',strtotime($end.'+5 Years'));

        $assetland->addedBy = auth()->user()->id;
        $assetland->save();

        return redirect()->route('assetsFurnitureView',[$request["id"]])->with(['message' => 'Changes Saved Succesfully']);
     }

     //



     public function assetsNewEquipment()
     {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();

        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('assetsNewEquipment',['role'=>$role,'notifications'=>$notifications]);
     }

     public function assetsNewEquipmentSave(Request $request)
     {
        $request->validate([
            'SiteLocation'=>'required',
            'Quantity'=>'required',
        ]);
        if( $request['DateofAcquisition'] > $request['DateinUse'] )
        {
            return redirect()->back()->withErrors(['message' => 'Date in use should be greater than or equal to date of acquisition ']);
        }
        $assetland = new assetsequipment();
        $assetland->_condition = $request['AssetCondition'];
        $assetland->depreciationRate = 100/$request['AssetUsefulLife'];
        $assetland->usefulLife = $request['AssetUsefulLife'];
        $assetland->location = $request['SiteLocation2'];

                        //
                        if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'CoICT'.$request['AssetNumber'];
                        $assetland->assetLocation = 'College of Information and Communication Technologies';

                        }else  if($request['SiteLocation']=='CoET')
                        {

                        $assetland->assetNumber = 'CoET'.$request['AssetNumber'];
                        $assetland->assetLocation = 'College of Engineering and Technology';

                        }else if($request['SiteLocation']=='CoAF')
                        {

                        $assetland->assetNumber = 'CoAF'.$request['AssetNumber'];
                        $assetland->assetLocation = 'College of Agricultural Science and Fisheries Technology';

                        }else  if($request['SiteLocation']=='CoSS')
                        {

                        $assetland->assetNumber = 'CoSS'.$request['AssetNumber'];
                        $assetland->assetLocation = 'College of Social science';

                        }else if($request['SiteLocation']=='SJMC')
                        {

                        $assetland->assetNumber = 'SJMC'.$request['AssetNumber'];
                        $assetland->assetLocation = 'School of Journalism and Mass Communication';

                        }else  if($request['SiteLocation']=='UDBS')
                        {

                        $assetland->assetNumber = 'UDBS'.$request['AssetNumber'];
                        $assetland->assetLocation = 'University of Dar es Salaam Business School';

                        }else if($request['SiteLocation']=='CoHU')
                        {

                        $assetland->assetNumber = 'CoHU'.$request['AssetNumber'];
                        $assetland->assetLocation = 'College of Humanities';

                        }else if($request['SiteLocation']=='CONAS')
                        {

                        $assetland->assetNumber = 'CONAS'.$request['AssetNumber'];
                        $assetland->assetLocation = 'College of Natural and Applied Sciences';

                        }else if($request['SiteLocation']=='SoED')
                        {

                        $assetland->assetNumber = 'SoED'.$request['AssetNumber'];
                        $assetland->assetLocation = 'School of Education';

                        }else if($request['SiteLocation']=='UDSoL')
                        {

                        $assetland->assetNumber = 'UDSoL'.$request['AssetNumber'];
                        $assetland->assetLocation = 'University of Dar es salaam School of Law';

                        }else if($request['SiteLocation']=='IDS')
                        {

                        $assetland->assetNumber = 'IDS'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Institute of Development Studies';

                        }else if($request['SiteLocation']=='IKS')
                        {

                        $assetland->assetNumber = 'IKS'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Institute of Kiswahili Studies';

                        }else if($request['SiteLocation']=='IRA')
                        {

                        $assetland->assetNumber = 'IRA'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Institute of Resource Assesment';

                        }else if($request['SiteLocation']=='IMS')
                        {

                        $assetland->assetNumber = 'IMS'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Institute of Marine Sciences';

                        }else if($request['SiteLocation']=='CIUDSM')
                        {

                        $assetland->assetNumber = 'CIUDSM'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Confucius Institute';

                        }else if($request['SiteLocation']=='IGS')
                        {

                        $assetland->assetNumber = 'IGS'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Institute of Gender Studies';

                        }else if($request['SiteLocation']=='MCHS')
                        {

                        $assetland->assetNumber = 'MCHS'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Mbeya college of health and allied sciences';

                        }else if($request['SiteLocation']=='DES')
                        {

                        $assetland->assetNumber = 'DES'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Directorate of Estates Services';

                        }else if($request['SiteLocation']=='ULB')
                        {

                        $assetland->assetNumber = 'ULB'.$request['AssetNumber'];
                        $assetland->assetLocation = 'University Library';

                        }else if($request['SiteLocation']=='VC')
                        {

                        $assetland->assetNumber = 'VC'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Vice Chancelor\'s Office';

                        }else if($request['SiteLocation']=='CCC')
                        {

                        $assetland->assetNumber = 'CCC'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Center for Climate Change Studies';

                        }else if($request['SiteLocation']=='MHL')
                        {

                        $assetland->assetNumber = 'MHL'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Mabibo Hostel';

                        }else if($request['SiteLocation']=='MNS')
                        {

                        $assetland->assetNumber = 'MNS'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Mlimani Nursery School';

                        }else if($request['SiteLocation']=='ADM')
                        {

                        $assetland->assetNumber = 'ADM'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Administration Block';

                        }else if($request['SiteLocation']=='DRP')
                        {

                        $assetland->assetNumber = 'DRP'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Directorate of Research and Publication';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'KHL'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Kijitonyama Hostel';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'LCR'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Lecture Room';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'MSH'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Magufuli Hostel';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'HL1'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Hall 1 Hostel';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'HL2'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Hall 2 Hostel';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'HL3'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Hall 3 Hostel';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'HL4'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Hall 4 Hostel';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'HL5'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Hall 5 Hostel';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'HL6'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Hall 6 Hostel';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'HL7'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Hall 7 Hostel';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'MKH'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Mikocheni Hostel';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'SMR'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Seminar Room';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'THR'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Theater Room';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'UBH'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Ubungo Hostel';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'DOP'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Directorate of Post Graduate Studies';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'MCLB'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Michaud Library';

                        }else if($request['SiteLocation']=='CoICT')
                        {

                        $assetland->assetNumber = 'WHR'.$request['AssetNumber'];
                        $assetland->assetLocation = 'Water Resources Houses';

                        }else
                        {

                        $assetland->assetNumber = $request['AssetNumber'];
                        $assetland->assetLocation = $request['SiteLocation'];
                        }
                        //

        $assetland->assetDescription = $request['AssetDescription'];
        $assetland->assetAcquisitionDate = $request['DateofAcquisition'];
        $assetland->assetQuantity = $request['Quantity'];
        $assetland->assetDateinUse = $request['DateinUse'];
        $assetland->Cost = $request['cost'];

        $end = $request['DateinUse'];

        $assetland->assetEndingDepreciationDate = date('Y-m-d',strtotime($end.'+5 Years'));

        $assetland->addedBy = auth()->user()->id;
        $assetland->save();

        return redirect()->route('assetsEquipment')->with(['message' => 'New Asset Added Succesfully']);
     }

     public function assetsEquipment()
     {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $land = assetsequipment::get();
        return view('assetsEquipment',['land'=>$land,'role'=>$role,'notifications'=>$notifications]);
     }
     public function assetsEquipmentView($id)
     {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $land = assetsequipment::where('id',$id)->get();
        $asses = assetsassesequipment::where('assetID',$id)->get();
        return view('assetsEquipmentView',['asses'=>$asses,'land'=>$land,'role'=>$role,'notifications'=>$notifications]);
     }

     public function assetsEquipmentEdit($id)
     {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $land = assetsequipment::where('id',$id)->get();
        return view('assetsEquipmentEdit',['land'=>$land,'role'=>$role,'notifications'=>$notifications]);
     }

     public function assetsEquipmentEditSave(Request $request)
     {if( $request['DateofAcquisition'] > $request['DateinUse'] )
        {
            return redirect()->back()->withErrors(['message' => 'Date in use should be greater than or equal to date of acquisition ']);
        }
        $assetland =  assetsequipment::where('id',$request['id'])->first();
        $assetland->_condition = $request['AssetCondition'];
        $assetland->depreciationRate = 100/$request['AssetUsefulLife'];
        $assetland->usefulLife = $request['AssetUsefulLife'];
        $assetland->location = $request['SiteLocation2'];

                         //
                         if($request['SiteLocation']=='CoICT')
                         {

                         $assetland->assetNumber = 'CoICT'.$request['AssetNumber'];
                         $assetland->assetLocation = 'College of Information and Communication Technologies';

                         }else  if($request['SiteLocation']=='CoET')
                         {

                         $assetland->assetNumber = 'CoET'.$request['AssetNumber'];
                         $assetland->assetLocation = 'College of Engineering and Technology';

                         }else if($request['SiteLocation']=='CoAF')
                         {

                         $assetland->assetNumber = 'CoAF'.$request['AssetNumber'];
                         $assetland->assetLocation = 'College of Agricultural Science and Fisheries Technology';

                         }else  if($request['SiteLocation']=='CoSS')
                         {

                         $assetland->assetNumber = 'CoSS'.$request['AssetNumber'];
                         $assetland->assetLocation = 'College of Social science';

                         }else if($request['SiteLocation']=='SJMC')
                         {

                         $assetland->assetNumber = 'SJMC'.$request['AssetNumber'];
                         $assetland->assetLocation = 'School of Journalism and Mass Communication';

                         }else  if($request['SiteLocation']=='UDBS')
                         {

                         $assetland->assetNumber = 'UDBS'.$request['AssetNumber'];
                         $assetland->assetLocation = 'University of Dar es Salaam Business School';

                         }else if($request['SiteLocation']=='CoHU')
                         {

                         $assetland->assetNumber = 'CoHU'.$request['AssetNumber'];
                         $assetland->assetLocation = 'College of Humanities';

                         }else if($request['SiteLocation']=='CONAS')
                         {

                         $assetland->assetNumber = 'CONAS'.$request['AssetNumber'];
                         $assetland->assetLocation = 'College of Natural and Applied Sciences';

                         }else if($request['SiteLocation']=='SoED')
                         {

                         $assetland->assetNumber = 'SoED'.$request['AssetNumber'];
                         $assetland->assetLocation = 'School of Education';

                         }else if($request['SiteLocation']=='UDSoL')
                         {

                         $assetland->assetNumber = 'UDSoL'.$request['AssetNumber'];
                         $assetland->assetLocation = 'University of Dar es salaam School of Law';

                         }else if($request['SiteLocation']=='IDS')
                         {

                         $assetland->assetNumber = 'IDS'.$request['AssetNumber'];
                         $assetland->assetLocation = 'Institute of Development Studies';

                         }else if($request['SiteLocation']=='IKS')
                         {

                         $assetland->assetNumber = 'IKS'.$request['AssetNumber'];
                         $assetland->assetLocation = 'Institute of Kiswahili Studies';

                         }else if($request['SiteLocation']=='IRA')
                         {

                         $assetland->assetNumber = 'IRA'.$request['AssetNumber'];
                         $assetland->assetLocation = 'Institute of Resource Assesment';

                         }else if($request['SiteLocation']=='IMS')
                         {

                         $assetland->assetNumber = 'IMS'.$request['AssetNumber'];
                         $assetland->assetLocation = 'Institute of Marine Sciences';

                         }else if($request['SiteLocation']=='CIUDSM')
                         {

                         $assetland->assetNumber = 'CIUDSM'.$request['AssetNumber'];
                         $assetland->assetLocation = 'Confucius Institute';

                         }else if($request['SiteLocation']=='IGS')
                         {

                         $assetland->assetNumber = 'IGS'.$request['AssetNumber'];
                         $assetland->assetLocation = 'Institute of Gender Studies';

                         }else if($request['SiteLocation']=='MCHS')
                         {

                         $assetland->assetNumber = 'MCHS'.$request['AssetNumber'];
                         $assetland->assetLocation = 'Mbeya college of health and allied sciences';

                         }else if($request['SiteLocation']=='DES')
                         {

                         $assetland->assetNumber = 'DES'.$request['AssetNumber'];
                         $assetland->assetLocation = 'Directorate of Estates Services';

                         }else if($request['SiteLocation']=='ULB')
                         {

                         $assetland->assetNumber = 'ULB'.$request['AssetNumber'];
                         $assetland->assetLocation = 'University Library';

                         }else if($request['SiteLocation']=='VC')
                         {

                         $assetland->assetNumber = 'VC'.$request['AssetNumber'];
                         $assetland->assetLocation = 'Vice Chancelor\'s Office';

                         }else if($request['SiteLocation']=='CCC')
                         {

                         $assetland->assetNumber = 'CCC'.$request['AssetNumber'];
                         $assetland->assetLocation = 'Center for Climate Change Studies';

                         }else if($request['SiteLocation']=='MHL')
                         {

                         $assetland->assetNumber = 'MHL'.$request['AssetNumber'];
                         $assetland->assetLocation = 'Mabibo Hostel';

                         }else if($request['SiteLocation']=='MNS')
                         {

                         $assetland->assetNumber = 'MNS'.$request['AssetNumber'];
                         $assetland->assetLocation = 'Mlimani Nursery School';

                         }else if($request['SiteLocation']=='ADM')
                         {

                         $assetland->assetNumber = 'ADM'.$request['AssetNumber'];
                         $assetland->assetLocation = 'Administration Block';

                         }else if($request['SiteLocation']=='DRP')
                         {

                         $assetland->assetNumber = 'DRP'.$request['AssetNumber'];
                         $assetland->assetLocation = 'Directorate of Research and Publication';

                         }else if($request['SiteLocation']=='CoICT')
                         {

                         $assetland->assetNumber = 'KHL'.$request['AssetNumber'];
                         $assetland->assetLocation = 'Kijitonyama Hostel';

                         }else if($request['SiteLocation']=='CoICT')
                         {

                         $assetland->assetNumber = 'LCR'.$request['AssetNumber'];
                         $assetland->assetLocation = 'Lecture Room';

                         }else if($request['SiteLocation']=='CoICT')
                         {

                         $assetland->assetNumber = 'MSH'.$request['AssetNumber'];
                         $assetland->assetLocation = 'Magufuli Hostel';

                         }else if($request['SiteLocation']=='CoICT')
                         {

                         $assetland->assetNumber = 'HL1'.$request['AssetNumber'];
                         $assetland->assetLocation = 'Hall 1 Hostel';

                         }else if($request['SiteLocation']=='CoICT')
                         {

                         $assetland->assetNumber = 'HL2'.$request['AssetNumber'];
                         $assetland->assetLocation = 'Hall 2 Hostel';

                         }else if($request['SiteLocation']=='CoICT')
                         {

                         $assetland->assetNumber = 'HL3'.$request['AssetNumber'];
                         $assetland->assetLocation = 'Hall 3 Hostel';

                         }else if($request['SiteLocation']=='CoICT')
                         {

                         $assetland->assetNumber = 'HL4'.$request['AssetNumber'];
                         $assetland->assetLocation = 'Hall 4 Hostel';

                         }else if($request['SiteLocation']=='CoICT')
                         {

                         $assetland->assetNumber = 'HL5'.$request['AssetNumber'];
                         $assetland->assetLocation = 'Hall 5 Hostel';

                         }else if($request['SiteLocation']=='CoICT')
                         {

                         $assetland->assetNumber = 'HL6'.$request['AssetNumber'];
                         $assetland->assetLocation = 'Hall 6 Hostel';

                         }else if($request['SiteLocation']=='CoICT')
                         {

                         $assetland->assetNumber = 'HL7'.$request['AssetNumber'];
                         $assetland->assetLocation = 'Hall 7 Hostel';

                         }else if($request['SiteLocation']=='CoICT')
                         {

                         $assetland->assetNumber = 'MKH'.$request['AssetNumber'];
                         $assetland->assetLocation = 'Mikocheni Hostel';

                         }else if($request['SiteLocation']=='CoICT')
                         {

                         $assetland->assetNumber = 'SMR'.$request['AssetNumber'];
                         $assetland->assetLocation = 'Seminar Room';

                         }else if($request['SiteLocation']=='CoICT')
                         {

                         $assetland->assetNumber = 'THR'.$request['AssetNumber'];
                         $assetland->assetLocation = 'Theater Room';

                         }else if($request['SiteLocation']=='CoICT')
                         {

                         $assetland->assetNumber = 'UBH'.$request['AssetNumber'];
                         $assetland->assetLocation = 'Ubungo Hostel';

                         }else if($request['SiteLocation']=='CoICT')
                         {

                         $assetland->assetNumber = 'DOP'.$request['AssetNumber'];
                         $assetland->assetLocation = 'Directorate of Post Graduate Studies';

                         }else if($request['SiteLocation']=='CoICT')
                         {

                         $assetland->assetNumber = 'MCLB'.$request['AssetNumber'];
                         $assetland->assetLocation = 'Michaud Library';

                         }else if($request['SiteLocation']=='CoICT')
                         {

                         $assetland->assetNumber = 'WHR'.$request['AssetNumber'];
                         $assetland->assetLocation = 'Water Resources Houses';

                         }else
                         {

                         $assetland->assetNumber = $request['AssetNumber'];
                         $assetland->assetLocation = $request['SiteLocation'];
                         }
                         //

        $assetland->assetDescription = $request['AssetDescription'];
        $assetland->assetAcquisitionDate = $request['DateofAcquisition'];
        $assetland->assetQuantity = $request['Quantity'];
        $assetland->assetDateinUse = $request['DateinUse'];
        $assetland->Cost = $request['cost'];

        $end = $request['DateinUse'];

        $assetland->assetEndingDepreciationDate = date('Y-m-d',strtotime($end.'+5 Years'));

        $assetland->addedBy = auth()->user()->id;
        $assetland->save();

        return redirect()->route('assetsEquipmentView',[$request["id"]])->with(['message' => 'Changes Saved Succesfully']);
     }

     //



     public function assetsNewComputerEquipment()
     {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();

        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('assetsNewComputerEquipment',['role'=>$role,'notifications'=>$notifications]);
     }

     public function assetsNewComputerEquipmentSave(Request $request)
     {
        $request->validate([
            'SiteLocation'=>'required',
            'Quantity'=>'required',
        ]);
        if( $request['DateofAcquisition'] > $request['DateinUse'] )
        {
            return redirect()->back()->withErrors(['message' => 'Date in use should be greater than or equal to date of acquisition ']);
        }
        $assetland = new assetscomputerequipment();
        $assetland->_condition = $request['AssetCondition'];
        $assetland->depreciationRate = 100/$request['AssetUsefulLife'];
        $assetland->usefulLife = $request['AssetUsefulLife'];
        $assetland->location = $request['SiteLocation2'];

                 //
                 if($request['SiteLocation']=='CoICT')
                 {

                 $assetland->assetNumber = 'CoICT'.$request['AssetNumber'];
                 $assetland->assetLocation = 'College of Information and Communication Technologies';

                 }else  if($request['SiteLocation']=='CoET')
                 {

                 $assetland->assetNumber = 'CoET'.$request['AssetNumber'];
                 $assetland->assetLocation = 'College of Engineering and Technology';

                 }else if($request['SiteLocation']=='CoAF')
                 {

                 $assetland->assetNumber = 'CoAF'.$request['AssetNumber'];
                 $assetland->assetLocation = 'College of Agricultural Science and Fisheries Technology';

                 }else  if($request['SiteLocation']=='CoSS')
                 {

                 $assetland->assetNumber = 'CoSS'.$request['AssetNumber'];
                 $assetland->assetLocation = 'College of Social science';

                 }else if($request['SiteLocation']=='SJMC')
                 {

                 $assetland->assetNumber = 'SJMC'.$request['AssetNumber'];
                 $assetland->assetLocation = 'School of Journalism and Mass Communication';

                 }else  if($request['SiteLocation']=='UDBS')
                 {

                 $assetland->assetNumber = 'UDBS'.$request['AssetNumber'];
                 $assetland->assetLocation = 'University of Dar es Salaam Business School';

                 }else if($request['SiteLocation']=='CoHU')
                 {

                 $assetland->assetNumber = 'CoHU'.$request['AssetNumber'];
                 $assetland->assetLocation = 'College of Humanities';

                 }else if($request['SiteLocation']=='CONAS')
                 {

                 $assetland->assetNumber = 'CONAS'.$request['AssetNumber'];
                 $assetland->assetLocation = 'College of Natural and Applied Sciences';

                 }else if($request['SiteLocation']=='SoED')
                 {

                 $assetland->assetNumber = 'SoED'.$request['AssetNumber'];
                 $assetland->assetLocation = 'School of Education';

                 }else if($request['SiteLocation']=='UDSoL')
                 {

                 $assetland->assetNumber = 'UDSoL'.$request['AssetNumber'];
                 $assetland->assetLocation = 'University of Dar es salaam School of Law';

                 }else if($request['SiteLocation']=='IDS')
                 {

                 $assetland->assetNumber = 'IDS'.$request['AssetNumber'];
                 $assetland->assetLocation = 'Institute of Development Studies';

                 }else if($request['SiteLocation']=='IKS')
                 {

                 $assetland->assetNumber = 'IKS'.$request['AssetNumber'];
                 $assetland->assetLocation = 'Institute of Kiswahili Studies';

                 }else if($request['SiteLocation']=='IRA')
                 {

                 $assetland->assetNumber = 'IRA'.$request['AssetNumber'];
                 $assetland->assetLocation = 'Institute of Resource Assesment';

                 }else if($request['SiteLocation']=='IMS')
                 {

                 $assetland->assetNumber = 'IMS'.$request['AssetNumber'];
                 $assetland->assetLocation = 'Institute of Marine Sciences';

                 }else if($request['SiteLocation']=='CIUDSM')
                 {

                 $assetland->assetNumber = 'CIUDSM'.$request['AssetNumber'];
                 $assetland->assetLocation = 'Confucius Institute';

                 }else if($request['SiteLocation']=='IGS')
                 {

                 $assetland->assetNumber = 'IGS'.$request['AssetNumber'];
                 $assetland->assetLocation = 'Institute of Gender Studies';

                 }else if($request['SiteLocation']=='MCHS')
                 {

                 $assetland->assetNumber = 'MCHS'.$request['AssetNumber'];
                 $assetland->assetLocation = 'Mbeya college of health and allied sciences';

                 }else if($request['SiteLocation']=='DES')
                 {

                 $assetland->assetNumber = 'DES'.$request['AssetNumber'];
                 $assetland->assetLocation = 'Directorate of Estates Services';

                 }else if($request['SiteLocation']=='ULB')
                 {

                 $assetland->assetNumber = 'ULB'.$request['AssetNumber'];
                 $assetland->assetLocation = 'University Library';

                 }else if($request['SiteLocation']=='VC')
                 {

                 $assetland->assetNumber = 'VC'.$request['AssetNumber'];
                 $assetland->assetLocation = 'Vice Chancelor\'s Office';

                 }else if($request['SiteLocation']=='CCC')
                 {

                 $assetland->assetNumber = 'CCC'.$request['AssetNumber'];
                 $assetland->assetLocation = 'Center for Climate Change Studies';

                 }else if($request['SiteLocation']=='MHL')
                 {

                 $assetland->assetNumber = 'MHL'.$request['AssetNumber'];
                 $assetland->assetLocation = 'Mabibo Hostel';

                 }else if($request['SiteLocation']=='MNS')
                 {

                 $assetland->assetNumber = 'MNS'.$request['AssetNumber'];
                 $assetland->assetLocation = 'Mlimani Nursery School';

                 }else if($request['SiteLocation']=='ADM')
                 {

                 $assetland->assetNumber = 'ADM'.$request['AssetNumber'];
                 $assetland->assetLocation = 'Administration Block';

                 }else if($request['SiteLocation']=='DRP')
                 {

                 $assetland->assetNumber = 'DRP'.$request['AssetNumber'];
                 $assetland->assetLocation = 'Directorate of Research and Publication';

                 }else if($request['SiteLocation']=='CoICT')
                 {

                 $assetland->assetNumber = 'KHL'.$request['AssetNumber'];
                 $assetland->assetLocation = 'Kijitonyama Hostel';

                 }else if($request['SiteLocation']=='CoICT')
                 {

                 $assetland->assetNumber = 'LCR'.$request['AssetNumber'];
                 $assetland->assetLocation = 'Lecture Room';

                 }else if($request['SiteLocation']=='CoICT')
                 {

                 $assetland->assetNumber = 'MSH'.$request['AssetNumber'];
                 $assetland->assetLocation = 'Magufuli Hostel';

                 }else if($request['SiteLocation']=='CoICT')
                 {

                 $assetland->assetNumber = 'HL1'.$request['AssetNumber'];
                 $assetland->assetLocation = 'Hall 1 Hostel';

                 }else if($request['SiteLocation']=='CoICT')
                 {

                 $assetland->assetNumber = 'HL2'.$request['AssetNumber'];
                 $assetland->assetLocation = 'Hall 2 Hostel';

                 }else if($request['SiteLocation']=='CoICT')
                 {

                 $assetland->assetNumber = 'HL3'.$request['AssetNumber'];
                 $assetland->assetLocation = 'Hall 3 Hostel';

                 }else if($request['SiteLocation']=='CoICT')
                 {

                 $assetland->assetNumber = 'HL4'.$request['AssetNumber'];
                 $assetland->assetLocation = 'Hall 4 Hostel';

                 }else if($request['SiteLocation']=='CoICT')
                 {

                 $assetland->assetNumber = 'HL5'.$request['AssetNumber'];
                 $assetland->assetLocation = 'Hall 5 Hostel';

                 }else if($request['SiteLocation']=='CoICT')
                 {

                 $assetland->assetNumber = 'HL6'.$request['AssetNumber'];
                 $assetland->assetLocation = 'Hall 6 Hostel';

                 }else if($request['SiteLocation']=='CoICT')
                 {

                 $assetland->assetNumber = 'HL7'.$request['AssetNumber'];
                 $assetland->assetLocation = 'Hall 7 Hostel';

                 }else if($request['SiteLocation']=='CoICT')
                 {

                 $assetland->assetNumber = 'MKH'.$request['AssetNumber'];
                 $assetland->assetLocation = 'Mikocheni Hostel';

                 }else if($request['SiteLocation']=='CoICT')
                 {

                 $assetland->assetNumber = 'SMR'.$request['AssetNumber'];
                 $assetland->assetLocation = 'Seminar Room';

                 }else if($request['SiteLocation']=='CoICT')
                 {

                 $assetland->assetNumber = 'THR'.$request['AssetNumber'];
                 $assetland->assetLocation = 'Theater Room';

                 }else if($request['SiteLocation']=='CoICT')
                 {

                 $assetland->assetNumber = 'UBH'.$request['AssetNumber'];
                 $assetland->assetLocation = 'Ubungo Hostel';

                 }else if($request['SiteLocation']=='CoICT')
                 {

                 $assetland->assetNumber = 'DOP'.$request['AssetNumber'];
                 $assetland->assetLocation = 'Directorate of Post Graduate Studies';

                 }else if($request['SiteLocation']=='CoICT')
                 {

                 $assetland->assetNumber = 'MCLB'.$request['AssetNumber'];
                 $assetland->assetLocation = 'Michaud Library';

                 }else if($request['SiteLocation']=='CoICT')
                 {

                 $assetland->assetNumber = 'WHR'.$request['AssetNumber'];
                 $assetland->assetLocation = 'Water Resources Houses';

                 }else
                 {

                 $assetland->assetNumber = $request['AssetNumber'];
                 $assetland->assetLocation = $request['SiteLocation'];
                 }
                 //

        $assetland->assetDescription = $request['AssetDescription'];
        $assetland->assetAcquisitionDate = $request['DateofAcquisition'];
        $assetland->assetQuantity = $request['Quantity'];
        $assetland->assetDateinUse = $request['DateinUse'];
        $assetland->Cost = $request['cost'];

        $end = $request['DateinUse'];

        $assetland->assetEndingDepreciationDate = date('Y-m-d',strtotime($end.'+3 Years'));

        $assetland->addedBy = auth()->user()->id;
        $assetland->save();

        return redirect()->route('assetsComputerEquipment')->with(['message' => 'New Asset Added Succesfully']);
     }

     public function assetsComputerEquipment()
     {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $land = assetscomputerequipment::get();
        return view('assetsComputerEquipment',['land'=>$land,'role'=>$role,'notifications'=>$notifications]);
     }
     public function assetsComputerEquipmentView($id)
     {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $land = assetscomputerequipment::where('id',$id)->get();
        $asses = assetsassescomputerequipment::where('assetID',$id)->get();
        return view('assetsComputerEquipmentView',['asses'=>$asses,'land'=>$land,'role'=>$role,'notifications'=>$notifications]);
     }

     public function assetsComputerEquipmentEdit($id)
     {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $land = assetscomputerequipment::where('id',$id)->get();
        return view('assetsComputerEquipmentEdit',['land'=>$land,'role'=>$role,'notifications'=>$notifications]);
     }

     public function assetsComputerEquipmentEditSave(Request $request)
     {if( $request['DateofAcquisition'] > $request['DateinUse'] )
        {
            return redirect()->back()->withErrors(['message' => 'Date in use should be greater than or equal to date of acquisition ']);
        }
        $assetland =  assetscomputerequipment::where('id',$request['id'])->first();
        $assetland->_condition = $request['AssetCondition'];
        $assetland->depreciationRate = 100/$request['AssetUsefulLife'];
        $assetland->usefulLife = $request['AssetUsefulLife'];
        $assetland->location = $request['SiteLocation2'];

                     //
                     if($request['SiteLocation']=='CoICT')
                     {

                     $assetland->assetNumber = 'CoICT'.$request['AssetNumber'];
                     $assetland->assetLocation = 'College of Information and Communication Technologies';

                     }else  if($request['SiteLocation']=='CoET')
                     {

                     $assetland->assetNumber = 'CoET'.$request['AssetNumber'];
                     $assetland->assetLocation = 'College of Engineering and Technology';

                     }else if($request['SiteLocation']=='CoAF')
                     {

                     $assetland->assetNumber = 'CoAF'.$request['AssetNumber'];
                     $assetland->assetLocation = 'College of Agricultural Science and Fisheries Technology';

                     }else  if($request['SiteLocation']=='CoSS')
                     {

                     $assetland->assetNumber = 'CoSS'.$request['AssetNumber'];
                     $assetland->assetLocation = 'College of Social science';

                     }else if($request['SiteLocation']=='SJMC')
                     {

                     $assetland->assetNumber = 'SJMC'.$request['AssetNumber'];
                     $assetland->assetLocation = 'School of Journalism and Mass Communication';

                     }else  if($request['SiteLocation']=='UDBS')
                     {

                     $assetland->assetNumber = 'UDBS'.$request['AssetNumber'];
                     $assetland->assetLocation = 'University of Dar es Salaam Business School';

                     }else if($request['SiteLocation']=='CoHU')
                     {

                     $assetland->assetNumber = 'CoHU'.$request['AssetNumber'];
                     $assetland->assetLocation = 'College of Humanities';

                     }else if($request['SiteLocation']=='CONAS')
                     {

                     $assetland->assetNumber = 'CONAS'.$request['AssetNumber'];
                     $assetland->assetLocation = 'College of Natural and Applied Sciences';

                     }else if($request['SiteLocation']=='SoED')
                     {

                     $assetland->assetNumber = 'SoED'.$request['AssetNumber'];
                     $assetland->assetLocation = 'School of Education';

                     }else if($request['SiteLocation']=='UDSoL')
                     {

                     $assetland->assetNumber = 'UDSoL'.$request['AssetNumber'];
                     $assetland->assetLocation = 'University of Dar es salaam School of Law';

                     }else if($request['SiteLocation']=='IDS')
                     {

                     $assetland->assetNumber = 'IDS'.$request['AssetNumber'];
                     $assetland->assetLocation = 'Institute of Development Studies';

                     }else if($request['SiteLocation']=='IKS')
                     {

                     $assetland->assetNumber = 'IKS'.$request['AssetNumber'];
                     $assetland->assetLocation = 'Institute of Kiswahili Studies';

                     }else if($request['SiteLocation']=='IRA')
                     {

                     $assetland->assetNumber = 'IRA'.$request['AssetNumber'];
                     $assetland->assetLocation = 'Institute of Resource Assesment';

                     }else if($request['SiteLocation']=='IMS')
                     {

                     $assetland->assetNumber = 'IMS'.$request['AssetNumber'];
                     $assetland->assetLocation = 'Institute of Marine Sciences';

                     }else if($request['SiteLocation']=='CIUDSM')
                     {

                     $assetland->assetNumber = 'CIUDSM'.$request['AssetNumber'];
                     $assetland->assetLocation = 'Confucius Institute';

                     }else if($request['SiteLocation']=='IGS')
                     {

                     $assetland->assetNumber = 'IGS'.$request['AssetNumber'];
                     $assetland->assetLocation = 'Institute of Gender Studies';

                     }else if($request['SiteLocation']=='MCHS')
                     {

                     $assetland->assetNumber = 'MCHS'.$request['AssetNumber'];
                     $assetland->assetLocation = 'Mbeya college of health and allied sciences';

                     }else if($request['SiteLocation']=='DES')
                     {

                     $assetland->assetNumber = 'DES'.$request['AssetNumber'];
                     $assetland->assetLocation = 'Directorate of Estates Services';

                     }else if($request['SiteLocation']=='ULB')
                     {

                     $assetland->assetNumber = 'ULB'.$request['AssetNumber'];
                     $assetland->assetLocation = 'University Library';

                     }else if($request['SiteLocation']=='VC')
                     {

                     $assetland->assetNumber = 'VC'.$request['AssetNumber'];
                     $assetland->assetLocation = 'Vice Chancelor\'s Office';

                     }else if($request['SiteLocation']=='CCC')
                     {

                     $assetland->assetNumber = 'CCC'.$request['AssetNumber'];
                     $assetland->assetLocation = 'Center for Climate Change Studies';

                     }else if($request['SiteLocation']=='MHL')
                     {

                     $assetland->assetNumber = 'MHL'.$request['AssetNumber'];
                     $assetland->assetLocation = 'Mabibo Hostel';

                     }else if($request['SiteLocation']=='MNS')
                     {

                     $assetland->assetNumber = 'MNS'.$request['AssetNumber'];
                     $assetland->assetLocation = 'Mlimani Nursery School';

                     }else if($request['SiteLocation']=='ADM')
                     {

                     $assetland->assetNumber = 'ADM'.$request['AssetNumber'];
                     $assetland->assetLocation = 'Administration Block';

                     }else if($request['SiteLocation']=='DRP')
                     {

                     $assetland->assetNumber = 'DRP'.$request['AssetNumber'];
                     $assetland->assetLocation = 'Directorate of Research and Publication';

                     }else if($request['SiteLocation']=='CoICT')
                     {

                     $assetland->assetNumber = 'KHL'.$request['AssetNumber'];
                     $assetland->assetLocation = 'Kijitonyama Hostel';

                     }else if($request['SiteLocation']=='CoICT')
                     {

                     $assetland->assetNumber = 'LCR'.$request['AssetNumber'];
                     $assetland->assetLocation = 'Lecture Room';

                     }else if($request['SiteLocation']=='CoICT')
                     {

                     $assetland->assetNumber = 'MSH'.$request['AssetNumber'];
                     $assetland->assetLocation = 'Magufuli Hostel';

                     }else if($request['SiteLocation']=='CoICT')
                     {

                     $assetland->assetNumber = 'HL1'.$request['AssetNumber'];
                     $assetland->assetLocation = 'Hall 1 Hostel';

                     }else if($request['SiteLocation']=='CoICT')
                     {

                     $assetland->assetNumber = 'HL2'.$request['AssetNumber'];
                     $assetland->assetLocation = 'Hall 2 Hostel';

                     }else if($request['SiteLocation']=='CoICT')
                     {

                     $assetland->assetNumber = 'HL3'.$request['AssetNumber'];
                     $assetland->assetLocation = 'Hall 3 Hostel';

                     }else if($request['SiteLocation']=='CoICT')
                     {

                     $assetland->assetNumber = 'HL4'.$request['AssetNumber'];
                     $assetland->assetLocation = 'Hall 4 Hostel';

                     }else if($request['SiteLocation']=='CoICT')
                     {

                     $assetland->assetNumber = 'HL5'.$request['AssetNumber'];
                     $assetland->assetLocation = 'Hall 5 Hostel';

                     }else if($request['SiteLocation']=='CoICT')
                     {

                     $assetland->assetNumber = 'HL6'.$request['AssetNumber'];
                     $assetland->assetLocation = 'Hall 6 Hostel';

                     }else if($request['SiteLocation']=='CoICT')
                     {

                     $assetland->assetNumber = 'HL7'.$request['AssetNumber'];
                     $assetland->assetLocation = 'Hall 7 Hostel';

                     }else if($request['SiteLocation']=='CoICT')
                     {

                     $assetland->assetNumber = 'MKH'.$request['AssetNumber'];
                     $assetland->assetLocation = 'Mikocheni Hostel';

                     }else if($request['SiteLocation']=='CoICT')
                     {

                     $assetland->assetNumber = 'SMR'.$request['AssetNumber'];
                     $assetland->assetLocation = 'Seminar Room';

                     }else if($request['SiteLocation']=='CoICT')
                     {

                     $assetland->assetNumber = 'THR'.$request['AssetNumber'];
                     $assetland->assetLocation = 'Theater Room';

                     }else if($request['SiteLocation']=='CoICT')
                     {

                     $assetland->assetNumber = 'UBH'.$request['AssetNumber'];
                     $assetland->assetLocation = 'Ubungo Hostel';

                     }else if($request['SiteLocation']=='CoICT')
                     {

                     $assetland->assetNumber = 'DOP'.$request['AssetNumber'];
                     $assetland->assetLocation = 'Directorate of Post Graduate Studies';

                     }else if($request['SiteLocation']=='CoICT')
                     {

                     $assetland->assetNumber = 'MCLB'.$request['AssetNumber'];
                     $assetland->assetLocation = 'Michaud Library';

                     }else if($request['SiteLocation']=='CoICT')
                     {

                     $assetland->assetNumber = 'WHR'.$request['AssetNumber'];
                     $assetland->assetLocation = 'Water Resources Houses';

                     }else
                     {

                     $assetland->assetNumber = $request['AssetNumber'];
                     $assetland->assetLocation = $request['SiteLocation'];
                     }
                     //


        $assetland->assetDescription = $request['AssetDescription'];
        $assetland->assetAcquisitionDate = $request['DateofAcquisition'];
        $assetland->assetQuantity = $request['Quantity'];
        $assetland->assetDateinUse = $request['DateinUse'];
        $assetland->Cost = $request['cost'];

        $end = $request['DateinUse'];

        $assetland->assetEndingDepreciationDate = date('Y-m-d',strtotime($end.'+3 Years'));

        $assetland->addedBy = auth()->user()->id;
        $assetland->save();

        return redirect()->route('assetsComputerEquipmentView',[$request["id"]])->with(['message' => 'Changes Saved Succesfully']);
     }


     //



     public function assetsNewBuilding()
     {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();

        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('assetsNewBuilding',['role'=>$role,'notifications'=>$notifications]);
     }

     public function assetsNewBuildingSave(Request $request)
     {
        $request->validate([
            'SiteLocation'=>'required',
            'Quantity'=>'required',
        ]);
        if( $request['DateofAcquisition'] > $request['DateinUse'] )
        {
            return redirect()->back()->withErrors(['message' => 'Date in use should be greater than or equal to date of acquisition ']);
        }
        $assetland = new assetsbuilding();
        $assetland->assetNumber = $request['AssetNumber'];
        $assetland->_condition = $request['AssetCondition'];
        $assetland->depreciationRate = 100/$request['AssetUsefulLife'];
        $assetland->usefulLife = $request['AssetUsefulLife'];
        $assetland->assetLocation = $request['SiteLocation'];
        $assetland->assetDescription = $request['AssetDescription'];
        $assetland->assetAcquisitionDate = $request['DateofAcquisition'];
        $assetland->assetQuantity = $request['Quantity'];
        $assetland->assetDateinUse = $request['DateinUse'];
        $assetland->Cost = $request['cost'];

        $end = $request['DateinUse'];

        $assetland->assetEndingDepreciationDate = date('Y-m-d',strtotime($end.'+25 Years'));

        $assetland->addedBy = auth()->user()->id;
        $assetland->save();

        return redirect()->route('assetsBuilding')->with(['message' => 'New Asset Added Succesfully']);
     }

     public function assetsBuilding()
     {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $land = assetsbuilding::get();
        return view('assetsBuilding',['land'=>$land,'role'=>$role,'notifications'=>$notifications]);
     }
     public function assetsBuildingView($id)
     {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $land = assetsbuilding::where('id',$id)->get();
        $asses = assetsassesbuilding::where('assetID',$id)->get();
        return view('assetsBuildingView',['asses'=>$asses,'land'=>$land,'role'=>$role,'notifications'=>$notifications]);
     }

     public function assetsBuildingEdit($id)
     {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $land = assetsbuilding::where('id',$id)->get();
        return view('assetsBuildingEdit',['land'=>$land,'role'=>$role,'notifications'=>$notifications]);
     }

     public function assetsBuildingEditSave(Request $request)
     {if( $request['DateofAcquisition'] > $request['DateinUse'] )
        {
            return redirect()->back()->withErrors(['message' => 'Date in use should be greater than or equal to date of acquisition ']);
        }
        $assetland =  assetsbuilding::where('id',$request['id'])->first();
        $assetland->assetNumber = $request['AssetNumber'];
        $assetland->_condition = $request['AssetCondition'];
        $assetland->depreciationRate = 100/$request['AssetUsefulLife'];
        $assetland->usefulLife = $request['AssetUsefulLife'];
        $assetland->assetLocation = $request['SiteLocation'];
        $assetland->assetDescription = $request['AssetDescription'];
        $assetland->assetAcquisitionDate = $request['DateofAcquisition'];
        $assetland->assetQuantity = $request['Quantity'];
        $assetland->Cost = $request['cost'];
        $assetland->assetDateinUse = $request['DateinUse'];

        $end = $request['DateinUse'];

        $assetland->assetEndingDepreciationDate = date('Y-m-d',strtotime($end.'+25 Years'));

        $assetland->addedBy = auth()->user()->id;
        $assetland->save();

        return redirect()->route('assetsBuildingView',[$request["id"]])->with(['message' => 'Changes Saved Succesfully']);
     }

     //

     public function assetsNewWorkinProgress()
     {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();

        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('assetsNewWorkinProgress',['role'=>$role,'notifications'=>$notifications]);
     }

     public function assetsNewWorkinProgressSave(Request $request)
     {
        $request->validate([
            'SiteLocation'=>'required',
            'Quantity'=>'required',
        ]);
        if( $request['DateofAcquisition'] > $request['DateinUse'] )
        {
            return redirect()->back()->withErrors(['message' => 'Date in use should be greater than or equal to date of acquisition ']);
        }
        $assetland = new assetsworkinprogress();
        $assetland->assetNumber = $request['AssetNumber'];
        $assetland->assetLocation = $request['SiteLocation'];
        $assetland->assetDescription = $request['AssetDescription'];
        $assetland->assetQuantity = $request['Quantity'];
        $assetland->Cost = $request['cost'];
        $assetland->addedBy = auth()->user()->id;
        $assetland->save();

        return redirect()->route('assetsWorkinProgress')->with(['message' => 'New Asset Added Succesfully']);
     }

     public function assetsWorkinProgress()
     {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $land = assetsworkinprogress::where('_status',0)->get();
        return view('assetsWorkinProgress',['land'=>$land,'role'=>$role,'notifications'=>$notifications]);
     }
     public function assetsWorkinProgressView($id)
     {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $land = assetsworkinprogress::where('id',$id)->where('_status',0)->get();
        return view('assetsWorkinProgressView',['land'=>$land,'role'=>$role,'notifications'=>$notifications]);
     }

     public function assetsWorkinProgressEdit($id)
     {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $land = assetsworkinprogress::where('id',$id)->where('_status',0)->get();
        return view('assetsWorkinProgressEdit',['land'=>$land,'role'=>$role,'notifications'=>$notifications]);
     }

     public function assetsWorkinProgressEditSave(Request $request)
     {if( $request['DateofAcquisition'] > $request['DateinUse'] )
        {
            return redirect()->back()->withErrors(['message' => 'Date in use should be greater than or equal to date of acquisition ']);
        }
        $assetland =  assetsworkinprogress::where('id',$request['id'])->first();
        $assetland->assetNumber = $request['AssetNumber'];
        $assetland->assetLocation = $request['SiteLocation'];
        $assetland->assetDescription = $request['AssetDescription'];
        $assetland->assetQuantity = $request['Quantity'];
        $assetland->Cost = $request['cost'];
        $assetland->addedBy = auth()->user()->id;
        $assetland->save();

        return redirect()->route('assetsWorkinProgressView',[$request["id"]])->with(['message' => 'Changes Saved Succesfully']);
     }

     public function assetsWorkinProgressReallocate($id)
     {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $land = assetsworkinprogress::where('id',$id)->where('_status',0)->get();
        return view('assetsWorkinProgressReallocate',['land'=>$land,'role'=>$role,'notifications'=>$notifications]);
     }


     public function  assetsWorkinProgressReallocateSave(Request $request)
     {
        $request->validate([
            'SiteLocation'=>'required',
            'Quantity'=>'required',
        ]);
        if( $request['DateofAcquisition'] > $request['DateinUse'] )
        {
            return redirect()->back()->withErrors(['message' => 'Date in use should be greater than or equal to date of acquisition ']);
        }
        $assetland = new assetsbuilding();
        $assetland->assetNumber = $request['AssetNumber'];
        $assetland->_condition = $request['AssetCondition'];
        $assetland->depreciationRate = 100/$request['AssetUsefulLife'];
        $assetland->usefulLife = $request['AssetUsefulLife'];
        $assetland->assetLocation = $request['SiteLocation'];
        $assetland->assetDescription = $request['AssetDescription'];
        $assetland->assetAcquisitionDate = $request['DateofAcquisition'];
        $assetland->assetQuantity = $request['Quantity'];
        $assetland->assetDateinUse = $request['DateinUse'];
        $assetland->Cost = $request['cost'];

        $end = $request['DateinUse'];

        $assetland->assetEndingDepreciationDate = date('Y-m-d',strtotime($end.'+25 Years'));

        $assetland->addedBy = auth()->user()->id;
        $assetland->save();

        $assetwip =  assetsworkinprogress::where('id',$request['id'])->first();
        $assetwip->_status = 1;
        $assetwip->save();

        return redirect()->route('assetsBuilding')->with(['message' => 'New Asset Added Succesfully']);
     }
     // asses

     public function assetsAssesBuildingSave(Request $request)
     {if( $request['DateofAcquisition'] > $request['DateinUse'] )
        {
            return redirect()->back()->withErrors(['message' => 'Date in use should be greater than or equal to date of acquisition ']);
        }
        $assetland =  assetsbuilding::where('id',$request['id'])->first();
        $assetland->_condition = $request['AssetCondition'];
        $assetland->save();

        $assetdep = new assetsassesbuilding();
        $assetdep->assetID = $request['id'];
        $assetdep->assesedBy = auth()->user()->id;
        $assetdep->assesmentYear = $request['depreciationDate'];
        $assetdep->disposalCost = $request['disposalCost'];
        $assetdep->impairmentLoss = $request['impairmentLoss'];
          $time = strtotime($assetland['assetAcquisitionDate']);
          $percent = $assetland['depreciationRate'];
          $cost = $assetland['Cost'];
          $amount = abs(($percent/100)*$cost);
          $timed = strtotime($request['depreciationDate']);
          $catch =  $time;
          $catched = $timed;
          $totalyearsc = abs($catched-$catch);
          $ds = floor($totalyearsc/(365*60*60*24));
          $totalyears = $ds;
        $assetdep->totalDepreciatedYears = $totalyears ;
        $assetdep->accumulatedDepreciation = $amount*$totalyears;
        $assetdep->save();

        return redirect()->route('assetsBuildingView',[$request["id"]])->with(['message' => 'Asesments Saved Succesfully']);

     }
     //

     public function assetsAssesFurnitureSave(Request $request)
     {if( $request['DateofAcquisition'] > $request['DateinUse'] )
        {
            return redirect()->back()->withErrors(['message' => 'Date in use should be greater than or equal to date of acquisition ']);
        }
        $assetland =  assetsfurniture::where('id',$request['id'])->first();
        $assetland->_condition = $request['AssetCondition'];
        $assetland->save();

        $assetdep = new assetsassesfurniture();
        $assetdep->assetID = $request['id'];
        $assetdep->assesedBy = auth()->user()->id;
        $assetdep->assesmentYear = $request['depreciationDate'];
        $assetdep->disposalCost = $request['disposalCost'];
        $assetdep->impairmentLoss = $request['impairmentLoss'];

          $time = strtotime($assetland['assetAcquisitionDate']);
          $percent = $assetland['depreciationRate'];
          $cost = $assetland['Cost'];
          $amount = abs(($percent/100)*$cost);
          $timed = strtotime($request['depreciationDate']);
          $catch =  $time;
          $catched = $timed;
          $totalyearsc = abs($catched-$catch);
          $ds = floor($totalyearsc/(365*60*60*24));
          $totalyears = $ds;
        $assetdep->totalDepreciatedYears = $totalyears ;
        $assetdep->accumulatedDepreciation = $amount*$totalyears;
        $assetdep->save();

        return redirect()->route('assetsFurnitureView',[$request["id"]])->with(['message' => 'Asesments Saved Succesfully']);

     }
     //

     public function assetsAssesEquipmentSave(Request $request)
     {if( $request['DateofAcquisition'] > $request['DateinUse'] )
        {
            return redirect()->back()->withErrors(['message' => 'Date in use should be greater than or equal to date of acquisition ']);
        }
        $assetland =  assetsequipment::where('id',$request['id'])->first();
        $assetland->_condition = $request['AssetCondition'];
        $assetland->save();

        $assetdep = new assetsassesequipment();
        $assetdep->assetID = $request['id'];
        $assetdep->assesedBy = auth()->user()->id;
        $assetdep->assesmentYear = $request['depreciationDate'];
        $assetdep->disposalCost = $request['disposalCost'];
        $assetdep->impairmentLoss = $request['impairmentLoss'];

          $time = strtotime($assetland['assetAcquisitionDate']);
          $percent = $assetland['depreciationRate'];
          $cost = $assetland['Cost'];
          $amount = abs(($percent/100)*$cost);
          $timed = strtotime($request['depreciationDate']);
          $catch =  $time;
          $catched = $timed;
          $totalyearsc = abs($catched-$catch);
          $ds = floor($totalyearsc/(365*60*60*24));
          $totalyears = $ds;
        $assetdep->totalDepreciatedYears = $totalyears ;
        $assetdep->accumulatedDepreciation = $amount*$totalyears;
        $assetdep->save();

        return redirect()->route('assetsEquipmentView',[$request["id"]])->with(['message' => 'Asesments Saved Succesfully']);

     }
     //

     public function assetsAssesComputerEquipmentSave(Request $request)
     {if( $request['DateofAcquisition'] > $request['DateinUse'] )
        {
            return redirect()->back()->withErrors(['message' => 'Date in use should be greater than or equal to date of acquisition ']);
        }
        $assetland =  assetscomputerequipment::where('id',$request['id'])->first();
        $assetland->_condition = $request['AssetCondition'];
        $assetland->save();

        $assetdep = new assetsassescomputerequipment();
        $assetdep->assetID = $request['id'];
        $assetdep->assesedBy = auth()->user()->id;
        $assetdep->assesmentYear = $request['depreciationDate'];
        $assetdep->disposalCost = $request['disposalCost'];
        $assetdep->impairmentLoss = $request['impairmentLoss'];

          $time = strtotime($assetland['assetAcquisitionDate']);
          $percent = $assetland['depreciationRate'];
          $cost = $assetland['Cost'];
          $amount = abs(($percent/100)*$cost);
          $timed = strtotime($request['depreciationDate']);
          $catch =  $time;
          $catched = $timed;
          $totalyearsc = abs($catched-$catch);
          $ds = floor($totalyearsc/(365*60*60*24));
          $totalyears = $ds;
        $assetdep->totalDepreciatedYears = $totalyears ;
        $assetdep->accumulatedDepreciation = $amount*$totalyears;
        $assetdep->save();

        return redirect()->route('assetsComputerEquipmentView',[$request["id"]])->with(['message' => 'Asesments Saved Succesfully']);

     }
     //

     public function assetsAssesPlantMachinerySave(Request $request)
     {if( $request['DateofAcquisition'] > $request['DateinUse'] )
        {
            return redirect()->back()->withErrors(['message' => 'Date in use should be greater than or equal to date of acquisition ']);
        }
        $assetland =  assetsplantandmachinery::where('id',$request['id'])->first();
        $assetland->_condition = $request['AssetCondition'];
        $assetland->save();

        $assetdep = new assetsassesplantandmachinery();
        $assetdep->assetID = $request['id'];
        $assetdep->assesedBy = auth()->user()->id;
        $assetdep->assesmentYear = $request['depreciationDate'];
        $assetdep->disposalCost = $request['disposalCost'];
        $assetdep->impairmentLoss = $request['impairmentLoss'];

          $time = strtotime($assetland['assetAcquisitionDate']);
          $percent = $assetland['depreciationRate'];
          $cost = $assetland['Cost'];
          $amount = abs(($percent/100)*$cost);
          $timed = strtotime($request['depreciationDate']);
          $catch =  $time;
          $catched = $timed;
          $totalyearsc = abs($catched-$catch);
          $ds = floor($totalyearsc/(365*60*60*24));
          $totalyears = $ds;
        $assetdep->totalDepreciatedYears = $totalyears ;
        $assetdep->accumulatedDepreciation = $amount*$totalyears;
        $assetdep->save();

        return redirect()->route('assetsPlantMachineryView',[$request["id"]])->with(['message' => 'Asesments Saved Succesfully']);

     }
     //

     public function assetsAssesMotorVehicleSave(Request $request)
     {if( $request['DateofAcquisition'] > $request['DateinUse'] )
        {
            return redirect()->back()->withErrors(['message' => 'Date in use should be greater than or equal to date of acquisition ']);
        }
        $assetland =  assetsmotorvehicle::where('id',$request['id'])->first();
        $assetland->_condition = $request['AssetCondition'];
        $assetland->save();

        $assetdep = new assetsassesmotorvehicle();
        $assetdep->assetID = $request['id'];
        $assetdep->assesedBy = auth()->user()->id;
        $assetdep->assesmentYear = $request['depreciationDate'];
        $assetdep->disposalCost = $request['disposalCost'];
        $assetdep->impairmentLoss = $request['impairmentLoss'];

          $time = strtotime($assetland['assetAcquisitionDate']);
          $percent = $assetland['depreciationRate'];
          $cost = $assetland['Cost'];
          $amount = abs(($percent/100)*$cost);
          $timed = strtotime($request['depreciationDate']);
          $catch =  $time;
          $catched = $timed;
          $totalyearsc = abs($catched-$catch);
          $ds = floor($totalyearsc/(365*60*60*24));
          $totalyears = $ds;
        $assetdep->totalDepreciatedYears = $totalyears ;
        $assetdep->accumulatedDepreciation = $amount*$totalyears;
        $assetdep->save();

        return redirect()->route('assetsMotorVehicleView',[$request["id"]])->with(['message' => 'Asesments Saved Succesfully']);

     }
     //

     public function assetsAssesLandSave(Request $request)
     {if( $request['DateofAcquisition'] > $request['DateinUse'] )
        {
            return redirect()->back()->withErrors(['message' => 'Date in use should be greater than or equal to date of acquisition ']);
        }
        $assetland =  assetsland::where('id',$request['id'])->first();
        $assetland->_condition = $request['AssetCondition'];
        $assetland->save();

        $assetdep = new assetsassesland();
        $assetdep->assetID = $request['id'];
        $assetdep->assesedBy = auth()->user()->id;
        $assetdep->assesmentYear = $request['depreciationDate'];
        $assetdep->disposalCost = $request['disposalCost'];
        $assetdep->impairmentLoss = $request['impairmentLoss'];

          $time = strtotime($assetland['assetAcquisitionDate']);
          $percent = $assetland['depreciationRate'];
          $cost = $assetland['Cost'];
          $amount = abs(($percent/100)*$cost);
          $timed = strtotime($request['depreciationDate']);
          $catch =  $time;
          $catched = $timed;
          $totalyearsc = abs($catched-$catch);
          $ds = floor($totalyearsc/(365*60*60*24));
          $totalyears = $ds;
        $assetdep->totalDepreciatedYears = $totalyears ;
        $assetdep->accumulatedDepreciation = $amount*$totalyears;
        $assetdep->save();

        return redirect()->route('assetsLandView',[$request["id"]])->with(['message' => 'Asesments Saved Succesfully']);

     }
     //

     public function assetsAssesIntangibleSave(Request $request)
     {if( $request['DateofAcquisition'] > $request['DateinUse'] )
        {
            return redirect()->back()->withErrors(['message' => 'Date in use should be greater than or equal to date of acquisition ']);
        }
        $assetland =  assetsintangible::where('id',$request['id'])->first();
        $assetland->_condition = $request['AssetCondition'];
        $assetland->save();

        $assetdep = new assetsassesintangible();
        $assetdep->assetID = $request['id'];
        $assetdep->assesedBy = auth()->user()->id;
        $assetdep->assesmentYear = $request['depreciationDate'];
        $assetdep->disposalCost = $request['disposalCost'];
        $assetdep->impairmentLoss = $request['impairmentLoss'];

          $time = strtotime($assetland['assetAcquisitionDate']);
          $percent = $assetland['depreciationRate'];
          $cost = $assetland['Cost'];
          $amount = abs(($percent/100)*$cost);
          $timed = strtotime($request['depreciationDate']);
          $catch =  $time;
          $catched = $timed;
          $totalyearsc = abs($catched-$catch);
          $ds = floor($totalyearsc/(365*60*60*24));
          $totalyears = $ds;
        $assetdep->totalDepreciatedYears = $totalyears ;
        $assetdep->accumulatedDepreciation = $amount*$totalyears;
        $assetdep->save();

        return redirect()->route('assetsIntangibleView',[$request["id"]])->with(['message' => 'Asesments Saved Succesfully']);

     }
     //


     public function exportinfo($id, $type)
     {


        if($type=='building')
        {
            $land=assetsbuilding::where('id',$id)->get();
        }else if($type=='land')
        {
            $land=assetsland::where('id',$id)->get();
        }else if($type=='motorvehicle')
        {
            $land=assetsmotorvehicle::where('id',$id)->get();
        }else if($type=='plantandmachinery')
        {
            $land=assetsplantandmachinery::where('id',$id)->get();
        }else if($type=='computerequipment')
        {
            $land=assetscomputerequipment::where('id',$id)->get();
        }else if($type=='equipment')
        {
            $land=assetsequipment::where('id',$id)->get();
        }else if($type=='furniture')
        {
            $land=assetsfurniture::where('id',$id)->get();
        }else if($type=='intangible')
        {
            $land=assetsintangible::where('id',$id)->get();
        }else if($type=='workinprogress')
        {
            $land=assetsintangible::where('id',$id)->get();
        }

        $pdf = PDF::loadView('exports.assetsInfo', ['land' => $land]);
        return $pdf->stream(''.$type.''.$id.' asset information'.date('d-m-Y H-i').'.pdf');

     }

     public function assesExport($type)
     {
        if($_GET['type']=='building')
        {
            $land = assetsbuilding::where('id',$type)->get();

        }else if($_GET['type']=='land')
        {
            $land = assetsland::where('id',$type)->get();

        }else if($_GET['type']=='motorvehicle')
        {
            $land = assetsmotorvehicle::where('id',$type)->get();

        }else if($_GET['type']=='plantandmachinery')
        {
            $land = assetsplantandmachinery::where('id',$type)->get();

        }else if($_GET['type']=='computerequipment')
        {
            $land = assetscomputerequipment::where('id',$type)->get();

        }else if($_GET['type']=='equipment')
        {
            $land = assetsequipment::where('id',$type)->get();

        }else if($_GET['type']=='furniture')
        {
            $land =  assetsfurniture::where('id',$type)->get();

        }else if($_GET['type']=='intangible')
        {
            $land =  assetsintangible::where('id',$type)->get();

        }
        $pdf = PDF::loadView('exports.assetassessmentsingle', ['land'=>$land])->setPaper('a4', 'landscape');
        return $pdf->stream($_GET['type'].'-'.$type.' asset information '.date('d-m-Y H-i').'.pdf');

     }
     public function  assetssummaryall()
     {
         $pdf = PDF::loadView('exports.assetsallsummary')->setPaper('a4', 'landscape');
         return $pdf->stream(' asset summary '.date('d-m-Y H-i').'.pdf');
     }

     public function assetsSummaryFiltered()
     {
        if ($_GET['date']!='') {
            if ($_GET['month']!='') {
                if ($_GET['year']!='') {
                    $time = strtotime($_GET['year'].'/'.$_GET['month'].'/'.$_GET['date']);
                    $datyer = date('Y-m-d',$time);
                    // echo $datyer;

            $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
            $role = User::where('id', auth()->user()->id)->with('user_role')->first();

            if($_GET['asset']=='Land')
            {
                $assetsinfo = assetsassesland::where('assesmentYear',$datyer)->get();
            }else if( $_GET['asset']=='Building')
            {
                $assetsinfo = assetsassesbuilding::where('assesmentYear',$datyer)->get();

            }else if( $_GET['asset']=='PlantMachinery')
            {
                $assetsinfo = assetsassesplantandmachinery::where('assesmentYear',$datyer)->get();

            }else if( $_GET['asset']=='MotorVehicle')
            {
                $assetsinfo = assetsassesmotorvehicle::where('assesmentYear',$datyer)->get();

            }else if( $_GET['asset']=='ComputerEquipment')
            {
                $assetsinfo = assetsassescomputerequipment::where('assesmentYear',$datyer)->get();

            }else if( $_GET['asset']=='Equipment')
            {
                $assetsinfo = assetsassesequipment::where('assesmentYear',$datyer)->get();

            }else if( $_GET['asset']=='Furniture')
            {
                $assetsinfo = assetsassesfurniture::where('assesmentYear',$datyer)->get();

            }else if( $_GET['asset']=='Intangible')
            {
                $assetsinfo = assetsassesintangible::where('assesmentYear',$datyer)->get();

            } else
            {
                return redirect()->back();

            }




            return view('exports.assetsassesmentview',['asses'=>$assetsinfo,'role'=>$role,'year'=>$datyer,'notifications'=>$notifications]);

         } else {
            return redirect()->back()->withErrors(['message' => 'Please Choose Assesment Year For Filtering']);
         }
        }else {
            return redirect()->back()->withErrors(['message' => 'Please Choose Assesment Month For Filtering']);
         }
        }else {
            return redirect()->back()->withErrors(['message' => 'Please Choose Assesment Date For Filtering']);
         }

     }



   public function yearlyplantmachinery()
   {
    $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
    $role = User::where('id', auth()->user()->id)->with('user_role')->first();
    if (request()->has('year'))
    {
        if(request('year')=='')
        {
            return redirect()->back()->withErrors(['message' => 'Please Choose Assessment Year!']);

        }
        $year=request('year');
        $asset = assetsassesplantandmachinery::whereYear('assesmentYear',$year)->orderBy('created_at','Desc')->get();

    }else
    {
        $year=date('Y');
        $asset = assetsassesplantandmachinery::whereYear('assesmentYear',date('Y'))->orderBy('created_at','Desc')->get();

    }
    return view('assetsYearlyPlantMachinery',['role'=>$role,'notifications'=>$notifications,'asset'=>$asset,'year'=>$year]);
   }
   public function yearlymotorvehicle()
   {

    $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
    $role = User::where('id', auth()->user()->id)->with('user_role')->first();
    if (request()->has('year'))
    {
        if(request('year')=='')
        {
            return redirect()->back()->withErrors(['message' => 'Please Choose Assessment Year!']);

        }
        $year=request('year');
        $asset = assetsassesmotorvehicle::whereYear('assesmentYear',$year)->orderBy('created_at','Desc')->get();

    }else
    {
        $year=date('Y');
        $asset = assetsassesmotorvehicle::whereYear('assesmentYear',date('Y'))->orderBy('created_at','Desc')->get();

    }
    return view('assetsYearlyMotorVehicle',['role'=>$role,'notifications'=>$notifications,'asset'=>$asset,'year'=>$year]);

   }
   public function yearlycomputerequipment()
   {

    $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
    $role = User::where('id', auth()->user()->id)->with('user_role')->first();
    if (request()->has('year'))
    {
        if(request('year')=='')
        {
            return redirect()->back()->withErrors(['message' => 'Please Choose Assessment Year!']);

        }
        $year=request('year');
        $asset = assetsassescomputerequipment::whereYear('assesmentYear',$year)->orderBy('created_at','Desc')->get();

    }else
    {
        $year=date('Y');
        $asset = assetsassescomputerequipment::whereYear('assesmentYear',date('Y'))->orderBy('created_at','Desc')->get();

    }
    return view('assetsYearlyComputerEquipment',['role'=>$role,'notifications'=>$notifications,'asset'=>$asset,'year'=>$year]);

   }
   public function yearlyequipment()
   {

    $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
    $role = User::where('id', auth()->user()->id)->with('user_role')->first();
    if (request()->has('year'))
    {
        if(request('year')=='')
        {
            return redirect()->back()->withErrors(['message' => 'Please Choose Assessment Year!']);

        }
        $year=request('year');
        $asset = assetsassesequipment::whereYear('assesmentYear',$year)->orderBy('created_at','Desc')->get();

    }else
    {
        $year=date('Y');
        $asset = assetsassesequipment::whereYear('assesmentYear',date('Y'))->orderBy('created_at','Desc')->get();

    }
    return view('assetsYearlyEquipment',['role'=>$role,'notifications'=>$notifications,'asset'=>$asset,'year'=>$year]);

   }
   public function yearlyfurniture()
   {

    $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
    $role = User::where('id', auth()->user()->id)->with('user_role')->first();
    if (request()->has('year'))
    {
        if(request('year')=='')
        {
            return redirect()->back()->withErrors(['message' => 'Please Choose Assessment Year!']);

        }
        $year=request('year');
        $asset = assetsassesfurniture::whereYear('assesmentYear',$year)->orderBy('created_at','Desc')->get();

    }else
    {
        $year=date('Y');
        $asset = assetsassesfurniture::whereYear('assesmentYear',date('Y'))->orderBy('created_at','Desc')->get();

    }
    return view('assetsYearlyFurniture',['role'=>$role,'notifications'=>$notifications,'asset'=>$asset,'year'=>$year]);

   }
   public function yearlyintangible()
   {

    $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
    $role = User::where('id', auth()->user()->id)->with('user_role')->first();
    if (request()->has('year'))
    {
        if(request('year')=='')
        {
            return redirect()->back()->withErrors(['message' => 'Please Choose Assessment Year!']);

        }
        $year=request('year');
        $asset = assetsassesintangible::whereYear('assesmentYear',$year)->orderBy('created_at','Desc')->get();

    }else
    {
        $year=date('Y');
        $asset = assetsassesintangible::whereYear('assesmentYear',date('Y'))->orderBy('created_at','Desc')->get();

    }
    return view('assetsYearlyIntangible',['role'=>$role,'notifications'=>$notifications,'asset'=>$asset,'year'=>$year]);

   }
   public function yearlyland()
   {

    $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
    $role = User::where('id', auth()->user()->id)->with('user_role')->first();
    if (request()->has('year'))
    {
        if(request('year')=='')
        {
            return redirect()->back()->withErrors(['message' => 'Please Choose Assessment Year!']);

        }
        $year=request('year');
        $asset = assetsassesland::whereYear('assesmentYear',$year)->orderBy('created_at','Desc')->get();

    }else
    {
        $year=date('Y');
        $asset = assetsassesland::whereYear('assesmentYear',date('Y'))->orderBy('created_at','Desc')->get();

    }
    return view('assetsYearlyLand',['role'=>$role,'notifications'=>$notifications,'asset'=>$asset,'year'=>$year]);

   }
   public function yearlybuilding()
   {

    $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();
    $role = User::where('id', auth()->user()->id)->with('user_role')->first();
    if (request()->has('year'))
    {
        if(request('year')=='')
        {
            return redirect()->back()->withErrors(['message' => 'Please Choose Assessment Year!']);

        }
        $year=request('year');
        $asset = assetsassesbuilding::whereYear('assesmentYear',$year)->orderBy('created_at','Desc')->get();

    }else
    {
        $year=date('Y');
        $asset = assetsassesbuilding::whereYear('assesmentYear',date('Y'))->orderBy('created_at','Desc')->get();

    }
    return view('assetsYearlyBuilding',['role'=>$role,'notifications'=>$notifications,'asset'=>$asset,'year'=>$year]);

   }
//
}
