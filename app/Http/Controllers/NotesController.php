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
   
class NotesController extends Controller
{

    public function pdf(){
      
     $data['title'] = 'Notes List';
  
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
if($_GET['userid']!=''){$usere = ' WorkOrders From '.$username;}else{$usere =' WorkOrders ';}
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
        Where('client_id',$_GET['userid'])->get();
       
    }
//if only ->from not inserted
    if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['status']!='')&&($_GET['userid']=='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','>=',$_GET['start'])->
        Where('created_at','<=',$_GET['end'])->
        Where('status',$_GET['status'])->get();
    }
//if only status not inserted
    if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['status']=='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','>=',$_GET['start'])->
        Where('created_at','<=',$_GET['end'])->
        Where('client_id',$_GET['userid'])->get();
    }
//if status and ->from not inserted
    if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['status']=='')&&($_GET['userid']=='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','>=',$_GET['start'])->
        Where('created_at','<=',$_GET['end'])->get();
    }
//if only name no inserted
    if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['status']!='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('created_at','>=',$_GET['start'])->
        Where('created_at','<=',$_GET['end'])->
        Where('status',$_GET['status'])->
        Where('client_id',$_GET['userid'])->get();
    }
//if name and from not inserted
    if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['status']!='')&&($_GET['userid']=='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('created_at','>=',$_GET['start'])->
        Where('created_at','<=',$_GET['end'])->
        Where('status',$_GET['status'])->get();
    }
//if name and status not inserted
    if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['status']=='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('created_at','>=',$_GET['start'])->
        Where('created_at','<=',$_GET['end'])->
        Where('client_id',$_GET['userid'])->get();
    }
//if name, status, from not inserted
    if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['status']=='')&&($_GET['userid']=='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('created_at','>=',$_GET['start'])->
        Where('created_at','<=',$_GET['end'])->get();
    }
//if end not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['status']!='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','>=',$_GET['start'])->
        Where('status',$_GET['status'])->
        Where('client_id',$_GET['userid'])->get();
    }
//if end and from not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['status']!='')&&($_GET['userid']=='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','>=',$_GET['start'])->
        Where('status',$_GET['status'])->get();
    }
//if end and status not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['status']=='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','>=',$_GET['start'])->
        Where('client_id',$_GET['userid'])->get();
    }
//if end, status, from not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['status']=='')&&($_GET['userid']=='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','>=',$_GET['start'])->get();
    }
//if end, name not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['status']!='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('created_at','>=',$_GET['start'])->
        Where('status',$_GET['status'])->
        Where('client_id',$_GET['userid'])->get();
    }
//if end, name, from not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['status']!='')&&($_GET['userid']=='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('created_at','>=',$_GET['start'])->
        Where('status',$_GET['status'])->get();
    }
//if end, name, status not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['status']=='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('created_at','>=',$_GET['start'])->
        Where('client_id',$_GET['userid'])->get();
    }
//if end,name,status,from not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['status']=='')&&($_GET['userid']=='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('created_at','>=',$_GET['start'])->get();
    }
//if start not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['status']!='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','<=',$_GET['end'])->
        Where('status',$_GET['status'])->
        Where('client_id',$_GET['userid'])->get();
    }
//if start, from not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['status']!='')&&($_GET['userid']=='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','<=',$_GET['end'])->
        Where('status',$_GET['status'])->get();
    }
//if start, status not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['status']=='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','<=',$_GET['end'])->
        Where('client_id',$_GET['userid'])->get();
    }
//if start, status, from not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['status']=='')&&($_GET['userid']=='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','<=',$_GET['end'])->get();
    }
//if start, name not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['status']!='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('created_at','<=',$_GET['end'])->
        Where('status',$_GET['status'])->
        Where('client_id',$_GET['userid'])->get();
    }
//if start, name, from not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['status']!='')&&($_GET['userid']=='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('created_at','<=',$_GET['end'])->
        Where('status',$_GET['status'])->get();
    }
//if start, name, status not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['status']=='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('created_at','<=',$_GET['end'])->
        Where('client_id',$_GET['userid'])->get();
    }
//if start, name, status, from not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['status']=='')&&($_GET['userid']=='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('created_at','<=',$_GET['end'])->get();
    }
//if start, end not inserted
    if(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['status']!='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('status',$_GET['status'])->
        Where('client_id',$_GET['userid'])->get();
    }
//if start, end, from not inserted
    if(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['status']!='')&&($_GET['userid']=='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('status',$_GET['status'])->get();
    }
//if start, end, status not inserted
    if(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['status']=='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('client_id',$_GET['userid'])->get();
    }
//if start, end, status, from not inserted
    if(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['status']=='')&&($_GET['userid']=='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->get();
    }
//if start, end, name not inserted
    if(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['status']!='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('status',$_GET['status'])->
        Where('client_id',$_GET['userid'])->get();
    }
//if start, end, name, from not inserted
    if(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['status']!='')&&($_GET['userid']=='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('status',$_GET['status'])->get();
    }
//if start, end, name, status not inserted
    if(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['status']=='')&&($_GET['userid']!='')&&($_GET['location']=='')){
        $data['wo'] =  Workorder::
        Where('client_id',$_GET['userid'])->get();
    }
    if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['status']!='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','>=',$_GET['start'])->
        Where('created_at','<=',$_GET['end'])->
        Where('location',$_GET['location'])->
        Where('status',$_GET['status'])->
        Where('client_id',$_GET['userid'])->get();
    }
//if only ->from not inserted
    if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['status']!='')&&($_GET['userid']=='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','>=',$_GET['start'])->
        Where('location',$_GET['location'])->
        Where('created_at','<=',$_GET['end'])->
        Where('status',$_GET['status'])->get();
    }
//if only status not inserted
    if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['status']=='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','>=',$_GET['start'])->
        Where('location',$_GET['location'])->
        Where('created_at','<=',$_GET['end'])->
        Where('client_id',$_GET['userid'])->get();
    }
//if status and ->from not inserted
    if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['status']=='')&&($_GET['userid']=='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','>=',$_GET['start'])->
        Where('location',$_GET['location'])->
        Where('created_at','<=',$_GET['end'])->get();
    }
//if only name no inserted
    if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['status']!='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('created_at','>=',$_GET['start'])->
        Where('created_at','<=',$_GET['end'])->
        Where('location',$_GET['location'])->
        Where('status',$_GET['status'])->
        Where('client_id',$_GET['userid'])->get();
    }
//if name and from not inserted
    if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['status']!='')&&($_GET['userid']=='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('created_at','>=',$_GET['start'])->
        Where('created_at','<=',$_GET['end'])->
        Where('location',$_GET['location'])->
        Where('status',$_GET['status'])->get();
    }
//if name and status not inserted
    if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['status']=='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('created_at','>=',$_GET['start'])->
        Where('created_at','<=',$_GET['end'])->
        Where('location',$_GET['location'])->
        Where('client_id',$_GET['userid'])->get();
    }
//if name, status, from not inserted
    if(($_GET['start']!='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['status']=='')&&($_GET['userid']=='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('created_at','>=',$_GET['start'])->
        Where('location',$_GET['location'])->
        Where('created_at','<=',$_GET['end'])->get();
    }
//if end not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['status']!='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','>=',$_GET['start'])->
        Where('location',$_GET['location'])->
        Where('status',$_GET['status'])->
        Where('client_id',$_GET['userid'])->get();
    }
//if end and from not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['status']!='')&&($_GET['userid']=='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','>=',$_GET['start'])->
        Where('location',$_GET['location'])->
        Where('status',$_GET['status'])->get();
    }
//if end and status not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['status']=='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','>=',$_GET['start'])->
        Where('location',$_GET['location'])->
        Where('client_id',$_GET['userid'])->get();
    }
//if end, status, from not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['status']=='')&&($_GET['userid']=='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('location',$_GET['location'])->
        Where('created_at','>=',$_GET['start'])->get();
    }
//if end, name not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['status']!='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('created_at','>=',$_GET['start'])->
        Where('status',$_GET['status'])->
        Where('location',$_GET['location'])->
        Where('client_id',$_GET['userid'])->get();
    }
//if end, name, from not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['status']!='')&&($_GET['userid']=='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('created_at','>=',$_GET['start'])->
        Where('location',$_GET['location'])->
        Where('status',$_GET['status'])->get();
    }
//if end, name, status not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['status']=='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('created_at','>=',$_GET['start'])->
        Where('location',$_GET['location'])->
        Where('client_id',$_GET['userid'])->get();
    }
//if end,name,status,from not inserted
    if(($_GET['start']!='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['status']=='')&&($_GET['userid']=='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('location',$_GET['location'])->
        Where('created_at','>=',$_GET['start'])->get();
    }
//if start not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['status']!='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','<=',$_GET['end'])->
        Where('status',$_GET['status'])->
        Where('location',$_GET['location'])->
        Where('client_id',$_GET['userid'])->get();
    }
//if start, from not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['status']!='')&&($_GET['userid']=='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','<=',$_GET['end'])->
        Where('location',$_GET['location'])->
        Where('status',$_GET['status'])->get();
    }
//if start, status not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['status']=='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('created_at','<=',$_GET['end'])->
        Where('location',$_GET['location'])->
        Where('client_id',$_GET['userid'])->get();
    }
//if start, status, from not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']!='')&&($_GET['status']=='')&&($_GET['userid']=='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('location',$_GET['location'])->
        Where('created_at','<=',$_GET['end'])->get();
    }
//if start, name not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['status']!='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('created_at','<=',$_GET['end'])->
        Where('status',$_GET['status'])->
        Where('location',$_GET['location'])->
        Where('client_id',$_GET['userid'])->get();
    }
//if start, name, from not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['status']!='')&&($_GET['userid']=='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('created_at','<=',$_GET['end'])->
        Where('location',$_GET['location'])->
        Where('status',$_GET['status'])->get();
    }
//if start, name, status not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['status']=='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('created_at','<=',$_GET['end'])->
        Where('location',$_GET['location'])->
        Where('client_id',$_GET['userid'])->get();
    }
//if start, name, status, from not inserted
    if(($_GET['start']=='')&&($_GET['end']!='')&&($_GET['problem_type']=='')&&($_GET['status']=='')&&($_GET['userid']=='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('location',$_GET['location'])->
        Where('created_at','<=',$_GET['end'])->get();
    }
//if start, end not inserted
    if(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['status']!='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('status',$_GET['status'])->
        Where('location',$_GET['location'])->
        Where('client_id',$_GET['userid'])->get();
    }
//if start, end, from not inserted
    if(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['status']!='')&&($_GET['userid']=='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('location',$_GET['location'])->
        Where('status',$_GET['status'])->get();
    }
//if start, end, status not inserted
    if(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['status']=='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('problem_type',$_GET['problem_type'])->
        Where('client_id',$_GET['userid'])->get();
    }
//if start, end, status, from not inserted
    if(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']!='')&&($_GET['status']=='')&&($_GET['userid']=='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('location',$_GET['location'])->
        Where('problem_type',$_GET['problem_type'])->get();
    }
//if start, end, name not inserted
    if(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['status']!='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('location',$_GET['location'])->
        Where('status',$_GET['status'])->
        Where('client_id',$_GET['userid'])->get();
    }
//if start, end, name, from not inserted
    if(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['status']!='')&&($_GET['userid']=='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('location',$_GET['location'])->
        Where('status',$_GET['status'])->get();
    }
//if start, end, name, status not inserted
    if(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['status']=='')&&($_GET['userid']!='')&&($_GET['location']!='')){
        $data['wo'] =  Workorder::
        Where('location',$_GET['location'])->
        Where('client_id',$_GET['userid'])->get();
    }
    if(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['status']=='')&&($_GET['userid']=='')&&($_GET['location']!='')){
          $data['wo'] =  Workorder::
        Where('location',$_GET['location'])->get(); 
        //$header = $_GET['problem_type'].' Work orders ';
}
//if all empty
    elseif(($_GET['start']=='')&&($_GET['end']=='')&&($_GET['problem_type']=='')&&($_GET['status']=='')&&($_GET['userid']=='')&&($_GET['location']=='')){
          $data['wo'] =  Workorder::get(); 
}


     $pdf = PDF::loadView('notes_pdf',$data);
   
     return $pdf->download('workorder.pdf');
    // return $pdf->inline('workorder.pdf');
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
         $data['display_users'] =  user::get();
     }
     if (($_GET['type']=='')&&($_GET['college']!='')) {
         $data['display_users'] =  user::
         Where('id',$_GET['college'])->get();
     }
      if (($_GET['type']!='')&&($_GET['college']=='')) {
         $data['display_users'] =  user::
         Where('type',$_GET['type'])->get();
     }
      if (($_GET['type']!='')&&($_GET['college']!='')) {
         $data['display_users'] =  user::
         Where('id',$_GET['college'])->
         Where('type',$_GET['type'])->get();
     }
     
 
     $pdf = PDF::loadView('users_pdf', $data);
   
     return $pdf->download('users.pdf');
    }


     public function storespdf(){
        if($_GET['name']!=''){$name = 'All '.$_GET['name'];}else{$name = 'All ';}
        if($_GET['type']!=''){$type=$_GET['type'].' Materials Available in Store';}else{ $type =' Materials Available in Store';}

      $data['header'] = $name.''.$type;
     $data['title'] = 'Notes List';
     if (($_GET['name']=='')&&($_GET['brand']=='')&&($_GET['type']!='')) {
         $data['items'] =  material::
         Where('type',$_GET['type'])->get();
     }
     if (($_GET['name']=='')&&($_GET['brand']!='')&&($_GET['type']=='')) {
        $data['items'] =  material::
        Where('description',$_GET['brand'])->get();
     }
     if (($_GET['name']=='')&&($_GET['brand']!='')&&($_GET['type']!='')) {
         $data['items'] =  material::
         Where('type',$_GET['type'])->
         Where('description',$_GET['brand'])->get();
     }
     if (($_GET['name']!='')&&($_GET['brand']=='')&&($_GET['type']=='')) {
          $data['items'] =  material::
         Where('name',$_GET['name'])->get();
     }
     if (($_GET['name']!='')&&($_GET['brand']=='')&&($_GET['type']!='')) {
          $data['items'] =  material::
         Where('name',$_GET['name'])->
         Where('type',$_GET['type'])->get();
     }
     if (($_GET['name']!='')&&($_GET['brand']!='')&&($_GET['type']=='')) {
          $data['items'] =  material::
         Where('name',$_GET['name'])->
         Where('description',$_GET['brand'])->get();
     }
     if (($_GET['name']!='')&&($_GET['brand']!='')&&($_GET['type']!='')) {
          $data['items'] =  material::
         Where('type',$_GET['type'])->
         Where('name',$_GET['name'])->
         Where('description',$_GET['brand'])->get();
     }
     if (($_GET['name']=='')&&($_GET['brand']=='')&&($_GET['type']=='')) {
          $data['items'] =  material::get();
     }
    
 
     $pdf = PDF::loadView('material_pdf', $data);
   
     return $pdf->download('materials.pdf');
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
 
     $pdf = PDF::loadView('unatended_pdf', ['wo' => $wo ,'tittle' =>$title]);
   
     return $pdf->download('unattended_workorder.pdf');
    }
 
 
}

public function unattendedwopdf(){
      if (($_GET['name']!='')&&($_GET['location']!='')&&($_GET['problem_type']!='')) {
          $data['unattended_work'] =  WorkOrder::Where('client_id',$_GET['name'])->
         Where('location',$_GET['location'])->
         WHERE('problem_type',$_GET['problem_type'])->Where('status','-1')->get();
      }
   
        if (($_GET['name']!='')&&($_GET['location']!='')&&($_GET['problem_type']=='')) {
            $data['unattended_work'] =  WorkOrder::Where('client_id',$_GET['name'])->
                             Where('location',$_GET['location'])->
                             Where('status','-1')->get();
         }

        if (($_GET['name']!='')&&($_GET['location']=='')&&($_GET['problem_type']!='')) {
          $data['unattended_work'] =  WorkOrder::Where('client_id',$_GET['name'])->
         WHERE('problem_type',$_GET['problem_type'])->
         Where('status','-1')->get();

      }if (($_GET['name']!='')&&($_GET['location']=='')&&($_GET['problem_type']=='')) {
          $data['unattended_work'] =  WorkOrder::Where('client_id',$_GET['name'])->
          Where('status','-1')->get();

      }if (($_GET['name']=='')&&($_GET['location']!='')&&($_GET['problem_type']!='')) {
          $data['unattended_work'] =  WorkOrder::Where('location',$_GET['location'])->
         WHERE('problem_type',$_GET['problem_type'])->
         Where('status','-1')->get();

      }if (($_GET['name']=='')&&($_GET['location']!='')&&($_GET['problem_type']=='')) {
          $data['unattended_work'] =  WorkOrder::Where('location',$_GET['location'])->
         Where('status','-1')->get();

      }if (($_GET['name']=='')&&($_GET['location']=='')&&($_GET['problem_type']!='')) {
          $data['unattended_work'] =  WorkOrder::
         WHERE('problem_type',$_GET['problem_type'])->Where('status','-1')->get();
      }

       if(($_GET['name']=='')&&($_GET['location']=='')&&($_GET['problem_type']=='')){
            $data['unattended_work'] =  WorkOrder::Where('status','-1')->get();
       }   
    
     
 
     $pdf = PDF::loadView('unattendedwopdf', $data);
   
     return $pdf->download('unattended WO.pdf');
    }

    public function completewopdf(){
      if (($_GET['name']!='')&&($_GET['location']!='')&&($_GET['problem_type']!='')) {
          $data['unattended_work'] =  WorkOrder::Where('client_id',$_GET['name'])->
         Where('location',$_GET['location'])->
         WHERE('problem_type',$_GET['problem_type'])->Where('status','2')->get();
      }
   
        if (($_GET['name']!='')&&($_GET['location']!='')&&($_GET['problem_type']=='')) {
            $data['unattended_work'] =  WorkOrder::Where('client_id',$_GET['name'])->
                             Where('location',$_GET['location'])->
                             Where('status','2')->get();
         }

        if (($_GET['name']!='')&&($_GET['location']=='')&&($_GET['problem_type']!='')) {
          $data['unattended_work'] =  WorkOrder::Where('client_id',$_GET['name'])->
         WHERE('problem_type',$_GET['problem_type'])->
         Where('status','2')->get();

      }if (($_GET['name']!='')&&($_GET['location']=='')&&($_GET['problem_type']=='')) {
          $data['unattended_work'] =  WorkOrder::Where('client_id',$_GET['name'])->
          Where('status','2')->get();

      }if (($_GET['name']=='')&&($_GET['location']!='')&&($_GET['problem_type']!='')) {
          $data['unattended_work'] =  WorkOrder::Where('location',$_GET['location'])->
         WHERE('problem_type',$_GET['problem_type'])->
         Where('status','2')->get();

      }if (($_GET['name']=='')&&($_GET['location']!='')&&($_GET['problem_type']=='')) {
          $data['unattended_work'] =  WorkOrder::Where('location',$_GET['location'])->
         Where('status','2')->get();

      }if (($_GET['name']=='')&&($_GET['location']=='')&&($_GET['problem_type']!='')) {
          $data['unattended_work'] =  WorkOrder::
         WHERE('problem_type',$_GET['problem_type'])->Where('status','2')->get();
      }

       if(($_GET['name']=='')&&($_GET['location']=='')&&($_GET['problem_type']=='')){
            $data['unattended_work'] =  WorkOrder::Where('status','2')->get();
       }   
    
     
 
     $pdf = PDF::loadView('completewopdf', $data);
   
     return $pdf->download('completed WO.pdf');
    }
        public function wowithdurationpdf(){
      if (($_GET['name']!='')&&($_GET['location']!='')&&($_GET['problem_type']!='')) {
          $data['unattended_work'] =  WorkOrder::Where('client_id',$_GET['name'])->
         Where('location',$_GET['location'])->
         WHERE('problem_type',$_GET['problem_type'])->Where('status','2')->get();
      }
   
        if (($_GET['name']!='')&&($_GET['location']!='')&&($_GET['problem_type']=='')) {
            $data['unattended_work'] =  WorkOrder::Where('client_id',$_GET['name'])->
                             Where('location',$_GET['location'])->
                             Where('status','2')->get();
         }

        if (($_GET['name']!='')&&($_GET['location']=='')&&($_GET['problem_type']!='')) {
          $data['unattended_work'] =  WorkOrder::Where('client_id',$_GET['name'])->
         WHERE('problem_type',$_GET['problem_type'])->
         Where('status','2')->get();

      }if (($_GET['name']!='')&&($_GET['location']=='')&&($_GET['problem_type']=='')) {
          $data['unattended_work'] =  WorkOrder::Where('client_id',$_GET['name'])->
          Where('status','2')->get();

      }if (($_GET['name']=='')&&($_GET['location']!='')&&($_GET['problem_type']!='')) {
          $data['unattended_work'] =  WorkOrder::Where('location',$_GET['location'])->
         WHERE('problem_type',$_GET['problem_type'])->
         Where('status','2')->get();

      }if (($_GET['name']=='')&&($_GET['location']!='')&&($_GET['problem_type']=='')) {
          $data['unattended_work'] =  WorkOrder::Where('location',$_GET['location'])->
         Where('status','2')->get();

      }if (($_GET['name']=='')&&($_GET['location']=='')&&($_GET['problem_type']!='')) {
          $data['unattended_work'] =  WorkOrder::
         WHERE('problem_type',$_GET['problem_type'])->Where('status','2')->get();
      }

       if(($_GET['name']=='')&&($_GET['location']=='')&&($_GET['problem_type']=='')){
            $data['unattended_work'] =  WorkOrder::Where('status','2')->get();
       }   
    
     
 
     $pdf = PDF::loadView('wowithdurationpdf', $data);
   
     return $pdf->download('completed WO duration.pdf');
    }

    public function roomreportpdf(){
        if ($_GET['location']!='') {
            $data['local'] = WorkOrder::select('location')->distinct()->Where('location',$_GET['location'])->get();
        }
        if ($_GET['location']=='') {
           $data['local'] = WorkOrder::select('location')->distinct()->get();
        }
         $pdf = PDF::loadView('roomreportpdf', $data);
   
     return $pdf->download('Wo with duration.pdf');
    }
}