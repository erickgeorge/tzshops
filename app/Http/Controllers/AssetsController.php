<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\house;
use App\hall;
use App\Notification;
use App\user;
use App\Campus;
use App\zone;
use App\cleaningarea;

class AssetsController extends Controller
{
    //

     public function RegisterHouse(Request $request)
    {
       

        if ($request['campus'] == 'Choose...') {
            return redirect()->back()->withErrors(['message' => 'campus is required']);
        }


        $staffhouse = new House();
        $staffhouse->name_of_house = $request['name_of_house'];
        $staffhouse->location = $request['location'];
        $staffhouse->type = $request['type'];
        $staffhouse->no_room = $request['no_room'];
        $staffhouse->campus_id = $request['campus'];
        $staffhouse->save();
        return redirect()->route('register.house')->with(['message' => 'New house is registered successfully']);
    }



 public function TecnicianView(Request $request)
    {

       $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();


       
       return view('technicianreport', [
            'role' => $role,
            'notifications' => $notifications,
           
          
          
          ]);
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
               'newzone' => zone::all(),
               'cleanarea' => cleaningarea::all(),
  
          ]);
         }


         public function managecampus(){
         $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
         $role = User::where('id', auth()->user()->id)->with('user_role')->first();
         
         return view('managecampus', [
            'role' => $role,
            'notifications' => $notifications,
            'staffhouses' => House::all(),
            'HallofResdence' => Hall::all(),
             'campuses' => Campus::all(),
               'newzone' => zone::all(),
               'cleanarea' => cleaningarea::all(),
  
          ]);

         }


           public function Hallofresdence(){
        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('hallofresdence', [
            'role' => $role,
            'notifications' => $notifications,
            'staffhouses' => House::all(),
            'HallofResdence' => Hall::all(),
             'campuses' => Campus::all(),
               'newzone' => zone::all(),
               'cleanarea' => cleaningarea::all(),
  
          ]);
         }

           public function Cleaningarea(){
        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('cleaningarea', [
            'role' => $role,
            'notifications' => $notifications,
            'staffhouses' => House::all(),
            'HallofResdence' => Hall::all(),
             'campuses' => Campus::all(),
               'newzone' => zone::all(),
               'cleanarea' => cleaningarea::all(),
  
          ]);
         }

           public function cleaningzone(){
        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('cleaningzone', [
            'role' => $role,
            'notifications' => $notifications,
            'staffhouses' => House::all(),
            'HallofResdence' => Hall::all(),
             'campuses' => Campus::all(),
               'newzone' => zone::all(),
               'cleanarea' => cleaningarea::all(),
  
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
       
           $House->location = $request['location'];
           $House->type = $request['type'];
           $House->no_room = $request['no_room'];
           $House->campus_id = $request['campus'];
           $House->save();
  
        return redirect()->route('register.house')->with(['message' => 'House Edited successfully']);
    }
  
  







     public function RegisterHalls(Request $request)
    {
      
        $HallofResdence = new Hall();
        $HallofResdence->hall_name = $request['hall_name'];
        $HallofResdence->campus_id = $request['campus'];
        $HallofResdence->area_name = $request['area_name'];
        $HallofResdence->type = $request['type'];
        $HallofResdence->location = $request['location'];
        $HallofResdence->save();

        return redirect()->route('register.hallofres')->with(['message' => 'New Hall of Residence is registered successfully']);
    }




          public function deleteHall($id)
       {
           $HallofRes=Hall::where('id', $id)->first();
           $HallofRes->delete();
           return redirect()->route('register.hallofres')->with(['message' => 'Respective hall is deleted successfully']);
       }





            public function editHall(Request $request)
    {
       $p=$request['edit_hallid'];
       $hall = Hall::where('id',$p)->first();
       $hall->hall_name = $request['hall_name'];
       $hall->campus_id = $request['campus'];
       $hall->area_name = $request['area_name'];
       $hall->type = $request['type'];
       $hall->location = $request['location'];
       $hall->save();
  
        return redirect()->route('register.hallofres')->with(['message' => 'Respective Hall Edited successfully']);
    }
  
  



     public function RegisteCampus(Request $request)
    {
      
        $campuses = new Campus();
        $campuses->campus_name = $request['campus_name'];
        $campuses->location = $request['location'];
        $campuses->save();
        return redirect()->route('register.campus')->with(['message' => 'New Campus is registered successfully']);
    }


     public function editcampus(Request $request)
    {
           $p=$request['edit_cid'];
           $campus = Campus::where('id',$p)->first();
           $campus->campus_name = $request['campus_name'];
           $campus->location = $request['location'];
           $campus->save();
  
        return redirect()->route('register.campus')->with(['message' => 'Respective campus Edited successfully']);
    }
  

      public function deletecampus($id)
       {
           $HallofRes=Campus::where('id', $id)->first();
           $HallofRes->delete();
           return redirect()->route('register.campus')->with(['message' => 'Respective campus is deleted successfully']);
       }



       public function Registerzone(Request $request)
    {
      
        $newzone = new zone();
        $newzone->zone_name = $request['zone_name'];
        $newzone->campus_id = $request['campus'];
        $newzone->type = $request['type'];
        $newzone->save();
        return redirect()->route('register.cleanningzone')->with(['message' => 'New Zones is registered successfully']);
    }


      public function deletezone($id)
       {
           $newzone=zone::where('id', $id)->first();
           $newzone->delete();
           return redirect()->route('register.cleanningzone')->with(['message' => 'Respective Zone is deleted successfully']);
       }


      public function editzone(Request $request)
    {
        $p=$request['editzone_id'];
        $editnewzone = zone::where('id',$p)->first();
        $editnewzone->zone_name = $request['zone_name'];
        $editnewzone->campus_id = $request['campus'];
        $editnewzone->type = $request['type'];
        $editnewzone->save();
  
        return redirect()->route('register.cleanningzone')->with(['message' => 'Respective zone Edited successfully']);
    }
  


  public function RegisterCleaningArea(Request $request)
    {
        $cleanarea = new cleaningarea();
        $cleanarea->cleaning_name = $request['cleaning_name'];
        $cleanarea->zone_id = $request['zone'];
       
        $cleanarea->save();
        return redirect()->route('register.cleaningareas')->with(['message' => 'New Cleaning Area is registered successfully']);
    }



public function deletecleanarea($id)
       {
           $cleanareaa=cleaningarea::where('id', $id)->first();
           $cleanareaa->delete();
           return redirect()->route('register.cleaningareas')->with(['message' => 'Respective Clean Area is deleted successfully']);
       }


  public function editcleanarea(Request $request)
    {
        $p=$request['editarea_id'];
        $editcleanarea = cleaningarea::where('id',$p)->first();
        $editcleanarea->cleaning_name = $request['cleaning_name'];
        $editcleanarea->zone_id = $request['zone'];
        $editcleanarea->save();
        return redirect()->route('register.cleaningareas')->with(['message' => 'Respective Clean Area Edited successfully']);
    }
 

   public function Registercampusview(){
         $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('registercampus', [
            'role' => $role,
            'notifications' => $notifications,
          ]);
     }

   public function Registerstaffhouseview(){
        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('registerstaffhouse', [
            'role' => $role,
            'notifications' => $notifications,
            'campuses' => Campus::all(),
          ]);
     }




   public function Registerhallview(){
        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('registerhall', [
            'role' => $role,
            'notifications' => $notifications,
            'campuses' => Campus::all(),
          ]);
     }



 public function Registercleanzoneview(){
        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('registercleaningzone', [
            'role' => $role,
            'notifications' => $notifications,
            'campuses' => Campus::all(),
          ]);
     }




 public function Registercleaningareaview(){
        $notifications = Notification::where('receiver_id', auth()->user()->id)->get();
        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        return view('registercleaningarea', [
            'role' => $role,
            'notifications' => $notifications,
            'campuses' => Campus::all(),
                'newzone' => zone::all(),
          ]);
     }

     public function nonbuildingasset(){
      return view('Nonbuildingasset');
     }

     public function cleaningcompany(){
      return view('cleaningcompany');
     }
}
 