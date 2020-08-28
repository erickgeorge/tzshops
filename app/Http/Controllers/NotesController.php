<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Note;
use Illuminate\Http\Request;
use Redirect;


use PDF;
use App\WorkOrder;
use App\User;
use App\Notification;
use App\Material;
use App\Technician;
use App\WorkOrderMaterial;
use App\Directorate;
use App\Department;
use App\workordersection;
use App\Procurement;
use App\Storehistory;
use App\iowzone;
use App\company;
use App\cleaningarea;
use App\iowzonelocation;
use App\landassessmentactivityform;
use App\landassessmentform;
use App\landcrosschecklandassessmentactivity;
 use Carbon\Carbon;
 use App\tendernumber;


class NotesController extends Controller
{

    public function pdf(){

     $data['title'] = 'Notes List';
     $data['header'] = '';

    /////////////////////////////////////////
     $username = '';
     $typevalue = '';
    if($_GET['userid'] != ''){
      $userinid = User::get();

      foreach ($userinid as $usedid)
      {
        if ( $usedid['id']==$_GET['userid'])
        {
                $username = $usedid['fname'].' '.$usedid['lname'];
             }
      }
  }
        //fetch type
  if($_GET['type'] !=''){
  $type = $_GET['type'];
  if ($type == -1) {
      $typevalue = 'New';
  }elseif ($type == 1) {
      $typevalue = 'Accepted';
  }elseif ($type == 0) {
      $typevalue = 'Rejected';
  }elseif ($type == 2) {
      $typevalue = 'waiting response from client';
  }elseif ($type == 30) {
      $typevalue = 'Closed';
  }elseif ($type == 3) {
      $typevalue = 'Technician assigned';
  }elseif ($type == 4) {
      $typevalue = 'Transportation stage';
  }elseif ($type == 5) {
      $typevalue = 'Pre-implementation';
  }elseif ($type == 6) {
      $typevalue = 'Post-implementation';
  }elseif ($type == 7) {
      $typevalue = 'Material Requested';
  }elseif ($type == 8) {
      $typevalue = 'Procurement stage';
  }elseif ($type == 9) {
      $typevalue = 'Closed - satisfied by client';
  }elseif($type == 15){
    $typevalue = 'Material Accepted by IoW';
  }elseif($type == 16){
    $typevalue = 'Material rejected by IoW';
  }
  else{
      $typevalue = 'Closed - not satisfied by client';
  }
}
if($_GET['problem_type']!= ''){$probleme = 'All '.$_GET['problem_type'];}else{$probleme='All ';}
if($_GET['userid']!=''){$usere = ' Works Orders From '.$username;}else{$usere =' WorkOrders ';}
if($_GET['start']!=''){$starte = ' <date> from'.$_GET['start'];}else{$starte ='<date>';}
if($_GET['end']!=''){$ende = ' to '.$_GET['end'].'</date>';}else{$ende ='</date>';}
if($_GET['type']!= ''){$typee = '<br> type :'.$typevalue;} else{$typee ='';}
if(($_GET['problem_type']== '')&&($_GET['userid']=='')&&($_GET['start']=='')&&($_GET['end']=='')&&($_GET['type']== '')) {$data['header'] = 'All WorkOrders Report'; }

$data['header'] = $probleme.''.$usere.''.$starte.''.$ende.''.$typee;
    /////////////////////////////////////////


//if all inserted
if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['type']!='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','>=',$_GET['start'])->
        Where('created_at','<=',$_GET['end'])->
        Where('type',$_GET['type'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();

    }
//if only ->from not inserted
    if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['type']!='')&&($_GET['userid']=='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','>=',$_GET['start'])->
        Where('created_at','<=',$_GET['end'])->
        Where('type',$_GET['type'])->orderBy('created_at','Desc')->get();
    }
//if only type not inserted
    if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['type']=='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','>=',$_GET['start'])->
        Where('created_at','<=',$_GET['end'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if type and ->from not inserted
    if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['type']=='')&&($_GET['userid']=='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','>=',$_GET['start'])->
        Where('created_at','<=',$_GET['end'])->orderBy('created_at','Desc')->get();
    }
//if only name no inserted
    if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['type']!='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('created_at','>=',$_GET['start'])->
        Where('created_at','<=',$_GET['end'])->
        Where('type',$_GET['type'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if name and from not inserted
    if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['type']!='')&&($_GET['userid']=='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('created_at','>=',$_GET['start'])->
        Where('created_at','<=',$_GET['end'])->
        Where('type',$_GET['type'])->orderBy('created_at','Desc')->get();
    }
//if name and type not inserted
    if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['type']=='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('created_at','>=',$_GET['start'])->
        Where('created_at','<=',$_GET['end'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if name, type, from not inserted
    if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['type']=='')&&($_GET['userid']=='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('created_at','>=',$_GET['start'])->
        Where('created_at','<=',$_GET['end'])->orderBy('created_at','Desc')->get();
    }
//if end not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['type']!='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','>=',$_GET['start'])->
        Where('type',$_GET['type'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if end and from not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['type']!='')&&($_GET['userid']=='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','>=',$_GET['start'])->
        Where('type',$_GET['type'])->orderBy('created_at','Desc')->get();
    }
//if end and type not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['type']=='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','>=',$_GET['start'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if end, type, from not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['type']=='')&&($_GET['userid']=='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','>=',$_GET['start'])->orderBy('created_at','Desc')->get();
    }
//if end, name not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['type']!='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('created_at','>=',$_GET['start'])->
        Where('type',$_GET['type'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if end, name, from not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['type']!='')&&($_GET['userid']=='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('created_at','>=',$_GET['start'])->
        Where('type',$_GET['type'])->orderBy('created_at','Desc')->get();
    }
//if end, name, type not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['type']=='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('created_at','>=',$_GET['start'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if end,name,type,from not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['type']=='')&&($_GET['userid']=='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('created_at','>=',$_GET['start'])->orderBy('created_at','Desc')->get();
    }
//if start not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['type']!='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','<=',$_GET['end'])->
        Where('type',$_GET['type'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if start, from not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['type']!='')&&($_GET['userid']=='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','<=',$_GET['end'])->
        Where('type',$_GET['type'])->orderBy('created_at','Desc')->get();
    }
//if start, type not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['type']=='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','<=',$_GET['end'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if start, type, from not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['type']=='')&&($_GET['userid']=='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','<=',$_GET['end'])->orderBy('created_at','Desc')->get();
    }
//if start, name not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['type']!='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('created_at','<=',$_GET['end'])->
        Where('type',$_GET['type'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if start, name, from not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['type']!='')&&($_GET['userid']=='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('created_at','<=',$_GET['end'])->
        Where('type',$_GET['type'])->orderBy('created_at','Desc')->get();
    }
//if start, name, type not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['type']=='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('created_at','<=',$_GET['end'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if start, name, type, from not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['type']=='')&&($_GET['userid']=='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('created_at','<=',$_GET['end'])->orderBy('created_at','Desc')->get();
    }
//if start, end not inserted
    if(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['type']!='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('type',$_GET['type'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if start, end, from not inserted
    if(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['type']!='')&&($_GET['userid']=='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('type',$_GET['type'])->orderBy('created_at','Desc')->get();
    }
//if start, end, type not inserted
    if(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['type']=='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if start, end, type, from not inserted
    if(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['type']=='')&&($_GET['userid']=='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->orderBy('created_at','Desc')->get();
    }
//if start, end, name not inserted
    if(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['type']!='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('type',$_GET['type'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if start, end, name, from not inserted
    if(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['type']!='')&&($_GET['userid']=='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('type',$_GET['type'])->orderBy('created_at','Desc')->get();
    }
//if start, end, name, type not inserted
    if(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['type']=='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
    if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['type']!='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','>=',$_GET['start'])->
        Where('created_at','<=',$_GET['end'])->
        Where('location',$_GET['location'])->
        Where('type',$_GET['type'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if only ->from not inserted
    if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['type']!='')&&($_GET['userid']=='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','>=',$_GET['start'])->
        Where('location',$_GET['location'])->
        Where('created_at','<=',$_GET['end'])->
        Where('type',$_GET['type'])->orderBy('created_at','Desc')->get();
    }
//if only type not inserted
    if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['type']=='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','>=',$_GET['start'])->
        Where('location',$_GET['location'])->
        Where('created_at','<=',$_GET['end'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if type and ->from not inserted
    if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['type']=='')&&($_GET['userid']=='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','>=',$_GET['start'])->
        Where('location',$_GET['location'])->
        Where('created_at','<=',$_GET['end'])->orderBy('created_at','Desc')->get();
    }
//if only name no inserted
    if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['type']!='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('created_at','>=',$_GET['start'])->
        Where('created_at','<=',$_GET['end'])->
        Where('location',$_GET['location'])->
        Where('type',$_GET['type'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if name and from not inserted
    if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['type']!='')&&($_GET['userid']=='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('created_at','>=',$_GET['start'])->
        Where('created_at','<=',$_GET['end'])->
        Where('location',$_GET['location'])->
        Where('type',$_GET['type'])->orderBy('created_at','Desc')->get();
    }
//if name and type not inserted
    if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['type']=='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('created_at','>=',$_GET['start'])->
        Where('created_at','<=',$_GET['end'])->
        Where('location',$_GET['location'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if name, type, from not inserted
    if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['type']=='')&&($_GET['userid']=='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('created_at','>=',$_GET['start'])->
        Where('location',$_GET['location'])->
        Where('created_at','<=',$_GET['end'])->orderBy('created_at','Desc')->get();
    }
//if end not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['type']!='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','>=',$_GET['start'])->
        Where('location',$_GET['location'])->
        Where('type',$_GET['type'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if end and from not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['type']!='')&&($_GET['userid']=='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','>=',$_GET['start'])->
        Where('location',$_GET['location'])->
        Where('type',$_GET['type'])->orderBy('created_at','Desc')->get();
    }
//if end and type not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['type']=='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','>=',$_GET['start'])->
        Where('location',$_GET['location'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if end, type, from not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['type']=='')&&($_GET['userid']=='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('location',$_GET['location'])->
        Where('created_at','>=',$_GET['start'])->orderBy('created_at','Desc')->get();
    }
//if end, name not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['type']!='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('created_at','>=',$_GET['start'])->
        Where('type',$_GET['type'])->
        Where('location',$_GET['location'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if end, name, from not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['type']!='')&&($_GET['userid']=='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('created_at','>=',$_GET['start'])->
        Where('location',$_GET['location'])->
        Where('type',$_GET['type'])->orderBy('created_at','Desc')->get();
    }
//if end, name, type not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['type']=='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('created_at','>=',$_GET['start'])->
        Where('location',$_GET['location'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if end,name,type,from not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['type']=='')&&($_GET['userid']=='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('location',$_GET['location'])->
        Where('created_at','>=',$_GET['start'])->orderBy('created_at','Desc')->get();
    }
//if start not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['type']!='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','<=',$_GET['end'])->
        Where('type',$_GET['type'])->
        Where('location',$_GET['location'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if start, from not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['type']!='')&&($_GET['userid']=='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','<=',$_GET['end'])->
        Where('location',$_GET['location'])->
        Where('type',$_GET['type'])->orderBy('created_at','Desc')->get();
    }
//if start, type not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['type']=='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','<=',$_GET['end'])->
        Where('location',$_GET['location'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if start, type, from not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['type']=='')&&($_GET['userid']=='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('location',$_GET['location'])->
        Where('created_at','<=',$_GET['end'])->orderBy('created_at','Desc')->get();
    }
//if start, name not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['type']!='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('created_at','<=',$_GET['end'])->
        Where('type',$_GET['type'])->
        Where('location',$_GET['location'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if start, name, from not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['type']!='')&&($_GET['userid']=='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('created_at','<=',$_GET['end'])->
        Where('location',$_GET['location'])->
        Where('type',$_GET['type'])->orderBy('created_at','Desc')->get();
    }
//if start, name, type not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['type']=='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('created_at','<=',$_GET['end'])->
        Where('location',$_GET['location'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if start, name, type, from not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['type']=='')&&($_GET['userid']=='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('location',$_GET['location'])->
        Where('created_at','<=',$_GET['end'])->orderBy('created_at','Desc')->get();
    }
//if start, end not inserted
    if(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['type']!='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('type',$_GET['type'])->
        Where('location',$_GET['location'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if start, end, from not inserted
    if(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['type']!='')&&($_GET['userid']=='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('location',$_GET['location'])->
        Where('type',$_GET['type'])->orderBy('created_at','Desc')->get();
    }
//if start, end, type not inserted
    if(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['type']=='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if start, end, type, from not inserted
    if(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['type']=='')&&($_GET['userid']=='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('location',$_GET['location'])->
        Where('problem_type',$_GET['problem_type'])->orderBy('created_at','Desc')->get();
    }
//if start, end, name not inserted
    if(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['type']!='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('location',$_GET['location'])->
        Where('type',$_GET['type'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if start, end, name, from not inserted
    if(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['type']!='')&&($_GET['userid']=='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('location',$_GET['location'])->
        Where('type',$_GET['type'])->orderBy('created_at','Desc')->get();
    }
//if start, end, name, type not inserted
    if(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['type']=='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('location',$_GET['location'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
    if(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['type']=='')&&($_GET['userid']=='')&&($_GET['location']!='')){
          $data['wo'] =  Workorder::
        Where('location',$_GET['location'])->orderBy('created_at','Desc')->get();
        //$header = $_GET['problem_type'].' Works orders ';
}
//if all empty
    elseif(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['type']=='')&&($_GET['userid']=='')&&($_GET['location']=='')){
          $data['wo'] =  Workorder::orderBy('created_at','Desc')->get();
}
////////////////////////////////////////////////////
        if($data['wo'] ->isEmpty()){
return redirect()->back()->withErrors(['message' => 'No data Found For Your Search :'.$data['header'].'']);

    // return $pdf->inline('workorder.pdf');

    }else{
$pdf = PDF::loadView('notes_pdf',$data);
return $pdf->stream(''.$data['header'].'- '.date('d-m-Y Hi').'.pdf');
    }
///////////////////////////////////////////////////////
}


    public function userspdf(){

     $data['title'] = 'Notes List';
     ///////////////////////////////////////
     if($_GET['college']!=''){
        $userinid = User::get();

      foreach ($userinid as $usedid)
      {
        if ( $usedid['id']==$_GET['college'])
        {$username = $usedid['fname'].' '.$usedid['lname']; }
      }
      }else{$username = 'All';}
      if($_GET['type']!=''){$type=' '.$_GET['type'].' Details Report';}else{$type=' User Report';}
      //////////////////////////////////////////
     $data['header'] = $username.''.$type;
     //////////////////////////////////////////
     if (($_GET['type']=='')&&($_GET['college']=='')&&($_GET['directorate']=='')&&($_GET['department']=='')) {
         $data['display_users'] =  user::orderBy('fname','asc')->get();
     }
     if (($_GET['type']=='')&&($_GET['college']!='')&&($_GET['directorate']=='')&&($_GET['department']=='')) {
         $data['display_users'] =  user::
         Where('id',$_GET['college'])->orderBy('fname','asc')->get();
     }
      if (($_GET['type']!='')&&($_GET['college']=='')&&($_GET['directorate']=='')&&($_GET['department']=='')) {
         $data['display_users'] =  user::
         Where('type',$_GET['type'])->orderBy('fname','asc')->get();
     }
      if (($_GET['type']!='')&&($_GET['college']!='')&&($_GET['directorate']=='')&&($_GET['department']=='')) {
         $data['display_users'] =  user::
         Where('id',$_GET['college'])->
         Where('type',$_GET['type'])->orderBy('fname','asc')->get();
     }


     if (($_GET['type']=='')&&($_GET['college']=='')&&($_GET['directorate']!='')&&($_GET['department']=='')) {

        $directora = Directorate::where('id',$_GET['directorate'])->first();
        $dept  = Department::where('directorate_id',$directora['id'])->first();

        $data['display_users'] =  user::where('section_id',$dept['id'])->orderBy('fname','asc')->get();


    }
    if (($_GET['type']=='')&&($_GET['college']!='')&&($_GET['directorate']!='')&&($_GET['department']=='')) {

        $directora = Directorate::where('id',$_GET['directorate'])->first();
        $dept  = Department::where('directorate_id',$directora['id'])->first();

        $data['display_users'] =  user::where('section_id',$dept['id'])->
        Where('id',$_GET['college'])->orderBy('fname','asc')->get();
    }
     if (($_GET['type']!='')&&($_GET['college']=='')&&($_GET['directorate']!='')&&($_GET['department']=='')) {

        $directora = Directorate::where('id',$_GET['directorate'])->first();
        $dept  = Department::where('directorate_id',$directora['id'])->first();

        $data['display_users'] =  user::where('section_id',$dept['id'])->
        Where('type',$_GET['type'])->orderBy('fname','asc')->get();
    }
     if (($_GET['type']!='')&&($_GET['college']!='')&&($_GET['directorate']!='')&&($_GET['department']=='')) {

        $directora = Directorate::where('id',$_GET['directorate'])->first();
        $dept  = Department::where('directorate_id',$directora['id'])->first();

        $data['display_users'] =  user::where('section_id',$dept['id'])->
        Where('id',$_GET['college'])->
        Where('type',$_GET['type'])->orderBy('fname','asc')->get();
    }

    if (($_GET['type']=='')&&($_GET['college']=='')&&($_GET['directorate']=='')&&($_GET['department']!='')) {

        $data['display_users'] =  user::where('section_id',$_GET['department'])->orderBy('fname','asc')->get();
    }
    if (($_GET['type']=='')&&($_GET['college']!='')&&($_GET['directorate']=='')&&($_GET['department']!='')) {
        $data['display_users'] =  user::where('section_id',$_GET['department'])->
        Where('id',$_GET['college'])->orderBy('fname','asc')->get();
    }
     if (($_GET['type']!='')&&($_GET['college']=='')&&($_GET['directorate']=='')&&($_GET['department']!='')) {
        $data['display_users'] =  user::where('section_id',$_GET['department'])->
        Where('type',$_GET['type'])->orderBy('fname','asc')->get();
    }
     if (($_GET['type']!='')&&($_GET['college']!='')&&($_GET['directorate']=='')&&($_GET['department']!='')) {
        $data['display_users'] =  user::where('section_id',$_GET['department'])->
        Where('id',$_GET['college'])->
        Where('type',$_GET['type'])->orderBy('fname','asc')->get();
    }

    if (($_GET['type']=='')&&($_GET['college']=='')&&($_GET['directorate']!='')&&($_GET['department']!='')) {

        $directora = Directorate::where('id',$_GET['directorate'])->first();
        $dept  = Department::where('directorate_id',$directora['id'])->first();

        if($dept['id']==$_GET['department'])
        {
            $data['display_users'] =  user::where('section_id',$_GET['department'])->orderBy('fname','asc')->get();
        }else
        {
            $data['display_users'] = user::where('id',0)->get();;

        }


    }
    if (($_GET['type']=='')&&($_GET['college']!='')&&($_GET['directorate']!='')&&($_GET['department']!='')) {

       $directora = Directorate::where('id',$_GET['directorate'])->first();
            $dept  = Department::where('directorate_id',$directora['id'])->first();

            if($dept['id']==$_GET['department'])
            {
                $data['display_users'] =  user::where('section_id',$_GET['department'])->
                Where('id',$_GET['college'])->orderBy('fname','asc')->get();
            }else
            {
                $data['display_users'] = user::where('id',0)->get();;

            }


    }
     if (($_GET['type']!='')&&($_GET['college']=='')&&($_GET['directorate']!='')&&($_GET['department']!='')) {

        $directora = Directorate::where('id',$_GET['directorate'])->first();
        $dept  = Department::where('directorate_id',$directora['id'])->first();

        if($dept['id']==$_GET['department'])
        {
            $data['display_users'] =  user::where('section_id',$_GET['department'])->
            Where('type',$_GET['type'])->orderBy('fname','asc')->get();
        }else
        {
            $data['display_users'] = user::where('id',0)->get();;

        }


    }
     if (($_GET['type']!='')&&($_GET['college']!='')&&($_GET['directorate']!='')&&($_GET['department']!='')) {

        $directora = Directorate::where('id',$_GET['directorate'])->first();
        $dept  = Department::where('directorate_id',$directora['id'])->first();

        if($dept['id']==$_GET['department'])
        {
             $data['display_users'] =  user::where('section_id',$_GET['department'])->
            Where('id',$_GET['college'])->
            Where('type',$_GET['type'])->orderBy('fname','asc')->get();
        }else
        {
            $data['display_users'] = user::where('id',0)->get();

        }


    }
  //////////////////////////////////////////////
 if($data['display_users'] ->isEmpty()){

 return redirect()->back()->withErrors(['message' => 'No data Found For Your Search :'.$data['header'].'']);

}else{

$pdf = PDF::loadView('users_pdf', $data);

return $pdf->stream(''.$data['header'].' '.date('d-m-Y Hi').'.pdf');
    }
 //////////////////////////////////////////////
    }


     public function storespdf(){
        if($_GET['name']!=''){$name = 'All '.$_GET['name'];}else{$name = 'All ';}
        if($_GET['type']!=''){$type=$_GET['type'].' Materials Available in Store';}else{ $type =' Materials Available in Store';}

      $data['header'] = $name.''.$type;
     $data['title'] = 'Notes List';
     if (($_GET['name']=='')&&($_GET['brand']=='')&&($_GET['type']!='')) {
         $data['items'] =  material::
         Where('type',$_GET['type'])->orderBy('name','asc')->orderBy('description','asc')->get();
     }
     if (($_GET['name']=='')&&($_GET['brand']!='')&&($_GET['type']=='')) {
        $data['items'] =  material::
        Where('description',$_GET['brand'])->orderBy('name','asc')->orderBy('description','asc')->get();
     }
     if (($_GET['name']=='')&&($_GET['brand']!='')&&($_GET['type']!='')) {
         $data['items'] =  material::
         Where('type',$_GET['type'])->
         Where('description',$_GET['brand'])->orderBy('name','asc')->orderBy('description','asc')->get();
     }
     if (($_GET['name']!='')&&($_GET['brand']=='')&&($_GET['type']=='')) {
          $data['items'] =  material::
         Where('name',$_GET['name'])->orderBy('name','asc')->orderBy('description','asc')->get();
     }
     if (($_GET['name']!='')&&($_GET['brand']=='')&&($_GET['type']!='')) {
          $data['items'] =  material::
         Where('name',$_GET['name'])->
         Where('type',$_GET['type'])->orderBy('name','asc')->orderBy('description','asc')->get();
     }
     if (($_GET['name']!='')&&($_GET['brand']!='')&&($_GET['type']=='')) {
          $data['items'] =  material::
         Where('name',$_GET['name'])->
         Where('description',$_GET['brand'])->orderBy('name','asc')->orderBy('description','asc')->get();
     }
     if (($_GET['name']!='')&&($_GET['brand']!='')&&($_GET['type']!='')) {
          $data['items'] =  material::
         Where('type',$_GET['type'])->
         Where('name',$_GET['name'])->
         Where('description',$_GET['brand'])->orderBy('name','asc')->orderBy('description','asc')->get();
     }
     if (($_GET['name']=='')&&($_GET['brand']=='')&&($_GET['type']=='')) {
          $data['items'] =  material::orderBy('name','asc')->orderBy('description','asc')->get();
     }
 ///////////////////////////////////////////////
 if($data['items'] ->isEmpty()){
    return redirect()->back()->withErrors(['message' => 'No data Found For Your Search :'.$data['header'].'']);


}else{
$pdf = PDF::loadView('material_pdf', $data);
return $pdf->stream(''.$data['header'].' -  '.date('d-m-Y Hi').'.pdf');
    }
  ////////////////////////////////////////////////////
    }

    public function unatendedpdf(){

     $title = 'Notes List';


            if(request()->has('start') && request()->has('end') )  {


        $_GET['userid']=request('start');
        $to=request('end');

        if(request('start')>request('end')){
            $to=request('start');
        $_GET['userid']=request('end');
        }


     $wo =  WorkOrder::where('type',2)->whereBetween('updated_at', [$_GET['userid'], $to])->get();

     $wo =  WorkOrder::where('type',2)-> orderBy(DB::raw('ABS(DATEDIFF(created_at, NOW()))'))->  get();
///////////////////////////////////////////////
     if($wo ->isEmpty()){

return redirect()->back()->withErrors(['message' => 'No data Found For Your Search :'.$data['header'].'']);

}else{
$pdf = PDF::loadView('unatended_pdf', ['wo' => $wo ,'tittle' =>$title]);
return $pdf->stream(''.$data['header'].'- '.date('d-m-Y Hi').'.pdf');
    }
/////////////////////////////////////////////////
    }


}

public function unattendedwopdf(){
      if (($_GET['name']!='')&&($_GET['location']!='')&&($_GET['problem_type']!='')) {
          $data['unattended_work'] =  WorkOrder::Where('client_id',$_GET['name'])->
         Where('location',$_GET['location'])->
         WHERE('problem_type',$_GET['problem_type'])->Where('type','-1')->OrderBy('created_at','Desc')->get();
      }

        if (($_GET['name']!='')&&($_GET['location']!='')&&($_GET['problem_type']=='')) {
            $data['unattended_work'] =  WorkOrder::Where('client_id',$_GET['name'])->
                             Where('location',$_GET['location'])->
                             Where('type','-1')->OrderBy('created_at','Desc')->get();
         }

        if (($_GET['name']!='')&&($_GET['location']=='')&&($_GET['problem_type']!='')) {
          $data['unattended_work'] =  WorkOrder::Where('client_id',$_GET['name'])->
         WHERE('problem_type',$_GET['problem_type'])->
         Where('type','-1')->OrderBy('created_at','Desc')->get();

      }if (($_GET['name']!='')&&($_GET['location']=='')&&($_GET['problem_type']=='')) {
          $data['unattended_work'] =  WorkOrder::Where('client_id',$_GET['name'])->
          Where('type','-1')->OrderBy('created_at','Desc')->get();

      }if (($_GET['name']=='')&&($_GET['location']!='')&&($_GET['problem_type']!='')) {
          $data['unattended_work'] =  WorkOrder::Where('location',$_GET['location'])->
         WHERE('problem_type',$_GET['problem_type'])->
         Where('type','-1')->OrderBy('created_at','Desc')->get();

      }if (($_GET['name']=='')&&($_GET['location']!='')&&($_GET['problem_type']=='')) {
          $data['unattended_work'] =  WorkOrder::Where('location',$_GET['location'])->
         Where('type','-1')->OrderBy('created_at','Desc')->get();

      }if (($_GET['name']=='')&&($_GET['location']=='')&&($_GET['problem_type']!='')) {
          $data['unattended_work'] =  WorkOrder::
         WHERE('problem_type',$_GET['problem_type'])->Where('type','-1')->OrderBy('created_at','Desc')->get();
      }

       if(($_GET['name']=='')&&($_GET['location']=='')&&($_GET['problem_type']=='')){
            $data['unattended_work'] =  WorkOrder::Where('type','-1')->OrderBy('created_at','Desc')->get();
       }
////////////////////////////////////////////////////////
     if($data['unattended_work'] ->isEmpty()){

return redirect()->back()->withErrors(['message' => 'No data Found For Your Search ']);
}else{

        $data['header'] = 'Un-attended works order';
 $pdf = PDF::loadView('unattendedwopdf', $data);
 return $pdf->stream(''.$data['header'].'- '.date('d-m-Y Hi').'.pdf');
    }
/////////////////////////////////////////////////////////////
    }

    public function completewopdf(){
      if (($_GET['name']!='')&&($_GET['location']!='')&&($_GET['problem_type']!='')) {
          $data['unattended_work'] =  WorkOrder::Where('client_id',$_GET['name'])->
         Where('location',$_GET['location'])->
         WHERE('problem_type',$_GET['problem_type'])->Where('type','2')->OrderBy('created_at','Desc')->get();
      }

        if (($_GET['name']!='')&&($_GET['location']!='')&&($_GET['problem_type']=='')) {
            $data['unattended_work'] =  WorkOrder::Where('client_id',$_GET['name'])->
                             Where('location',$_GET['location'])->
                             Where('type','2')->OrderBy('created_at','Desc')->get();
         }

        if (($_GET['name']!='')&&($_GET['location']=='')&&($_GET['problem_type']!='')) {
          $data['unattended_work'] =  WorkOrder::Where('client_id',$_GET['name'])->
         WHERE('problem_type',$_GET['problem_type'])->
         Where('type','2')->OrderBy('created_at','Desc')->get();

      }if (($_GET['name']!='')&&($_GET['location']=='')&&($_GET['problem_type']=='')) {
          $data['unattended_work'] =  WorkOrder::Where('client_id',$_GET['name'])->
          Where('type','2')->OrderBy('created_at','Desc')->get();

      }if (($_GET['name']=='')&&($_GET['location']!='')&&($_GET['problem_type']!='')) {
          $data['unattended_work'] =  WorkOrder::Where('location',$_GET['location'])->
         WHERE('problem_type',$_GET['problem_type'])->
         Where('type','2')->OrderBy('created_at','Desc')->get();

      }if (($_GET['name']=='')&&($_GET['location']!='')&&($_GET['problem_type']=='')) {
          $data['unattended_work'] =  WorkOrder::Where('location',$_GET['location'])->
         Where('type','2')->OrderBy('created_at','Desc')->get();

      }if (($_GET['name']=='')&&($_GET['location']=='')&&($_GET['problem_type']!='')) {
          $data['unattended_work'] =  WorkOrder::
         WHERE('problem_type',$_GET['problem_type'])->Where('type','2')->OrderBy('created_at','Desc')->get();
      }

       if(($_GET['name']=='')&&($_GET['location']=='')&&($_GET['problem_type']=='')){
            $data['unattended_work'] =  WorkOrder::Where('type','2')->OrderBy('created_at','Desc')->get();
       }

//////////////////////////////////////////////
 if($data['unattended_work'] ->isEmpty()){
return redirect()->back()->withErrors(['message' => 'No data Found For Your Search :'.$data['header'].'']);

}else{
$pdf = PDF::loadView('completewopdf', $data);
return $pdf->stream(''.$data['header'].'- '.date('d-m-Y Hi').'.pdf');
    }
////////////////////////////////////////////////
    }
        public function wowithdurationpdf(){
      if (($_GET['name']!='')&&($_GET['location']!='')&&($_GET['problem_type']!='')) {
          $data['unattended_work'] =  WorkOrder::Where('client_id',$_GET['name'])->
         Where('location',$_GET['location'])->
         WHERE('problem_type',$_GET['problem_type'])->Where('type','2')->OrderBy('created_at','Desc')->get();
      }

        if (($_GET['name']!='')&&($_GET['location']!='')&&($_GET['problem_type']=='')) {
            $data['unattended_work'] =  WorkOrder::Where('client_id',$_GET['name'])->
                             Where('location',$_GET['location'])->
                             Where('type','2')->OrderBy('created_at','Desc')->get();
         }

        if (($_GET['name']!='')&&($_GET['location']=='')&&($_GET['problem_type']!='')) {
          $data['unattended_work'] =  WorkOrder::Where('client_id',$_GET['name'])->
         WHERE('problem_type',$_GET['problem_type'])->
         Where('type','2')->OrderBy('created_at','Desc')->get();

      }if (($_GET['name']!='')&&($_GET['location']=='')&&($_GET['problem_type']=='')) {
          $data['unattended_work'] =  WorkOrder::Where('client_id',$_GET['name'])->
          Where('type','2')->OrderBy('created_at','Desc')->get();

      }if (($_GET['name']=='')&&($_GET['location']!='')&&($_GET['problem_type']!='')) {
          $data['unattended_work'] =  WorkOrder::Where('location',$_GET['location'])->
         WHERE('problem_type',$_GET['problem_type'])->
         Where('type','2')->OrderBy('created_at','Desc')->get();

      }if (($_GET['name']=='')&&($_GET['location']!='')&&($_GET['problem_type']=='')) {
          $data['unattended_work'] =  WorkOrder::Where('location',$_GET['location'])->
         Where('type','2')->OrderBy('created_at','Desc')->get();

      }if (($_GET['name']=='')&&($_GET['location']=='')&&($_GET['problem_type']!='')) {
          $data['unattended_work'] =  WorkOrder::
         WHERE('problem_type',$_GET['problem_type'])->Where('type','2')->OrderBy('created_at','Desc')->get();
      }

       if(($_GET['name']=='')&&($_GET['location']=='')&&($_GET['problem_type']=='')){
            $data['unattended_work'] =  WorkOrder::Where('type','2')->OrderBy('created_at','Desc')->get();
       }

/////////////////////////////////////////////////
 if($data['unattended_work'] ->isEmpty()){
return redirect()->back()->withErrors(['message' => 'No data Found For Your Search :'.$data['header'].'']);

}else{

$pdf = PDF::loadView('wowithdurationpdf', $data);
return $pdf->stream(''.$data['header'].'- '.date('d-m-Y Hi').'.pdf');
    }
////////////////////////////////////////////////////
    }

    public function roomreportpdf(){
        if ($_GET['location']!='') {
            $data['local'] = WorkOrder::select('location')->distinct()->Where('location',$_GET['location'])->get();
        }
        if ($_GET['location']=='') {
           $data['local'] = WorkOrder::select('location')->distinct()->get();
        }
///////////////////////////////////////////////
       if($data['local'] ->isEmpty()){

return redirect()->back()->withErrors(['message' => 'No data Found For Your Search :'.$data['header'].'']);
}else{

$pdf = PDF::loadView('roomreportpdf', $data);
return $pdf->stream(''.$data['header'].'- '.date('d-m-Y Hi').'.pdf');
    }
///////////////////////////////////////////////////
    }
///////////////// prints from hos \/ below /////////////////////
    public function allpdf()

    {
        $data['header']='';
        if (($_GET['name']!='')&&($_GET['type']!='')) {
            if ($_GET['change']=='hos')
            {
                 $data['fetch'] = user::where('type','like','%'.$_GET['type'].'%')->where('id',$_GET['name'])->OrderBy('fname','asc')->get();
 $data['header'] = 'All Heads of Sections Details';
 $data['section'] ='0';
            }elseif($_GET['change']=='iow')
            {
                 $data['fetch'] = user::where('type','like','%'.$_GET['type'].'%')->where('id',$_GET['name'])->OrderBy('fname','asc')->get();
 $data['header'] = 'All Inspectors of work Details';
 $data['section'] ='0';
            }else
            {
                 $data['fetch'] = Technician::where('type',0)->where('type',$_GET['type'])->where('id',$_GET['name'])->OrderBy('fname','asc')->get();
             $data['header'] = 'All Technicians Details';
             $data['section'] ='0';
            }
        }
        if (($_GET['name']=='')&&($_GET['type']!=''))
        {
          if ($_GET['change']=='hos')
          {
                 $data['fetch'] = user::where('type',$_GET['type'])->OrderBy('fname','asc')->get();
                $data['header'] = 'All '.$_GET['type'].' Details';
                $data['section'] =$_GET['type'];
            }elseif($_GET['change']=='iow')
            {
                 $data['fetch'] = user::where('type',$_GET['type'])->OrderBy('fname','asc')->get();
                $data['header'] = 'All '.$_GET['type'].' Details';
               $data['section'] =$_GET['type'];
            }else
            {
                 $data['fetch'] = Technician::where('type',0)->where('type',$_GET['type'])->OrderBy('fname','asc')->get();
                $data['header'] = 'All '.$_GET['type'].'  Technicians Details';
                $data['section'] = $_GET['type'];
            }
        }
        if (($_GET['name']!='')&&($_GET['type']==''))
        {
             if ($_GET['change']=='hos')
             {
                 $data['fetch'] = user::where('id',$_GET['name'])->OrderBy('fname','asc')->get();
                $data['header'] = 'Head of Section Details';
                $data['section'] ='0';
            }elseif($_GET['change']=='iow')
            {
                 $data['fetch'] = user::where('id',$_GET['name'])->OrderBy('fname','asc')->where('id',$_GET['name'])->get();
                $data['header'] = 'Inspector of work Details';
                $data['section'] ='0';
            }else
            {
                 $data['fetch'] = Technician::where('type',0)->where('id',$_GET['name'])->OrderBy('fname','asc')->get();
                 $data['header'] = 'Technician Details';
                 $data['section'] ='0';
            }
        }
        if (($_GET['name']=='')&&($_GET['type']==''))
        {
            if ($_GET['change']=='hos')
            {
                 $data['fetch'] = user::OrderBy('type','asc')->OrderBy('fname','asc')->get();
 $data['header'] = 'All Heads of Sections Details';
 $data['section'] ='0';
            }elseif($_GET['change']=='iow')
            {
                 $data['fetch'] = user::OrderBy('type','asc')->OrderBy('fname','asc')->get();
 $data['header'] = 'All Inspectors of work Details';
 $data['section'] ='0';
            }else
            {
                 $data['fetch'] = Technician::where('type',0)->OrderBy('type','asc')->OrderBy('fname','asc')->get();

             $data['header'] = 'All Technician Details';
              $data['section'] ='0';

             $data['header'] = 'All Technician Details';
             $data['section'] ='0';

            }
        }



       if($data['fetch'] ->isEmpty()){

return redirect()->back()->withErrors(['message' => 'No data Found Matching your Filter ']);
}else{

$pdf = PDF::loadView('allreport', $data);
return $pdf->stream(''.$data['header'].'- '.date('d-m-Y Hi').'.pdf');
    }


    }
///////////////// prints from hos /\ up ////////////////////////

    public function grnotepdf($id){

           $data = ['title' => 'Notes List' , 'items' => WorkOrderMaterial::where('work_order_id',$id)->where('type',15)
                    ->get()];
         $pdf = PDF::loadView('grnpdf', $data)->setPaper('a4', 'landscape');

     return $pdf->stream('Goods received Note - '.$id.'- '.date('d-m-Y Hi').'.pdf');
    }



    public function issuenotepdf($id){


         $data = ['title' => 'Notes List' , 'items' => WorkOrderMaterial::where('work_order_id',$id)->where('type',3)
                    ->get()];
         $pdf = PDF::loadView('issuenotepdf', $data);

     return $pdf->stream('Issue Note- '.$id.'- '.date('d-m-Y Hi').'.pdf');
    }

    public function trackreport (Request $request, $id)
    {
    $data['wo'] = WorkOrder::where('id', $id)->with('work_order_inspection')->first();
    $data['header'] = 'Works Order Report (WO#'.$id.')';
///////////////////////////////////////////////

     $pdf = PDF::loadView('trackworkreport', $data);
      return $pdf->stream(''.$data['header'].'-  '.date('d-m-Y Hi').'.pdf');
///////////////////////////////////////////////////
    }




        public function techforreport (Request $request, $id)
    {
    $data['wo'] = WorkOrder::where('id', $id)->with('work_order_inspection')->first();
    $data['header'] = 'Works Order Technician Inspection (WO#'.$id.')';
///////////////////////////////////////////////

    $pdf = PDF::loadView('techforreport', $data);
     return $pdf->stream(''.$data['header'].'-  '.date('d-m-Y Hi').'.pdf');
///////////////////////////////////////////////////
    }



    public function colgenerate()
    {
     if($_GET['college']=='')
     {
        $data['catch'] = directorate::orderby('name','ASC')->get();
        $data['header'] = 'All Colleges/Directorates/Institute/Schools Details';
     }
     if($_GET['college']!='')
     {
        $data['catch'] = directorate::where('id',$_GET['college'])->orderby('name','ASC')->get();
        $data['header'] = 'Colleges/Directorates/Institute/Schools Details';

     }

     if($data['catch'] ->isEmpty()){

        return redirect()->back()->withErrors(['message' => 'No data Found Matching your filter ']);
        }else{

        $pdf = PDF::loadView('collegesreport', $data);
        return $pdf->stream(''.$data['header'].'- '.date('d-m-Y Hi').'.pdf');
            }


    }

    public function depgenerate()
    {
        if(($_GET['department']!='')&&($_GET['college']!=''))
        {
            $data['catch'] = department::Where('id',$_GET['department'])->where('directorate_id',$_GET['college'])->OrderBy('name','ASC')->get();
            $data['header'] = 'All Departments Details';
            $data['dept'] = '0';
        }

        if(($_GET['department']=='')&&($_GET['college']!=''))
        {
            $department = directorate::where('id',$_GET['college'])->orderBy('name','ASC')->get();
            foreach ($department as $department) {

            }
            $data['catch'] = department::where('directorate_id',$_GET['college'])->orderBy('name','ASC')->get();

            $data['header'] = $department->name.' Departments Details';
            $data['dept'] = $department->name;
        }

        if(($_GET['department']!='')&&($_GET['college']==''))
        {
            $data['catch'] = department::where('id',$_GET['department'])->get();

            $data['header'] = 'Departments Details';
            $data['dept'] = '0';
        }

        if(($_GET['department']=='')&&($_GET['college']==''))
        {
            $data['catch'] = department::orderby('name','ASC')->get();
            $data['header'] = 'All Departments Details';
            $data['dept'] = '0';
        }

        if($data['catch'] ->isEmpty()){

            return redirect()->back()->withErrors(['message' => 'No data Found Matching your filter ']);
            }else{

            $pdf = PDF::loadView('departmentsreport', $data);
            return $pdf->stream(''.$data['header'].'- '.date('d-m-Y Hi').'.pdf');
                }

    }
    public function desdepts()
    {
        $data['sects'] = workordersection::orderby('section_name','ASC')->get();
        $pdf = PDF::loadView('desdeptsreport', $data);
        return $pdf->stream('All sections report - '.date('d-m-Y Hi').'.pdf');
    }


    public function iowzones()
    {
        $data['iowzone'] =  User::where('type', 'Inspector Of Works')->
                       select(DB::raw('zone') )
                       ->where('type', 1)
                       ->where('zone','<>', 'NULL')
                     ->groupBy('zone')
                     ->get();
        $pdf = PDF::loadView('iowzonereport', $data);
        return $pdf->stream('iowzone - '.date('d-m-Y Hi').'.pdf');
    }


        public function iowonlyzones()
    {
        $data['iowzone'] = iowzone::OrderBy('zonename', 'ASC')->get();
        $pdf = PDF::loadView('iowonlyzonereport', $data);
        return $pdf->stream('iowzone - '.date('d-m-Y Hi').'.pdf');
    }


        public function iowfromzones($zone)
    {
        $data['iowzone'] =  User::where('zone', $zone)->get();
        $pdf = PDF::loadView('iowfromzonereport', $data);
        return $pdf->stream('iowzone - '.date('d-m-Y Hi').'.pdf');
    }



        public function iowlocation($id)
    {
        $data['iowlocation'] = iowzonelocation::where('iow_id',$id)->orderby('location','ASC')->get();
        $pdf = PDF::loadView('iowlocationreport', $data);
        return $pdf->stream('iowlocation - '.date('d-m-Y Hi').'.pdf');
    }


    public function exportProcure($id)
    {
        $data['procure'] = Procurement::where('tag_',$id)->orderBy('material_name','Asc')->orderBy('type','Asc')->get();
        $data['header'] = "Procured Materials Sent To Store";
        $pdf = PDF::loadView('procurementList',$data);
        return $pdf->stream(' Procured Materials - '.date('d-m-Y H:i').'.pdf');
    }
    public function PrintNote($id)
    {
        $data['procure'] = Procurement::where('tag_',$id)->orderBy('material_name','Asc')->orderBy('type','Asc')->get();
        $data['header'] = "Procured Materials Receiving Document";
        $pdf = PDF::loadView('procurementReceiving',$data)->setPaper('a4', 'landscape');
        return $pdf->stream(' Procured Materials Receiving Document - '.date('d-m-Y H:i').'.pdf');
    }
     public function materialEntrypdf($id)
    {
        $data['entry'] = Storehistory::where('tag_',$id)->orderBy('material_name','Asc')->orderBy('type','Asc')->get();
        $data['header'] = "Store Material Entry Report";
        $pdf = PDF::loadView('materialEntrypdf',$data);
        return $pdf->stream('Store Material Entry Report - '.date('d-m-Y H:i').'.pdf');
    }





      public function addassessmentpdf($id , $tender ){

        $tender = Crypt::decrypt($tender);
        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();

           $data = [

            'title' => 'Notes List' ,
            'role' => $role,
            'notifications' => $notifications,
            'company' =>company::where('tender', $tender)->get(),
            'companyname' =>company::where('id', $id)->first(),


          ];
         $pdf = PDF::loadView('addassessmentpdf', $data);

     return $pdf->stream('Assessmentform - '.$id.'- '.date('d-m-Y Hi').'.pdf');
    }







      public function assessmentpdf($id , $tender , $month){
         $company = Crypt::decrypt($tender);
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();

           $data = [

            'title' => 'Notes List' ,

           'notifications' => $notifications,

            'role' => $role,

            'company' =>company::all(),
            'carea' =>cleaningarea::all(),

            'assessmmentcompany' => landassessmentform::where('id', $id)->get(),
             'assessmmentcompanyname' => landassessmentform::where('company', $company)->where('assessment_month', $month)->get(),


          ];
         $pdf = PDF::loadView('assessmentpdf', $data);

     return $pdf->stream('Assessmentform - '.$id.'- '.date('d-m-Y Hi').'.pdf');
    }


          public function trendingscorereport(request $request ,$tender , $company){
         $tenders = Crypt::decrypt($tender);
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();

         if($request['start'] and $request['end']){


        $from=request('start');
        $to=request('end');


        $nextday = date("Y-m-d", strtotime("$to +1 day"));

        $to=$nextday;
        if(request('start')>request('end')){
            $to=request('start');
        $from=request('end');
        }// start> end


           $data = [
            'notifications' => $notifications,
            'role' => $role,
             'assessmmentcompanyname' => landcrosschecklandassessmentactivity::whereBetween('month', [$from, $to])->where('company', $tenders)->select(DB::raw('sum(score) as erick , month'))
                    ->groupBy('month')->orderby('month','DESC')->get(),
                    'compa'=>$company,
            'crosscheckassessmmentactivitygroupbyarea' => landcrosschecklandassessmentactivity::whereBetween('month', [$from, $to])->where('company', $tenders)->select(DB::raw('area'))
                    ->groupBy('area')->get()
               ];

                 if($data['assessmmentcompanyname'] ->isEmpty()) {
            return redirect()->back()->withErrors(['message' => 'No data found for your search ']);}
            else{
                 $pdf = PDF::loadView('trendingscorereport', $data);

        return $pdf->stream('trending_month_score - '.date('d-m-Y Hi').'.pdf');
            }
              }

              else{
                if($request['start']==''){

           $data = [
            'notifications' => $notifications,
            'role' => $role,
             'assessmmentcompanyname' => landcrosschecklandassessmentactivity::where('company', $tenders)->select(DB::raw('sum(score) as erick , month'))
                    ->groupBy('month')->orderby('month','DESC')->get(),
                    'compa'=>$company,
            'crosscheckassessmmentactivitygroupbyarea' => landcrosschecklandassessmentactivity::where('company', $tenders)->select(DB::raw('area'))
                    ->groupBy('area')->get()
               ];
          }
            if($request['start']){

           $data = [
            'notifications' => $notifications,
            'role' => $role,
             'assessmmentcompanyname' => landcrosschecklandassessmentactivity::where('company', $tenders)->where('month', $request['start'])->select(DB::raw('sum(score) as erick , month'))
                    ->groupBy('month')->orderby('month','DESC')->get(),
                    'compa'=>$company,
            'crosscheckassessmmentactivitygroupbyarea' => landcrosschecklandassessmentactivity::where('company', $tenders)->where('month', $request['start'])->select(DB::raw('area'))
                    ->groupBy('area')->get()
               ];

          }

          if($data['assessmmentcompanyname'] ->isEmpty()) {
            return redirect()->back()->withErrors(['message' => 'No data found for your search ']);}
            else{
                 $pdf = PDF::loadView('trendingscorereport', $data);

        return $pdf->stream('trending_month_score - '.date('d-m-Y Hi').'.pdf');
            }

              }


         }


              public function trendingscorereportcompany($tender , $month){
         $tenders = Crypt::decrypt($tender);
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();

           $data = [
            'notifications' => $notifications,
            'role' => $role,

              'assessmmentcompany' => landassessmentform::where('assessment_month', $month)->where('company', $tenders)->OrderBy('company_id')->get(),

        'assessmmentcompanyname' => landassessmentform::where('assessment_month', $month)->where('company', $tenders)->get(),

               ];
         $pdf = PDF::loadView('trendingscorereportcompany', $data);

     return $pdf->stream('trending_month_score_forcompany - '.date('d-m-Y Hi').'.pdf');
    }




         public function landcleaningcompanyreport(){

        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();

           $data = [
            'notifications' => $notifications,
            'role' => $role,
                'cleangcompany' => tendernumber::all()
               ];
         $pdf = PDF::loadView('landcleaning_companyreport', $data);

     return $pdf->stream('cleaning_company_report - '.date('d-m-Y Hi').'.pdf');
    }



    public function landcleaningareareport(){

        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();

           $data = [
            'notifications' => $notifications,
            'role' => $role,
                           'newzone' => iowzone::OrderBy('zonename', 'ASC')->get(),
               'cleanarea' => cleaningarea::OrderBy('cleaning_name', 'ASC')->get()
               ];
         $pdf = PDF::loadView('landcleaning_areareport', $data);

     return $pdf->stream('cleaning_area_report - '.date('d-m-Y Hi').'.pdf');
    }






    public function printmonthreport(request $request , $id){


          if($request['tender']=='' and $request['company']=='' and $request['area']=='' and $request['sheet']==''){

             $data['assessmmentcompany']= landassessmentform::where('assessment_month', $id)->get();
              }


         if($request['sheet']){

             $data['assessmmentcompany']= landassessmentform::where('assessment_month', $id)->where('assessment_name', $request['sheet'])->get();
              }
         if($request['area']){

             $data['assessmmentcompany']= landassessmentform::where('assessment_month', $id)->where('area_id', $request['area'])->get();
              }

         if($request['company']){

             $data['assessmmentcompany']= landassessmentform::where('assessment_month', $id)->where('company_id', $request['company'])->get();
              }

         if($request['area'] and $request['sheet']){

             $data['assessmmentcompany']= landassessmentform::where('assessment_month', $id)->where('assessment_name', $request['sheet'])->where('area_id', $request['area'])->get();
              }

          if($request['company'] and $request['sheet']){

             $data['assessmmentcompany']= landassessmentform::where('assessment_month', $id)->where('assessment_name', $request['sheet'])->where('company_id', $request['company'])->get();
              }


          if($request['company'] and $request['area']){

             $data['assessmmentcompany']= landassessmentform::where('assessment_month', $id)->where('area_id', $request['area'])->where('company_id', $request['company'])->get();
              }

          if($request['company'] and $request['area'] and $request['sheet'] ){

             $data['assessmmentcompany']= landassessmentform::where('assessment_month', $id)->where('area_id', $request['area'])->where('company_id', $request['company'])->where('assessment_name', $request['sheet'])->get();
              }


         if($request['tender']){

             $data['assessmmentcompany']= landassessmentform::where('assessment_month', $id)->where('company', $request['tender'])->get();
              }

         if($request['sheet'] and $request['tender']){

             $data['assessmmentcompany']= landassessmentform::where('assessment_month', $id)->where('assessment_name', $request['sheet'])->where('company', $request['tender'])->get();
              }
         if($request['area'] and $request['tender']){

             $data['assessmmentcompany']= landassessmentform::where('assessment_month', $id)->where('area_id', $request['area'])->where('company', $request['tender'])->get();
              }

         if($request['company'] and $request['tender']){

             $data['assessmmentcompany']= landassessmentform::where('assessment_month', $id)->where('company_id', $request['company'])->where('company', $request['tender'])->get();
              }

         if($request['area'] and $request['sheet'] and $request['tender']){

             $data['assessmmentcompany']= landassessmentform::where('assessment_month', $id)->where('assessment_name', $request['sheet'])->where('area_id', $request['area'])->where('company', $request['tender'])->get();
              }

          if($request['company'] and $request['sheet'] and $request['tender']){

             $data['assessmmentcompany']= landassessmentform::where('assessment_month', $id)->where('assessment_name', $request['sheet'])->where('company_id', $request['company'])->where('company', $request['tender'])->get();
              }


          if($request['company'] and $request['area'] and $request['tender']){

             $data['assessmmentcompany']= landassessmentform::where('assessment_month', $id)->where('area_id', $request['area'])->where('company_id', $request['company'])->where('company', $request['tender'])->get();
              }

          if($request['company'] and $request['area'] and $request['sheet'] and $request['tender'] ){

             $data['assessmmentcompany']= landassessmentform::where('assessment_month', $id)->where('area_id', $request['area'])->where('company_id', $request['company'])->where('assessment_name', $request['sheet'])->where('company', $request['tender'])->get();
              }

          if($data['assessmmentcompany'] ->isEmpty()) {
            return redirect()->back()->withErrors(['message' => 'No data found for your search ']);
        }else{


         $pdf = PDF::loadView('assessmentmonthreport', $data);

     return $pdf->stream('Assessmentmonthreport - '.$id.'- '.date('d-m-Y Hi').'.pdf');
   }
 }



//landscaping

        public function assessmentviewpdf(request $request)
    {

        $data['header'] = $request['sheet'];


           if($request['start'] and $request['end'])  { //date filter


        $from=request('start');
        $to=request('end');


        $nextday = date("Y-m-d", strtotime("$to +1 day"));

        $to=$nextday;
        if(request('start')>request('end')){
            $to=request('start');
        $from=request('end');
        }// start> end




          if($request['typees']=='' and $request['sheet']=='' and $request['company']=='' and $request['area']=='' and $request['tender']==''){

             $data['assessmmentcompany'] = landassessmentform::whereBetween('assessment_month', [$from, $to])->OrderBy('assessment_month', 'DESC')->get();

        }
          if($request['typees']==''  and $request['sheet']=='' and $request['company']=='' and $request['area']=='' and $request['tender'] ){

             $data['assessmmentcompany'] = landassessmentform::whereBetween('assessment_month', [$from, $to])->where('company', $request['tender'])->orwhere('type', $request['typees'])->orwhere('company_id', $request['company'])->orwhere('assessment_name', $request['sheet'])->orwhere('area_id', $request['area'])->OrderBy('assessment_month', 'DESC')->get();

        }

        if($request['typees']=='' and $request['sheet']=='' and $request['company']=='' and $request['area'] and $request['tender']=='' ){

             $data['assessmmentcompany'] = landassessmentform::whereBetween('assessment_month', [$from, $to])->where('area_id', $request['area'])->orwhere('type', $request['typees'])->orwhere('company_id', $request['company'])->orwhere('assessment_name', $request['sheet'])->orwhere('company', $request['tender'])->OrderBy('assessment_month', 'DESC')->get();

        } if($request['typees']=='' and $request['sheet']=='' and $request['company']=='' and $request['area'] and $request['tender'] ){

             $data['assessmmentcompany'] = landassessmentform::whereBetween('assessment_month', [$from, $to])->where('area_id', $request['area'])->where('company', $request['tender'])->orwhere('type', $request['typees'])->orwhere('company_id', $request['company'])->orwhere('assessment_name', $request['sheet'])->OrderBy('assessment_month', 'DESC')->get();

        }
         if($request['typees']=='' and $request['sheet']=='' and $request['company'] and $request['area']=='' and $request['tender']=='' ){

             $data['assessmmentcompany'] = landassessmentform::whereBetween('assessment_month', [$from, $to])->where('company_id', $request['company'])->orwhere('type', $request['typees'])->orwhere('assessment_name', $request['sheet'])->orwhere('area_id', $request['area'])->orwhere('company', $request['tender'])->OrderBy('assessment_month', 'DESC')->get();

        }

         if($request['typees']=='' and $request['sheet']=='' and $request['company'] and $request['area']=='' and $request['tender'] ){

             $data['assessmmentcompany'] = landassessmentform::whereBetween('assessment_month', [$from, $to])->where('company', $request['tender'])->where('company_id', $request['company'])->orwhere('type', $request['typees'])->orwhere('assessment_name', $request['sheet'])->orwhere('area_id', $request['area'])->OrderBy('assessment_month', 'DESC')->get();

        }

         if($request['typees']=='' and $request['sheet']=='' and $request['company'] and $request['area'] and $request['tender']=='' ){

             $data['assessmmentcompany'] = landassessmentform::whereBetween('assessment_month', [$from, $to])->where('company_id', $request['company'])->where('area_id', $request['area'])->orwhere('type', $request['typees'])->orwhere('assessment_name', $request['sheet'])->orwhere('company', $request['tender'])->OrderBy('assessment_month', 'DESC')->get();

        }
         if($request['typees']=='' and $request['sheet']=='' and $request['company'] and $request['area'] and $request['tender'] ){

             $data['assessmmentcompany'] = landassessmentform::whereBetween('assessment_month', [$from, $to])->where('company_id', $request['company'])->where('area_id', $request['area'])->where('company', $request['tender'])->orwhere('type', $request['typees'])->orwhere('assessment_name', $request['sheet'])->OrderBy('assessment_month', 'DESC')->get();

        }
         if($request['typees']=='' and $request['sheet'] and $request['company']=='' and $request['area']=='' and $request['tender']=='' ){

             $data['assessmmentcompany'] = landassessmentform::whereBetween('assessment_month', [$from, $to])->where('assessment_name', $request['sheet'])->orwhere('type', $request['typees'])->orwhere('company_id', $request['company'])->orwhere('area_id', $request['area'])->orwhere('company', $request['tender'])->OrderBy('assessment_month', 'DESC')->get();

        }
         if($request['typees']=='' and $request['sheet'] and $request['company']=='' and $request['area']=='' and $request['tender']){

             $data['assessmmentcompany'] = landassessmentform::whereBetween('assessment_month', [$from, $to])->where('company', $request['tender'])->where('assessment_name', $request['sheet'])->orwhere('type', $request['typees'])->orwhere('company_id', $request['company'])->orwhere('area_id', $request['area'])->OrderBy('assessment_month', 'DESC')->get();

        }
         if($request['typees']=='' and $request['sheet'] and $request['company']=='' and $request['area'] and $request['tender']=='' ){

             $data['assessmmentcompany'] = landassessmentform::whereBetween('assessment_month', [$from, $to])->where('assessment_name', $request['sheet'])->where('area_id', $request['area'])->orwhere('type', $request['typees'])->orwhere('company_id', $request['company'])->orwhere('company', $request['tender'])->OrderBy('assessment_month', 'DESC')->get();

        }
         if($request['typees']=='' and $request['sheet'] and $request['company']=='' and $request['area'] and $request['tender']){

             $data['assessmmentcompany'] = landassessmentform::whereBetween('assessment_month', [$from, $to])->where('assessment_name', $request['sheet'])->where('area_id', $request['area'])->where('company', $request['tender'])->orwhere('type', $request['typees'])->orwhere('company_id', $request['company'])->OrderBy('assessment_month', 'DESC')->get();

        }
         if($request['typees']=='' and $request['sheet'] and $request['company'] and $request['area']=='' and $request['tender']=='' ){

             $data['assessmmentcompany'] = landassessmentform::whereBetween('assessment_month', [$from, $to])->where('company_id', $request['company'])->orwhere('assessment_name', $request['sheet'])->orwhere('type', $request['typees'])->orwhere('area_id', $request['area'])->orwhere('company', $request['tender'])->OrderBy('assessment_month', 'DESC')->get();

        }
         if($request['typees']=='' and $request['sheet'] and $request['company'] and $request['area']=='' and $request['tender'] ){

             $data['assessmmentcompany'] = landassessmentform::whereBetween('assessment_month', [$from, $to])->where('company_id', $request['company'])->where('assessment_name', $request['sheet'])->where('company', $request['tender'])->orwhere('area_id', $request['area'])->orwhere('type', $request['typees'])->OrderBy('assessment_month', 'DESC')->get();

        }

         if($request['typees']=='' and $request['sheet'] and $request['company'] and $request['area'] and $request['tender']=='' ){

             $data['assessmmentcompany'] = landassessmentform::whereBetween('assessment_month', [$from, $to])->where('company_id', $request['company'])->where('assessment_name', $request['sheet'])->where('area_id', $request['area'])->orwhere('type', $request['typees'])->orwhere('company', $request['tender'])->OrderBy('assessment_month', 'DESC')->get();

        }

         if($request['typees']=='' and $request['sheet'] and $request['company'] and $request['area'] and $request['tender'] ){

             $data['assessmmentcompany'] = landassessmentform::whereBetween('assessment_month', [$from, $to])->where('company_id', $request['company'])->where('assessment_name', $request['sheet'])->where('area_id', $request['area'])->where('company', $request['tender'])->orwhere('type', $request['typees'])->OrderBy('assessment_month', 'DESC')->get();

        }


         if($request['typees'] and $request['sheet']=='' and $request['company']=='' and $request['area']=='' and $request['tender']=='' ){

             $data['assessmmentcompany'] = landassessmentform::whereBetween('assessment_month', [$from, $to])->where('type', $request['typees'])->orwhere('company_id', $request['company'])->orwhere('assessment_name', $request['sheet'])->orwhere('area_id', $request['area'])->orwhere('company', $request['tender'])->OrderBy('assessment_month', 'DESC')->get();

        }
         if($request['typees'] and $request['sheet']=='' and $request['company']=='' and $request['area']=='' and $request['tender']){

             $data['assessmmentcompany'] = landassessmentform::whereBetween('assessment_month', [$from, $to])->where('type', $request['typees'])->where('company', $request['tender'])->orwhere('company_id', $request['company'])->orwhere('assessment_name', $request['sheet'])->orwhere('area_id', $request['area'])->OrderBy('assessment_month', 'DESC')->get();

        }
         if($request['typees'] and $request['sheet']=='' and $request['company']=='' and $request['area'] and $request['tender']=='' ){

             $data['assessmmentcompany'] = landassessmentform::whereBetween('assessment_month', [$from, $to])->where('type', $request['typees'])->where('area_id', $request['area'])->orwhere('company_id', $request['company'])->orwhere('assessment_name', $request['sheet'])->orwhere('company', $request['tender'])->OrderBy('assessment_month', 'DESC')->get();

        }
         if($request['typees'] and $request['sheet']=='' and $request['company']=='' and $request['area'] and $request['tender'] ){

             $data['assessmmentcompany'] = landassessmentform::whereBetween('assessment_month', [$from, $to])->where('type', $request['typees'])->where('area_id', $request['area'])->where('company', $request['tender'])->orwhere('company_id', $request['company'])->orwhere('assessment_name', $request['sheet'])->OrderBy('assessment_month', 'DESC')->get();

        }
         if($request['typees'] and $request['sheet']=='' and $request['company'] and $request['area']=='' and $request['tender']=='' ){

             $data['assessmmentcompany'] = landassessmentform::whereBetween('assessment_month', [$from, $to])->where('type', $request['typees'])->where('company_id', $request['company'])->orwhere('assessment_name', $request['sheet'])->orwhere('area_id', $request['area'])->orwhere('company', $request['tender'])->OrderBy('assessment_month', 'DESC')->get();

        }
         if($request['typees'] and $request['sheet']=='' and $request['company'] and $request['area']=='' and $request['tender']){

             $data['assessmmentcompany'] = landassessmentform::whereBetween('assessment_month', [$from, $to])->where('type', $request['typees'])->where('company_id', $request['company'])->where('company', $request['tender'])->orwhere('assessment_name', $request['sheet'])->orwhere('area_id', $request['area'])->OrderBy('assessment_month', 'DESC')->get();

        }
         if($request['typees'] and $request['sheet']=='' and $request['company'] and $request['area'] and $request['tender']=='' ){

             $data['assessmmentcompany'] = landassessmentform::whereBetween('assessment_month', [$from, $to])->where('type', $request['typees'])->where('company_id', $request['company'])->where('area_id', $request['area'])->orwhere('assessment_name', $request['sheet'])->orwhere('company', $request['tender'])->OrderBy('assessment_month', 'DESC')->get();

        }
         if($request['typees'] and $request['sheet']=='' and $request['company'] and $request['area'] and $request['tender'] ){

             $data['assessmmentcompany'] = landassessmentform::whereBetween('assessment_month', [$from, $to])->where('type', $request['typees'])->where('company_id', $request['company'])->where('area_id', $request['area'])->where('company', $request['tender'])->orwhere('assessment_name', $request['sheet'])->OrderBy('assessment_month', 'DESC')->get();

        }
         if($request['typees'] and $request['sheet'] and $request['company']=='' and $request['area']=='' and $request['tender']=='' ){

             $data['assessmmentcompany'] = landassessmentform::whereBetween('assessment_month', [$from, $to])->where('type', $request['typees'])->where('assessment_name', $request['sheet'])->orwhere('company_id', $request['company'])->orwhere('area_id', $request['area'])->orwhere('company', $request['tender'])->OrderBy('assessment_month', 'DESC')->get();

        }
         if($request['typees'] and $request['sheet']=='' and $request['company']=='' and $request['area']=='' and $request['tender'] ){

              $data['assessmmentcompany'] = landassessmentform::whereBetween('assessment_month', [$from, $to])->where('type', $request['typees'])->where('assessment_name', $request['sheet'])->where('company', $request['tender'])->orwhere('company_id', $request['company'])->orwhere('area_id', $request['area'])->OrderBy('assessment_month', 'DESC')->get();

        }
         if($request['typees'] and $request['sheet'] and $request['company']=='' and $request['area'] and $request['tender']=='' ){

           $data['assessmmentcompany'] = landassessmentform::whereBetween('assessment_month', [$from, $to])->where('type', $request['typees'])->where('assessment_name', $request['sheet'])->where('area_id', $request['area'])->orwhere('company', $request['tender'])->orwhere('company_id', $request['company'])->OrderBy('assessment_month', 'DESC')->get();

        }
         if($request['typees'] and $request['sheet'] and $request['company']=='' and $request['area'] and $request['tender']){

             $data['assessmmentcompany'] = landassessmentform::whereBetween('assessment_month', [$from, $to])->where('type', $request['typees'])->where('assessment_name', $request['sheet'])->where('area_id', $request['area'])->where('company', $request['tender'])->orwhere('company_id', $request['company'])->OrderBy('assessment_month', 'DESC')->get();

        }
         if($request['typees'] and $request['sheet'] and $request['company'] and $request['area']=='' and $request['tender']=='' ){

             $data['assessmmentcompany'] = landassessmentform::whereBetween('assessment_month', [$from, $to])->where('type', $request['typees'])->where('company_id', $request['company'])->where('assessment_name', $request['sheet'])->orwhere('area_id', $request['area'])->orwhere('company', $request['tender'])->OrderBy('assessment_month', 'DESC')->get();

        }
         if($request['typees'] and $request['sheet'] and $request['company'] and $request['area']=='' and $request['tender']){

             $data['assessmmentcompany'] = landassessmentform::whereBetween('assessment_month', [$from, $to])->where('type', $request['typees'])->where('company_id', $request['company'])->where('assessment_name', $request['sheet'])->where('company', $request['tender'])->orwhere('area_id', $request['area'])->OrderBy('assessment_month', 'DESC')->get();

        }
         if($request['typees'] and $request['sheet'] and $request['company'] and $request['area'] and $request['tender']=='' ){

             $data['assessmmentcompany'] = landassessmentform::whereBetween('assessment_month', [$from, $to])->where('type', $request['typees'])->where('company_id', $request['company'])->where('assessment_name', $request['sheet'])->where('area_id', $request['area'])->orwhere('company', $request['tender'])->OrderBy('assessment_month', 'DESC')->get();

        }
         if($request['typees'] and $request['sheet'] and $request['company'] and $request['area'] and $request['tender'] ){

             $data['assessmmentcompany'] = landassessmentform::whereBetween('assessment_month', [$from, $to])->where('type', $request['typees'])->where('company_id', $request['company'])->where('assessment_name', $request['sheet'])->where('area_id', $request['area'])->where('company', $request['tender'])->OrderBy('assessment_month', 'DESC')->get();

        }

           if($data['assessmmentcompany'] ->isEmpty()) {
            return redirect()->back()->withErrors(['message' => 'No data found for your search  '.$data['header'].'']);
        }else{

            $pdf = PDF::loadView('assessmentviewreport', $data);
        return $pdf->stream('Assessment report - '.date('d-m-Y Hi').'.pdf');
        }

            }


//when date not filtered.....


            else {

          if($request['typees']=='' and $request['sheet']=='' and $request['start']==''  and $request['company']=='' and $request['area']=='' and $request['tender']==''){

             $data['assessmmentcompany'] = landassessmentform::OrderBy('assessment_month', 'DESC')->get();

        }

         if($request['typees']=='' and $request['sheet']=='' and  $request['start']=='' and $request['company']=='' and $request['area']=='' and $request['tender']){

             $data['assessmmentcompany'] = landassessmentform::where('company', $request['tender'])->orwhere('area_id', $request['area'])->orwhere('company_id', $request['company'])->orwhere('assessment_month', $request['start'])->orwhere('type', $request['typees'])->orwhere('assessment_name', $request['sheet'])->OrderBy('assessment_month', 'DESC')->get();

        }
           if($request['typees']=='' and $request['sheet']=='' and  $request['start']=='' and $request['company']=='' and $request['area'] and $request['tender']==''){

             $data['assessmmentcompany'] = landassessmentform::where('area_id', $request['area'])->orwhere('company', $request['tender'])->orwhere('company_id', $request['company'])->orwhere('assessment_month', $request['start'])->orwhere('type', $request['typees'])->orwhere('assessment_name', $request['sheet'])->OrderBy('assessment_month', 'DESC')->get();

        }

          if($request['typees']=='' and $request['sheet']=='' and  $request['start']=='' and $request['company']=='' and $request['area'] and $request['tender']){

             $data['assessmmentcompany'] = landassessmentform::where('area_id', $request['area'])->where('company', $request['tender'])->orwhere('company_id', $request['company'])->orwhere('assessment_month', $request['start'])->orwhere('type', $request['typees'])->orwhere('assessment_name', $request['sheet'])->OrderBy('assessment_month', 'DESC')->get();

        }

             if($request['typees']=='' and $request['sheet']=='' and  $request['start']=='' and $request['company'] and $request['area']=='' and $request['tender']==''){

             $data['assessmmentcompany'] = landassessmentform::where('company_id', $request['company'])->orwhere('area_id', $request['area'])->orwhere('company', $request['tender'])->orwhere('assessment_month', $request['start'])->orwhere('type', $request['typees'])->orwhere('assessment_name', $request['sheet'])->OrderBy('assessment_month', 'DESC')->get();

        }

          if($request['typees']=='' and $request['sheet']=='' and  $request['start']=='' and $request['company'] and $request['area']=='' and $request['tender']){

             $data['assessmmentcompany'] = landassessmentform::where('company_id', $request['company'])->where('company', $request['tender'])->orwhere('area_id', $request['area'])->orwhere('assessment_month', $request['start'])->orwhere('type', $request['typees'])->orwhere('assessment_name', $request['sheet'])->OrderBy('assessment_month', 'DESC')->get();

        }



         if($request['typees']=='' and $request['sheet']=='' and  $request['start']=='' and $request['company'] and $request['area'] and $request['tender']==''){

             $data['assessmmentcompany'] = landassessmentform::where('company_id', $request['company'])->where('area_id', $request['area'])->orwhere('company', $request['tender'])->orwhere('assessment_month', $request['start'])->orwhere('type', $request['typees'])->orwhere('assessment_name', $request['sheet'])->OrderBy('assessment_month', 'DESC')->get();

        }


            if($request['typees']=='' and $request['sheet']=='' and  $request['start']=='' and $request['company'] and $request['area'] and $request['tender']){

             $data['assessmmentcompany'] = landassessmentform::where('company_id', $request['company'])->where('area_id', $request['area'])->where('company', $request['tender'])->orwhere('assessment_month', $request['start'])->orwhere('type', $request['typees'])->orwhere('assessment_name', $request['sheet'])->OrderBy('assessment_month', 'DESC')->get();

        }


              if($request['typees']=='' and $request['sheet']=='' and  $request['start'] and $request['company']=='' and $request['area']=='' and $request['tender']==''){

             $data['assessmmentcompany'] = landassessmentform::where('assessment_month', $request['start'])->orwhere('company_id', $request['company'])->orwhere('area_id', $request['area'])->orwhere('company', $request['tender'])->orwhere('type', $request['typees'])->orwhere('assessment_name', $request['sheet'])->OrderBy('assessment_month', 'DESC')->get();

        }



              if($request['typees']=='' and $request['sheet']=='' and  $request['start'] and $request['company']=='' and $request['area']=='' and $request['tender']){

             $data['assessmmentcompany'] = landassessmentform::where('company', $request['tender'])->where('assessment_month', $request['start'])->orwhere('company_id', $request['company'])->orwhere('area_id', $request['area'])->orwhere('type', $request['typees'])->orwhere('assessment_name', $request['sheet'])->OrderBy('assessment_month', 'DESC')->get();

        }


               if($request['typees']=='' and $request['sheet']=='' and  $request['start'] and $request['company']=='' and $request['area'] and $request['tender']==''){

             $data['assessmmentcompany'] = landassessmentform::where('area_id', $request['area'])->where('assessment_month', $request['start'])->orwhere('company_id', $request['company'])->orwhere('type', $request['typees'])->orwhere('assessment_name', $request['sheet'])->orwhere('company', $request['tender'])->OrderBy('assessment_month', 'DESC')->get();

        }


                  if($request['typees']=='' and $request['sheet']=='' and  $request['start'] and $request['company']=='' and $request['area'] and $request['tender']){

             $data['assessmmentcompany'] = landassessmentform::where('company', $request['tender'])->where('area_id', $request['area'])->where('assessment_month', $request['start'])->orwhere('company_id', $request['company'])->orwhere('type', $request['typees'])->orwhere('assessment_name', $request['sheet'])->OrderBy('assessment_month', 'DESC')->get();

        }


              if($request['typees']=='' and $request['sheet']=='' and  $request['start'] and $request['company'] and $request['area']=='' and $request['tender']==''){

             $data['assessmmentcompany'] = landassessmentform::where('assessment_month', $request['start'])->where('company_id', $request['company'])->orwhere('type', $request['typees'])->orwhere('assessment_name', $request['sheet'])->orwhere('company', $request['tender'])->orwhere('area_id', $request['area'])->OrderBy('assessment_month', 'DESC')->get();

        }


                      if($request['typees']=='' and $request['sheet']=='' and  $request['start'] and $request['company'] and $request['area']=='' and $request['tender']){

             $data['assessmmentcompany'] = landassessmentform::where('company', $request['tender'])->where('assessment_month', $request['start'])->where('company_id', $request['company'])->orwhere('type', $request['typees'])->orwhere('assessment_name', $request['sheet'])->orwhere('area_id', $request['area'])->OrderBy('assessment_month', 'DESC')->get();

        }


                    if($request['typees']=='' and $request['sheet']=='' and  $request['start'] and $request['company'] and $request['area'] and $request['tender']==''){

             $data['assessmmentcompany'] = landassessmentform::where('area_id', $request['area'])->where('assessment_month', $request['start'])->where('company_id', $request['company'])->orwhere('type', $request['typees'])->orwhere('assessment_name', $request['sheet'])->orwhere('company', $request['tender'])->OrderBy('assessment_month', 'DESC')->get();

        }


                   if($request['typees']=='' and $request['sheet']=='' and  $request['start'] and $request['company'] and $request['area'] and $request['tender']){

             $data['assessmmentcompany'] = landassessmentform::where('company', $request['tender'])->where('area_id', $request['area'])->where('assessment_month', $request['start'])->where('company_id', $request['company'])->orwhere('type', $request['typees'])->orwhere('assessment_name', $request['sheet'])->OrderBy('assessment_month', 'DESC')->get();

        }



                   if($request['typees']=='' and $request['sheet'] and  $request['start']=='' and $request['company']=='' and $request['area']=='' and $request['tender']==''){

             $data['assessmmentcompany'] = landassessmentform::where('assessment_name', $request['sheet'])->orwhere('company', $request['tender'])->orwhere('area_id', $request['area'])->orwhere('assessment_month', $request['start'])->orwhere('company_id', $request['company'])->orwhere('type', $request['typees'])->OrderBy('assessment_month', 'DESC')->get();

        }




                   if($request['typees']=='' and $request['sheet'] and  $request['start']=='' and $request['company']=='' and $request['area']=='' and $request['tender']){

             $data['assessmmentcompany'] = landassessmentform::where('assessment_name', $request['sheet'])->where('company', $request['tender'])->orwhere('area_id', $request['area'])->orwhere('assessment_month', $request['start'])->orwhere('company_id', $request['company'])->orwhere('type', $request['typees'])->OrderBy('assessment_month', 'DESC')->get();

        }


                   if($request['typees']=='' and $request['sheet'] and  $request['start']=='' and $request['company']=='' and $request['area'] and $request['tender']==''){

             $data['assessmmentcompany'] = landassessmentform::where('area_id', $request['area'])->where('assessment_name', $request['sheet'])->orwhere('company', $request['tender'])->orwhere('assessment_month', $request['start'])->orwhere('company_id', $request['company'])->orwhere('type', $request['typees'])->OrderBy('assessment_month', 'DESC')->get();

        }


                    if($request['typees']=='' and $request['sheet'] and  $request['start']=='' and $request['company']=='' and $request['area'] and $request['tender']){

             $data['assessmmentcompany'] = landassessmentform::where('area_id', $request['area'])->where('assessment_name', $request['sheet'])->where('company', $request['tender'])->orwhere('assessment_month', $request['start'])->orwhere('company_id', $request['company'])->orwhere('type', $request['typees'])->OrderBy('assessment_month', 'DESC')->get();

        }


                   if($request['typees']=='' and $request['sheet'] and  $request['start']=='' and $request['company'] and $request['area']=='' and $request['tender']==''){

             $data['assessmmentcompany'] = landassessmentform::where('company_id', $request['company'])->where('assessment_name', $request['sheet'])->orwhere('company', $request['tender'])->orwhere('assessment_month', $request['start'])->orwhere('area_id', $request['area'])->orwhere('type', $request['typees'])->OrderBy('assessment_month', 'DESC')->get();

        }


                   if($request['typees']=='' and $request['sheet'] and  $request['start']=='' and $request['company'] and $request['area']=='' and $request['tender']){

             $data['assessmmentcompany'] = landassessmentform::where('company_id', $request['company'])->where('assessment_name', $request['sheet'])->where('company', $request['tender'])->orwhere('assessment_month', $request['start'])->orwhere('area_id', $request['area'])->orwhere('type', $request['typees'])->OrderBy('assessment_month', 'DESC')->get();

        }


                      if($request['typees']=='' and $request['sheet'] and  $request['start']=='' and $request['company'] and $request['area'] and $request['tender']==''){

             $data['assessmmentcompany'] = landassessmentform::where('company_id', $request['company'])->where('assessment_name', $request['sheet'])->where('area_id', $request['area'])->orwhere('company', $request['tender'])->orwhere('assessment_month', $request['start'])->orwhere('type', $request['typees'])->OrderBy('assessment_month', 'DESC')->get();

        }


                    if($request['typees']=='' and $request['sheet'] and  $request['start']=='' and $request['company'] and $request['area'] and $request['tender']){

             $data['assessmmentcompany'] = landassessmentform::where('company_id', $request['company'])->where('assessment_name', $request['sheet'])->where('area_id', $request['area'])->where('company', $request['tender'])->orwhere('assessment_month', $request['start'])->orwhere('type', $request['typees'])->OrderBy('assessment_month', 'DESC')->get();

        }

                  if($request['typees']=='' and $request['sheet'] and  $request['start'] and $request['company']=='' and $request['area']=='' and $request['tender']==''){

             $data['assessmmentcompany'] = landassessmentform::where('assessment_name', $request['sheet'])->where('assessment_month', $request['start'])->orwhere('area_id', $request['area'])->orwhere('company', $request['tender'])->orwhere('type', $request['typees'])->orwhere('company_id', $request['company'])->OrderBy('assessment_month', 'DESC')->get();

        }

                    if($request['typees']=='' and $request['sheet'] and  $request['start'] and $request['company']=='' and $request['area']=='' and $request['tender']){

             $data['assessmmentcompany'] = landassessmentform::where('company', $request['tender'])->where('assessment_name', $request['sheet'])->where('assessment_month', $request['start'])->orwhere('area_id', $request['area'])->orwhere('type', $request['typees'])->orwhere('company_id', $request['company'])->OrderBy('assessment_month', 'DESC')->get();

        }

              if($request['typees']=='' and $request['sheet'] and  $request['start'] and $request['company']=='' and $request['area'] and $request['tender']==''){

             $data['assessmmentcompany'] = landassessmentform::where('assessment_name', $request['sheet'])->where('assessment_month', $request['start'])->where('area_id', $request['area'])->orwhere('type', $request['typees'])->orwhere('company_id', $request['company'])->orwhere('company', $request['tender'])->OrderBy('assessment_month', 'DESC')->get();

        }


              if($request['typees']=='' and $request['sheet'] and  $request['start'] and $request['company']=='' and $request['area'] and $request['tender']){

             $data['assessmmentcompany'] = landassessmentform::where('company', $request['tender'])->where('assessment_name', $request['sheet'])->where('assessment_month', $request['start'])->where('area_id', $request['area'])->orwhere('type', $request['typees'])->orwhere('company_id', $request['company'])->OrderBy('assessment_month', 'DESC')->get();

        }

               if($request['typees']=='' and $request['sheet'] and  $request['start'] and $request['company'] and $request['area']=='' and $request['tender']==''){

             $data['assessmmentcompany'] = landassessmentform::where('assessment_name', $request['sheet'])->where('assessment_month', $request['start'])->where('company_id', $request['company'])->orwhere('area_id', $request['area'])->orwhere('type', $request['typees'])->orwhere('company', $request['tender'])->OrderBy('assessment_month', 'DESC')->get();

        }


            if($request['typees']=='' and $request['sheet'] and  $request['start'] and $request['company'] and $request['area']=='' and $request['tender']){

             $data['assessmmentcompany'] = landassessmentform::where('company', $request['tender'])->where('assessment_name', $request['sheet'])->where('assessment_month', $request['start'])->where('company_id', $request['company'])->orwhere('area_id', $request['area'])->orwhere('type', $request['typees'])->OrderBy('assessment_month', 'DESC')->get();

        }



            if($request['typees']=='' and $request['sheet'] and  $request['start'] and $request['company'] and $request['area'] and $request['tender']==''){

             $data['assessmmentcompany'] = landassessmentform::where('assessment_name', $request['sheet'])->where('assessment_month', $request['start'])->where('company_id', $request['company'])->where('area_id', $request['area'])->orwhere('type', $request['typees'])->orwhere('company', $request['tender'])->OrderBy('assessment_month', 'DESC')->get();

        }


            if($request['typees']=='' and $request['sheet'] and  $request['start'] and $request['company'] and $request['area'] and $request['tender']){

             $data['assessmmentcompany'] = landassessmentform::where('assessment_name', $request['sheet'])->where('assessment_month', $request['start'])->where('company_id', $request['company'])->where('area_id', $request['area'])->where('company', $request['tender'])->orwhere('type', $request['typees'])->OrderBy('assessment_month', 'DESC')->get();

        }

     ///
                    if($request['typees'] and $request['sheet']=='' and  $request['start']=='' and $request['company']=='' and $request['area']=='' and $request['tender']==''){

             $data['assessmmentcompany'] = landassessmentform::where('type', $request['typees'])->orwhere('assessment_name', $request['sheet'])->orwhere('assessment_month', $request['start'])->orwhere('company_id', $request['company'])->orwhere('area_id', $request['area'])->orwhere('company', $request['tender'])->OrderBy('assessment_month', 'DESC')->get();

        }

                 if($request['typees'] and $request['sheet']=='' and  $request['start']=='' and $request['company']=='' and $request['area']=='' and $request['tender']){

             $data['assessmmentcompany'] = landassessmentform::where('type', $request['typees'])->where('company', $request['tender'])->orwhere('area_id', $request['area'])->orwhere('company_id', $request['company'])->orwhere('assessment_month', $request['start'])->orwhere('assessment_name', $request['sheet'])->OrderBy('assessment_month', 'DESC')->get();

        }
           if($request['typees'] and $request['sheet']=='' and  $request['start']=='' and $request['company']=='' and $request['area'] and $request['tender']==''){

             $data['assessmmentcompany'] = landassessmentform::where('type', $request['typees'])->where('area_id', $request['area'])->orwhere('company', $request['tender'])->orwhere('company_id', $request['company'])->orwhere('assessment_month', $request['start'])->orwhere('assessment_name', $request['sheet'])->OrderBy('assessment_month', 'DESC')->get();

        }

          if($request['typees'] and $request['sheet']=='' and  $request['start']=='' and $request['company']=='' and $request['area'] and $request['tender']){

             $data['assessmmentcompany'] = landassessmentform::where('type', $request['typees'])->where('area_id', $request['area'])->where('company', $request['tender'])->orwhere('company_id', $request['company'])->orwhere('assessment_month', $request['start'])->orwhere('assessment_name', $request['sheet'])->OrderBy('assessment_month', 'DESC')->get();

        }

             if($request['typees'] and $request['sheet']=='' and  $request['start']=='' and $request['company'] and $request['area']=='' and $request['tender']==''){

             $data['assessmmentcompany'] = landassessmentform::where('type', $request['typees'])->where('company_id', $request['company'])->orwhere('area_id', $request['area'])->orwhere('company', $request['tender'])->orwhere('assessment_month', $request['start'])
             ->orwhere('assessment_name', $request['sheet'])->OrderBy('assessment_month', 'DESC')->get();

        }

          if($request['typees'] and $request['sheet']=='' and  $request['start']=='' and $request['company'] and $request['area']=='' and $request['tender']){

             $data['assessmmentcompany'] = landassessmentform::where('type', $request['typees'])->where('company_id', $request['company'])->where('company', $request['tender'])->orwhere('area_id', $request['area'])->orwhere('assessment_month', $request['start'])->orwhere('assessment_name', $request['sheet'])->OrderBy('assessment_month', 'DESC')->get();

        }



         if($request['typees'] and $request['sheet']=='' and  $request['start']=='' and $request['company'] and $request['area'] and $request['tender']==''){

             $data['assessmmentcompany'] = landassessmentform::where('type', $request['typees'])->where('company_id', $request['company'])->where('area_id', $request['area'])->orwhere('company', $request['tender'])->orwhere('assessment_month', $request['start'])->orwhere('assessment_name', $request['sheet'])->OrderBy('assessment_month', 'DESC')->get();

        }


            if($request['typees'] and $request['sheet']=='' and  $request['start']=='' and $request['company'] and $request['area'] and $request['tender']){

             $data['assessmmentcompany'] = landassessmentform::where('type', $request['typees'])->where('company_id', $request['company'])->where('area_id', $request['area'])->where('company', $request['tender'])->orwhere('assessment_month', $request['start'])->orwhere('assessment_name', $request['sheet'])->OrderBy('assessment_month', 'DESC')->get();

        }


              if($request['typees'] and $request['sheet']=='' and  $request['start'] and $request['company']=='' and $request['area']=='' and $request['tender']==''){

             $data['assessmmentcompany'] = landassessmentform::where('type', $request['typees'])->where('assessment_month', $request['start'])->orwhere('company_id', $request['company'])->orwhere('area_id', $request['area'])->orwhere('company', $request['tender'])->orwhere('assessment_name', $request['sheet'])->OrderBy('assessment_month', 'DESC')->get();

        }



              if($request['typees'] and $request['sheet']=='' and  $request['start'] and $request['company']=='' and $request['area']=='' and $request['tender']){

             $data['assessmmentcompany'] = landassessmentform::where('type', $request['typees'])->where('company', $request['tender'])->where('assessment_month', $request['start'])->orwhere('company_id', $request['company'])->orwhere('area_id', $request['area'])->orwhere('assessment_name', $request['sheet'])->OrderBy('assessment_month', 'DESC')->get();

        }


               if($request['typees'] and $request['sheet']=='' and  $request['start'] and $request['company']=='' and $request['area'] and $request['tender']==''){

             $data['assessmmentcompany'] = landassessmentform::where('type', $request['typees'])->where('area_id', $request['area'])->where('assessment_month', $request['start'])->orwhere('company_id', $request['company'])->orwhere('assessment_name', $request['sheet'])->orwhere('company', $request['tender'])->OrderBy('assessment_month', 'DESC')->get();

        }


                  if($request['typees'] and $request['sheet']=='' and  $request['start'] and $request['company']=='' and $request['area'] and $request['tender']){

             $data['assessmmentcompany'] = landassessmentform::where('type', $request['typees'])->where('company', $request['tender'])->where('area_id', $request['area'])->where('assessment_month', $request['start'])->orwhere('company_id', $request['company'])->orwhere('assessment_name', $request['sheet'])->OrderBy('assessment_month', 'DESC')->get();

        }


              if($request['typees'] and $request['sheet']=='' and  $request['start'] and $request['company'] and $request['area']=='' and $request['tender']==''){

             $data['assessmmentcompany'] = landassessmentform::where('type', $request['typees'])->where('assessment_month', $request['start'])->where('company_id', $request['company'])->orwhere('assessment_name', $request['sheet'])->orwhere('company', $request['tender'])->orwhere('area_id', $request['area'])->OrderBy('assessment_month', 'DESC')->get();

        }


                      if($request['typees'] and $request['sheet']=='' and  $request['start'] and $request['company'] and $request['area']=='' and $request['tender']){

             $data['assessmmentcompany'] = landassessmentform::where('type', $request['typees'])->where('company', $request['tender'])->where('assessment_month', $request['start'])->where('company_id', $request['company'])->orwhere('assessment_name', $request['sheet'])->orwhere('area_id', $request['area'])->OrderBy('assessment_month', 'DESC')->get();

        }


                    if($request['typees'] and $request['sheet']=='' and  $request['start'] and $request['company'] and $request['area'] and $request['tender']==''){

             $data['assessmmentcompany'] = landassessmentform::where('type', $request['typees'])->where('area_id', $request['area'])->where('assessment_month', $request['start'])->where('company_id', $request['company'])->orwhere('assessment_name', $request['sheet'])->orwhere('company', $request['tender'])->OrderBy('assessment_month', 'DESC')->get();

        }


                   if($request['typees'] and $request['sheet']=='' and  $request['start'] and $request['company'] and $request['area'] and $request['tender']){

             $data['assessmmentcompany'] = landassessmentform::where('type', $request['typees'])->where('company', $request['tender'])->where('area_id', $request['area'])->where('assessment_month', $request['start'])->where('company_id', $request['company'])->orwhere('assessment_name', $request['sheet'])->OrderBy('assessment_month', 'DESC')->get();

        }



                   if($request['typees'] and $request['sheet'] and  $request['start']=='' and $request['company']=='' and $request['area']=='' and $request['tender']==''){

             $data['assessmmentcompany'] = landassessmentform::where('type', $request['typees'])->where('assessment_name', $request['sheet'])->orwhere('company', $request['tender'])->orwhere('area_id', $request['area'])->orwhere('assessment_month', $request['start'])->orwhere('company_id', $request['company'])->OrderBy('assessment_month', 'DESC')->get();

        }




                   if($request['typees'] and $request['sheet'] and  $request['start']=='' and $request['company']=='' and $request['area']=='' and $request['tender']){

             $data['assessmmentcompany'] = landassessmentform::where('assessment_name', $request['sheet'])->where('company', $request['tender'])->orwhere('area_id', $request['area'])->orwhere('assessment_month', $request['start'])->orwhere('company_id', $request['company'])->OrderBy('assessment_month', 'DESC')->get();

        }


                   if($request['typees'] and $request['sheet'] and  $request['start']=='' and $request['company']=='' and $request['area'] and $request['tender']==''){

             $data['assessmmentcompany'] = landassessmentform::where('type', $request['typees'])->where('area_id', $request['area'])->where('assessment_name', $request['sheet'])->orwhere('company', $request['tender'])->orwhere('assessment_month', $request['start'])->orwhere('company_id', $request['company'])->OrderBy('assessment_month', 'DESC')->get();

        }


                    if($request['typees'] and $request['sheet'] and  $request['start']=='' and $request['company']=='' and $request['area'] and $request['tender']){

             $data['assessmmentcompany'] = landassessmentform::where('type', $request['typees'])->where('area_id', $request['area'])->where('assessment_name', $request['sheet'])->where('company', $request['tender'])->orwhere('assessment_month', $request['start'])->orwhere('company_id', $request['company'])->OrderBy('assessment_month', 'DESC')->get();

        }


                   if($request['typees'] and $request['sheet'] and  $request['start']=='' and $request['company'] and $request['area']=='' and $request['tender']==''){

             $data['assessmmentcompany'] = landassessmentform::where('type', $request['typees'])->where('company_id', $request['company'])->where('assessment_name', $request['sheet'])->orwhere('company', $request['tender'])->orwhere('assessment_month', $request['start'])->orwhere('area_id', $request['area'])->OrderBy('assessment_month', 'DESC')->get();

        }


                   if($request['typees'] and $request['sheet'] and  $request['start']=='' and $request['company'] and $request['area']=='' and $request['tender']){

             $data['assessmmentcompany'] = landassessmentform::where('type', $request['typees'])->where('company_id', $request['company'])->where('assessment_name', $request['sheet'])->where('company', $request['tender'])->orwhere('assessment_month', $request['start'])->orwhere('area_id', $request['area'])->OrderBy('assessment_month', 'DESC')->get();

        }


                      if($request['typees'] and $request['sheet'] and  $request['start']=='' and $request['company'] and $request['area'] and $request['tender']==''){

             $data['assessmmentcompany'] = landassessmentform::where('type', $request['typees'])->where('company_id', $request['company'])->where('assessment_name', $request['sheet'])->where('area_id', $request['area'])->orwhere('company', $request['tender'])->orwhere('assessment_month', $request['start'])->OrderBy('assessment_month', 'DESC')->get();

        }


                    if($request['typees'] and $request['sheet'] and  $request['start']=='' and $request['company'] and $request['area'] and $request['tender']){

             $data['assessmmentcompany'] = landassessmentform::where('type', $request['typees'])->where('company_id', $request['company'])->where('assessment_name', $request['sheet'])->where('area_id', $request['area'])->where('company', $request['tender'])->orwhere('assessment_month', $request['start'])->OrderBy('assessment_month', 'DESC')->get();

        }

                  if($request['typees'] and $request['sheet'] and  $request['start'] and $request['company']=='' and $request['area']=='' and $request['tender']==''){

             $data['assessmmentcompany'] = landassessmentform::where('type', $request['typees'])->where('assessment_name', $request['sheet'])->where('assessment_month', $request['start'])->orwhere('area_id', $request['area'])->orwhere('company', $request['tender'])->orwhere('company_id', $request['company'])->OrderBy('assessment_month', 'DESC')->get();

        }

                    if($request['typees'] and $request['sheet'] and  $request['start'] and $request['company']=='' and $request['area']=='' and $request['tender']){

             $data['assessmmentcompany'] = landassessmentform::where('type', $request['typees'])->where('company', $request['tender'])->where('assessment_name', $request['sheet'])->where('assessment_month', $request['start'])->orwhere('area_id', $request['area'])->orwhere('company_id', $request['company'])->OrderBy('assessment_month', 'DESC')->get();

        }

              if($request['typees'] and $request['sheet'] and  $request['start'] and $request['company']=='' and $request['area'] and $request['tender']==''){

             $data['assessmmentcompany'] = landassessmentform::where('type', $request['typees'])->where('assessment_name', $request['sheet'])->where('assessment_month', $request['start'])->where('area_id', $request['area'])->orwhere('company_id', $request['company'])->orwhere('company', $request['tender'])->OrderBy('assessment_month', 'DESC')->get();

        }


              if($request['typees'] and $request['sheet'] and  $request['start'] and $request['company']=='' and $request['area'] and $request['tender']){

             $data['assessmmentcompany'] = landassessmentform::where('type', $request['typees'])->where('company', $request['tender'])->where('assessment_name', $request['sheet'])->where('assessment_month', $request['start'])->where('area_id', $request['area'])->orwhere('company_id', $request['company'])->OrderBy('assessment_month', 'DESC')->get();

        }

               if($request['typees'] and $request['sheet'] and  $request['start'] and $request['company'] and $request['area']=='' and $request['tender']==''){

             $data['assessmmentcompany'] = landassessmentform::where('type', $request['typees'])->where('assessment_name', $request['sheet'])->where('assessment_month', $request['start'])->where('company_id', $request['company'])->orwhere('area_id', $request['area'])->orwhere('company', $request['tender'])->OrderBy('assessment_month', 'DESC')->get();

        }


            if($request['typees'] and $request['sheet'] and  $request['start'] and $request['company'] and $request['area']=='' and $request['tender']){

             $data['assessmmentcompany'] = landassessmentform::where('type', $request['typees'])->where('company', $request['tender'])->where('assessment_name', $request['sheet'])->where('assessment_month', $request['start'])->where('company_id', $request['company'])->orwhere('area_id', $request['area'])->OrderBy('assessment_month', 'DESC')->get();

        }



            if($request['typees'] and $request['sheet'] and  $request['start'] and $request['company'] and $request['area'] and $request['tender']==''){

             $data['assessmmentcompany'] = landassessmentform::where('type', $request['typees'])->where('assessment_name', $request['sheet'])->where('assessment_month', $request['start'])->where('company_id', $request['company'])->where('area_id', $request['area'])->orwhere('company', $request['tender'])->OrderBy('assessment_month', 'DESC')->get();

        }


            if($request['typees'] and $request['sheet'] and  $request['start'] and $request['company'] and $request['area'] and $request['tender']){

             $data['assessmmentcompany'] = landassessmentform::where('type', $request['typees'])->where('assessment_name', $request['sheet'])->where('assessment_month', $request['start'])->where('company_id', $request['company'])->where('area_id', $request['area'])->where('company', $request['tender'])->OrderBy('assessment_month', 'DESC')->get();

        }

           if($data['assessmmentcompany'] ->isEmpty()) {
            return redirect()->back()->withErrors(['message' => 'No data found for your search '.$data['header'].'']);
        }else{

                 $pdf = PDF::loadView('assessmentviewreport', $data);
        return $pdf->stream('Assessment report - '.date('d-m-Y Hi').'.pdf');
        }




}


    }






    public function tenderviewpdf(request $request)
    {



           if($request['start'] and $request['end'])  { //date filter


        $from=request('start');
        $to=request('end');

        $nextday = date("Y-m-d", strtotime("$to +1 day"));

        $to=$nextday;
        if(request('start')>request('end')){
            $to=request('start');
        $from=request('end');
        }// start> end




          if($request['tender']=='' and $request['area']=='' and $request['company']==''){

             $data['tenderpdf'] = company::whereBetween('created_at', [$from, $to])->OrderBy('created_at', 'DESC')->get();

        }
           if($request['tender']=='' and $request['area']=='' and $request['company']){

             $data['tenderpdf'] = company::whereBetween('created_at', [$from, $to])->where('company_name', $request['company'])->orwhere('tender', $request['tender'])->orwhere('area', $request['area'])->OrderBy('created_at', 'DESC')->get();

        }

         if($request['tender']=='' and $request['area'] and $request['company']==''){

             $data['tenderpdf'] = company::whereBetween('created_at', [$from, $to])->where('area', $request['area'])->orwhere('company_name', $request['company'])->orwhere('tender', $request['tender'])->OrderBy('created_at', 'DESC')->get();

        }

            if($request['tender']=='' and $request['area'] and $request['company']){

             $data['tenderpdf'] = company::whereBetween('created_at', [$from, $to])->where('area', $request['area'])->where('company_name', $request['company'])->orwhere('tender', $request['tender'])->OrderBy('created_at', 'DESC')->get();

        }



          if($request['tender'] and $request['area']=='' and $request['company']==''){


             $data['tenderpdf'] = company::whereBetween('created_at', [$from, $to])->where('tender', $request['tender'])->orwhere('area', $request['area'])->orwhere('company_name', $request['company'])->OrderBy('created_at', 'DESC')->get();

        }
           if($request['tender'] and $request['area']=='' and $request['company']){

             $data['tenderpdf'] = company::whereBetween('created_at', [$from, $to])->where('company_name', $request['company'])->where('tender', $request['tender'])->orwhere('area', $request['area'])->OrderBy('created_at', 'DESC')->get();

        }

         if($request['tender'] and $request['area'] and $request['company']==''){

             $data['tenderpdf'] = company::whereBetween('created_at', [$from, $to])->where('area', $request['area'])->where('tender', $request['tender'])->orwhere('company_name', $request['company'])->OrderBy('created_at', 'DESC')->get();

        }

            if($request['tender'] and $request['area'] and $request['company'] ){

             $data['tenderpdf'] = company::whereBetween('created_at', [$from, $to])->where('area', $request['area'])->where('company_name', $request['company'])->where('tender', $request['tender'])->OrderBy('created_at', 'DESC')->get();

        }

        if($request['type'] ){

             $data['tenderpdf'] = company::whereBetween('created_at', [$from, $to])->where('type', $request['type'])->OrderBy('created_at', 'DESC')->get();

        }



         if($request['tender'] and $request['area'] and $request['type'] ){

             $data['tenderpdf'] = company::whereBetween('created_at', [$from, $to])->where('type', $request['type'])->where('area', $request['area'])->where('tender', $request['tender'])->OrderBy('created_at', 'DESC')->get();

        }




          if($request['tender']  and $request['company'] and $request['type'] ){

             $data['tenderpdf'] = company::whereBetween('created_at', [$from, $to])->where('type', $request['type'])->where('company_name', $request['company'])->where('tender', $request['tender'])->OrderBy('created_at', 'DESC')->get();

        }

         if($request['area'] and $request['company'] and $request['type'] ){

             $data['tenderpdf'] = company::whereBetween('created_at', [$from, $to])->where('type', $request['type'])->where('area', $request['area'])->where('company_name', $request['company'])->OrderBy('created_at', 'DESC')->get();

        }


         if($request['company'] and $request['type'] ){

             $data['tenderpdf'] = company::whereBetween('created_at', [$from, $to])->where('type', $request['type'])->where('company_name', $request['company'])->OrderBy('created_at', 'DESC')->get();

        }

          if($request['area'] and $request['type'] ){

             $data['tenderpdf'] = company::whereBetween('created_at', [$from, $to])->where('type', $request['type'])->where('area', $request['area'])->OrderBy('created_at', 'DESC')->get();

        }

            if($request['tender'] and $request['type'] ){

             $data['tenderpdf'] = company::whereBetween('created_at', [$from, $to])->where('type', $request['type'])->where('tender', $request['tender'])->OrderBy('created_at', 'DESC')->get();

        }


            if($request['tender'] and $request['area'] and $request['company'] and $request['type'] ){

             $data['tenderpdf'] = company::whereBetween('created_at', [$from, $to])->where('type', $request['type'])->where('area', $request['area'])->where('company_name', $request['company'])->where('tender', $request['tender'])->OrderBy('created_at', 'DESC')->get();

        }

           if($data['tenderpdf']->isEmpty()) {
            return redirect()->back()->withErrors(['message' => 'No data found for your search ']);
        }else{

                 $pdf = PDF::loadView('tenderviewreport', $data);
        return $pdf->stream('Tender report - '.date('d-m-Y Hi').'.pdf');
        }

            }


//when date not filtered.....
       else{ //date filter


        $from=request('start');
        $to= Carbon::now();

            if($request['start']=='' and $request['tender']=='' and $request['area']=='' and $request['company']==''){

             $data['tenderpdf'] = company::OrderBy('created_at', 'DESC')->get();

        }

            if($request['start']=='' and $request['tender']=='' and $request['area']=='' and $request['company']){

             $data['tenderpdf'] = company::where('company_name', $request['company'])->OrderBy('created_at', 'DESC')->get();

        }

             if($request['start']=='' and $request['tender']=='' and $request['area'] and $request['company']==''){

             $data['tenderpdf'] = company::where('area', $request['area'])->OrderBy('created_at', 'DESC')->get();

        }

            if($request['start']=='' and $request['tender']=='' and $request['area'] and $request['company']){

             $data['tenderpdf'] = company::where('area', $request['area'])->where('company_name', $request['company'])->OrderBy('created_at', 'DESC')->get();

        }

                 if($request['start']=='' and $request['tender'] and $request['area']=='' and $request['company']==''){

             $data['tenderpdf'] = company::where('tender', $request['tender'])->OrderBy('created_at', 'DESC')->get();

        }

                 if($request['start']=='' and $request['tender'] and $request['area']=='' and $request['company']){

             $data['tenderpdf'] = company::where('tender', $request['tender'])->where('company_name', $request['company'])->OrderBy('created_at', 'DESC')->get();

        }
                if($request['start']=='' and $request['tender'] and $request['area']and $request['company']=='' ){

             $data['tenderpdf'] = company::where('tender', $request['tender'])->where('area', $request['area'])->OrderBy('created_at', 'DESC')->get();

        }

                if($request['start']=='' and $request['tender'] and $request['area']and $request['company'] ){

             $data['tenderpdf'] = company::where('tender', $request['tender'])->where('area', $request['area'])->where('company_name', $request['company'])->OrderBy('created_at', 'DESC')->get();

        }

//
            if($request['start'] and $request['tender']=='' and $request['area']=='' and $request['company']==''){

             $data['tenderpdf'] = company::whereBetween('created_at', [$from, $to])->OrderBy('created_at', 'DESC')->get();

        }

            if($request['start'] and $request['tender']=='' and $request['area']=='' and $request['company']){

             $data['tenderpdf'] = company::whereBetween('created_at', [$from, $to])->where('company_name', $request['company'])->OrderBy('created_at', 'DESC')->get();

        }

             if($request['start'] and $request['tender']=='' and $request['area'] and $request['company']==''){

             $data['tenderpdf'] = company::whereBetween('created_at', [$from, $to])->where('area', $request['area'])->OrderBy('created_at', 'DESC')->get();

        }

            if($request['start'] and $request['tender']=='' and $request['area'] and $request['company']){

             $data['tenderpdf'] = company::whereBetween('created_at', [$from, $to])->where('area', $request['area'])->where('company_name', $request['company'])->OrderBy('created_at', 'DESC')->get();

        }

                 if($request['start'] and $request['tender'] and $request['area']=='' and $request['company']==''){

             $data['tenderpdf'] = company::whereBetween('created_at', [$from, $to])->where('tender', $request['tender'])->OrderBy('created_at', 'DESC')->get();

        }

                 if($request['start'] and $request['tender'] and $request['area']=='' and $request['company']){

             $data['tenderpdf'] = company::whereBetween('created_at', [$from, $to])->where('tender', $request['tender'])->where('company_name', $request['company'])->OrderBy('created_at', 'DESC')->get();

        }
                if($request['start'] and $request['tender'] and $request['area']and $request['company']=='' ){

             $data['tenderpdf'] = company::whereBetween('created_at', [$from, $to])->where('tender', $request['tender'])->where('area', $request['area'])->OrderBy('created_at', 'DESC')->get();

        }

                if($request['start'] and $request['tender'] and $request['area']and $request['company'] ){

             $data['tenderpdf'] = company::whereBetween('created_at', [$from, $to])->where('tender', $request['tender'])->where('area', $request['area'])->where('company_name', $request['company'])->OrderBy('created_at', 'DESC')->get();

        }

        if($request['type'] ){

             $data['tenderpdf'] = company::where('type', $request['type'])->OrderBy('created_at', 'DESC')->get();

        }


        if( $request['company']  and $request['type'] ){

             $data['tenderpdf'] = company::where('type', $request['type'])->where('company_name', $request['company'])->OrderBy('created_at', 'DESC')->get();

        }


        if($request['area'] and  $request['type'] ){

             $data['tenderpdf'] = company::where('type', $request['type'])->where('area', $request['area'])->OrderBy('created_at', 'DESC')->get();

        }



         if( $request['tender'] and  $request['type'] ){

             $data['tenderpdf'] = company::where('type', $request['type'])->where('tender', $request['tender'])->OrderBy('created_at', 'DESC')->get();

        }



         if($request['start']  and $request['type'] ){

             $data['tenderpdf'] = company::whereBetween('created_at', [$from, $to])->where('type', $request['type'])->OrderBy('created_at', 'DESC')->get();

        }


        if($request['start'] and $request['tender']  and $request['type'] ){

             $data['tenderpdf'] = company::whereBetween('created_at', [$from, $to])->where('type', $request['type'])->where('tender', $request['tender'])->OrderBy('created_at', 'DESC')->get();

        }




        if($request['start']  and $request['area']  and $request['type'] ){

             $data['tenderpdf'] = company::whereBetween('created_at', [$from, $to])->where('type', $request['type'])->where('area', $request['area'])->OrderBy('created_at', 'DESC')->get();

        }




          if($request['start'] and  $request['company']  and $request['type'] ){

             $data['tenderpdf'] = company::whereBetween('created_at', [$from, $to])->where('type', $request['type'])->where('company_name', $request['company'])->OrderBy('created_at', 'DESC')->get();

        }



           if( $request['tender'] and $request['area'] and $request['type'] ){

             $data['tenderpdf'] = company::where('type', $request['type'])->where('tender', $request['tender'])->where('area', $request['area'])->OrderBy('created_at', 'DESC')->get();

        }


          if( $request['tender'] and $request['company']  and $request['type'] ){

             $data['tenderpdf'] = company::where('type', $request['type'])->where('tender', $request['tender'])->where('company_name', $request['company'])->OrderBy('created_at', 'DESC')->get();

        }


        if( $request['area'] and $request['company']  and $request['type'] ){

             $data['tenderpdf'] = company::where('type', $request['type'])->where('area', $request['area'])->where('company_name', $request['company'])->OrderBy('created_at', 'DESC')->get();

        }



          if($request['start'] and $request['tender'] and $request['area']  and $request['type'] ){

             $data['tenderpdf'] = company::whereBetween('created_at', [$from, $to])->where('type', $request['type'])->where('tender', $request['tender'])->where('area', $request['area'])->OrderBy('created_at', 'DESC')->get();

        }



         if($request['start'] and $request['tender']  and $request['company']  and $request['type'] ){

             $data['tenderpdf'] = company::whereBetween('created_at', [$from, $to])->where('type', $request['type'])->where('tender', $request['tender'])->where('company_name', $request['company'])->OrderBy('created_at', 'DESC')->get();

        }



            if($request['start'] and $request['area'] and $request['company']  and $request['type'] ){

             $data['tenderpdf'] = company::whereBetween('created_at', [$from, $to])->where('type', $request['type'])->where('area', $request['area'])->where('company_name', $request['company'])->OrderBy('created_at', 'DESC')->get();

        }




               if($request['tender'] and $request['area'] and $request['company']  and $request['type'] ){

             $data['tenderpdf'] = company::where('type', $request['type'])->where('tender', $request['tender'])->where('area', $request['area'])->where('company_name', $request['company'])->OrderBy('created_at', 'DESC')->get();

        }


               if($request['start'] and $request['tender'] and $request['area'] and $request['company']  and $request['type'] ){

             $data['tenderpdf'] = company::whereBetween('created_at', [$from, $to])->where('type', $request['type'])->where('tender', $request['tender'])->where('area', $request['area'])->where('company_name', $request['company'])->OrderBy('created_at', 'DESC')->get();

        }







           if($data['tenderpdf'] ->isEmpty()) {
            return redirect()->back()->withErrors(['message' => 'No data found for your search']);
        }else{

                 $pdf = PDF::loadView('tenderviewreport', $data);
        return $pdf->stream('Assessment report - '.date('d-m-Y Hi').'.pdf');
        }
}



}







}
