<?php

namespace App\Http\Controllers;

use App\Department;
use App\Directorate;
use App\Location;
use App\Notification;
use App\Section;
use App\User;
use Illuminate\Http\Request;

class DirectorateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function workordersectionView(){

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
        
       return view('workordersection', [
            'role' => $role,
            'notifications' => $notifications,
            'directorates' => Directorate::whereBetween('created_at', [$from, $to])->OrderBy('name', 'ASC')->get(),
            'deps' => Department::whereBetween('created_at', [$from, $to])->OrderBy('name', 'ASC')->with('directorate')->get(),
            'secs' => Section::whereBetween('created_at', [$from, $to])->OrderBy('created_at', 'DESC')->with('department')->get()
        ]);

        
    }
        return view('workordersection', [
            'role' => $role,
            'notifications' => $notifications,
            'directorates' => Directorate::OrderBy('name', 'ASC')->get(),
            'deps' => Department::OrderBy('name', 'ASC')->with('directorate')->get(),
            'secs' => Section::with('department')->get()
        ]);
    }


    public function departmentsView(){

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
        
       return view('department', [
            'role' => $role,
            'notifications' => $notifications,
            'directorates' => Directorate::whereBetween('created_at', [$from, $to])->OrderBy('name', 'ASC')->get(),
            'deps' => Department::whereBetween('created_at', [$from, $to])->OrderBy('name', 'ASC')->with('directorate')->get(),
            'secs' => Section::whereBetween('created_at', [$from, $to])->OrderBy('created_at', 'DESC')->with('department')->get()
        ]);

        
    }
        return view('department', [
            'role' => $role,
            'notifications' => $notifications,
            'directorates' => Directorate::OrderBy('name', 'ASC')->get(),
            'deps' => Department::OrderBy('name', 'ASC')->with('directorate')->get(),
            'secs' => Section::with('department')->get()
        ]);
    }




 public function directorateView(){

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
        
       return view('directorate', [
            'role' => $role,
            'notifications' => $notifications,
            'directorates' => Directorate::whereBetween('created_at', [$from, $to])->OrderBy('name', 'ASC')->get(),
            'deps' => Department::whereBetween('created_at', [$from, $to])->OrderBy('name', 'ASC')->with('directorate')->get(),
            'secs' => Section::whereBetween('created_at', [$from, $to])->OrderBy('created_at', 'DESC')->with('department')->get()
        ]);

        
    }
        return view('directorate', [
            'role' => $role,
            'notifications' => $notifications,
            'directorates' => Directorate::OrderBy('name', 'ASC')->get(),
            'deps' => Department::OrderBy('name', 'ASC')->with('directorate')->get(),
            'secs' => Section::with('department')->get()
        ]);
    }


     public function adddirectorateView(){
          $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();

        return view('add_directorate', [
            'role' => $role,
            'notifications' => $notifications,
            'directorates' => Directorate::OrderBy('name', 'ASC')->get(),
            'deps' => Department::OrderBy('name', 'ASC')->with('directorate')->get(),
            'secs' => Section::with('department')->get()
        ]);


     }



     public function adddepartmentView(){
          $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();

        return view('add_dipartment', [
            'role' => $role,
            'notifications' => $notifications,
            'directorates' => Directorate::OrderBy('name', 'ASC')->get(),
            'deps' => Department::OrderBy('name', 'ASC')->with('directorate')->get(),
            'secs' => Section::with('department')->get()
        ]);


     }


    

    public function createDirectorate(Request $request)
    {
        /*$request->validate([
            'dir_name' => 'required|unique:directorates',
            'dir_abb' => 'required|unique:directorates'
        ]);*/

         $request->validate([
            'dir_name' => 'required|unique:directorates',
            'dir_ab' => 'required|unique:directorates',
            
        ]);

        if ($request['location'] == 'Choose...') {
            return redirect()->back()->withErrors(['message' => 'Campus is required']);
        }

        if (Directorate::where('directorate_description',$request['dir_name'])->first() || Directorate::where('name',$request['dir_abb'])->first()){
            return redirect()->back()->withErrors(['message' => 'Directorate already exist']);
        }

        $directorate = new Directorate();
        $directorate->directorate_description = $request['dir_name'];
        $directorate->name = $request['dir_abb'];
        $directorate->campus_id = 1;
        $directorate->save();

        return redirect()->route('dir.manage')->with(['message' => 'Directorate added successfully']);
    }

	public function editDirectorate(Request $request)
    {
       $p=$request['edirid'];
        
		
        $directoratee = Directorate::where('id',$p)->first();
		
		$directoratee->name = $request['edirname'];
        $directoratee->directorate_description = $request['edirabb'];
        
        $directoratee->campus_id = 1;
        $directoratee->save();

        return redirect()->route('dir.manage')->with(['message' => 'Directorate Edited successfully']);
    }
	

	public function deleteDirectorate($id)
    {

        $directorate=Directorate::where('id', $id)->first();
        $deps = Department::where('directorate_id', $directorate->id)->get();

        $deps_id = Department::select('id')->where('directorate_id', $directorate->id)->get();
        $secs = Section::whereIn('department_id', $deps_id)->get();

        foreach ($secs as $sec){
            $sec->delete();
        }
        foreach ($deps as $dep){
            $dep->delete();
        }
        $directorate->delete();
		  
		  
        return redirect()->route('dir.manage')->with(['message' => 'Directorate and its children Deleted successfully']);
  

      
    }

    public function createDepartment(Request $request)
    {
        /*$request->validate([
            'dep_name' => 'required|unique:directorates',
            'dep_ab' => 'required|unique:directorates'
        ]);*/
         $request->validate([
            'dep_name' => 'required|unique:directorates',
            'dep_ab' => 'required|unique:directorates',
            
        ]);

        if ($request['directorate'] == 'Choose...') {
            return redirect()->back()->withErrors(['message' => 'Directorate is required']);
        }

        if (!empty(Department::where('description',$request['dep_name'])->where('name',$request['dep_ab'])->first())){
            return redirect()->back()->withErrors(['message' => 'Department already exist']);
        }

        $dpeartment = new Department();
        $dpeartment->description = $request['dep_name'];
        $dpeartment->name = $request['dep_ab'];
        $dpeartment->directorate_id = $request['directorate'];
        $dpeartment->save();

        return redirect()->route('dipartment.manage')->with(['message' => 'Department added successfully']);
    }
	
	
	public function editDepartment(Request $request)
    {
       $p=$request['edepid'];
        
		
        $dep = Department::where('id',$p)->first();
		
		$dep->name = $request['edepname'];
        $dep->description = $request['edepdesc'];
		 $dep->directorate_id = $request['editdirectoratefdep'];
        
        //$directoratee->campus_id = 1;
        $dep->save();

        return redirect()->route('dipartment.manage')->with(['message' => 'Department Edited successfully']);
    }
	
	
	
	public function deleteDepartment($id)
    {

        $dep=Department::where('id', $id)->first();
		
		  $dep->delete();
		  
		  
		  return redirect()->route('dipartment.manage')->with(['message' => 'Department Deleted successfully']);
  

      
    }
	
	

    public function createSection(Request $request)
    {
        /*$request->validate([
            'sec_ab' => 'required|unique:directorates',
            'sec_name' => 'required|unique:directorates'
        ]);*/

        if ($request['department'] == 'Choose...') {
            return redirect()->back()->withErrors(['message' => 'Department is required']);
        }

        if (Section::where('description',$request['section_name'])->first() || Section::where('description',$request['sec_ab'])->first()){
            return redirect()->back()->withErrors(['message' => 'Section already exist']);
        }

        $section = new Section();
        $section->description = $request['sec_name'];
        $section->section_name = $request['sec_ab'];
        $section->department_id = $request['department'];
        $section->save();

        return redirect()->route('dir.manage')->with(['message' => 'Department added successfully']);
    }
	

	public function editSection(Request $request)
    {
       $p=$request['esecid'];
        
		
        $sec = Section::where('id',$p)->first();
		
		$sec->section_name = $request['esecname'];
        $sec->description = $request['esecdesc'];
        
        //$directoratee->campus_id = 1;
        $sec->save();

        return redirect()->route('dir.manage')->with(['message' => 'Section Edited successfully']);
    }
	

	public function deleteSection($id)
    {

        $sec=Section::where('id', $id)->first();
		
		  $sec->delete();
		  
		  
		  return redirect()->route('dir.manage')->with(['message' => 'Section Deleted successfully']);
  

      
    }
	
}
