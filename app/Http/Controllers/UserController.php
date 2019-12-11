<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Area;
use App\Block;
use App\Location;
use App\Notification;
use App\Room;
use Illuminate\Http\Request;
use App\User;
use App\UserRole;
use App\Directorate;
use App\Department;
use App\Section;
use App\Complaint;
use App\WorkOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function create(Request $request)
    {
		
		
		
		
		
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            //'section' => 'required',
            'name' => 'required|unique:users',
            'phone' => 'required|max:15|min:10',
            'email' => 'required|unique:users',
			
        ]);

        if ($request['role'] == 'Choose...') {
            return redirect()->back()->withErrors(['message' => 'Role name required'])->with(['directorates' => Directorate::all()]);
        }

        if ($request['user_type'] == 'Choose...') {
            return redirect()->back()->withErrors(['message' => 'Type of user required'])->with(['directorates' => Directorate::all()]);
        }

        $user = new User();
        $user->fname = $request['fname'];
        $user->lname = $request['lname'];
        $user->name = $request['name'];
        $user->phone = $request['phone'];
        $user->email = $request['email'];
        $user->type  = implode("", $request->type);
        $user->section_id = $request['department'];
        $user->password = bcrypt($request['name'].'@esmis');
        $user->save();

        $role = new UserRole();
        $role->user_id = $user->id;
        $role->role_id = $request['role'];
        $role->save();

        $users = User::get();
        $departments = Department::where('directorate_id', 1)->get();
        //$sections = Section::where('department_id', 1)->get();
        // return redirect()->route('createUserView')->with([
        //     'message' => 'User created successfully',
        //     'directorates' => Directorate::all(),
        //     'sections' => $sections,
        //     'departments' => $departments, 'role' => $role
        // ]);


        return redirect()->route('users.view')->with([
            'message' => 'User Created Successfully',
            'display_users' => $users = User::all()
        ]);
    }

    

    public function deleteUser($id)
    {

        $user=User::where('id', $id)->first();
		$user->status='0';
		  $user->save();
        $users = User::where('status', 1)->get();
        return redirect()->route('users.view')->with([
            'message' => 'User deleted successfully',
            'display_users' => $users
        ]);
    }


    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
    }


    public function getDepartments(Request $request)
    {
        return response()->json(['departments' => Department::where('directorate_id', $request->get('id'))->orderby('name','ASC')->get()]);
    }




    public function getAreas(Request $request)
    {
        return response()->json(['areas' => Area::where('location_id', $request->get('id'))->orderby('name_of_area','ASC')->get()]);
    }


    public function getBlocks(Request $request)
    {
        return response()->json(['blocks' => Block::where('area_id', $request->get('id'))->orderby('name_of_block','ASC')->get()]);
    }


    public function getRooms(Request $request)
    {
        return response()->json(['rooms' => Room::where('block_id', $request->get('id'))->orderby('name_of_room','ASC')->get()]);
    }


    public function getSections(Request $request)
    {
        return response()->json(['sections' => Section::where('department_id', $request->get('id'))->orderby('section_name','ASC')->get()]);
    }

    public function editUserView($id)
    {
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        $trole = User::where('id', $id)->with('user_role')->first();
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();


//        return response()->json(User::with('section.department.directorate')->where('id', $id)->first());
        return view('edit_user', [

            'user' => User::with('department.directorate')->where('id', $id)->first(),
            'directorates' => Directorate::where('name','<>',null)->OrderBy('name','ASC')->get(),
            'departments' => Department::all(),
            'role' => $role,
            'nrole' => $role,
            'notifications' => $notifications,
            'trole' => $trole

        ]);
    }

    public function editUser(Request $request, $id)
    {
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            //'uname' => 'required',
            //'section' => 'required',
            'phone' => 'required|max:15|min:10',
            'email' => 'required'
        ]);

        if ($request['role'] == 'Choose...') {
            return redirect()->back()->withErrors(['message' => 'Role name required'])->with(['directorates' => Directorate::all()]);
        }

        if ($request['user_type'] == 'Choose...') {
            return redirect()->back()->withErrors(['message' => 'Type of user required'])->with(['directorates' => Directorate::all()]);
        }

        $user = User::where('id', $id)->first();
        $user->fname = $request['fname'];
        $user->lname = $request['lname'];
        // $user->name = $request['uname'];
        $user->phone = $request['phone'];
        $user->email = $request['email'];
        $user->section_id = $request['department'];
        $user->type  = implode("", $request->type);
        $user->save();

        $role = UserRole::where('user_id', $id)->first();
        $role->user_id = $user->id;
        $role->role_id = $request['role'];
        $role->save();

        return redirect()->route('users.view')->with([
            'message' => 'User Edited Successfully',
            'display_users' => $users = User::all()
        ]);
    }

    public function changePassword(Request $request){

        
      $rules=[

            'old-pass' => 'required',
            'new-pass' => 'required',
            'confirm-pass' => 'required|same:new-pass'

            
          
        ];
        $error_messages=[
            
            'confirm-pass.same'=>'New password and Confirm password must match please enter the password again',


        ];
        $validator=  validator($request->all(), $rules, $error_messages);
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
       }







        
        $user = User::find(auth()->user()->id);
        if (Hash::check($request['old-pass'], Auth::User()->password)){
            $user->password = bcrypt($request['new-pass']);
            $user->change_password = \Carbon\Carbon::now();
            $user->save();
            return redirect()->back()->with(['message' => 'Password changed successfully']);
        }
        return redirect()->back()->withErrors(['message' => 'You entered the wrong old password']);
    }
	
	
		 public function changeProfile(Request $request){
            if ($request->Image!='') {
        $request->validate(['Image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',]);
            }
        $request->validate([
            'email' => 'required',
            'phone' => 'required',
            
            
        ]);
        $user = User::find(auth()->user()->id);
        
		 $user->email = $request['email'];
		  $user->phone = $request['phone'];
            $user->save();
            
             

     $user = Auth::user();
if ($request->Image!='') {
        
        $ImageName = $user->id.'_Image'.time().'.'.request()->Image->getClientOriginalExtension();

        $request->Image->storeAs('avatars',$ImageName);

        $user->avatar = $ImageName;
        $user->save();
}

return redirect()->route('myprofile')->with(['message' => 'Profile has changed successfully']);
        }




//////////////////////////////////////////////////////////////
public function Complaint(Request $request)
        {
            $request->validate([
            'name' => 'required',
            'message' => 'required',
            
        ]);

        $compliant = new Complaint();

        $compliant->sender = auth()->user()->id;
        $compliant->receiver = $request['name'];
        $compliant->work = $request['work'];
        $compliant->message = $request['message'];
       
        $compliant->save();

return redirect()->route('work_order')->with(['message' => 'Compliant sent successfully']);
}
public function comp()
{
$role = User::where('id', auth()->user()->id)->with('user_role')->first();
$notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();
$compliant = Complaint::where('receiver',auth()->user()->id)->orderby('created_at','Desc')->get();
return view('compliant', ['role' => $role,'compliant' => $compliant,'notifications' => $notifications
        ]);
}
public function complian(request $request, $id){
$role = User::where('id', auth()->user()->id)->with('user_role')->first();
$notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get(); 
$single = Complaint::where('id',$id)->get();
return view('complaint', ['role' => $role,'compliant' => $single,'notifications' => $notifications
        ]);
}

Public function savesign(Request $request){

    // Get the data
//$img_data=$_GET['img'];
// Remove the headers (data:,) part.
// A real application should use them according to needs such as to check image type
//$filteredData=substr($img_data, strpos($img_data, ",")+1);
// Need to decode before saving since the data we received is already base64 encoded
//$unencodedData=base64_decode($filteredData);
//echo "unencodedData".$unencodedData;
//$imageName = auth()->user()->username.'-'. rand(5,1000) . rand(1, 10) . rand(10000, 150000) . rand(1500, 100000000) . ".png";
//Set the absolute path to your folder (i.e. /usr/home/your-domain/your-folder/
//$filepath = public_path('signs/') . $imageName;

//$fp = fopen($filepath, 'wb' );
//fwrite( $fp, $unencodedData);
//fclose( $fp );
    $signature = $request['signature'];

        $user = User::where('id', auth()->user()->id)->first();
        $user->signature_ = $signature;
        $user->save();
 $msg = "Signature Saved successfully <a class='btn btn-success' href='/myprofile'>Ok</a><br>";
    return response()->json(array('msg'=> $msg), 200);
       //return redirect()->route('myprofile')->with(['message' => 'Signature saved succesfully']);
}

}