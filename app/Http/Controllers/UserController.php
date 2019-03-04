<?php

namespace App\Http\Controllers;

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
    	$user->password = bcrypt($request['password']);
    	$user->save();

        $role = new UserRole();
        $role->user_id = $user->id;
        $role->role_id = $request['role'];
        $role->save();

		$users = User::get();
        return redirect()->route('createUserView')->with([
            'message' => 'User created successfully',
            'directorates' => Directorate::all()
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


    public function getSections(Request $request){
        return response()->json(['sections' => Section::where('department_id', $request->get('id'))->get()]);
    }



}
