<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\Notification;
use App\User;
use App\Material;
class StoreController extends Controller
{
    //
	
	public function addmaterialView()
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();

        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
        
        return view('addmaterial', [
           
            'role' => $role,
            'notifications' => $notifications
        ]);
    }
	
	public function incrementmaterialView($id)
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)->where('status', 0)->get();

        $role = User::where('id', auth()->user()->id)->with('user_role')->first();
		$item= Material::where('id',$id)->first();
        
        return view('incrementmaterial', [
           
            'role' => $role,
            'notifications' => $notifications,
			'item' => $item
        ]);
    }
	
	
	
	public function incrementmaterial(Request $request)
    {
 
        $material =Material::where('id', $request['nameid'])->first();;

		
		 $material->stock = $request['tstock'];
        $material->save();

        return redirect()->route('storeIncrement.view', $request['nameid'])->with(['message' => 'Material is incremented']);
    }
	
	 public function addnewmaterail(Request $request)
    {
        $request->validate([
            'description' => 'required|unique:materials',
			
			
        ]);


       

        if ($request['m_type'] == 'Choose...') {
            return redirect()->back()->withErrors(['message' => 'Material type required ']);
        }
        $material = new Material();


      


        $material->name = $request['name'];
        $material->description = $request['description'];
        $material->type = $request['m_type'];
		
		 $material->stock = $request['stock'];
        $material->save();

        return redirect()->route('add_material')->with(['message' => 'New material successfully added']);
    }
	

	
	
	
	
	
	
	
}
