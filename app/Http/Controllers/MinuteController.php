<?php 
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Material;
use App\Notification;
use App\Technician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\WorkOrderStaff;
use App\PurchasingOrder;
use App\Directorate;
use App\WorkOrder;
use App\Department;
use App\Section;
use App\WorkOrderMaterial;
use App\WorkOrderTransport;
use App\Note;
use App\MinuteSheet;

use Redirect;
use PDF;

class MinuteController extends Controller
{
    public function minutesheets()
    {

       $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $sheets = MinuteSheet:: select(DB::raw('Woid'),'status')->groupBy('Woid')->groupBy('status')->get();
         return view('Minutesheets', [
            'role' => $role,
            'sheet'=>$sheets,
            'notifications' => $notifications,
          ]);
    }
        



    public function newsheet(Request $request)
    {
        $minutesheet = new MinuteSheet();


        $minutesheet->_From = auth()->user()->id;
        $minutesheet->_To = $request['_to'];
        $minutesheet->_With = null;
        $minutesheet->seen = null;
        $minutesheet->status = 1;
        $minutesheet->Woid = $request['id'];
        $minutesheet->Message = $request['message'];
        $minutesheet->Sent = NOW();
        $minutesheet->save();
$sheet = MinuteSheet::select('Woid')->distinct()->Where('Woid','<>',null)->Distinct()->get();


        return redirect()->route('minutesheets')->with([ 'sheet'=>$sheet,'message' => 'MinuteSheet created succesfully!']);
    }

    public function minutesheet($id)
    {
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();


        $conversation=MinuteSheet::where('Woid', $id)->get();
        $worked=MinuteSheet::Select('Woid')->distinct()->where('Woid', $id)->get();
        $last = MinuteSheet::where('Woid',$id)->OrderBy('id','DESC')->Limit(1)->get();
        
        return view('conversation', [
            'notifications' => $notifications,
            'conversatt' => $conversation,
            'last'=>$last,
            'worked'=>$worked,
            'role' => $role
        ]);
    }
    public function addconv(Request $request)
    {
        $minutesheet = new MinuteSheet();

        $minutesheet->_From = auth()->user()->id;
        $minutesheet->_To = $request['_to'];
        $minutesheet->_With = null;
        $minutesheet->seen = null;
        $minutesheet->Woid = $request['id'];
        $minutesheet->Message = $request['message'];
        $minutesheet->Sent = NOW();
        $minutesheet->status = 1;
        $minutesheet->save();
////////////////////////////////////////////////////////

$role = User::where('id', auth()->user()->id)->with('user_role')->first();
$notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();

$conversation=MinuteSheet::where('Woid', $request['id'])->get();
$worked=MinuteSheet::Select('Woid')->distinct()->where('Woid', $request['id'])->get();
$last = MinuteSheet::where('Woid',$request['id'])->OrderBy('id','DESC')->Limit(1)->get();
        
        return view('conversation', ['notifications' => $notifications,'conversatt' => $conversation,'last'=>$last,'worked'=>$worked,'role' => $role,'message' => 'MinuteSheet created succesfully!'
        ]);

       
    }


    
public function sminutesheet(){
    $role = User::where('id', auth()->user()->id)->with('user_role')->first();
$notifications = Notification::where('receiver_id', auth()->user()->id)->orderBy('id','Desc')->get();

    return view('minutesheetsignature',['notifications' => $notifications,
'role' => $role]);
    }

   /* public function closeminute($id)
    {
        $minute=MinuteSheet::Where('status',1)->where('Woid', $id)->get();
        foreach( $minute as $minute )
        { 
            $minute->status ='2'; 
            $minute->save();
        }
		  
    }*/

    }


?>