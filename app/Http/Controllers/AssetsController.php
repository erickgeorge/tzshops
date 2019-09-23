<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\House;
use App\Hall;
use App\notification;
use App\user;
use App\Campus;
class AssetsController extends Controller
{
    //

     public function RegisterHouse(Request $request)
    {
       
        $staffhouse = new House();
        $staffhouse->name_of_house = $request['name_of_house'];
        $staffhouse->location = $request['location'];
        $staffhouse->type = $request['type'];
        $staffhouse->no_room = $request['no_room'];
        $staffhouse->save();
        return redirect()->route('register.house')->with(['message' => 'New house is registered successfully']);
    }




       public function HousesView(){
        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('houses', [
            'role' => $role,
            'notifications' => $notifications,
            'staffhouses' => House::all(),
            'HallofResdence' => Hall::all(),
             'campuses' => Campus::all(),
          
          
          ]);
     }




          public function deleteHouse($id)
       {
           $House=House::where('id', $id)->first();
           $House->delete();
           return redirect()->route('register.house')->with(['message' => 'Respective house is deleted successfully']);
       }



           public function editHouse(Request $request)
    {
           $p=$request['edit_id'];
           $House = House::where('id',$p)->first();
		   $House->name_of_house = $request['name_of_house'];
		   $House->type = $request['type'];
		   $House->location = $request['location'];
		   $House->type = $request['type'];
		   $House->no_room = $request['no_room'];
           $House->save();
  
        return redirect()->route('register.house')->with(['message' => 'House Edited successfully']);
    }
	
	







     public function RegisterHalls(Request $request)
    {
      
        $HallofResdence = new Hall();
        $HallofResdence->hall_name = $request['hall_name'];
        $HallofResdence->campus_id = $request['campus_id'];
        $HallofResdence->area_name = $request['area_name'];
        $HallofResdence->type = $request['type'];
        $HallofResdence->location = $request['location'];
        $HallofResdence->save();

        return redirect()->route('register.house')->with(['message' => 'New Hall of Residence is registered successfully']);
    }




          public function deleteHall($id)
       {
           $HallofRes=Hall::where('id', $id)->first();
           $HallofRes->delete();
           return redirect()->route('register.house')->with(['message' => 'Respective hall is deleted successfully']);
       }





            public function editHall(Request $request)
    {
           $p=$request['edit_hallid'];
           $hall = Hall::where('id',$p)->first();
		   $hall->hall_name = $request['hall_name'];
		   $hall->campus_id = $request['campus_id'];
		   $hall->area_name = $request['area_name'];
		   $hall->type = $request['type'];
		   $hall->location = $request['location'];
           $hall->save();
  
        return redirect()->route('register.house')->with(['message' => 'Respective Hall Edited successfully']);
    }
	
	



	   public function RegisteCampus(Request $request)
    {
      
        $campuses = new Campus();
        $campuses->campus_name = $request['campus_name'];
        $campuses->location = $request['location'];
        $campuses->save();
        return redirect()->route('register.house')->with(['message' => 'New Campus is registered successfully']);
    }




}
