<?php

namespace App\Http\Controllers;
use App\Imports\UsersImport;
use App\Http\Controllers\Controller;
use Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\house;
use App\hall;
use App\Notification;
use App\user;
use App\Campus;
use App\zone;
use App\cleaningarea;
use App\NonBuildingAsset;
use App\Area;
use App\Room;
use App\Block;
use App\Location;
use Excel;

class ImportExcelController extends Controller
{
	 public function importUserExcel(Request $request)
	 {
	 	$request->validate(['select_file'=>'required']);
			Excel::import(new UsersImport,$request->select_file);
	 	 
	 	 

	 	 return redirect()->route('users.view')->with(['message' => 'Users Data Inserted succesfully!.']);

	 } 

	 public function excelinsertusers()
	 {
	 	$notifications = Notification::where('receiver_id', auth()->user()->id)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();

	 	return view('excelinsertusers', [
            'role' => $role,
            'notifications' => $notifications,
          ]);
	 }
}