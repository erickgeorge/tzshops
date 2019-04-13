<?php

namespace App\Http\Controllers;

use App\Area;
use App\Block;
use App\Room;
use Illuminate\Http\Request;
use App\User;
use App\UserRole;
use App\Directorate;
use App\Department;
use App\Section;

class UserController extends Controller
{
    public function create(Request $request){
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'section' => 'required',
            'name' => 'required|unique:users',
            'phone' => 'required|max:15|min:10',
            'email' => 'required|unique:users'
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
        $user->type = $request['user_type'];
        $user->section_id = $request['section'];
    	$user->password = bcrypt($request['password']);
    	$user->save();

        $role = new UserRole();
        $role->user_id = $user->id;
        $role->role_id = $request['role'];
        $role->save();

		$users = User::get();
        $departments = Department::where('directorate_id', 1)->get();
        $sections = Section::where('department_id', 1)->get();
        // return redirect()->route('createUserView')->with([
        //     'message' => 'User created successfully',
        //     'directorates' => Directorate::all(),
        //     'sections' => $sections,
        //     'departments' => $departments, 'role' => $role
        // ]);



        return redirect()->route('users.view')->with([
            'message' => 'User Created Successfully',
            'display_users'=> $users=User::all()
        ]);
    }

    public function deleteUser($id){

        User::where('id', $id)->delete();
        $users = User::all();
        return redirect()->route('users.view')->with([
            'message' => 'User deleted successfully',
            'display_users'=> $users
        ]);
    }


 public function destroy($id){
       $user = User::find($id);
        $user ->delete();
    }


    public function getDepartments(Request $request){
        return response()->json(['departments' => Department::where('directorate_id', $request->get('id'))->get()]);
    }


    public function getAreas(Request $request){
        return response()->json(['areas' => Area::where('location_id', $request->get('id'))->get()]);
    }


    public function getBlocks(Request $request){
        return response()->json(['blocks' => Block::where('area_id', $request->get('id'))->get()]);
    }


    public function getRooms(Request $request){
        return response()->json(['rooms' => Room::where('block_id', $request->get('id'))->get()]);
    }


    public function getSections(Request $request){
        return response()->json(['sections' => Section::where('department_id', $request->get('id'))->get()]);
    }

    public function editUserView($id){
        $role = User::where('id',auth()->user()->id)->with('user_role')->first();
         $trole = User::where('id',$id)->with('user_role')->first();
        $departments = Department::all();
        $sections = Section::all();


        return view('edit_user', [

            'user' => User::with('section.department.directorate')->where('id', $id)->first(),
            'directorates' => Directorate::all(),
            'sections' => $sections,
            'departments' => $departments, 
            'role' => $role,
            'nrole' => $role,
            'trole' => $trole

        ]);
    }

    public function editUser(Request $request, $id){
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            //'uname' => 'required',
            'section' => 'required',
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
        $user->section_id = $request['section'];
        $user->type = $request['user_type'];
        $user->save();

        $role = UserRole::where('user_id', $id)->first();
        $role->user_id = $user->id;
        $role->role_id = $request['role'];
        $role->save();
    
return redirect()->route('users.view')->with([
            'message' => 'User Edited Successfully',
            'display_users'=> $users=User::all()
        ]);
    }

}
