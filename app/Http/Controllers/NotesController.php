<?php
   
namespace App\Http\Controllers;
   
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

   
class NotesController extends Controller
{

    public function pdf(){
      
     $data['title'] = 'Notes List';
     $data['header'] = '';
  
    /////////////////////////////////////////
     $username = '';
     $statusvalue = '';
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
        //fetch status
  if($_GET['status'] !=''){
  $status = $_GET['status'];
  if ($status == -1) {
      $statusvalue = 'New';
  }elseif ($status == 1) {
      $statusvalue = 'Accepted';
  }elseif ($status == 0) {
      $statusvalue = 'Rejected';
  }elseif ($status == 2) {
      $statusvalue = 'Closed';
  }elseif ($status == 3) {
      $statusvalue = 'Technician assigned';
  }elseif ($status == 4) {
      $statusvalue = 'Transportation stage';
  }elseif ($status == 5) {
      $statusvalue = 'Pre-implementation';
  }elseif ($status == 6) {
      $statusvalue = 'Post-implementation';
  }elseif ($status == 7) {
      $statusvalue = 'Material Requested';
  }elseif ($status == 8) {
      $statusvalue = 'Procurement stage';
  }elseif ($status == 9) {
      $statusvalue = 'Closed - satisfied by client';
  }elseif($status == 15){
    $statusvalue = 'Material Accepted by IoW';
  }elseif($status == 16){
    $statusvalue = 'Material rejected by IoW';
  }
  else{
      $statusvalue = 'Closed - not satisfied by client';
  }
}
if($_GET['problem_type']!= ''){$probleme = 'All '.$_GET['problem_type'];}else{$probleme='All ';}
if($_GET['userid']!=''){$usere = ' Works Orders From '.$username;}else{$usere =' WorkOrders ';}
if($_GET['start']!=''){$starte = ' <date> from'.$_GET['start'];}else{$starte ='<date>';}   
if($_GET['end']!=''){$ende = ' to '.$_GET['end'].'</date>';}else{$ende ='</date>';}
if($_GET['status']!= ''){$statuse = '<br> Status :'.$statusvalue;} else{$statuse ='';}  
if(($_GET['problem_type']== '')&&($_GET['userid']=='')&&($_GET['start']=='')&&($_GET['end']=='')&&($_GET['status']== '')) {$data['header'] = 'All WorkOrders Report'; } 
    
$data['header'] = $probleme.''.$usere.''.$starte.''.$ende.''.$statuse;
    /////////////////////////////////////////
       

//if all inserted
if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['status']!='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','>=',$_GET['start'])->
        Where('created_at','<=',$_GET['end'])->
        Where('status',$_GET['status'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
       
    }
//if only ->from not inserted
    if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['status']!='')&&($_GET['userid']=='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','>=',$_GET['start'])->
        Where('created_at','<=',$_GET['end'])->
        Where('status',$_GET['status'])->orderBy('created_at','Desc')->get();
    }
//if only status not inserted
    if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['status']=='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','>=',$_GET['start'])->
        Where('created_at','<=',$_GET['end'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if status and ->from not inserted
    if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['status']=='')&&($_GET['userid']=='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','>=',$_GET['start'])->
        Where('created_at','<=',$_GET['end'])->orderBy('created_at','Desc')->get();
    }
//if only name no inserted
    if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['status']!='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('created_at','>=',$_GET['start'])->
        Where('created_at','<=',$_GET['end'])->
        Where('status',$_GET['status'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if name and from not inserted
    if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['status']!='')&&($_GET['userid']=='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('created_at','>=',$_GET['start'])->
        Where('created_at','<=',$_GET['end'])->
        Where('status',$_GET['status'])->orderBy('created_at','Desc')->get();
    }
//if name and status not inserted
    if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['status']=='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('created_at','>=',$_GET['start'])->
        Where('created_at','<=',$_GET['end'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if name, status, from not inserted
    if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['status']=='')&&($_GET['userid']=='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('created_at','>=',$_GET['start'])->
        Where('created_at','<=',$_GET['end'])->orderBy('created_at','Desc')->get();
    }
//if end not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['status']!='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','>=',$_GET['start'])->
        Where('status',$_GET['status'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if end and from not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['status']!='')&&($_GET['userid']=='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','>=',$_GET['start'])->
        Where('status',$_GET['status'])->orderBy('created_at','Desc')->get();
    }
//if end and status not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['status']=='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','>=',$_GET['start'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if end, status, from not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['status']=='')&&($_GET['userid']=='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','>=',$_GET['start'])->orderBy('created_at','Desc')->get();
    }
//if end, name not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['status']!='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('created_at','>=',$_GET['start'])->
        Where('status',$_GET['status'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if end, name, from not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['status']!='')&&($_GET['userid']=='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('created_at','>=',$_GET['start'])->
        Where('status',$_GET['status'])->orderBy('created_at','Desc')->get();
    }
//if end, name, status not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['status']=='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('created_at','>=',$_GET['start'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if end,name,status,from not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['status']=='')&&($_GET['userid']=='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('created_at','>=',$_GET['start'])->orderBy('created_at','Desc')->get();
    }
//if start not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['status']!='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','<=',$_GET['end'])->
        Where('status',$_GET['status'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if start, from not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['status']!='')&&($_GET['userid']=='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','<=',$_GET['end'])->
        Where('status',$_GET['status'])->orderBy('created_at','Desc')->get();
    }
//if start, status not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['status']=='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','<=',$_GET['end'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if start, status, from not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['status']=='')&&($_GET['userid']=='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','<=',$_GET['end'])->orderBy('created_at','Desc')->get();
    }
//if start, name not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['status']!='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('created_at','<=',$_GET['end'])->
        Where('status',$_GET['status'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if start, name, from not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['status']!='')&&($_GET['userid']=='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('created_at','<=',$_GET['end'])->
        Where('status',$_GET['status'])->orderBy('created_at','Desc')->get();
    }
//if start, name, status not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['status']=='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('created_at','<=',$_GET['end'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if start, name, status, from not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['status']=='')&&($_GET['userid']=='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('created_at','<=',$_GET['end'])->orderBy('created_at','Desc')->get();
    }
//if start, end not inserted
    if(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['status']!='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('status',$_GET['status'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if start, end, from not inserted
    if(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['status']!='')&&($_GET['userid']=='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('status',$_GET['status'])->orderBy('created_at','Desc')->get();
    }
//if start, end, status not inserted
    if(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['status']=='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if start, end, status, from not inserted
    if(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['status']=='')&&($_GET['userid']=='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->orderBy('created_at','Desc')->get();
    }
//if start, end, name not inserted
    if(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['status']!='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('status',$_GET['status'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if start, end, name, from not inserted
    if(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['status']!='')&&($_GET['userid']=='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('status',$_GET['status'])->orderBy('created_at','Desc')->get();
    }
//if start, end, name, status not inserted
    if(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['status']=='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
    if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['status']!='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','>=',$_GET['start'])->
        Where('created_at','<=',$_GET['end'])->
        Where('location',$_GET['location'])->
        Where('status',$_GET['status'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if only ->from not inserted
    if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['status']!='')&&($_GET['userid']=='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','>=',$_GET['start'])->
        Where('location',$_GET['location'])->
        Where('created_at','<=',$_GET['end'])->
        Where('status',$_GET['status'])->orderBy('created_at','Desc')->get();
    }
//if only status not inserted
    if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['status']=='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','>=',$_GET['start'])->
        Where('location',$_GET['location'])->
        Where('created_at','<=',$_GET['end'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if status and ->from not inserted
    if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['status']=='')&&($_GET['userid']=='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','>=',$_GET['start'])->
        Where('location',$_GET['location'])->
        Where('created_at','<=',$_GET['end'])->orderBy('created_at','Desc')->get();
    }
//if only name no inserted
    if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['status']!='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('created_at','>=',$_GET['start'])->
        Where('created_at','<=',$_GET['end'])->
        Where('location',$_GET['location'])->
        Where('status',$_GET['status'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if name and from not inserted
    if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['status']!='')&&($_GET['userid']=='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('created_at','>=',$_GET['start'])->
        Where('created_at','<=',$_GET['end'])->
        Where('location',$_GET['location'])->
        Where('status',$_GET['status'])->orderBy('created_at','Desc')->get();
    }
//if name and status not inserted
    if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['status']=='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('created_at','>=',$_GET['start'])->
        Where('created_at','<=',$_GET['end'])->
        Where('location',$_GET['location'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if name, status, from not inserted
    if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['status']=='')&&($_GET['userid']=='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('created_at','>=',$_GET['start'])->
        Where('location',$_GET['location'])->
        Where('created_at','<=',$_GET['end'])->orderBy('created_at','Desc')->get();
    }
//if end not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['status']!='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','>=',$_GET['start'])->
        Where('location',$_GET['location'])->
        Where('status',$_GET['status'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if end and from not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['status']!='')&&($_GET['userid']=='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','>=',$_GET['start'])->
        Where('location',$_GET['location'])->
        Where('status',$_GET['status'])->orderBy('created_at','Desc')->get();
    }
//if end and status not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['status']=='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','>=',$_GET['start'])->
        Where('location',$_GET['location'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if end, status, from not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['status']=='')&&($_GET['userid']=='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('location',$_GET['location'])->
        Where('created_at','>=',$_GET['start'])->orderBy('created_at','Desc')->get();
    }
//if end, name not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['status']!='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('created_at','>=',$_GET['start'])->
        Where('status',$_GET['status'])->
        Where('location',$_GET['location'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if end, name, from not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['status']!='')&&($_GET['userid']=='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('created_at','>=',$_GET['start'])->
        Where('location',$_GET['location'])->
        Where('status',$_GET['status'])->orderBy('created_at','Desc')->get();
    }
//if end, name, status not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['status']=='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('created_at','>=',$_GET['start'])->
        Where('location',$_GET['location'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if end,name,status,from not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['status']=='')&&($_GET['userid']=='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('location',$_GET['location'])->
        Where('created_at','>=',$_GET['start'])->orderBy('created_at','Desc')->get();
    }
//if start not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['status']!='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','<=',$_GET['end'])->
        Where('status',$_GET['status'])->
        Where('location',$_GET['location'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if start, from not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['status']!='')&&($_GET['userid']=='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','<=',$_GET['end'])->
        Where('location',$_GET['location'])->
        Where('status',$_GET['status'])->orderBy('created_at','Desc')->get();
    }
//if start, status not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['status']=='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','<=',$_GET['end'])->
        Where('location',$_GET['location'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if start, status, from not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['status']=='')&&($_GET['userid']=='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('location',$_GET['location'])->
        Where('created_at','<=',$_GET['end'])->orderBy('created_at','Desc')->get();
    }
//if start, name not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['status']!='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('created_at','<=',$_GET['end'])->
        Where('status',$_GET['status'])->
        Where('location',$_GET['location'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if start, name, from not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['status']!='')&&($_GET['userid']=='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('created_at','<=',$_GET['end'])->
        Where('location',$_GET['location'])->
        Where('status',$_GET['status'])->orderBy('created_at','Desc')->get();
    }
//if start, name, status not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['status']=='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('created_at','<=',$_GET['end'])->
        Where('location',$_GET['location'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if start, name, status, from not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['status']=='')&&($_GET['userid']=='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('location',$_GET['location'])->
        Where('created_at','<=',$_GET['end'])->orderBy('created_at','Desc')->get();
    }
//if start, end not inserted
    if(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['status']!='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('status',$_GET['status'])->
        Where('location',$_GET['location'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if start, end, from not inserted
    if(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['status']!='')&&($_GET['userid']=='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('location',$_GET['location'])->
        Where('status',$_GET['status'])->orderBy('created_at','Desc')->get();
    }
//if start, end, status not inserted
    if(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['status']=='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if start, end, status, from not inserted
    if(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['status']=='')&&($_GET['userid']=='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('location',$_GET['location'])->
        Where('problem_type',$_GET['problem_type'])->orderBy('created_at','Desc')->get();
    }
//if start, end, name not inserted
    if(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['status']!='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('location',$_GET['location'])->
        Where('status',$_GET['status'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
//if start, end, name, from not inserted
    if(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['status']!='')&&($_GET['userid']=='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('location',$_GET['location'])->
        Where('status',$_GET['status'])->orderBy('created_at','Desc')->get();
    }
//if start, end, name, status not inserted
    if(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['status']=='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('location',$_GET['location'])->
        Where('client_id',$_GET['userid'])->orderBy('created_at','Desc')->get();
    }
    if(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['status']=='')&&($_GET['userid']=='')&&($_GET['location']!='')){
          $data['wo'] =  Workorder::
        Where('location',$_GET['location'])->orderBy('created_at','Desc')->get(); 
        //$header = $_GET['problem_type'].' Works orders ';
}
//if all empty
    elseif(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['status']=='')&&($_GET['userid']=='')&&($_GET['location']=='')){
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
      if($_GET['type']!=''){$type=' '.$_GET['type'].' Details Report';}else{$type=' Users Report';}
      //////////////////////////////////////////
     $data['header'] = $username.''.$type;
     //////////////////////////////////////////
     if (($_GET['type']=='')&&($_GET['college']=='')) {
         $data['display_users'] =  user::orderBy('fname','asc')->get();
     }
     if (($_GET['type']=='')&&($_GET['college']!='')) {
         $data['display_users'] =  user::
         Where('id',$_GET['college'])->orderBy('fname','asc')->get();
     }
      if (($_GET['type']!='')&&($_GET['college']=='')) {
         $data['display_users'] =  user::
         Where('type',$_GET['type'])->orderBy('fname','asc')->get();
     }
      if (($_GET['type']!='')&&($_GET['college']!='')) {
         $data['display_users'] =  user::
         Where('id',$_GET['college'])->
         Where('type',$_GET['type'])->orderBy('fname','asc')->get();
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
         Where('type',$_GET['type'])->orderBy('name','asc')->get();
     }
     if (($_GET['name']=='')&&($_GET['brand']!='')&&($_GET['type']=='')) {
        $data['items'] =  material::
        Where('description',$_GET['brand'])->orderBy('name','asc')->get();
     }
     if (($_GET['name']=='')&&($_GET['brand']!='')&&($_GET['type']!='')) {
         $data['items'] =  material::
         Where('type',$_GET['type'])->
         Where('description',$_GET['brand'])->orderBy('name','asc')->get();
     }
     if (($_GET['name']!='')&&($_GET['brand']=='')&&($_GET['type']=='')) {
          $data['items'] =  material::
         Where('name',$_GET['name'])->orderBy('name','asc')->get();
     }
     if (($_GET['name']!='')&&($_GET['brand']=='')&&($_GET['type']!='')) {
          $data['items'] =  material::
         Where('name',$_GET['name'])->
         Where('type',$_GET['type'])->orderBy('name','asc')->get();
     }
     if (($_GET['name']!='')&&($_GET['brand']!='')&&($_GET['type']=='')) {
          $data['items'] =  material::
         Where('name',$_GET['name'])->
         Where('description',$_GET['brand'])->orderBy('name','asc')->get();
     }
     if (($_GET['name']!='')&&($_GET['brand']!='')&&($_GET['type']!='')) {
          $data['items'] =  material::
         Where('type',$_GET['type'])->
         Where('name',$_GET['name'])->
         Where('description',$_GET['brand'])->orderBy('name','asc')->get();
     }
     if (($_GET['name']=='')&&($_GET['brand']=='')&&($_GET['type']=='')) {
          $data['items'] =  material::orderBy('name','asc')->get();
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
      
   
     $wo =  WorkOrder::where('status',2)->whereBetween('updated_at', [$_GET['userid'], $to])->get();

     $wo =  WorkOrder::where('status',2)-> orderBy(DB::raw('ABS(DATEDIFF(created_at, NOW()))'))->  get();
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
         WHERE('problem_type',$_GET['problem_type'])->Where('status','-1')->OrderBy('created_at','Desc')->get();
      }
   
        if (($_GET['name']!='')&&($_GET['location']!='')&&($_GET['problem_type']=='')) {
            $data['unattended_work'] =  WorkOrder::Where('client_id',$_GET['name'])->
                             Where('location',$_GET['location'])->
                             Where('status','-1')->OrderBy('created_at','Desc')->get();
         }

        if (($_GET['name']!='')&&($_GET['location']=='')&&($_GET['problem_type']!='')) {
          $data['unattended_work'] =  WorkOrder::Where('client_id',$_GET['name'])->
         WHERE('problem_type',$_GET['problem_type'])->
         Where('status','-1')->OrderBy('created_at','Desc')->get();

      }if (($_GET['name']!='')&&($_GET['location']=='')&&($_GET['problem_type']=='')) {
          $data['unattended_work'] =  WorkOrder::Where('client_id',$_GET['name'])->
          Where('status','-1')->OrderBy('created_at','Desc')->get();

      }if (($_GET['name']=='')&&($_GET['location']!='')&&($_GET['problem_type']!='')) {
          $data['unattended_work'] =  WorkOrder::Where('location',$_GET['location'])->
         WHERE('problem_type',$_GET['problem_type'])->
         Where('status','-1')->OrderBy('created_at','Desc')->get();

      }if (($_GET['name']=='')&&($_GET['location']!='')&&($_GET['problem_type']=='')) {
          $data['unattended_work'] =  WorkOrder::Where('location',$_GET['location'])->
         Where('status','-1')->OrderBy('created_at','Desc')->get();

      }if (($_GET['name']=='')&&($_GET['location']=='')&&($_GET['problem_type']!='')) {
          $data['unattended_work'] =  WorkOrder::
         WHERE('problem_type',$_GET['problem_type'])->Where('status','-1')->OrderBy('created_at','Desc')->get();
      }

       if(($_GET['name']=='')&&($_GET['location']=='')&&($_GET['problem_type']=='')){
            $data['unattended_work'] =  WorkOrder::Where('status','-1')->OrderBy('created_at','Desc')->get();
       }   
//////////////////////////////////////////////////////// 
     if($data['unattended_work'] ->isEmpty()){
 
return redirect()->back()->withErrors(['message' => 'No data Found For Your Search :'.$data['header'].'']);
}else{
        
 $pdf = PDF::loadView('unattendedwopdf', $data);
 return $pdf->stream(''.$data['header'].'- '.date('d-m-Y Hi').'.pdf');
    }
///////////////////////////////////////////////////////////// 
    }

    public function completewopdf(){
      if (($_GET['name']!='')&&($_GET['location']!='')&&($_GET['problem_type']!='')) {
          $data['unattended_work'] =  WorkOrder::Where('client_id',$_GET['name'])->
         Where('location',$_GET['location'])->
         WHERE('problem_type',$_GET['problem_type'])->Where('status','2')->OrderBy('created_at','Desc')->get();
      }
   
        if (($_GET['name']!='')&&($_GET['location']!='')&&($_GET['problem_type']=='')) {
            $data['unattended_work'] =  WorkOrder::Where('client_id',$_GET['name'])->
                             Where('location',$_GET['location'])->
                             Where('status','2')->OrderBy('created_at','Desc')->get();
         }

        if (($_GET['name']!='')&&($_GET['location']=='')&&($_GET['problem_type']!='')) {
          $data['unattended_work'] =  WorkOrder::Where('client_id',$_GET['name'])->
         WHERE('problem_type',$_GET['problem_type'])->
         Where('status','2')->OrderBy('created_at','Desc')->get();

      }if (($_GET['name']!='')&&($_GET['location']=='')&&($_GET['problem_type']=='')) {
          $data['unattended_work'] =  WorkOrder::Where('client_id',$_GET['name'])->
          Where('status','2')->OrderBy('created_at','Desc')->get();

      }if (($_GET['name']=='')&&($_GET['location']!='')&&($_GET['problem_type']!='')) {
          $data['unattended_work'] =  WorkOrder::Where('location',$_GET['location'])->
         WHERE('problem_type',$_GET['problem_type'])->
         Where('status','2')->OrderBy('created_at','Desc')->get();

      }if (($_GET['name']=='')&&($_GET['location']!='')&&($_GET['problem_type']=='')) {
          $data['unattended_work'] =  WorkOrder::Where('location',$_GET['location'])->
         Where('status','2')->OrderBy('created_at','Desc')->get();

      }if (($_GET['name']=='')&&($_GET['location']=='')&&($_GET['problem_type']!='')) {
          $data['unattended_work'] =  WorkOrder::
         WHERE('problem_type',$_GET['problem_type'])->Where('status','2')->OrderBy('created_at','Desc')->get();
      }

       if(($_GET['name']=='')&&($_GET['location']=='')&&($_GET['problem_type']=='')){
            $data['unattended_work'] =  WorkOrder::Where('status','2')->OrderBy('created_at','Desc')->get();
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
         WHERE('problem_type',$_GET['problem_type'])->Where('status','2')->OrderBy('created_at','Desc')->get();
      }
   
        if (($_GET['name']!='')&&($_GET['location']!='')&&($_GET['problem_type']=='')) {
            $data['unattended_work'] =  WorkOrder::Where('client_id',$_GET['name'])->
                             Where('location',$_GET['location'])->
                             Where('status','2')->OrderBy('created_at','Desc')->get();
         }

        if (($_GET['name']!='')&&($_GET['location']=='')&&($_GET['problem_type']!='')) {
          $data['unattended_work'] =  WorkOrder::Where('client_id',$_GET['name'])->
         WHERE('problem_type',$_GET['problem_type'])->
         Where('status','2')->OrderBy('created_at','Desc')->get();

      }if (($_GET['name']!='')&&($_GET['location']=='')&&($_GET['problem_type']=='')) {
          $data['unattended_work'] =  WorkOrder::Where('client_id',$_GET['name'])->
          Where('status','2')->OrderBy('created_at','Desc')->get();

      }if (($_GET['name']=='')&&($_GET['location']!='')&&($_GET['problem_type']!='')) {
          $data['unattended_work'] =  WorkOrder::Where('location',$_GET['location'])->
         WHERE('problem_type',$_GET['problem_type'])->
         Where('status','2')->OrderBy('created_at','Desc')->get();

      }if (($_GET['name']=='')&&($_GET['location']!='')&&($_GET['problem_type']=='')) {
          $data['unattended_work'] =  WorkOrder::Where('location',$_GET['location'])->
         Where('status','2')->OrderBy('created_at','Desc')->get();

      }if (($_GET['name']=='')&&($_GET['location']=='')&&($_GET['problem_type']!='')) {
          $data['unattended_work'] =  WorkOrder::
         WHERE('problem_type',$_GET['problem_type'])->Where('status','2')->OrderBy('created_at','Desc')->get();
      }

       if(($_GET['name']=='')&&($_GET['location']=='')&&($_GET['problem_type']=='')){
            $data['unattended_work'] =  WorkOrder::Where('status','2')->OrderBy('created_at','Desc')->get();
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
                 $data['fetch'] = Technician::where('type',$_GET['type'])->where('id',$_GET['name'])->OrderBy('fname','asc')->get();
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
                 $data['fetch'] = Technician::where('type',$_GET['type'])->OrderBy('fname','asc')->get();
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
                 $data['fetch'] = Technician::where('id',$_GET['name'])->OrderBy('fname','asc')->get();
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
                 $data['fetch'] = Technician::OrderBy('type','asc')->OrderBy('fname','asc')->get();

             $data['header'] = 'All Technician Details'; 
              $data['section'] ='0';   

             $data['header'] = 'All Technician Details';  
             $data['section'] ='0';  

            }
        }



       if($data['fetch'] ->isEmpty()){
     
return redirect()->back()->withErrors(['message' => 'No data Found Matching your search ']);         
}else{
        
$pdf = PDF::loadView('allreport', $data);
return $pdf->stream(''.$data['header'].'- '.date('d-m-Y Hi').'.pdf');
    }


    }
///////////////// prints from hos /\ up ////////////////////////

    public function grnotepdf($id){

           $data = ['title' => 'Notes List' , 'items' => WorkOrderMaterial::where('work_order_id',$id)->where('status',15)
                    ->get()];
         $pdf = PDF::loadView('grnpdf', $data);
   
     return $pdf->stream('Goods received Note - '.$id.'- '.date('d-m-Y Hi').'.pdf');
    }

    public function issuenotepdf($id){

          
         $data = ['title' => 'Notes List' , 'items' => WorkOrderMaterial::where('work_order_id',$id)->where('status',3)
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

    public function exportProcure($id)
    {
        $data['procure'] = Procurement::where('tag_',$id)->orderBy('material_name','Asc')->orderBy('type','Asc')->get();
        $data['header'] = "Procured Materials Sent To Store";
        $pdf = PDF::loadView('procurementList',$data);
        return $pdf->stream(' Procured Materials - '.date('d-m-Y H:i').'.pdf');
    }

}