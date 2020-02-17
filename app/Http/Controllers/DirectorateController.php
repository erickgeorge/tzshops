<?php

namespace App\Http\Controllers;

use App\Department;
use App\Directorate;
use App\Location;
use App\Notification;
use App\workordersection;
use App\iowzone;
use App\User;
use Illuminate\Http\Request;



class DirectorateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    
     public function IoWZonesview(){

        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        
       return view('iowzoneview', [
            'role' => $role,
            'notifications' => $notifications,
            'iowzone' => iowzone::OrderBy('zonename', 'ASC')->get()
            
        ]);
   
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
            'worksec' => workordersection::whereBetween('created_at', [$from, $to])->OrderBy('section_name', 'ASC')->get()
            
        ]);
        
    }
        return view('workordersection', [
            'role' => $role,
            'notifications' => $notifications,
            'worksec' => workordersection::OrderBy('section_name', 'ASC')->get()
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
            'deps' => Department::whereBetween('created_at', [$from, $to])->OrderBy('name', 'ASC')->with('directorate')->get()
        ]);

        
    }
        return view('department', [
            'role' => $role,
            'notifications' => $notifications,
            'directorates' => Directorate::OrderBy('name', 'ASC')->get(),
            'deps' => Department::OrderBy('name', 'ASC')->with('directorate')->get()
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
            'deps' => Department::whereBetween('created_at', [$from, $to])->OrderBy('name', 'ASC')->with('directorate')->get()
        ]);

        
    }
        return view('directorate', [
            'role' => $role,
            'notifications' => $notifications,
            'directorates' => Directorate::OrderBy('name', 'ASC')->get(),
            'deps' => Department::OrderBy('name', 'ASC')->with('directorate')->get()
        ]);
    }


     public function adddirectorateView(){
          $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();

        return view('add_directorate', [
            'role' => $role,
            'notifications' => $notifications,
            'directorates' => Directorate::OrderBy('name', 'ASC')->get(),
            'deps' => Department::OrderBy('name', 'ASC')->with('directorate')->get()
        ]);


     }



     public function adddepartmentView(){
          $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();

        return view('add_dipartment', [
            'role' => $role,
            'notifications' => $notifications,
            'directorates' => Directorate::OrderBy('name', 'ASC')->get(),
            'deps' => Department::OrderBy('name', 'ASC')->with('directorate')->get()
        ]);


     }


   public function addsectionView(){
          $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();

        return view('add_workordersection', [
            'role' => $role,
            'notifications' => $notifications,
            'directorates' => Directorate::OrderBy('name', 'ASC')->get(),
            'deps' => Department::OrderBy('name', 'ASC')->with('directorate')->get()
        ]);


     }


        public function addiowzoneView(){
          $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();

        return view('add_iowzone', [
            'role' => $role,
            'notifications' => $notifications,
            'directorates' => Directorate::OrderBy('name', 'ASC')->get(),
            'deps' => Department::OrderBy('name', 'ASC')->with('directorate')->get(),
            'iows' => User::where('type' , 'Inspector Of Works')->get()
            
        ]);


     }



    
    

    public function createDirectorate(Request $request)
    {
        /*$request->validate([
            'dir_name' => 'required|unique:directorates',
            'dir_abb' => 'required|unique:directorates'
        ]);*/

     
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
       
       
        foreach ($deps as $dep){
            $dep->delete();
        }
        $directorate->delete();
		  
		  
        return redirect()->route('dir.manage')->with(['message' => 'Directorate and its children Deleted successfully']);
  

      
    }

    public function createDepartment(Request $request)
    {
        

        if ($request['directorate'] == 'Choose...') {
            return redirect()->back()->withErrors(['message' => 'Directorate is required']);
        }

        if (!empty(Department::where('description',$request['dep_name'])->where('directorate_id',$request['directorate'])->where('name',$request['dep_ab'])->first())){
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
	
    
	

    public function createworkorderection(Request $request)
    {
        
         if (!empty(workordersection::where('section_name',$request['sec_name'])->first())){
            return redirect()->back()->withErrors(['message' => 'Workorder Section already exist']);
        }

        $wsection = new workordersection();
        $wsection->section_name = $request['sec_name' ];
       
        $wsection->save();

        return redirect()->route('section.manage')->with(['message' => 'Work order Section added successfully']);
    }




    public function createiowzone(Request $request)
    {
        
         if (!empty(iowzone::where('zonename',$request['zonename'])->first())){
            return redirect()->back()->withErrors(['message' => 'IoW Zone already exist']);
        }

        $iowzone = new iowzone();
        $iowzone->zonename = $request['zonename' ];
        $iowzone->location = $request['location' ];
        $iowzone->iow = $request['iow' ];
        $iowzone->save();

        return redirect()->route('manage.IoWZones')->with(['message' => 'IoW Zone added successfully']);
    }
    
	

	public function editworkorderSection(Request $request)
    {

          if (!empty(workordersection::where('section_name',$request['sec_name'])->first())){
            return redirect()->back()->withErrors(['message' => 'Workorder Section already exist']);
        }
        
       $p=$request['esecid'];
        
		
        $wsec = workordersection::where('id',$p)->first();
		
		$wsec->section_name = $request['sec_name' ];
       
        $wsec->save();
        
        //$directoratee->campus_id = 1;
        $wsec->save();

        return redirect()->route('section.manage')->with(['message' => 'Work order Section Edited successfully']);
    }



        public function editiowzone(Request $request)
    {

          if (!empty(iowzone::where('zonename',$request['sec_name'])->first())){
            return redirect()->back()->withErrors(['message' => 'Zone already exist']);
        }
        
       $p=$request['esecid'];
        
        
        $wsec = iowzone::where('id',$p)->first();
        
        $wsec->zonename = $request['sec_name' ];
       
        $wsec->save();
        
       

        return redirect()->route('manage.IoWZones')->with(['message' => 'Zone edited successfully']);
    }
	

	public function deleteWorkorderSection($id)
    {

          $sec=workordersection::where('id', $id)->first();
		
		  $sec->delete();
		  
		  
		  return redirect()->route('section.manage')->with(['message' => 'Workorder Section Deleted successfully']);
  

      
    }


    public function deleteiowzone($id)
    {

          $zone=iowzone::where('id', $id)->first();
        
          $zone->delete();
          
          
          return redirect()->route('manage.IoWZones')->with(['message' => 'Zone deleted successfully']);
  

      
    }
	
}
