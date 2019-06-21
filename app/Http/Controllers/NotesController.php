<?php
   
namespace App\Http\Controllers;
   
use App\Note;
use Illuminate\Http\Request;
use Redirect;
use PDF;
use App\WorkOrder;
use App\User;
use App\Notification;
   
class NotesController extends Controller
{
   

 







    public function pdf(){
      
     $data['title'] = 'Notes List';
     $data['wo'] =  Workorder::get();
 
     $pdf = PDF::loadView('notes_pdf', $data);
   
     return $pdf->download('workorder.pdf');
    }
    
 
}